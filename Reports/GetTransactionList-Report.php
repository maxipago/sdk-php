<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "period" => "range", // 'today', 'yesterday', 'range' (12/25/2010 - 12/30/2010) //
  "startDate" => "01/22/2012", // If 'period = range' //
  "endDate" => "01/23/2012", // If 'period = range' //
);
$transaction = maxipago_payment("report", $credentials, $data, version, url);
print_r($transaction);
?>