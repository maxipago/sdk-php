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
    $maxiPago->setCredentials("100", "merchant_keymerchant_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "processorID" => "1", // REQUIRED - Use '1' for testing. Contact our team for production values //
        "referenceNum" => "TestTransaction123", // REQUIRED - Merchant internal order number //
        "chargeTotal" => "10.00", // REQUIRED - Transaction amount in US format //
        "numberOfInstallments" => "2", // Optional - Number of installments ("parcelas") //
        "chargeInterest" => "N", // Optional - Charge interest flag (Y/N) ("com" ou "sem" juros) //
        "currencyCode" => "", // Optional - Valid only for ChasePaymentech multi-currecy setup. Please see full documentation for more info//
        "number" => "4111111111111111", // REQUIRED - Full credit card number //
        "expMonth" => "07", // REQUIRED - Credit card expiration month //
        "expYear" => "2019", // REQUIRED - Credit card expiriation year //
        "cvvNumber" => "123", // Optional - Credit card verification number //
    	"softDescriptor" => "ORDER12313", // Optional - Text printed in customer's credit card statement (Cielo only) //
        "ipAddress" => "123.123.123.123", // Optional //
        "bname" => "Fulano de Tal", // RECOMMENDED - Customer name //
        "baddress" => "Av. Republica do Chile, 230", // REQUIRED - Customer address //
        "baddress2" => "16 Andar", // REQUIRED - Customer address //
        "bcity" => "Rio de Janeiro", // REQUIRED - Customer city //
        "bstate" => "RJ", // REQUIRED - Customer state with 2 characters //
        "bpostalcode" => "20031-170", // REQUIRED - Customer zip code //
        "bcountry" => "BR", // REQUIRED - Customer country code per ISO 3166-2 //
        "bphone" => "2140099400", // REQUIRED - Customer phone number //
        "bemail" => "fulanodetal@email.com", // REQUIRED - Customer email address //

        // Below are the REQUIRED commands to save a card automatically
        "saveOnFile" => "1", // REQUIRED for this command - Flag for saving a card automatically //
        "customerId" => "11006", // REQUIRED for this command - Customer ID replied by maxiPago! after the "add-customer" command //
    );
    $maxiPago->debtCardSale($data);

    $result = $maxiPago->getResult();

    if ($maxiPago->isErrorResponse()) {
        echo "Transaction has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Transaction Approved<br>Authorization code: ".$maxiPago->getAuthCode()."<br>Credit card token: ".$maxiPago->getToken(); }
        else { echo "Transaction Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
