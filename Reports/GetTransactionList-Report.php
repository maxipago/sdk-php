<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/ReportsAPI/servlet/ReportsAPI");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "period" => "range", // REQUIRED - Filter range: 'today', 'yesterday', 'range' (12/25/2010 - 12/30/2010) //
  "startDate" => "01/22/2012", // REQUIRED - Start date if 'period = range' //
  "endDate" => "01/23/2012", // REQUIRED - End date if 'period = range' //
);
$transaction = maxipago_payment("report", $credentials, $data, version, url);
print_r($transaction);
?>