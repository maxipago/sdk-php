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
		$maxiPago->setCredentials("12345", "123456789");
		
		$maxiPago->setDebug(true);
		$maxiPago->setEnvironment("TEST");
		$data = array(
				"processorID" => "18", // REQUIRED - Use 17 for testing. For production values contact our team //
				"referenceNum" => "TestBoleto123", // REQUIRED - Merchant's internal order number //
				//"ipAddress" => "123.123.123.123", // Optional //
				//"customerIdExt" => "111.111.111-11", //CPF,
				"billingId" => "123",
				"billingName" => "Fulano de Tal", // REQUIRED - Customer name //
				"billingAddress" => "Av. Republica do Chile, 230", // Optional - Customer address //
				"billingAddress2" => "16 Andar", // Optional - Customer address //
				"billingDistrict" => "Centro",
				"billingCity" => "Rio de Janeiro", // Optional - Customer city //
				"billingState" => "RJ", // Optional - Customer state with 2 characters //
				"billingPostalCode" => "20031-170",  // Optional - Customer zip code //
				"billingCountry" => "BR", // Optional - Customer country under ISO 3166-2 //
				"billingPhone" => "2140099400", // Optional - Customer phone number //
				"billingEmail" => "fulanodetal@email.com", // Optional - Customer email address //
				"billingCompanyName" => "Nome_Empresa",
				"billingType" => "Individual",
				"billingGender" => "M",
				"billingBirthDate" => "1982-03-08",
				"billingPhoneType" => "Mobile",
				"billingPhoneCountryCode" => "55",
				"billingPhoneAreaCode" => "11",
				"billingPhoneNumber" => "932890900",
				"billingDocumentType" => "CPF",
				"billingDocumentValue" => "25922837060",
				"shippingId" => "2546582",
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
				"shippingType" => "Individual",
				"shippingGender" => "M",
				"shippingBirthDate" => "1982-03-08",
				"shippingPhoneType" => "Commercial",
				"shippingPhoneCountryCode" => "55",
				"shippingPhoneAreaCode" => "11",
				"shippingPhoneNumber" => "32890900",
				"shippingPhoneExtension" => "123",
				"shippingDocumentType" => "CPF",
				"shippingDocumentValue" => "25922837060",
				"parametersURL" => "type=redepay",
				"chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
				"shippingTotal" => "10.00",
				"itemIndex" => "1",
				"itemProductCode" => "a123456",
				"itemDescription" => "Produto de teste",
				"itemQuantity" => "1",
				"itemTotalAmount" => "10.00",
				"itemUnitCost" => "10.00",
		);
		$maxiPago->redepay($data);
		
		if ($maxiPago->isErrorResponse()) {
			echo "There was an error creating the redepay transaction<br>Error message: ".$maxiPago->getMessage();
		}
		
		elseif ($maxiPago->isTransactionResponse()) {
			if ($maxiPago->getResponseCode() == "0") {
				echo "Redepay transaction created.<br><a href='".$maxiPago->getRedepayURL()."' target='_blank'>Click here</a> to open bank window.";
			} else {
				echo "There was an error creating the transaction<br>Error message: ".$maxiPago->getMessage();
			}
		}
		
	}
	
	catch (Exception $e) { 
		echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); 
	}
?>
