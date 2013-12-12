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
        "customerId" => "11006", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
        "creditCardNumber" => "5555555555554444", // REQUIRED - Full credit card number //
        "expirationMonth" => "12", // REQUIRED - Credit card expiration month //
        "expirationYear" => "2020", // REQUIRED - Credit card expiration year //
        "billingName" => "Fulano de Tal", // REQUIRED - Customer name //
        "billingAddress1" => "Av. República do Chile, 230", // REQUIRED - Customer address //
        "billingAddress2" => "16 Andar", // Optional - Customer address //
        "billingCity" => "Rio de Janeiro", // REQUIRED - Customer city //
        "billingState" => "RJ", // REQUIRED - Customer state with 2 characters //
        "billingZip" => "20031-170", // REQUIRED - Customer zip code //
        "billingCountry" => "BR", // REQUIRED - Customer country per ISO 3166-2 //
        "billingPhone" => "2140099400",  // REQUIRED - Customer phone //
        "billingEmail" => "fulanodetal@email.com" // REQUIRED - Customer email address //
    );
    $maxiPago->addCreditCard($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
    }

    else {
        echo "Credit Card was added successfully!<br>Credit card token: ".$maxiPago->getToken();
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
