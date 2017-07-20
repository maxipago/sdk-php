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
			"customerId" => "44708254", // REQUIRED - Customer ID created by maxiPago! after "add-customer" command //
			"creditCardNumber" => "4111111111111111",
			"expirationMonth" => "01",
			"expirationYear" => "3000",
			"billingName" => "Fulano de Tal", // RECOMMENDED - Customer name //
			"billingAddress" => "Av. Republica Livre, 230", // Optional - Customer address //
			"billingAddress2" => "16 Andar", // Optional - Customer address //
			"billingCity" => "Sao Paulo", // Optional - Customer city //
			"billingState" => "SP", // Optional - Customer state with 2 characters //
			"billingPostalCode" => "08021310", // Optional - Customer zip code //
			"billingCountry" => "BR", // Optional - Customer country code per ISO 3166-2 //
			"billingPhone" => "1132890900", // Optional - Customer phone number //
			"billinEmail" => "billing@maxipago.com", // Optional - Customer email address //
			"onFileEndDate" => "01/01/3000",
			"onFilePermissions" => "ongoing",
			"onFileComment" => "salvar um cartao",
			"onFileMaxChargeAmount" => "1000000.00",
	);
	$maxiPago->addCreditCard($data);
	
	if ($maxiPago->isErrorResponse()) {
		echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
	}
	
	else {
		echo "Credit Card Added Successfully";
	}
	
}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
