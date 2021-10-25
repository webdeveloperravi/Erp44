<?php
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$total_payable_amount = $_POST['total_payable_amount'];

$api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
$payment = $api->payment->fetch($razorpay_payment_id);
if (count($input)  && !empty($razorpay_payment_id)) {
    try {
        $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $total_payable_amount));
        return response()->json($response);
    } catch (\Exception $e) {
        return  $e->getMessage();
        Session::put('error', $e->getMessage());
        return redirect()->back();
    }
}
