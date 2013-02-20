<?php
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("100", "merchant_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "orderID" => "0AF90437:013C6E0449EE:D12A:009300C5", // REQUIRED - Order ID replied by maxiPago! after authorization //
        "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
        "chargeTotal" => "10.00", // REQUIRED - Amount to be captured. US format // 
    );
    $maxiPago->creditCardCapture($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Capture has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Transaction Captured"; }
        else { echo "Capture Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>