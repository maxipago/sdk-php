<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://www.url.com.");
$data = array(
  "debug" => "1",
  "customerIdExt" => "98765421",
  "firstName" => "Fulano",
  "lastName" => "de Tal",
  "address1" => "Av. República do Chile, 230",
  "address2" => "16 Andar",
  "city" => "Rio de Janeiro",
  "state" => "RJ",
  "zip" => "20031-170",
  "country" => "BR",
  "phone" => "2140099400",
  "email" => "fulanodetal@email.com",
  "dob" => "12/15/1970",
  "alternatePhone" => "2140099401",
  "sex" => "M"
);
$transaction = maxipago_payment("add-consumer", $credentials, $data, version, url);
print_r($transaction);
?>
