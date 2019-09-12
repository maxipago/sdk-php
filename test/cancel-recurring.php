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
    $maxiPago->setCredentials("12345", "123456789");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "orderID" => "0A0115CF:016D1716646F:70D8:2D7C7C96", // REQUIRED - Order ID replied by maxiPago! after creating the scheduled payment //
    );
    $maxiPago->cancelRecurring($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
    }

    else {
        echo "Recurring payment cancelled";
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
