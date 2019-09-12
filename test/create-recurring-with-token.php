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
        "referenceNum" => "TestTransaction1234562", // REQUIRED - Merchant internal order number //
        "customerIdExt" => "123.123.123-12",
        "chargeTotal" => "11.00", // REQUIRED - Transaction amount in US format //
        "numberOfInstallments" => "2", // Optional - Number of installments ("parcelas") //
        "chargeInterest" => "N", // Optional - Charge interest flag (Y/N) ("com" e "sem" juros) //        
        "token" => "Qhkx71KNxfNgJR4AQc9sZQ==", // REQUIRED for this command - Credit card token created by maxiPago! //
        "customerId" => "45350974", // REQUIRED for this command - Credit card token created by maxiPago! //        
        "currencyCode" => "", // Optional - Valid only for ChasePaymentech multi-currecy setup. Please see full documentation for more info//
        "ipAddress" => "123.123.123.123", // Optional //
    	"billingName" => "Fulano de Tal Joao", // RECOMMENDED - Customer name //
    	"billingAddress" => "Av. Republica Livre, 230", // Optional - Customer address //
    	"billingAddress2" => "16 Andar", // Optional - Customer address //
   		"billingCity" => "Sao Paulo", // Optional - Customer city //
   		"billingState" => "SP", // Optional - Customer state with 2 characters //
   		"billingPostalCode" => "08021310", // Optional - Customer zip code //
   		"billingCountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
   		"billingPhone" => "1132890900", // Optional - Customer phone number //
   		"billinEmail" => "billing@maxipago.com", // Optional - Customer email address //
   		"billingCompanyName" => "BillingCompany",
   		"shippingName" => "Fulano de Tal", // RECOMMENDED - Customer name //
   		"shippingAddress" => "Av. Republica Livre, 230", // Optional - Customer address //
   		"shippingAddress2" => "16 Andar", // Optional - Customer address //
   		"shippingDistrict" => "Centro",
   		"shippingCity" => "Sao Paulo", // Optional - Customer city //
   		"shippingState" => "SP", // Optional - Customer state with 2 characters //
   		"shippingPostalCode" => "08021310", // Optional - Customer zip code //
   		"shippingCountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
   		"shippingPhone" => "1132890900", // Optional - Customer phone number //
   		"shippingEmail" => "billing@maxipago.com", // Optional - Customer email address //
   		"comments" => "Pedido de teste.", // Optional - Additional comments // 
   		"currencyCode" => "BRL",
        
        // Below is a recurring order charged every MONTH, for 12 MONTHS, starting on DEC-12-2015 //
        "action" => "new",
        "startDate" => "2022-07-20", // REQUIRED for this command - Date of 1st payment (YYYY-MM-DD format) //
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
