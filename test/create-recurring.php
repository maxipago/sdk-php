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
        "processorID" => "1", // REQUIRED - Use '1' for testing. Contact our team for production values //
        "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
        "chargeTotal" => "10.00", // REQUIRED - Transaction amount in US format //
        "numberOfInstallments" => "2", // Optional - Number of installments ("parcelas") //
        "chargeInterest" => "N", // Optional - Charge interest flag (Y/N) ("com" e "sem" juros) //
        "number" => "4111111111111111", // REQUIRED - Full credit card number //
        "expMonth" => "07", // REQUIRED - Credit card expiration month //
        "expYear" => "2020", // REQUIRED - Credit card expiration year //
        "cvvNumber" => "123", // RECOMMENDED - Credit card verification number //
        "currencyCode" => "", // Optional - Valid only for ChasePaymentech multi-currecy setup. Please see full documentation for more info//
        "ipAddress" => "123.123.123.123", // Optional //
        "bname" => "Fulano de Tal", // RECOMMENDED - Customer name //
        "baddress" => "Av. República do Chile, 230", // Optional - Customer address //
        "baddress2" => "16 Andar", // Optional - Customer address //
        "bcity" => "Rio de Janeiro", // Optional - Customer city //
        "bstate" => "RJ", // Optional - Customer state with 2 characters //
        "bpostalcode" => "20031-170", // Optional - Customer zip code //
        "bcountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
        "bphone" => "2140099400", // Optional - Customer phone number //
        "bemail" => "fulanodetal@email.com", // Optional - Customer email address //
        "sname" => "Ciclano de Tal", // Optional - Shipping name //
        "saddress" => "Av. Prestes Maia, 737", // Optional - Shipping address //
        "saddress2" => "20 Andar", // Optional - Shipping address //
        "scity" => "São Paulo", // Optional - Shipping city //
        "sstate" => "SP", // Optional - Shipping stats with 2 characters //
        "spostalcode" => "01031-001", // Optional - Shipping zip code //
        "scountry" => "BR", // Optional - Shipping country code per ISO 3166-2 //
        "sphone" => "1121737900", // Optional - Shipping phone number //
        "semail" => "ciclanodetal@email.com", // Optional - Shipping email address //
        "comments" => "Pedido de teste.", // Optional - Additional comments // 
        
        // Below is a recurring order charged every MONTH, for 12 MONTHS, starting on DEC-12-2015 //
        "startDate" => "2015-12-25", // REQUIRED for this command - Date of 1st payment (YYYY-MM-DD format) //
        "frequency" => "1", // REQUIRED for this command - Frequency of payment (1, 3, 6, …) //
        "period" => "monthly", // REQUIRED for this command - Interval of payment: 'daily', 'weekly', 'monthly' //
        "installments" => "12", // REQUIRED for this command - Total number of payments before the order is completed //
        "failureThreshold" => "2" // REQUIRED for this command - Number of declines before email notification //
    );
    $maxiPago->createRecurring($data);

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
