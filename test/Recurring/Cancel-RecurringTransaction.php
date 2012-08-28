<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/UniversalAPI/postAPI");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "orderID" => "1", // REQUIRED - Order ID replied by maxiPago! after creating the scheduled payment //
);
$transaction = maxipago_payment("cancel-recurring", $credentials, $data, version, url);
print_r($transaction);
?>