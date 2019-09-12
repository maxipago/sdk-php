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
        "processorID" => "1", // REQUIRED - Use '1' for testing. Contact our team for production values //
        "orderID" => "0A0115CF:016D1716646F:70D8:2D7C7C96", // REQUIRED - orderID internal order number //
        "chargeTotal" => "12.00", // REQUIRED - Transaction amount in US format //
        "number" => "4916497917001722", // REQUIRED - Full credit card number //
        "expMonth" => "07", // REQUIRED - Credit card expiration month //
        "expYear" => "2020", // REQUIRED - Credit card expiration year //
    	"billingName" => "Fulano de Tal Joao", // RECOMMENDED - Customer name //
    	"billingAddress" => "Av. Republica Livre, 230", // Optional - Customer address //
    	"billingAddress2" => "16 Andar", // Optional - Customer address //
        "billingCity" => "Sao Paulo", // Optional - Customer city //
        "billingPostalCode" => "08021310", // Optional - Customer zip code //
        "billingCountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
        "billingPhone" => "1132890900", // Optional - Customer phone number //
        "billinEmail" => "billing@maxipago.com", // Optional - Customer email address //
        "shippingName" => "Fulano de Tal", // RECOMMENDED - Customer name //
        "shippingAddress" => "Av. Republica Livre, 230", // Optional - Customer address //
        "shippingAddress2" => "16 Andar", // Optional - Customer address //
        "shippingCity" => "Sao Paulo", // Optional - Customer city //
        "shippingPostalCode" => "08021310", // Optional - Customer zip code //
        "shippingCountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
        "shippingPhone" => "1132890900", // Optional - Customer phone number //
        "shippingEmail" => "shipping@maxipago.com", // Optional - Customer email address //
        
        // Below is a recurring //
        "action" => "enable", //REQUIRED  disable / enable 
        "nextFireDate" => "2022-07-20", // REQUIRED for this command - Date of 1st payment (YYYY-MM-DD format) //
        "lastDate" => "2022-07-20", // REQUIRED for this command - Last Date of 1st payment (YYYY-MM-DD format) //
        "fireDay" => "20", // REQUIRED for this command - Date of 1st payment (YYYY-MM-DD format) //
        "period" => "monthly", // REQUIRED for this command - Interval of payment: 'daily', 'weekly', 'monthly' //
        "installments" => "12", // REQUIRED for this command - Total number of payments before the order is completed //
        "lastAmount" => "22" // REQUIRED lastAmount //
    );
    $maxiPago->ModifyRecurring($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Transaction has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Transaction Approved<br>Order ID: ".$maxiPago->getOrderID(); }
        else { echo "Transaction Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
