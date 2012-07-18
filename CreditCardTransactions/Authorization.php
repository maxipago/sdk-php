<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "processorID" => "1",
  "referenceNum" => "TestTransaction123",
  "chargeTotal" => "10.00",
  "authentication" => "", // Only for Cielo. Please see documentation. //
  "numberOfInstallments" => "2",
  "chargeInterest" => "N",
  "number" => "4111111111111111",
  "expMonth" => "07",
  "expYear" => "2020", 
  "cvvNumber" => "123", 
  "ipAddress" => "123.123.123.123", 
  "bname" => "Fulano de Tal", // Billing information //
  "baddress" => "Av. República do Chile, 230",
  "baddress2" => "16 Andar",/
  "bcity" => "Rio de Janeiro",
  "bstate" => "RJ",
  "bpostalcode" => "20031-170", 
  "bcountry" => "BR", 
  "bphone" => "2140099400",
  "bemail" => "fulanodetal@email.com",
  "sname" => "Ciclano de Tal", // Shipping information //
  "saddress" => "Av. Prestes Maia, 737",
  "saddress2" => "20 Andar",
  "scity" => "São Paulo",
  "sstate" => "SP", 
  "spostalcode" => "01031-001", 
  "scountry" => "BR", 
  "sphone" => "1121737900",
  "semail" => "ciclanodetal@email.com", 
  "comments" => "Pedido de teste.", 
);
$transaction = maxipago_payment("auth", $credentials, $data, version, url);
print_r($transaction);
?>