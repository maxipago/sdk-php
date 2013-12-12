<?php
require_once "../lib/maxipago/Autoload.php"; // Remove if using a globa autoloader

require_once "../lib/maxiPago.php";



try {



    $maxiPago = new maxiPago;



    // Before calling any other methods you must first set your credentials

    // Define Logger parameters if preferred

    // Do *NOT* use 'DEBUG' for Production environment as Credit Card details WILL BE LOGGED

    // Severities INFO and up are safe to use in Production as Credi Card info are NOT logged

    $maxiPago->setLogger(dirname(__FILE__).'/logs','INFO');

    

    // Set your credentials before any other transaction methods

    $maxiPago->setCredentials("100", "merchant_key");



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

