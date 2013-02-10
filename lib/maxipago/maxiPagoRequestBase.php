<?php
class maxiPagoRequestBase {
    
    protected $version = '3.1.1.15';
    protected $sslVerify = 2;
    protected $timeout = 30;
    public static $debug;

    public function setEndpoint($param) {
        if (!$param) { throw new Exception('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no Endpoint defined'); }
        $this->endpoint = $param;
    }
    
    public function setTransactionType($param) {
        if (!$param) { throw new Exception('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no Transaction Type defined'); }
        $this->type = $param;
    }
    
    public function setVars($array) {
        if (!$array) { throw new Exception('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method: no array to format.', 400); }
        foreach($array as $k => $v) { $this->$k = $v; }
        $this->validateCall();
    }
    
    private function validateCall() {
        if ((strlen($this->processorID) > 0) && ((!ctype_digit($this->processorID)) || (strlen($this->processorID) > 2))) { throw new Exception("[maxiPago Class] Field 'processorID' is invalid. Please check documentation for valid values."); }
        if ((strlen($this->number) > 0) && (!ctype_digit($this->number))) { throw new Exception("[maxiPago Class] Field 'number' accepts only numerical values."); }
        if ((strlen($this->expMonth) > 0) && ((strlen($this->expMonth) < 2) || (!ctype_digit($this->expMonth)))) { throw new Exception("[maxiPago Class] Credit card expiration month must have 2 digits."); }
        if ((strlen($this->expirationMonth) > 0) && ((strlen($this->expirationMonth) < 2) || (!ctype_digit($this->expirationMonth)))) { throw new Exception("[maxiPago Class] Credit card expiration month must have 2 digits."); }
        if ((strlen($this->expYear) > 0) && ((strlen($this->expYear) < 4) || (!ctype_digit($this->expYear)))) { throw new Exception("[maxiPago Class] Credit card expiration year must have 4 digits."); }
        if ((strlen($this->expirationYear) > 0) && ((strlen($this->expirationYear) < 2) || (!ctype_digit($this->expirationYear)))) { throw new Exception("[maxiPago Class] Credit card expiration year must have 4 digits."); }
        if ((strlen($this->numberOfInstallments) > 0) && (!ctype_digit($this->numberOfInstallments))) { throw new Exception("[maxiPago Class] Field 'numberOfInstallments' accepts only numerical values."); }
        if ((strlen($this->chargeInterest) > 0) && (!in_array(strtoupper($this->chargeInterest), array("Y", "N")))) { throw new Exception("[maxiPago Class] Field 'chargeInterest' only accepts Y and N as value."); }
        if ((strlen($this->expirationDate) > 0) && (strtotime($this->expirationDate) < strtotime("now"))) { throw new Exception("[maxiPago Class] Boleto expiration date can only be set in the future."); }
        if ((strlen($this->instructions) > 0) && (strlen($this->instructions) > 100)) { throw new Exception("[maxiPago Class] Boleto instructions cannot be longer than 100 characters."); }
    }
    
    public function processRequest() {
        switch($this->type) {
            case "auth":
            case "sale":
                $this->tag = "<transaction-request></transaction-request>";
                $this->setAuthOrSale();
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
            case "boleto":
                $this->tag = "<transaction-request></transaction-request>";
                $this->type = "sale";
                $this->setBoleto();
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
                throw new Exception('[maxiPago Class] Transaction type '.$type.' is invalid. Transaction was not sent.');
                break;
        }
        return $this->sendXml();
    }
   
    protected $merchantId;
    protected $merchantKey;
    protected $processorID;
    protected $referenceNum;
    protected $ipAddress;
    protected $bname;
    protected $baddress;
    protected $baddress2;
    protected $bcity;
    protected $bstate;
    protected $bpostalcode;
    protected $bcountry;
    protected $bphone;
    protected $bemail;
    protected $sname;
    protected $saddress;
    protected $saddress2;
    protected $scity;
    protected $sstate;
    protected $spostalcode;
    protected $scountry;
    protected $sphone;
    protected $semail;
    protected $number;
    protected $expMonth;
    protected $expYear;
    protected $cvvNumber;
    protected $cvvInd;
    protected $chargeTotal;
    protected $chargeInterest;
    protected $numberOfInstallments;
    protected $currencyCode;
    protected $comments;
    protected $authentication;
    protected $saveOnFile;
    protected $onFileEndDate;
    protected $onFilePermission;
    protected $onFileMaxChargeAmount;
    protected $onFileComment;
    protected $recurring;
    protected $frequency;
    protected $installments;
    protected $failureThreshold;
    protected $orderID;
    protected $transactionID;
    protected $expirationDate;
    protected $instructions;
    protected $customerIdExt;
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
    protected $creditCardNumber;
    protected $expirationMonth;
    protected $expirationYear;
    protected $billingName;
    protected $billingAddress1;
    protected $billingAddress2;
    protected $billingCity;
    protected $billingState;
    protected $billingZip;
    protected $billingCountry;
    protected $billingPhone;
    protected $billingEmail;
    protected $parametersURL = '';
    protected $transactionId;
    protected $period;
    protected $pageSize;
    protected $startDate;
    protected $endDate;
    protected $startTime;
    protected $endTime;
    protected $orderByName;
    protected $orderByDirection;
    protected $token;
    protected $requestToken;
    protected $pageToken;
    protected $pageNumber;
    protected $fraudCheck;
    protected $xmlResponse;
    
}
?>