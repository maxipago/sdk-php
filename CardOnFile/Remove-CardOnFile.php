<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "customerId" => "11224", 
  "token" => "AB6TML7MMW=", // Card token assigne by maxiPago! //
);
$transaction = maxipago_payment("remove-card-onfile", $credentials, $data, version, url);
print_r($transaction);
?>