<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/UniversalAPI/postAPI");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "customerIdExt" => "98765421", // REQUIRED - Merchant internal customer ID //
  "firstName" => "Fulano", // REQUIRED - Customer first name //
  "lastName" => "de Tal", // REQUIRED - Customer last name //
  "address1" => "Av. República do Chile, 230", // REQUIRED - Customer address //
  "address2" => "16 Andar", // REQUIRED - Customer address //
  "city" => "Rio de Janeiro", // REQUIRED - Customer city //
  "state" => "RJ", // REQUIRED - Customer state with 2 characters //
  "zip" => "20031-170", // REQUIRED - Customer zip code //
  "country" => "BR", // REQUIRED - Customer country code per ISO 3166-2 //
  "phone" => "2140099400", // REQUIRED - Customer phone //
  "email" => "fulanodetal@email.com", // REQUIRED - Customer email //
  "dob" => "12/15/1970", // REQUIRED - Customer date of birth on MM/DD/YYYY format //
  "alternatePhone" => "2140099401", // Optional - Customer alternate phone //
  "sex" => "M" // REQUIRED - Customer gender //
);
$transaction = maxipago_payment("update-consumer", $credentials, $data, version, url);
print_r($transaction);
?>
