<?php
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;
   
    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("100", "merchant_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "processorID" => "1", // REQUIRED - Use '1' for testing. Contact our team for production values //
        "referenceNum" => "ORD29328493", // REQUIRED - Merchant internal order number //
        "chargeTotal" => "10.00", // REQUIRED - Transaction amount in US format //
        "bname" => "John Smith", // HIGHLY RECOMMENDED - Customer name //
        "number" => "5555555555554444", // REQUIRED - Full credit card number //
        "expMonth" => "07", // REQUIRED - Credit card expiration month //
        "expYear" => "2020", // REQUIRED - Credit card expiration year //
        "cvvNumber" => "123", // HIGHLY RECOMMENDED - Credit card verification code //
    );
    $maxiPago->creditCardAuth($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Transaction has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Transaction Approved<br>Authorization code: ".$maxiPago->getAuthCode(); }
        else { echo "Transaction Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>