<!DOCTYPE html>
<html>
<head>
	<title>Esewa Checkout</title>
</head>
<body onload="document.forms['esewa_checkout'].submit()">

	<form action="https://uat.esewa.com.np/epay/main" name="esewa_checkout" method="POST">
    <input value="{{ $amount }}" name="tAmt" type="hidden">
    <input value="{{ $amount }}" name="amt" type="hidden">
    <input value="0" name="txAmt" type="hidden">
    <input value="0" name="psc" type="hidden">
    <input value="0" name="pdc" type="hidden">
    <input value="{{ $merchant_code }}" name="scd" type="hidden">
    <input value="{{ $productId }}" name="pid" type="hidden">
    <input value="http://localhost/school.com/student/payment-verify?q=su" type="hidden" name="su">
    <input value="http://localhost/school.com/payment-verify?q=fu" type="hidden" name="fu">
    </form>

</body>
</html>