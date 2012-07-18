<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "orderID" => "0AF9063D:013510326483:093D:00ACE7A7", 
  "referenceNum" => "TestTransaction123", 
  "chargeTotal" => "0.50",
);
$transaction = maxipago_payment("capture", $credentials, $data, version, url);
print_r($transaction);
?>