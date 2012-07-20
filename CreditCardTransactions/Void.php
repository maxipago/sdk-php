<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/UniversalAPI/postXML");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "transactionID" => "5068372", // REQUIRED - TransactionID replied by maxiPago! //
);
$transaction = maxipago_payment("void", $credentials, $data, version, url);
print_r($transaction);
?>