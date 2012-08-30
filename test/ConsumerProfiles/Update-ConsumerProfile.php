<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerId" => "123456", // REQUIRED - Customer ID returned by MaxiPago!
  "customerIdExt" => "98765421", // REQUIRED - Merchant internal customer ID //
  "firstName" => "Fulano", // Optional - Customer first name //
  "lastName" => "de Tal", // Optional - Customer last name //
  "address1" => "Av. República do Chile, 230", // Optional - Customer address //
  "address2" => "16 Andar", // Optional - Customer address //
  "city" => "Rio de Janeiro", // Optional - Customer city //
  "state" => "RJ", // Optional - Customer state with 2 characters //
  "zip" => "20031-170", // Optional - Customer zip code //
  "country" => "BR", // Optional - Customer country code per ISO 3166-2 //
  "phone" => "2140099400", // Optional - Customer phone //
  "email" => "fulanodetal@email.com", // Optional - Customer email //
  "dob" => "12/15/1970", // Optional - Customer date of birth on MM/DD/YYYY format //
  "alternatePhone" => "2140099401", // Optional - Customer alternate phone //
  "sex" => "M" // Optional - Customer gender //
);
$transaction = maxipago_payment("update-consumer", $credentials, $data, "TEST");
print_r($transaction);
?>
