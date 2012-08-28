<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerId" => "11223", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
);
$transaction = maxipago_payment("delete-consumer", $credentials, $data, "TEST");
print_r($transaction);
?>
