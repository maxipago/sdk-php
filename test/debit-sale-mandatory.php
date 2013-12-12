<?php
require_once "../lib/maxipago/Autoload.php"; // Remove if using a globa autoloader
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;
   
    // Define Logger parameters if preferred
    // Do *NOT* use 'DEBUG' for Production environment as Credit Card details WILL BE LOGGED
    // Severities INFO and up are safe to use in Production as Credi Card info are NOT logged
    $maxiPago->setLogger(dirname(__FILE__).'/logs','INFO');
    
    // Set your credentials before any other transaction methods
    $maxiPago->setCredentials("100", "merchant_key");

    // true = prints XMLs on the screen for easy debugging
    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "processorID" => "17", // REQUIRED - Use 17 for testing. For production values contact our team //
        "referenceNum" => "ORD2928391", // REQUIRED - Merchant's internal order number //
        "chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
        "customerIdExt" => "12345678909", // REQUIRED FOR ITAU - Customer Brazilian ID (CPF, CNPJ) //
        "bname" => "Fulano de Tal", // REQUIRED FOR ITAU - Customer name //
        "baddress" => "Av. República do Chile, 230", // REQUIRED FOR ITAU - Customer address //
        "baddress2" => "16 Andar", // REQUIRED FOR ITAU - Customer address //
        "bcity" => "Rio de Janeiro", // REQUIRED FOR ITAU - Customer city //
        "bstate" => "RJ", // REQUIRED FOR ITAU - Customer state with 2 characters //
        "bpostalcode" => "20031170", // REQUIRED FOR ITAU - Customer zip code //
        "bcountry" => "BR", // REQUIRED FOR ITAU - Customer country code per ISO 3166-2 //
        "parametersURL" => "id=abc123&amp;type=3" // OPTIONAL - Value to be echoed back when the customer returns to store //
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
