<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/UniversalAPI/postAPI");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerId" => "11224", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
  "creditCardNumber" => "5555555555554444", // REQUIRED - Full credit card number //
  "expirationMonth" => "12", // REQUIRED - Credit card expiration month //
  "expirationYear" => "2020", // REQUIRED - Credit card expiration year //
  "billingName" => "Fulano de Tal", // Optional, but RECOMMENDED - Customer name //
  "billingAddress1" => "Av. República do Chile, 230", // Optional - Customer address //
  "billingAddress2" => "16 Andar", // Optional - Customer address //
  "billingCity" => "Rio de Janeiro", // Optional - Customer city //
  "billingState" => "RJ", // Optional - Customer state with 2 characters //
  "billingZip" => "20031-170", // Optional - Customer zip code //
  "billingCountry" => "BR", // Optional - Customer country per ISO 3166-2 //
  "billingPhone" => "2140099400",  // Optional - Customer phone //
  "billingEmail" => "fulanodetal@email.com" // Optional - Customer email address //
); 
$transaction = maxipago_payment("add-card-onfile", $credentials, $data, version, url);
print_r($transaction);
?>