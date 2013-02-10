<?php
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("99", "uanz3tvoooysclnkr16kd3as");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "orderID" => "0AF90437:013C6E0CB583:2E14:010CBDBD", // REQUIRED - Order ID replied by maxiPago! after authorization //
        "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
        "chargeTotal" => "5.00", // REQUIRED - Amount to be refunded. US format //
    );
    $maxiPago->creditCardRefund($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Refund has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Refund Approved"; }
        else { echo "Refund Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>