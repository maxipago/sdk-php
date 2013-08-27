<?php
require_once "../lib/maxipago/Autoload.php";
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("100", "merchant_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "customerId" => "11006", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command 
    );
    $maxiPago->deleteProfile($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
    }

    else {
        echo "Profile Removed";
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>