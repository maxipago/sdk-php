<?php
class maxiPago_RequestBase {
    
    protected $version = '3.1.1.15';
    protected $timeout = 60;
    protected static $sslVerifyPeer = 1;
    protected static $sslVerifyHost = 2;
    public static $logger;
    public static $loggerSev;
    public static $debug;

    public function setEndpoint($param) {
        try {
            if (!$param) { 
            	throw new BadMethodCallException('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no Endpoint defined'); 
            }
            $this->endpoint = $param;
            if (is_object(maxiPago_RequestBase::$logger)) { 
            	maxiPago_RequestBase::$logger->logDebug('Setting endpoint to "'.$param.'"'); 
            }
        }
        catch (Exception $e) {
            if (is_object(self::$logger)) { 
            	self::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); 
            }
            throw $e;
        }
    }
    
    public function setTransactionType($param) {
        try {
            if (!$param) { 
            	throw new BadMethodCallException('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no Transaction Type defined'); 
            }
            $this->type = $param;
        }
        catch (Exception $e) {
        	if (is_object(self::$logger)) { 
        		self::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); 
        	}
            throw $e;
        }
    }
    
    public function setVars($array) {
        try {
            if (!$array) { 
            	throw new BadMethodCallException('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no array to format.', 400); 
            }
            foreach($array as $k => $v) { 
            	$this->$k = $v; 
            }
            if (is_object(self::$logger)) { 
                if (self::$loggerSev != 'DEBUG') { 
                	$array = self::clearForLog($array); 
                }
                self::$logger->logNotice('Parameters sent', $array);
            }
            $this->validateCall();
        }
        catch (Exception $e) {
        	if (is_object(self::$logger)) { 
        		self::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); 
        	}
            throw $e;
        }
    }
    
    public static function setSslVerify($param) {
    	self::$sslVerifyHost = $param;
    	self::$sslVerifyPeer = $param;
    }
    
    public static function setLogger($path, $severity='INFO') {
        switch ($severity) {
            case "EMERG":
                self::$logger = new KLogger($path, KLogger::EMERG);
                break;
            case "ALERT":
                self::$logger = new KLogger($path, KLogger::ALERT);
                break;
            case "CRIT":
                self::$logger = new KLogger($path, KLogger::CRIT);
                break;
            case "ERR":
                self::$logger = new KLogger($path, KLogger::ERR);
                break;
            case "WARN":
                self::$logger = new KLogger($path, KLogger::WARN);
                break;
            case "NOTICE":
                self::$logger = new KLogger($path, KLogger::NOTICE);
                break;
            case "INFO": // Severities INFO and up are safe to use in Production as Credit Card info are NOT logged
                self::$logger = new KLogger($path, KLogger::INFO);
                break;
            case "DEBUG": // Do NOT use 'DEBUG' for Production environment as Credit Card info WILL BE LOGGED
                self::$logger = new KLogger($path, KLogger::DEBUG);
                break;
        }
        if (self::$logger->_logStatus == 1) { 
        	self::$loggerSev = $severity; 
        }
        else { 
        	self::$logger = null; 
        }
    }
    
    public static function clearForLog($text) {
        if ((!isset($text)) || (self::$loggerSev == 'DEBUG')) { 
        	return $text; 
        }
        elseif (is_array($text)) {
            @$text["cvvNumber"] = str_ireplace($text["cvvNumber"], str_repeat("*", strlen($text["cvvNumber"])), $text["cvvNumber"]);
            if (maxiPago_ServiceBase::checkCreditCard(@$text["number"])) { 
            	@$text["number"] = str_ireplace($text["number"], substr_replace($text["number"], str_repeat('*',strlen($text["number"])-4),'4'), $text["number"]); 
            }
            return $text;
        }
        elseif (strlen($text) >= 8) { 
        	return substr_replace($text, str_repeat('*',strlen($text)-4),'4'); 
        }
        else { 
        	return substr_replace($text, str_repeat('*', strlen($text)-2),'2'); 
        }
    }
       
    private function validateCall() {
        try {
            if ((strlen($this->processorID) > 0) && ((!ctype_digit((string)$this->processorID)) || (strlen($this->processorID) > 2))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Field 'processorID' is invalid. Please check documentation for valid values."); 
            }
            if ((strlen($this->number) > 0) && (!ctype_digit((string)$this->number))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Field 'number' accepts only numerical values."); 
            }
            if ((strlen($this->expMonth) > 0) && ((strlen($this->expMonth) < 2) || (!ctype_digit((string)$this->expMonth)))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Credit card expiration month must have 2 digits."); 
            }
            if ((strlen($this->expirationMonth) > 0) && ((strlen($this->expirationMonth) < 2) || (!ctype_digit((string)$this->expirationMonth)))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Credit card expiration month must have 2 digits."); 
            }
            if ((strlen($this->expYear) > 0) && ((strlen($this->expYear) < 4) || (!ctype_digit((string)$this->expYear)))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Credit card expiration year must have 4 digits."); 
            }
            if ((strlen($this->expirationYear) > 0) && ((strlen($this->expirationYear) < 2) || (!ctype_digit((string)$this->expirationYear)))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Credit card expiration year must have 4 digits."); 
            }
            if ((strlen($this->numberOfInstallments) > 0) && (!ctype_digit((string)$this->numberOfInstallments))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Field 'numberOfInstallments' accepts only numerical values."); 
            }
            if ((strlen($this->chargeInterest) > 0) && (!in_array(strtoupper($this->chargeInterest), array("Y", "N")))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Field 'chargeInterest' only accepts Y and N as value."); 
            }
            if ((strlen($this->expirationDate) > 0) && (date("Ymd", strtotime($this->expirationDate)) < date("Ymd"))) { 
            	throw new InvalidArgumentException("[maxiPago Class] Boleto expiration date can only be set in the future."); 
            }
            if ((strlen($this->instructions) > 0) && (strlen($this->instructions) > 350)) { 
            	throw new InvalidArgumentException("[maxiPago Class] Boleto instructions cannot be longer than 350 characters."); 
            }
        }
        catch (Exception $e) {
        	if (is_object(self::$logger)) { 
        		self::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); 
        	}
            throw $e;
        }
    }
    
    public function processRequest() {
        try {
            switch($this->type) {
                case "auth":
                case "sale":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->setAuthOrSale();
                    if ($this->fraudCheck == "Y"){
                    	$this->setFraudDetails();
                    	$this->setItens();
                    }
                    break;
                case "capture": 
                case "return":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->setCaptureOrReturn();
                    break;
                case "recurringPayment":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->setRecurring();                    
                    break;
                case "void":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->setVoid();
                    break;
                case "onlineDebit":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->type = "sale";
                    $this->setOnlineDebit();
                    break;
                case "boleto":
                    $this->tag = "<transaction-request></transaction-request>";
                    $this->type = "sale";
                    $this->setBoleto();
                    break;
                case "redepay":
                	$this->tag = "<transaction-request></transaction-request>";
                	$this->type = "sale";
                	$this->setRedepay();
                	break;
                case "authCreditCard3DS":
                	$this->tag = "<transaction-request></transaction-request>";
                	$this->type = "auth";
                	$this->setAuthCreditCard3DS();
                	if ($this->fraudCheck == "Y"){
                		$this->setFraudDetails();
                	}
                	break;
                case "saleCreditCard3DS":
                	$this->tag = "<transaction-request></transaction-request>";
                	$this->type = "sale";
                	$this->setSaleCreditCard3DS();
                	if ($this->fraudCheck == "Y"){
                		$this->setFraudDetails();
                	}
                	break;
                case "saleDebitCard3DS":
                	$this->tag = "<transaction-request></transaction-request>";
                	$this->type = "sale";
                	$this->setSaleDebitCard3DS();
                	if ($this->fraudCheck == "Y"){
                		$this->setFraudDetails();
                	}
                	break;
    			case "add-consumer":
    			case "delete-consumer":
    			case "update-consumer":
    			case "add-card-onfile":
    			case "delete-card-onfile":
    			case "cancel-recurring":
                	$this->tag = "<api-request></api-request>";
                    $this->setApiRequest();
                    break;
                case "report":
                    $this->tag = "<rapi-request></rapi-request>";
                    $this->type = "transactionDetailReport";
                    $this->setRapiRequest();
                    break;
                default:
                    throw new BadMethodCallException('[maxiPago Class] Transaction type '.$type.' is invalid. Transaction was not sent.');
                    break;
            }
            return $this->sendXml();
        }
        catch (Exception $e) {
        	if (is_object(self::$logger)) { self::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); }
            throw $e;
        }
    }
   

    
    
    protected $authentication;
    protected $baddress;
    protected $baddress2;
    protected $bcity;
    protected $bcountry;
    protected $bemail;
    protected $billingAddress1;
    protected $bname;
    protected $bphone;
    protected $bpostalcode;
    protected $bstate;
    protected $comments;    
    protected $creditCardNumber;
    protected $cvvInd;
    protected $endDate;
    protected $endTime;
    protected $expirationDate;
    protected $expirationMonth;
    protected $expirationYear;
    protected $instructions;            
    protected $onFileComment;
    protected $onFileEndDate;
    protected $onFileMaxChargeAmount;
    protected $onFilePermission;
    protected $orderByDirection;
    protected $orderByName;
    protected $orderID;
    protected $pageNumber;
    protected $pageSize;
    protected $pageToken;
    protected $parametersURL = '';
    protected $recurring;
    protected $requestToken;
    protected $saddress;
    protected $saddress2;
    protected $saveOnFile;
    protected $scity;
    protected $scountry;
    protected $semail;    
    protected $sname;
    protected $softDescriptor;
    protected $sphone;
    protected $spostalcode;
    protected $sstate;
    protected $startTime;    
    protected $token;
    protected $transactionID;
    protected $transactionId;
    protected $xmlResponse;    
    protected $authenticated;
    protected $authenticationURL;
    protected $processorTransactionID;
    protected $processorReferenceNumber;
    
    
    //Recurring
    protected $action;
    protected $startDate;
    protected $frequency;
    protected $period;
    protected $installments;
    protected $firstAmount;
    protected $lastAmount;
    protected $lastDate;
    protected $failureThreshold;
        
    //Authentication Data
    protected $merchantId;
    protected $merchantKey;
    
    //Order Data
    protected $processorID;
    protected $referenceNum;
    protected $fraudCheck;
    protected $customerIdExt;
    protected $ipAddress;
    protected $invoiceNumber;
    protected $userAgent;
    
    //Authentication Data
    protected $mpiProcessorID;
    protected $onFailure;
    
    //Billing Data 
    protected $billingId;
    protected $billingName;
    protected $billingAddress;
    protected $billingAddress2;
    protected $billingDistrict;
    protected $billingCity;
    protected $billingZip;
    protected $billingState;
    protected $billingPostalCode;
    protected $billingCountry;
    protected $billingEmail;
    protected $billingPhone;
    protected $billingCompanyName;
    protected $billingType;
    protected $billingGender;
    protected $billingBirthDate;
    protected $billingPhoneType;
    protected $billingPhoneCountryCode;
    protected $billingPhoneAreaCode;
    protected $billingPhoneNumber;
    protected $billingPhoneExtension;
    protected $billingDocumentType;
    protected $billingDocumentValue;
    
    //Shipping Data
    protected $shippingId;
    protected $shippingName;
    protected $shippingAddress;
    protected $shippingAddress2;
    protected $shippingDistrict;
    protected $shippingCity;
    protected $shippingZip;
    protected $shippingState;
    protected $shippingPostalCode;
    protected $shippingCountry;
    protected $shippingEmail;
    protected $shippingPhone;
    protected $shippingType;
    protected $shippingGender;
    protected $shippingBirthDate;
    protected $shippingPhoneType;
    protected $shippingPhoneCountryCode;
    protected $shippingPhoneAreaCode;
    protected $shippingPhoneNumber;
    protected $shippingPhoneExtension;
    protected $shippingDocumentType;
    protected $shippingDocumentValue;
    
    //Fraud Data
    protected $fraudProcessorID;
    protected $captureOnLowRisk;
    protected $voidOnHighRisk;
    protected $websiteId;
    protected $fraudToken;
    
    //CreditCard Data
    protected $number;
    protected $expMonth;
    protected $expYear;
    protected $cvvNumber;
    
    //Payment Data
    protected $currencyCode;
    protected $chargeTotal;
    protected $iataFee;
    protected $chargeInterest;
    protected $numberOfInstallments;
    protected $shippingTotal;
    
    //Itens Data
    protected $itemIndex;
    protected $itemProductCode;
    protected $itemDescription;
    protected $itemQuantity;
    protected $itemTotalAmount;
    protected $itemUnitCost;
    
    //Create, Update and Delete Customers 
    protected $firstName;
    protected $lastName;
    protected $address1;
    protected $address2;
    protected $city;
    protected $state;
    protected $zip;
    protected $country;
    protected $phone;
    protected $email;
    protected $dob;
    protected $sex;
    protected $customerId;
}
