<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "orderID" => "0AF9063D:013510326483:093D:00ACE7A7", // REQUIRED - Order ID replied by maxiPago! after authorization //
  "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
  "chargeTotal" => "0.50", // REQUIRED - Amount to be refunded. US format // 
);
$transaction = maxipago_payment("refund", $credentials, $data, "TEST");
print_r($transaction);
?>