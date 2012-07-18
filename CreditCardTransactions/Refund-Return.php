<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "orderID" => "0AF90437:0134438EE282:FE16:01965F39",
  "referenceNum" => "TestTransaction123",
  "chargeTotal" => "1.00",
);
$transaction = maxipago_payment("refund", $credentials, $data, version, url);
print_r($transaction);
?>