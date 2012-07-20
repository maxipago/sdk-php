<?php
// DO NOT MODIFY //
function mp_xml($xmlRequest, $startElement, $mp_url, $debug) {
	$buildxml = new XmlWriter();
	$buildxml->openMemory();
	$buildxml->startElement($startElement);
	function write(XMLWriter $buildxml, $xmlRequest) {  
	    foreach ($xmlRequest as $key => $value) {
	        if (is_array($value)) {
	            $buildxml->startElement($key);
	            write($buildxml, $value);
	            $buildxml->endElement();
	            continue;
	        }
	        if (!empty($value)) { $buildxml->writeElement($key, $value); }
	    }
	}
	write($buildxml, $xmlRequest);
	$buildxml->endElement();
	$xmlStr = $buildxml->outputMemory(true);
	if ($debug == 1) { echo "<br>----------[URL]----------<br>" . $mp_url . "<br><br>----------[Request]----------<br>" . htmlentities($xmlStr) . "<br>------------------------------------------<br>"; }
	$ch = curl_init($mp_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'charset=utf-8'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	$output = curl_exec($ch);
	curl_close($ch);
	if ($debug == 1) { echo "<br>----------[Response]----------<br>" . htmlentities($output) . "<br>------------------------------------------<br>"; }
	$xmlResponse = new SimpleXMLElement($output);
	$maxiPago_result = array(); 
	if ($startElement == "transaction-request") {
		if ($xmlResponse->getName() == "api-error") { $maxiPago_result["error"] = (string)$xmlResponse->errorCode[0] . ": " . (string)$xmlResponse->errorMsg[0]; }
		elseif ($xmlResponse->getName() == "transaction-response") {
			foreach ($xmlResponse as $key => $value) {
				if ($key == "save-on-file") {
					$subXml = $value;
					foreach ($subXml as $key => $value) { $maxiPago_result[$key] = (string)$value; }
				}
				elseif ($key == "transactionTimestamp") {
					$value = (string)$value;
					if (strlen($value) == 10) { $date = date("c", $value); }
					elseif (strlen($value) == 13) { $date = date("c", $value/1000); }
					$maxiPago_result[$key] = $date;
				}
				elseif ($key != "errorMessage") { $maxiPago_result[$key] = (string)$value; }
			}
			if ($xmlResponse->errorMessage[0] == true) { $maxiPago_result["error"] = (string)$xmlResponse->errorMessage[0]; }	
		}
	}
	elseif ($startElement == "api-request") {
		foreach ($xmlResponse as $key => $value) {
			if ($key == "result") {
				$subXml = $value;
				foreach ($subXml as $key => $value) { $maxiPago_result[$key] = (string)$value; }
			}
			elseif ($key != "time") { $maxiPago_result[$key] = (string)$value; }
			elseif ($key == "time") {
				$value = (string)$value;
				if (strlen($value) == 10) { $date = date(c, $value); }
				elseif (strlen($value) == 13) { $date = date(c, $value/1000); }
				$maxiPago_result[$key] = $date;
			}
		}
		if ($xmlResponse->errorMessage[0] == true) { $maxiPago_result["error"] = (string)$xmlResponse->errorMessage[0]; }	
	}
	elseif ($startElement == "rapi-request") {
		foreach ($xmlResponse as $key => $value) {
			if ($key == "header") {
				$subXml = $value;
				foreach ($subXml as $key => $value) { $maxiPago_result[$key] = (string)$value; }
			}
			elseif ($key == "result") {
				$resultSetInfo = $xmlResponse->result->resultSetInfo[0];
				if (!empty($resultSetInfo)) {
					foreach ($resultSetInfo as $key => $value)  { $maxiPago_result[$key] = (string)$value; }
					$records = $xmlResponse->result->records[0];
					$c = 1;
					foreach ($records as $key => $value) {
						$subXml = $value;
						foreach ($subXml as $key => $value) { $maxiPago_result["records"][$c][$key] = (string)$value; }
						$c++;
					}
				}
			}
		}	
	
	}
	if ($debug == 1) { echo "<br>----------['maxipago_payment' Response]----------<br>"; print_r($maxiPago_result); echo "<br>------------------------------------------<br><br>"; }
	return $maxiPago_result;
}
function maxipago_payment($transactionType, $mid, $data, $version, $mp_url) {
  if (!is_array($mid) || !is_array($data) || empty($transactionType) || empty($mp_url) || empty($version)) { $maxiPago_result["error"] = "'payment_function' error: expected to receive (string), (array), (array), (version), (url)."; return $maxiPago_result; }
  if (($transactionType == "sale") || ($transactionType == "auth")) {
  	if (($data["recurring"]) && ($transactionType == "sale")) { $transactionType = "recurringPayment"; }
  	elseif (($data["recurring"]) && ($transactionType == "auth")) { $maxiPago_result["error"] = "'payment_function' error: recurring payments can only accept 'sale' transactions."; return $maxiPago_result; }
	$xmlRequest = array(
		"version" => $version, 
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			$transactionType => array(
				"processorID" => $data["processorID"],
				"authentication" => $data["authentication"],
				"referenceNum" => $data["referenceNum"],
				"ipAddress" => $data["ipAddress"],
				"invoiceNumber" => $data["invoiceNumber"],
				"billing" => array(
					"name" => $data["bname"],
					"address" => $data["baddress"],
					"address2" => $data["baddress2"],
					"city" => $data["bcity"],
					"state" => $data["bstate"],
					"postalcode" => $data["bpostalcode"],
					"country" => $data["bcountry"],
					"phone" => $data["bphone"],
					"email" => $data["bemail"]
				),
				"shipping" => array(
					"name" => $data["sname"],
					"address" => $data["saddress"],
					"address2" => $data["saddress2"],
					"city" => $data["scity"],
					"state" => $data["sstate"],
					"postalcode" => $data["spostalcode"],
					"country" => $data["scountry"],
					"phone" => $data["sphone"],
					"email" => $data["semail"]
				),			
				"transactionDetail" => array(
			    	"payType" => array(
						"creditCard" => array(
							"number" => $data["number"],
							"expMonth" => $data["expMonth"],
							"expYear" => $data["expYear"],
							"cvvNumber" => $data["cvvNumber"],
							"eCommInd" => "eci"
						)
					)
				),
				"payment" => array(
					"chargeTotal" => $data["chargeTotal"],                                  
				),
			),
			"clientData" => array(
				"comments" => $data["comments"]
			)
		)
	);
	if ($data["numberOfInstallments"]) {
		if (!$data["chargeInterest"]) { $data["chargeInterest"] = "N"; }
		$creditInstallment = array(
			"numberOfInstallments" => $data["numberOfInstallments"],
			"chargeInterest" => $data["chargeInterest"]
		);
		$xmlRequest["order"][$transactionType]["payment"]["creditInstallment"] = $creditInstallment; 
	}
	if ($data["saveOnFile"]) {
		if ($data["customerId"] && $data["bname"] && $data["baddress"]) {
			$addOnFile = array(
				"customerToken" => $data["customerId"],
				"onFileEndDate" => $data["onFileEndDate"],
				"onFilePermission" => $data["onFilePermission"],
				"onFileComment" => $data["onFileComment"],
				"onFileMaxChargeAmount" => $data["onFileMaxChargeAmount"]
			);
			$xmlRequest["order"][$transactionType]["saveOnFile"] = $addOnFile;
		}
		else { 
			$maxiPago_result["error"] = "'payment_function' error: expected to receive 'customerId' and billing information if saving card on file.";
			return $maxiPago_result;
		} 
	}
	elseif ($data["recurring"]) {
		if ($data["startDate"] && $data["frequency"] && $data["period"] && $data["installments"] && $data["failureThreshold"]) {
			$recurrency = array(
				"action" => "new",
				"startDate" => $data["startDate"],
				"frequency"=> $data["frequency"],
				"period" => $data["period"],
				"installments" => $data["installments"],
				"failureThreshold" => $data["failureThreshold"]
			);
			$xmlRequest["order"][$transactionType]["recurring"] = $recurrency;
		}
		else { 
			$maxiPago_result["error"] = "'payment_function' error: expected to receive recurring information.";
			return $maxiPago_result;
		}
	}
	$requestType = "transaction-request";
  }
  elseif ($transactionType == "capture") {
	$xmlRequest = array(
		"version" => $version,
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			$transactionType => array(
				"orderID" =>  $data["orderID"], 
				"referenceNum" => $data["referenceNum"],
				"payment" => array(
			    	"chargeTotal" => $data["chargeTotal"]
				)
			)
		)
	);  
	$requestType = "transaction-request";
  }
  elseif (($transactionType == "return") || ($transactionType == "refund")) {
	$xmlRequest = array(
		"version" => $version,
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			"return" => array(
				"orderID" =>  $data["orderID"], 
				"referenceNum" => $data["referenceNum"],
				"payment" => array(
			    	"chargeTotal" => $data["chargeTotal"]
				)
			)
		)
	);  
	$requestType = "transaction-request";
  }
  elseif ($transactionType == "void") {
	$xmlRequest = array(
		"version" => $version,
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			$transactionType => array(
				"transactionID" => $data["transactionID"]
			)
		)
	);
	$requestType = "transaction-request";
  }
  elseif ($transactionType == "boleto") {
	$xmlRequest = array(
		"version" => $version,
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			"sale" => array(
				"processorID" => $data["processorID"],
				"referenceNum" => $data["referenceNum"],
				"ipAddress" => $data["ipAddress"],
				"billing" => array(
					"name" => $data["bname"],
					"address" => $data["baddress"],
					"address2" => $data["baddress2"],
					"city" => $data["bcity"],
					"state" => $data["bstate"],
					"postalcode" => $data["bpostalcode"],
					"country" => $data["bcountry"],
					"phone" => $data["bphone"],
					"email" => $data["bemail"]
				),
				"transactionDetail" => array(
					"payType" => array(
						"boleto" => array(
							"expirationDate" => $data["expirationDate"],
							"number" => $data["number"],
							"instructions" => $data["instructions"]
						)
					)
				),
				"payment" => array(
					"chargeTotal" => $data["chargeTotal"]
				)
			)
		)
	);
	$requestType = "transaction-request";
  }
  elseif ($transactionType == "add-consumer") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => $transactionType,
		"request" => array(
			"customerIdExt" => $data["customerIdExt"],
			"firstName" => $data["firstName"],
			"lastName" => $data["lastName"],
			"address1" => $data["address1"],
			"address2" => $data["address2"],
			"city" => $data["city"],
			"state" => $data["state"],
			"zip" => $data["zip"],
			"country" => $data["country"],
			"phone" => $data["phone"],
			"email" => $data["email"],
			"dob" => $data["dob"],
			"alternatePhone" => $data["alternatePhone"],
			"sex" => $data["sex"]
		)
	);	
  	$requestType = "api-request";
  }
  elseif ($transactionType == "update-consumer") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => $transactionType,
		"request" => array(
			"customerId" => $data["customerId"],
			"customerIdExt" => $data["customerIdExt"],
			"firstName" => $data["firstName"],
			"lastName" => $data["lastName"],
			"zip" => $data["zip"],
			"email" => $data["email"],
			"dob" => $data["dob"],
			"ssn" => $data["ssn"],
			"sex" => $data["sex"]
		)
	);  	
  	$requestType = "api-request";
  }
  elseif ($transactionType == "delete-consumer") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => "delete-consumer",
		"request" => array(
			"customerId" => $data["customerId"]
		)
	);	
  	$requestType = "api-request";
  }
  elseif ($transactionType == "add-card-onfile") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => $transactionType,
		"request" => array(
			"customerId" => $data["customerId"],
			"creditCardNumber" => $data["creditCardNumber"],
			"expirationMonth" => $data["expirationMonth"],
			"expirationYear" => $data["expirationYear"],
			"billingName" => $data["billingName"],
			"billingAddress1" => $data["billingAddress1"],
			"billingAddress2" => $data["billingAddress2"],
			"billingCity" => $data["billingCity"],
			"billingState" => $data["billingState"],
			"billingZip" => $data["billingZip"],
			"billingCountry" => $data["billingCountry"],
			"billingPhone" => $data["billingPhone"],
			"billingEmail" => $data["billingEmail"]
		)
	);	
  	$requestType = "api-request"; 	
  }	
  elseif ($transactionType == "remove-card-onfile") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => $transactionType,
		"request" => array(
			"customerId" => $data["customerId"],
			"token" => $data["token"],
		)
	);	
  	$requestType = "api-request";
  }
  elseif ($transactionType == "cancel-recurring") {
	$xmlRequest = array(
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"command" => $transactionType,
		"request" => array(
			"orderID" => $data["orderID"],
		)
	);	
  	$requestType = "api-request";
  }
  elseif (($transactionType == "token-sale") || ($transactionType == "token-auth")) {
  	$transactionType = str_ireplace("token-","",$transactionType);
	$xmlRequest = array(
		"version" => $version, 
		"verification" => array(
			"merchantId" => $mid["merchantId"],
			"merchantKey" => $mid["merchantKey"]
		),
		"order" => array(
			$transactionType => array(
				"processorID" => $data["processorID"],
				"authentication" => $data["authentication"],
				"referenceNum" => $data["referenceNum"],
				"ipAddress" => $data["ipAddress"],
				"invoiceNumber" => $data["invoiceNumber"],
				"billing" => array(
					"name" => $data["bname"],
					"address" => $data["baddress"],
					"address2" => $data["baddress2"],
					"city" => $data["bcity"],
					"state" => $data["bstate"],
					"postalcode" => $data["bpostalcode"],
					"country" => $data["bcountry"],
					"phone" => $data["bphone"],
					"email" => $data["bemail"]
				),
				"shipping" => array(
					"name" => $data["sname"],
					"address" => $data["saddress"],
					"address2" => $data["saddress2"],
					"city" => $data["scity"],
					"state" => $data["sstate"],
					"postalcode" => $data["spostalcode"],
					"country" => $data["scountry"],
					"phone" => $data["sphone"],
					"email" => $data["semail"]
				),			
				"transactionDetail" => array(
			    	"payType" => array(
						"onFile" => array(
							"customerId" => $data["customerId"],
							"token" => $data["token"]
						)
					)
				),
				"payment" => array(
					"chargeTotal" => $data["chargeTotal"],
					"creditInstallment" => array(
						"numberOfInstallments" => $data["numberOfInstallments"],
						"chargeInterest" => $data["chargeInterest"]
					)                                     
				),
			),
			"clientData" => array(
				"comments" => $data["comments"]
			)
		)
	);	
  	$requestType = "transaction-request";
  }	
   elseif ($transactionType == "report") {
   	if ($data["transactionId"] == true) {
	  	$xmlRequest = array(
			"verification" => array(
				"merchantId" => $mid["merchantId"],
				"merchantKey" => $mid["merchantKey"]
			),
			"command" => "transactionDetailReport",
			"request" => array(
				"filterOptions" => array(
					"transactionId" => $data["transactionId"]
				)
			)
		);
   	}
   	elseif ($data["period"]) {
	  	$xmlRequest = array(
			"verification" => array(
				"merchantId" => $mid["merchantId"],
				"merchantKey" => $mid["merchantKey"]
			),
			"command" => "transactionDetailReport",
			"request" => array(
				"filterOptions" => array(
					"period" => $data["period"],
					"pagesize" => "50",
					"startDate" => $data["startDate"],
					"endDate" => $data["endDate"],
					"orderByName" => $data["orderByName"],
					"orderByDirection" => $data["orderByDirection"]
				)
			)
		);
   	}
   	elseif ($data["pageToken"]) {
	  	$xmlRequest = array(
			"verification" => array(
				"merchantId" => $mid["merchantId"],
				"merchantKey" => $mid["merchantKey"]
			),
			"command" => "transactionDetailReport",
			"request" => array(
				"filterOptions" => array(
					"pageToken" => $data["pageToken"],
					"pageNumber" => $data["pageNumber"]
				)
			)
		);
   	}
   	elseif ($data["checkStatus"]) {
	  	$xmlRequest = array(
			"verification" => array(
				"merchantId" => $mid["merchantId"],
				"merchantKey" => $mid["merchantKey"]
			),
			"command" => "checkRequestStatus",
			"request" => array(
				"requestToken" => $data["requestToken"]
			)
		);		
   	}
  	$requestType = "rapi-request";
  }
  else { $maxiPago_result["error"] = "'payment_function' error: [" . $transactionType . "] is not a supported transaction type."; return $maxiPago_result; }
  $maxiPago_result = mp_xml($xmlRequest, $requestType, $mp_url, $data["debug"]);
  return $maxiPago_result;
} 
?>