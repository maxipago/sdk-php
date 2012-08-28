<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "transactionId" => "987654", // REQUIRED - TransactionID created by maxiPago! //
);
$transaction = maxipago_payment("report", $credentials, $data, "TEST");
print_r($transaction);
?>