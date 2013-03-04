<?php
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("100", "secret_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "processorID" => "17", // REQUIRED - Use 17 for testing. For production values contact our team //
        "referenceNum" => "ORD2928391", // REQUIRED - Merchant's internal order number //
        "chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
        "paramsURL" => "id=abc123" // OPTIONAL - Value to be echoed back when the customer returns to store //
    );
    $maxiPago->onlineDebitSale($data);

    if ($maxiPago->isErrorResponse()) {
        echo "There was an error creating the online debit transaction<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Online Debit created.<br><a href='".$maxiPago->getDebitURL()."' target='_blank'>Click here</a> to open bank window."; }
        else { echo "There was an error creating the transaction<br>Error message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>