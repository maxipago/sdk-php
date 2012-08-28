<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "pageToken" => "Y6snfd3=", // REQUIRED - Page token created by maxiPago! //
  "pageNumber" => "3", // REQUIRED - Page number //
);
$transaction = maxipago_payment("report", $credentials, $data, "TEST");
print_r($transaction);
?>