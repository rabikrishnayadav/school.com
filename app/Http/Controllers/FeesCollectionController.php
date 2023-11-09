<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use App\Models\SettingModel;
use Stripe\Stripe;
use App\Exports\ExportCollectFees;
use Auth;
use Session;
use Excel;
use Currency;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class FeesCollectionController extends Controller
{
    public function collect_fees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->all())) {
            $data['getRecord'] = User::getSingleCollectFessStudent();
        }

        $data['header_title'] = "Collect Fees";
        return view('admin.fees_collection.collect_fees', $data);
    }

    public function collect_fees_report()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = StudentAddFeesModel::getRecord();
        $data['header_title'] = "Collect Fees Report";
        return view('admin.fees_collection.collect_fees_report', $data);
    }

    public function export_collect_fees_report(Request $request)
    {
        return Excel::download(new ExportCollectFees, 'CollectFeesReport_'.date('d-m-Y').'.xls');
    }

    public function collect_fees_add($student_id)
    {
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $data['header_title'] = "Add Collect Fee";
        return view('admin.fees_collection.add_collect_fees', $data);
    }

    public function collect_fees_insert($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);

        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        
        if (!empty($request->amount))
        {
            $remaningAmount = $getStudent->amount - $paid_amount;
        
            if ($remaningAmount >= $request->amount)
            {
                $remaning_amount_user = $remaningAmount - $request->amount;
                $payment = new StudentAddFeesModel;
                $payment->student_id = $request->student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();
                return redirect()->back()->with('success', "Fees Successfully Add");
            }
            else
            {
                return redirect()->back()->with('error', "You Can not Pay Greather than remaning amount.");
            }
        }
        else
        {
            return redirect()->back()->with('error', "Amount Must Greather than 0.");
        }
    }

    // student side work

    public function CollectFeesStudent(Request $request)
    {
        $student_id = Auth::user()->id;
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        $data['header_title'] = "Fees Collection";
        return view('student.my_fees_collection', $data);
    }

    public function CollectFeesStudentPayment(Request $request)
    {
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        $amount_check = $request->amount;

        if (!empty($request->amount) &&  $amount_check >= 10)
        {
            $remaningAmount = $getStudent->amount - $paid_amount;
        
            if ($remaningAmount >= $request->amount)
            {
                $remaning_amount_user = $remaningAmount - $request->amount;
                $payment = new StudentAddFeesModel;
                $payment->student_id = Auth::user()->id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSetting = SettingModel::getSingle();

                if ($request->payment_type == 'Paypal')
                {
                    $paypal_currency = $getSetting->paypal_currency;
                    
                    $provider = new PayPalClient;

                    $provider->setApiCredentials(config('paypal'));
                    $provider->setCurrency($paypal_currency);
                    
                    $paypalToken = $provider->getAccessToken();

                    $response = $provider->createOrder([
                        "intent" => "CAPTURE",
                        "application_context" => [
                            "return_url" => route('paypal_success'),
                            "cancel_url" => route('paypal_cancel')
                        ],
                        "purchase_units" => [
                            [
                                "amount" => [
                                    "currency_code" => $paypal_currency,
                                    "value" => $request->amount
                                ]
                            ]
                        ]
                    ]);

                    // dd($response);

                    if (isset($response['id']) && $response['id'] != null) {
                        
                        $payment->paypal_payment_id = $response['id'];
                        $payment->save();

                        foreach($response['links'] as $link){
                            if ($link['rel'] === 'approve') {
                                return redirect()->away($link['href']);
                            }
                        }
                    }else{
                        return redirect()->route('paypal_cancel');
                    }
                }
                elseif ($request->payment_type == 'Stripe')
                {
                    $setPublicKey = $getSetting->stripe_key;
                    $setApiKey = $getSetting->stripe_secret;

                    Stripe::setApiKey($setApiKey);
                    $finalprice = $request->amount * 100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' =>   ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => $getSetting->stripe_currency,
                                'unit_amount' => intval($finalprice),
                                'product_data' => [
                                'name' => 'Student Fees',
                                'description' => 'Student School Fees',
                                'images' => [ url('public/dist/img/user2-160x160.jpg') ],
                            ],
                        ],
                        'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => url('student/stripe/payment-success'),
                        'cancel_url' => url('student/stripe/payment-error'),
                    ]);

                    $payment->stripe_session_id = $session['id'];
                    $payment->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;

                    return view('stripe_charge', $data);
                }
                elseif ($request->payment_type == 'Esewa')
                {
                    $data['amount'] = $request->amount;
                    $data['productId'] = $payment->id;
                    $data['merchant_code'] = $getSetting->esewa_secret_key;

                    return view('esewa_payment', $data);
                }
                elseif ($request->payment_type == 'Khalti')
                {                    
                    $setPublicKey = $getSetting->khalti_public_key;
                    $finalprice = $request->amount * 100;

                    $data['item_name'] = "Student Fees";
                    $data['item_number'] = $payment->id;
                    $data['amount'] = $finalprice;
                    $data['public_key'] = $setPublicKey;

                    return view('khalti_payment', $data);
                }

                return redirect()->back()->with('success', "Fees Successfully Add");
            }
            else
            {
                return redirect()->back()->with('error', "You Can not Pay Greather than remaning amount.");
            }
        }
        else
        {
            return redirect()->back()->with('error', "Amount Must Greather than Rs.10");
        }
    }

    public function success(Request $request)
    {
        // dd($request->all());
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        // dd($response);
        $fees = StudentAddFeesModel::getSingleRecord($request->token);
        $fees->is_payment = 1;
        $fees->payment_data = json_encode($request->all());
        $fees->save();
        // dd($fees);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            return redirect('student/fees_collection')->with('success', "Your Payment Successful");

        }else{
            return redirect()->route('paypal_cancel');
        }
    }

    public function verifyEsewaPayment(Request $request)
    {
        $status = $request->q;
        $amt = $request->amt;
        $oid = $request->oid;
        $refId = $request->refId;

        $getSetting = SettingModel::getSingle();
        $merchant_code = $getSetting->esewa_secret_key;

        $fees = StudentAddFeesModel::getSingle($oid);
        $verifyAmount = $fees->paid_amount;

        if ($status == 'su') {

            $url = "https://uat.esewa.com.np/epay/transrec";
            $data =[
                'amt'=> $verifyAmount,
                'rid'=> $refId,
                'pid'=> $oid,
                'scd'=> $merchant_code,
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);

            if(strpos($response, 'Success')){

                if (!empty($fees))
                {
                    $fees->is_payment = 1;
                    $fees->payment_data = json_encode($request->all());
                    $fees->save();
                    
                    return redirect('student/fees_collection')->with('success', "Your Payment Successful");
                }
                else
                {
                    return redirect('student/fees_collection')->with('error', "due to some error try again");
                }
            }else{
                return redirect('student/fees_collection')->with('error', "due to some error try again");
            }

        }else{
            return redirect('student/fees_collection')->with('error', "Your transaction failed");
        }
    }

    public function verifyKhaltiPayment(Request $request)
    {        
        $getSetting = SettingModel::getSingle();
        $secret_key = $getSetting->khalti_secret_key;

        $fees = StudentAddFeesModel::getSingle($request->product_identity);
        $verifyAmount = $fees->paid_amount;

        $token = $request->token;

        $args = http_build_query(array(
          'token' => $token,
          'amount'  => $verifyAmount
        ));

        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        

        $headers = ["Authorization: Key $secret_key"];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // if( $status_code == 200)
        // {
        //     return response()->json(['success' => 1, 'redirectto' => route('student/dashboard')]);
        // }else{
        //     return response()->json(['error' => 1, 'message' => 'Payment Failed']);
        // }

        return $response;
    }

    public function storeKhaltiPayment(Request $request)
    {
        if (!empty($request->idx))
        {
            $fees = StudentAddFeesModel::getSingle($request->product_identity);
            if (!empty($fees))
            {
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();
                
                return redirect('student/fees_collection')->with('success', "Your Payment Successful");
            }
            else
            {
                return redirect('student/fees_collection')->with('error', "fees error");
            }
        }else
        {
            return redirect('student/fees_collection')->with('error', "Idx error");
        }

        
    }

    public function PaymentError()
    {
        return redirect('student/fees_collection')->with('error', "due to some error try again");
    }

    public function PaymentSuccess(Request $request)
    {
        if (!empty($request->item_number) && !empty($request->st) && $request->st == 'Completed')
        {
            $fees = StudentAddFeesModel::getSingle($request->item_number);
            if (!empty($fees))
            {
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();
                
                return redirect('student/fees_collection')->with('success', "Your Payment Successful");
            }
            else
            {
                return redirect('student/fees_collection')->with('error', "due to some error try again");
            }
        }
        else
        {
            return redirect('student/fees_collection')->with('error', "due to some error try again");
        }
    }


    public function PaymentSuccessStripe(Request $request)
    {
        $getSetting = SettingModel::getSingle();
        $setPublicKey = $getSetting->stripe_key;
        $setApiKey = $getSetting->stripe_secret;
        $trans_id = Session::get('stripe_session_id');
        $getFee = StudentAddFeesModel::where('stripe_session_id', '=', $trans_id)->first();

        \Stripe\Stripe::setApiKey($setApiKey);
        $getData = \Stripe\Checkout\Session::retrieve($trans_id);

        if (!empty($getData->id) && ($getData->id == $trans_id) && !empty($getFee) && $getData->status == 'complete' && $getData->payment_status == 'paid')
        {
            $getFee->is_payment = 1;
            $getFee->payment_data = json_encode($getData);
            $getFee->save();
            Session::forget('stripe_session_id');
            return redirect('student/fees_collection')->with('success', "Your Payment Successful");
        }
        else
        {
            return redirect('student/fees_collection')->with('error', "due to some error try again");
        }
    }


    // parent side work

    public function CollectFeesStudentParent($student_id, Request $request)
    {
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        $data['header_title'] = "Fees Collection";
        return view('parent.my_fees_collection', $data);
    }


    public function CollectFeesStudentPaymentParent($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        
        if (!empty($request->amount))
        {
            $remaningAmount = $getStudent->amount - $paid_amount;
        
            if ($remaningAmount >= $request->amount)
            {
                $remaning_amount_user = $remaningAmount - $request->amount;
                $payment = new StudentAddFeesModel;
                $payment->student_id = $getStudent->id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSetting = SettingModel::getSingle();

                if ($request->payment_type == 'Paypal')
                {
                    $query = array();
                    $query['business'] = $getSetting->paypal_email;
                    $query['cmd'] = '_xclick';
                    $query['item_name'] = "Student Fees";
                    $query['no_shipping'] = '1';
                    $query['item_number'] = $payment->id;
                    $query['amount'] = $request->amount;
                    $query['currency_code'] = $getSetting->paypal_currency;
                    $query['cancel_return'] = url('parent/paypal/payment-error/' . $student_id);
                    $query['return'] = url('parent/paypal/payment-success/' . $student_id);

                    $query_string = http_build_query($query);

                    // header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);
                    header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
                    exit();

                }
                elseif ($request->payment_type == 'Stripe')
                {
                    $setPublicKey = $getSetting->stripe_key;
                    $setApiKey = $getSetting->stripe_secret;

                    Stripe::setApiKey($setApiKey);
                    $finalprice = $request->amount * 100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' =>   ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => $getSetting->stripe_currency,
                                'unit_amount' => intval($finalprice),
                                'product_data' => [
                                'name' => 'Student Fees',
                                'description' => 'Student School Fees',
                                'images' => [ url('public/dist/img/user2-160x160.jpg') ],
                            ],
                        ],
                        'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => url('parent/stripe/payment-success/'.$student_id),
                        'cancel_url' => url('parent/stripe/payment-error'),
                    ]);

                    $payment->stripe_session_id = $session['id'];
                    $payment->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;

                    return view('stripe_charge', $data);
                }
                elseif ($request->payment_type == 'Esewa')
                {
                    $payment->is_payment = 1;
                    $payment->save();
                    
                    return redirect('parent/my_student/fees_collection/'.$student_id)->with('success', "Your Payment Successful");
                }

                return redirect()->back()->with('success', "Fees Successfully Add");
            }
            else
            {
                return redirect()->back()->with('error', "You Can not Pay Greather than remaning amount.");
            }
        }
        else
        {
            return redirect()->back()->with('error', "Amount Must Greather than 0.");
        }
    }

    public function PaymentErrorParent($student_id)
    {
        return redirect('parent/my_student/fees_collection/'.$student_id)->with('error', "due to some error try again");
    }

    public function PaymentSuccessParent($student_id, Request $request)
    {
        if (!empty($request->item_number) && !empty($request->st) && $request->st == 'Completed')
        {
            $fees = StudentAddFeesModel::getSingle($request->item_number);
            if (!empty($fees))
            {
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();
                
                return redirect('parent/my_student/fees_collection/'.$student_id)->with('success', "Your Payment Successful");
            }
            else
            {
                return redirect('parent/my_student/fees_collection/'.$student_id)->with('error', "due to some error try again");
            }
        }
        else
        {
            return redirect('parent/my_student/fees_collection/'.$student_id)->with('error', "due to some error try again");
        }
    }

    public function PaymentSuccessStripeParent($student_id, Request $request)
    {
        $getSetting = SettingModel::getSingle();
        $setPublicKey = $getSetting->stripe_key;
        $setApiKey = $getSetting->stripe_secret;
        $trans_id = Session::get('stripe_session_id');
        $getFee = StudentAddFeesModel::where('stripe_session_id', '=', $trans_id)->first();

        \Stripe\Stripe::setApiKey($setApiKey);
        $getData = \Stripe\Checkout\Session::retrieve($trans_id);

        if (!empty($getData->id) && ($getData->id == $trans_id) && !empty($getFee) && $getData->status == 'complete' && $getData->payment_status == 'paid')
        {
            $getFee->is_payment = 1;
            $getFee->payment_data = json_encode($getData);
            $getFee->save();
            Session::forget('stripe_session_id');
            
            return redirect('parent/my_student/fees_collection/'.$student_id)->with('success', "Your Payment Successful");
        }
        else
        {
            return redirect('parent/my_student/fees_collection/'.$student_id)->with('error', "due to some error try again");
        }
    }

    public function verifyPayment(Request $request)
    {
        $status = $request->q;
        // dd($status);
        $amt = $request->amt;
        $oid = $request->oid;
        $refId = $request->refId;

        dump($amt, $oid, $refId);
    }
}
