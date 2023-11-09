<!DOCTYPE html>
<html>
<head>
	<title>Khalti Checkout</title>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
</head>
<body>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script>

        var config = {
            // replace the publicKey with yours
            "publicKey": @json($public_key),
            "productIdentity": @json($item_number),
            "productName": @json($item_name),
            "productUrl": "http://localhost/school.com/student/fees_collection",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication

                    // if(payload.idx){
                    //     $.ajaxSetup({
                    //         headers: {
                    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    //         }
                    //     });

                    //     $.ajax({
                    //         method: 'post',
                    //         url: "{{ route('khalti.verifyPayment') }}",
                    //         data: payload,
                    //         success: function(response) {
                    //             if(response.success == 1){
                    //                 window.location = response.redirectto;
                    //             }else{
                    //                 checkout.hide();
                    //             }
                    //         },
                    //         error: function(data) {
                    //             console.log('Error:', data);
                    //         }
                    //     });
                    // }

                    // // other method for verify payment with ajax call

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('khalti.verifyPayment') }}",
                        data: {
                            token: payload.token,
                            amount: payload.amount,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(res){
                            $.ajax({
                                type: "POST",
                                url: "{{ route('khalti.storePayment') }}",
                                data: {
                                    response: res,
                                    "_token": "{{ csrf_token() }}"
                                },
                            });
                            console.log(res);
                        }
                    });

                    console.log(payload);
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        
        checkout.show({amount: @json($amount)});

    </script>

</body>
</html>