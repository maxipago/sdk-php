<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "customerId" => "11224",
  "creditCardNumber" => "5555555555554444", 
  "expirationMonth" => "12", 
  "expirationYear" => "2020", 
  "billingName" => "Fulano de Tal", 
  "billingAddress1" => "Av. República do Chile, 230", 
  "billingAddress2" => "16 Andar", 
  "billingCity" => "Rio de Janeiro", 
  "billingState" => "RJ", 
  "billingZip" => "20031-170", 
  "billingCountry" => "BR",
  "billingPhone" => "2140099400", 
  "billingEmail" => "fulanodetal@email.com"
); 
$transaction = maxipago_payment("add-card-onfile", $credentials, $data, version, url);
print_r($transaction);
?>