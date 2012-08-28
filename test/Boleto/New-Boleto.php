<?php
include_once "maxipago_payment.php";
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");
define("version", "3.1.1.15");
define("url", "https://testapi.maxipago.net/UniversalAPI/postXML");
$data = array(
  "debug" => "1", // Turns debug ON (1) and OFF (0) //
  "processorID" => "12", // REQUIRED - Use 12 for testing. For production values contact our team //
  "referenceNum" => "TestBoleto123", // REQUIRED - Merchant's internal order number //
  "chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
  "number" => "01234567", // REQUIRED AND UNIQUE - Boleto ID number, max of 8 numbers //
  "expirationDate" => "2020-12-25", // REQUIRED - Boleto expiration date, YYYY-MM-DD format //
  "instructions" => "Sr. Caixa, não receber após vencimento.;Não receber pagamento com cheque.", // optional - Instructions to be printed with the boleto. Use ";" to break lines //
  "ipAddress" => "123.123.123.123", // optional //
  "bname" => "Fulano de Tal", // REQUIRED - Customer name //
  "baddress" => "Av. República do Chile, 230", // optional - Customer address //
  "baddress2" => "16 Andar", // optional - Customer address //
  "bcity" => "Rio de Janeiro", // optional - Customer city //
  "bstate" => "RJ", // optional - Customer state with 2 characters //
  "bpostalcode" => "20031-170",  // optional - Customer zip code //
  "bcountry" => "BR", // optional - Customer country under ISO 3166-2 //
  "bphone" => "2140099400", // optional - Customer phone number //
  "bemail" => "fulanodetal@email.com", // optional - Customer email address //
  "sname" => "Ciclano de Tal", // optional - Shipping address //
  "saddress" => "Av. Prestes Maia, 737", // optional - Shipping address //
  "saddress2" => "20 Andar", // optional - Shipping address //
  "scity" => "São Paulo", // optional - Shipping city //
  "sstate" => "SP", // optional - Shipping state with 2 characters //
  "spostalcode" => "01031-001", // optional - Shipping zip code //
  "scountry" => "BR", // optional - Shipping country under ISO 3166-2 //
  "sphone" => "1121737900", // optional - Shipping phone number
  "semail" => "ciclanodetal@email.com", // optional - Shipping email address //
  "comments" => "Pedido de teste.", // optional - Additional comments //
);
$transaction = maxipago_payment("boleto", $credentials, $data, version, url);
print_r($transaction);
?>