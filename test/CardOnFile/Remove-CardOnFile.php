<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerId" => "11224", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
  "token" => "AB6TML7MMW=", // REQUIRED - Card token assigne by maxiPago! after "add-card-onfile" command //
);
$transaction = maxipago_payment("remove-card-onfile", $credentials, $data, "TEST");
print_r($transaction);
?>