<?php
// Includes the 'maxipago_payment.php' file //
include_once "maxipago_payment.php";

// Sets the Merchant credentials. These should be kept secret! //
$credentials = array("merchantId" => "mid", "merchantKey" => "secret-key");

// Sets the API version //
define("version", "3.1.1.15");

// Sets the target URL for the request //
define("url", "https://www.url.com.");

// Transaction data array //
// Below we have the mandatory fields for a credit card transaction //
$data = array(
  "debug" => "1", // Debug mode. Prints request and response //
  "processorID" => "1", // Processor routing code: chooses the processor to which send the transaction to //
  "referenceNum" => "TestTransaction123", // Merchant order number, for reference purposes //
  "chargeTotal" => "100.00", // Total order amount in USD format //
  "numberOfInstallments" => "2", // Number of installments. If no installments then do not send.  //
  "chargeInterest" => "N", // Installment interest flag. If no installments then do not send.  //
  "bname" => "Fulano de Tal", // Customer name //
  "number" => "5555555555554444", // Credit card number //
  "expMonth" => "12", // Expiration month //
  "expYear" => "2020", // Expiration year; 4 digits //
  "cvvNumber" => "111", // Credit card security code //
); 

// Calls the 'maxipago_payment' function passing a Sale (Auth+Capture) transaction //
$transaction = maxipago_payment("sale", $credentials, $data, version, url);

// Prints the return array //
print_r($transaction);
?> 