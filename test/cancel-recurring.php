<?php
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("99", "uanz3tvoooysclnkr16kd3as");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "orderID" => "0AF90437:013C06E0B916:C5B6:0023DD09", // REQUIRED - Order ID replied by maxiPago! after creating the scheduled payment //
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