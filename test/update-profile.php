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
        "customerId" => "44692297", // REQUIRED - Customer ID returned by MaxiPago!
        "customerIdExt" => time(), // REQUIRED - Merchant internal customer ID //
        "firstName" => "Fulano", // Optional - Customer first name //
        "lastName" => "de Tal", // Optional - Customer last name //
        "address1" => "Av. República do Chile, 230", // Optional - Customer address //
        "address2" => "16 Andar", // Optional - Customer address //
        "city" => "Rio de Janeiro", // Optional - Customer city //
        "state" => "RJ", // Optional - Customer state with 2 characters //
        "zip" => "20031-170", // Optional - Customer zip code //
        "country" => "BR", // Optional - Customer country code per ISO 3166-2 //
        "phone" => "2140099400", // Optional - Customer phone //
        "email" => "fulanodetal@email.com", // Optional - Customer email //
        "dob" => "12/15/1970", // Optional - Customer date of birth on MM/DD/YYYY format //
        "sex" => "M" // Optional - Customer gender //
    );
    $maxiPago->updateProfile($data);

    $result = $maxiPago->getResult();

    if ($maxiPago->isErrorResponse()) {
        echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
    }

    else {
        echo "Profile Updated";
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
