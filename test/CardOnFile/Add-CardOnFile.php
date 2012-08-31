<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerId" => "11224", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
  "creditCardNumber" => "5555555555554444", // REQUIRED - Full credit card number //
  "expirationMonth" => "12", // REQUIRED - Credit card expiration month //
  "expirationYear" => "2020", // REQUIRED - Credit card expiration year //
  "billingName" => "Fulano de Tal", // REQUIRED - Customer name //
  "billingAddress1" => "Av. República do Chile, 230", // REQUIRED - Customer address //
  "billingAddress2" => "16 Andar", // Optional - Customer address //
  "billingCity" => "Rio de Janeiro", // REQUIRED - Customer city //
  "billingState" => "RJ", // REQUIRED - Customer state with 2 characters //
  "billingZip" => "20031-170", // REQUIRED - Customer zip code //
  "billingCountry" => "BR", // REQUIRED - Customer country per ISO 3166-2 //
  "billingPhone" => "2140099400",  // REQUIRED - Customer phone //
  "billingEmail" => "fulanodetal@email.com" // REQUIRED - Customer email address //
);
$transaction = maxipago_payment("add-card-onfile", $credentials, $data, "TEST");
print_r($transaction);
?>