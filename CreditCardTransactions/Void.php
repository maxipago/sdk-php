<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "transactionID" => "5068372",
);
$transaction = maxipago_payment("void", $credentials, $data, version, url);
print_r($transaction);
?>