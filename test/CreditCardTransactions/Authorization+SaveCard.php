<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "processorID" => "1", // REQUIRED - Use '1' for testing. Contact our team for production values //
  "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
  "chargeTotal" => "10.00", // REQUIRED - Transaction amount in US format //
  "numberOfInstallments" => "2", // Optional - Number of installments ("parcelas") in credit card purchase //
  "chargeInterest" => "N", // Optional - Charge interest flag (Y/N), used with installments ("com" ou "sem" juros) //
  "currencyCode" => "", // Optional - Valid only for ChasePaymentech multi-currecy setup. Please see full documentation for more info//
  "number" => "4111111111111111", // REQUIRED - Full credit card number //
  "expMonth" => "07", // REQUIRED - Credit card expiration month //
  "expYear" => "2020", // REQUIRED - Credit card expiration year //
  "cvvNumber" => "123", // RECOMMENDED - Credit card verification code //
  "authentication" => "", // Optional - valido nly for Cielo. Please see full documentation for more info. //
  "saveOnFile" => "1", // REQUIRED for this operation - Flag for saving a card automatically //
  "customerId" => "323", // REQUIRED for this operation - Customer ID created by maxiPago! after "add-customer" command //
  "ipAddress" => "123.123.123.123", // Optional //
  "bname" => "Fulano de Tal", // RECOMMENDED - Customer name //
  "baddress" => "Av. República do Chile, 230", // Optional - Customer address //
  "baddress2" => "16 Andar", // Optional - Customer address //
  "bcity" => "Rio de Janeiro", // Optional - Customer city //
  "bstate" => "RJ", // Optional - Customer state with 2 characters //
  "bpostalcode" => "20031-170", // Optional - Customer zip code //
  "bcountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
  "bphone" => "2140099400", // Optional - Customer phone number //
  "bemail" => "fulanodetal@email.com", // Optional - Customer email address //
  "sname" => "Ciclano de Tal", // Optional - Shipping name //
  "saddress" => "Av. Prestes Maia, 737", // Optional - Shipping address //
  "saddress2" => "20 Andar", // Optional - Shipping address //
  "scity" => "São Paulo", // Optional - Shipping city //
  "sstate" => "SP", // Optional - Shipping stats with 2 characters //
  "spostalcode" => "01031-001", // Optional - Shipping zip code //
  "scountry" => "BR", // Optional - Shipping country code per ISO 3166-2 //
  "sphone" => "1121737900", // Optional - Shipping phone number //
  "semail" => "ciclanodetal@email.com", // Optional - Shipping email address //
  "comments" => "Pedido de teste.", // Optional - Additional comments //
);
$transaction = maxipago_payment("auth", $credentials, $data, "TEST");
print_r($transaction);
?>