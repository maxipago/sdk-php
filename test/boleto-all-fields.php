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
        "processorID" => "12", // REQUIRED - Use 12 for testing. For production values contact our team //
        "referenceNum" => "TestBoleto123", // REQUIRED - Merchant's internal order number //
        "chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
        "bname" => "Fulano de Tal", // REQUIRED - Customer name //
        "number" => time(), // REQUIRED AND UNIQUE - Boleto ID number, max of 8 numbers //
        "expirationDate" => "2020-12-25", // REQUIRED - Boleto expiration date, YYYY-MM-DD format //
        "instructions" => "Sr. Caixa, nao receber apos vencimento.;Nao receber pagamento com cheque.", // Optional - Instructions to be printed with the boleto. Use ";" to break lines //
        "ipAddress" => "123.123.123.123", // Optional //
        "baddress" => "Av. Republica do Chile, 230", // Optional - Customer address //
        "baddress2" => "16 Andar", // Optional - Customer address //
        "bcity" => "Rio de Janeiro", // Optional - Customer city //
        "bstate" => "RJ", // Optional - Customer state with 2 characters //
        "bpostalcode" => "20031-170",  // Optional - Customer zip code //
        "bcountry" => "BR", // Optional - Customer country under ISO 3166-2 //
        "bphone" => "2140099400", // Optional - Customer phone number //
        "bemail" => "fulanodetal@email.com", // Optional - Customer email address //
        "sname" => "Ciclano de Tal", // Optional - Shipping address //
        "saddress" => "Av. Prestes Maia, 737", // Optional - Shipping address //
        "saddress2" => "20 Andar", // Optional - Shipping address //
        "scity" => "Sao Paulo", // Optional - Shipping city //
        "sstate" => "SP", // Optional - Shipping state with 2 characters //
        "spostalcode" => "01031-001", // Optional - Shipping zip code //
        "scountry" => "BR", // Optional - Shipping country under ISO 3166-2 //
        "sphone" => "1121737900", // Optional - Shipping phone number
        "semail" => "ciclanodetal@email.com", // Optional - Shipping email address //
        "comments" => "Pedido de teste.", // Optional - Additional comments //
    );
    $maxiPago->boletoSale($data);

    if ($maxiPago->isErrorResponse()) {
        echo "There was an error creating the boleto<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Boleto has been created<br>Visit ".$maxiPago->getBoletoURL()." to view boleto."; }
        else { echo "There was an error creating the boleto<br>Error message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
