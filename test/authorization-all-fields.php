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
        "chargeInterest" => "N", // Optional - Charge interest flag (Y/N), used with installments ("com" ou "sem" juros) //
        "number" => "4111111111111111", // REQUIRED - Full credit card number //
        "expMonth" => "07", // REQUIRED - Credit card expiration month //
        "expYear" => "2020", // REQUIRED - Credit card expiration year //
        "cvvNumber" => "123", // RECOMMENDED - Credit card verification code //
        "softDescriptor" => "ORDER12313", // Optional - Text printed in customer's credit card statement (Cielo only) //,
        "fraudCheck" => "N", // Optional - Trigger fraud analysis for the transaction //
        "bname" => "Fulano de Tal", // RECOMMENDED - Customer name //
        "currencyCode" => "BRL", // Optional - Valid only for ChasePaymentech multi-currecy setup. Please see full documentation for more info//
        "baddress" => "Av. Paulista, 1728", // Optional - Customer address //
        "baddress2" => "7 Andar", // Optional - Customer address //
        "bcity" => "Sao Paulo", // Optional - Customer city //
        "bstate" => "SP", // Optional - Customer state with 2 characters //
        "bpostalcode" => "01311-000", // Optional - Customer zip code //
        "bcountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
        "bphone" => "1132854216", // Optional - Customer phone number //
        "bemail" => "fulanodetal@email.com", // Optional - Customer email address //
        "sname" => "Ciclano de Tal", // Optional - Shipping name //
        "saddress" => "Av. Paulista, 1728", // Optional - Shipping address //
        "saddress2" => "7 Andar", // Optional - Shipping address //
        "scity" => "Sao Paulo", // Optional - Shipping city //
        "sstate" => "SP", // Optional - Shipping stats with 2 characters //
        "spostalcode" => "01311-000", // Optional - Shipping zip code //
        "scountry" => "BR", // Optional - Shipping country code per ISO 3166-2 //
        "sphone" => "1132854216", // Optional - Shipping phone number //
        "semail" => "ciclanodetal@email.com", // Optional - Shipping email address //
        "comments" => "Pedido de teste.", // Optional - Additional comments //
    );
    $maxiPago->creditCardAuth($data);

    if ($maxiPago->isErrorResponse()) {
        echo "Transaction has failed<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Transaction Approved<br>Authorization code: ".$maxiPago->getAuthCode(); }
        else { echo "Transaction Declined<br>Decline message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
