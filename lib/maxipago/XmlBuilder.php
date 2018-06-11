<?php

class maxiPago_XmlBuilder extends maxiPago_RequestBase {

    protected $xml;
    
    public function __construct($array) {
        $this->merchantId = $array["merchantId"];
        $this->merchantKey = $array["merchantKey"];
    }
  
    protected function setRequest() {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.$this->tag);
        if ($this->tag == "<transaction-request></transaction-request>") { $this->xml->addChild("version", $this->version); }
        $this->xml->addChild("verification");
        $this->xml->verification->addChild("merchantId", $this->merchantId);
        $this->xml->verification->addChild("merchantKey", $this->merchantKey);
    }
     
    protected function setOrder() {
        $type = $this->type;
        $this->xml->addChild("order");
        $this->xml->order->addChild($type);
        if (strlen($this->processorID) > 0 ) {  $this->xml->order->$type->addChild("processorID", $this->processorID); }
        if (strlen($this->referenceNum) > 0 ) {  $this->xml->order->$type->addChild("referenceNum", $this->referenceNum); }
        if (strlen($this->customerIdExt) > 0) { $this->xml->order->$type->addChild("customerIdExt", $this->customerIdExt); }
        if (strlen($this->fraudCheck) > 0 ) { $this->xml->order->$type->addChild("fraudCheck", strtoupper($this->fraudCheck)); }
        if (strlen($this->ipAddress) > 0 ) { $this->xml->order->$type->addChild("ipAddress", strtoupper($this->ipAddress)); }
        $this->setAddress();
    }
    
    protected function setAddress() {
        $type = $this->type;
        switch($type) {
            case "auth":
            case "sale":
            case "boleto":
                $this->xml->order->$type->addChild("billing");
                if (($type == "boleto") && (strlen($this->bname) == 0)) { throw new InvalidArgumentException("[maxiPago Class] Billing name is mandatory for Boleto transactions."); }
                if (strlen($this->bname) > 0) { $this->xml->order->$type->billing->addChild("name", $this->bname); }
                if (strlen($this->baddress) > 0) { $this->xml->order->$type->billing->addChild("address", $this->baddress); }
                if (strlen($this->baddress2) > 0) { $this->xml->order->$type->billing->addChild("address2", $this->baddress2); }
                if (strlen($this->bcity) > 0) { $this->xml->order->$type->billing->addChild("city", $this->bcity); }
                if (strlen($this->bstate) > 0) { $this->xml->order->$type->billing->addChild("state", $this->bstate); }
                if (strlen($this->bpostalcode) > 0) { $this->xml->order->$type->billing->addChild("postalcode", $this->bpostalcode); }
                if (strlen($this->bcountry) > 0) { $this->xml->order->$type->billing->addChild("country", $this->bcountry); }
                if (strlen($this->bphone) > 0) { $this->xml->order->$type->billing->addChild("phone", $this->bphone); }
                if (strlen($this->bemail) > 0) { $this->xml->order->$type->billing->addChild("email", $this->bemail); }
                $this->xml->order->$type->addChild("shipping");
                if (strlen($this->sname) > 0) { $this->xml->order->$type->shipping->addChild("name", $this->sname); }
                if (strlen($this->saddress) > 0) { $this->xml->order->$type->shipping->addChild("address", $this->saddress); }
                if (strlen($this->saddress2) > 0) { $this->xml->order->$type->shipping->addChild("address2", $this->saddress2); }
                if (strlen($this->scity) > 0) { $this->xml->order->$type->shipping->addChild("city", $this->scity); }
                if (strlen($this->sstate) > 0) { $this->xml->order->$type->shipping->addChild("state", $this->sstate); }
                if (strlen($this->spostalcode) > 0) { $this->xml->order->$type->shipping->addChild("postalcode", $this->spostalcode); }
                if (strlen($this->scountry) > 0) { $this->xml->order->$type->shipping->addChild("country", $this->scountry); }
                if (strlen($this->sphone) > 0) { $this->xml->order->$type->shipping->addChild("phone", $this->sphone); }
                if (strlen($this->semail) > 0) { $this->xml->order->$type->shipping->addChild("email", $this->semail); }          
                break;
            case "add-consumer":
            case "update-consumer":
                $this->xml->request->addChild("firstName", $this->firstName);
                $this->xml->request->addChild("lastName", $this->lastName);
                if (strlen($this->address1) > 0) { $this->xml->request->addChild("address1", $this->address1); }
                if (strlen($this->address2) > 0) { $this->xml->request->addChild("address2", $this->address2); }
                if (strlen($this->city) > 0) { $this->xml->request->addChild("city", $this->city); }
                if (strlen($this->state) > 0) { $this->xml->request->addChild("state", $this->state); }
                if (strlen($this->zip) > 0) { $this->xml->request->addChild("zip", $this->zip); }
                if (strlen($this->country) > 0) { $this->xml->request->addChild("country", $this->country); }
                if (strlen($this->phone) > 0) { $this->xml->request->addChild("phone", $this->phone); }
                if (strlen($this->email) > 0) { $this->xml->request->addChild("email", $this->email); }
                if (strlen($this->dob) > 0) { $this->xml->request->addChild("dob", $this->dob); }
                if (strlen($this->sex) > 0) { $this->xml->request->addChild("sex", strtoupper($this->sex)); }
                break;            
            case "add-card-onfile":
                $this->xml->request->addChild("billingName", $this->billingName);
                $this->xml->request->addChild("billingAddress1", $this->billingAddress1);
                $this->xml->request->addChild("billingAddress2", $this->billingAddress2);
                $this->xml->request->addChild("billingCity", $this->billingCity);
                $this->xml->request->addChild("billingState", $this->billingState);
                $this->xml->request->addChild("billingZip", $this->billingZip);
                $this->xml->request->addChild("billingCountry", $this->billingCountry);
                $this->xml->request->addChild("billingPhone", $this->billingPhone);
                $this->xml->request->addChild("billingEmail", $this->billingEmail);
                break;
            default:
                break;
        }
    }
    
    protected function setAuthOrSale() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("transactionDetail");
        $this->xml->order->$type->transactionDetail->addChild("payType");
        if (strlen($this->number) > 0) {
            $this->xml->order->$type->transactionDetail->payType->addChild("creditCard");
            $this->xml->order->$type->transactionDetail->payType->creditCard->addChild("number", $this->number);
            $this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expMonth", $this->expMonth);
            $this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expYear", $this->expYear);
            if (strlen($this->cvvNumber) > 0) { $this->xml->order->$type->transactionDetail->payType->creditCard->addChild("cvvNumber", $this->cvvNumber); }
        }
        elseif ((strlen($this->token) > 0) && (strlen($this->customerId) > 0)) {
            $this->xml->order->$type->transactionDetail->payType->addChild("onFile");
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("token", $this->token);
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("customerId", $this->customerId);
        }
        else { throw new InvalidArgumentException('[maxiPago Class] Invalid payment data for Credit Card transaction.'); }
        $this->setPayment();
        if (($this->saveOnFile) && (!$this->token) && ($this->type != "recurringPayment")) { $this->setSaveOnFile(); }
    }
    
    protected function setDebtSale() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("transactionDetail");
        $this->xml->order->$type->transactionDetail->addChild("payType");
        if (strlen($this->number) > 0) {
            $this->xml->order->$type->transactionDetail->payType->addChild("debitCard");
            $this->xml->order->$type->transactionDetail->payType->debitCard->addChild("number", $this->number);
            $this->xml->order->$type->transactionDetail->payType->debitCard->addChild("expMonth", $this->expMonth);
            $this->xml->order->$type->transactionDetail->payType->debitCard->addChild("expYear", $this->expYear);
            if (strlen($this->cvvNumber) > 0) { $this->xml->order->$type->transactionDetail->payType->debitCard->addChild("cvvNumber", $this->cvvNumber); }
        }
        elseif ((strlen($this->token) > 0) && (strlen($this->customerId) > 0)) {
            $this->xml->order->$type->transactionDetail->payType->addChild("onFile");
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("token", $this->token);
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("customerId", $this->customerId);
        }
        else { throw new InvalidArgumentException('[maxiPago Class] Invalid payment data for Credit Card transaction.'); }
        $this->setPayment();
        if (($this->saveOnFile) && (!$this->token) && ($this->type != "recurringPayment")) { $this->setSaveOnFile(); }
    }
    
    protected function setBoleto() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("transactionDetail");
        $this->xml->order->$type->transactionDetail->addChild("payType");        
        $this->xml->order->$type->transactionDetail->payType->addChild("boleto");
        $this->xml->order->$type->transactionDetail->payType->boleto->addChild("number", $this->number);
        $this->xml->order->$type->transactionDetail->payType->boleto->addChild("expirationDate", $this->expirationDate);
        if (strlen($this->instructions) > 0) { $this->xml->order->$type->transactionDetail->payType->boleto->addChild("instructions", $this->instructions); }
        $this->setPayment();
    }
    
    protected function setOnlineDebit() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("transactionDetail");
        $this->xml->order->$type->transactionDetail->addChild("payType");
        $this->xml->order->$type->transactionDetail->payType->addChild("onlineDebit");
        $this->xml->order->$type->transactionDetail->payType->onlineDebit->addChild("parametersURL", $this->parametersURL);
        $this->setPayment();
    }
    
    protected function setPayment() {
        $type = $this->type;
        $this->xml->order->$type->addChild("payment");
        $this->xml->order->$type->payment->addChild("chargeTotal", $this->chargeTotal);
        if (strlen($this->softDescriptor) > 0) { $this->xml->order->$type->payment->addChild("softDescriptor", $this->softDescriptor); }
        if (strlen($this->iataFee) > 0) { $this->xml->order->$type->payment->addChild("iataFee", $this->iataFee); }
        if (strlen($this->currencyCode) > 0) { $this->xml->order->$type->payment->addChild("currencyCode", strtoupper($this->currencyCode)); }
        if (in_array($type, array("auth", "sale", "recurringPayment"))) {
            if ($this->numberOfInstallments > 1) {
                $this->xml->order->$type->payment->addChild("creditInstallment");
                $this->xml->order->$type->payment->creditInstallment->addChild("numberOfInstallments", $this->numberOfInstallments);
                if ((strlen($this->chargeInterest) > 0) && (!in_array(strtoupper($this->chargeInterest), array("Y", "N")))) { throw new InvalidArgumentException("[maxiPago Class] Field 'chargeInterest' accepts only Y or N."); }
                elseif (strlen($this->chargeInterest) == 0) { $this->chargeInterest = "N"; }
                $this->xml->order->$type->payment->creditInstallment->addChild("chargeInterest", strtoupper($this->chargeInterest));
            }
        }
    }
    
    protected function setSaveOnFile() {
        $type = $this->type;
        $this->xml->order->$type->addChild("saveOnFile");
        $this->xml->order->$type->saveOnFile->addChild("customerToken", $this->customerId);
        if (strlen($this->onFileEndDate) > 0) { $this->xml->order->$type->saveOnFile->addChild("onFileEndDate", $this->onFileEndDate); }
        if (strlen($this->onFilePermission) > 0) { $this->xml->order->$type->saveOnFile->addChild("onFilePermission", $this->onFilePermission); }
        if (strlen($this->onFileComment) > 0) { $this->xml->order->$type->saveOnFile->addChild("onFileComment", $this->onFileComment); }
        if (strlen($this->onFileMaxChargeAmount) > 0) { $this->xml->order->$type->saveOnFile->addChild("onFileMaxChargeAmount", $this->onFileMaxChargeAmount); }
    }
    
    protected function setCaptureOrReturn() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("orderID", $this->orderID);
        $this->setPayment();
    }
    
    protected function setVoid() {
        $this->setRequest();
        $this->setOrder();
        $type = $this->type;
        $this->xml->order->$type->addChild("transactionID", $this->transactionID);      
    }
     
    protected function setRecurring() {
        $this->setAuthOrSale();
        $type = $this->type;
        $this->xml->order->$type->addChild("recurring");
        $this->xml->order->$type->recurring->addChild("action", "new");
        $this->xml->order->$type->recurring->addChild("startDate", $this->startDate);
        $this->xml->order->$type->recurring->addChild("frequency", $this->frequency);
        $this->xml->order->$type->recurring->addChild("installments", $this->installments);
        $this->xml->order->$type->recurring->addChild("period", $this->period);
        $this->xml->order->$type->recurring->addChild("failureThreshold", $this->failureThreshold);
    }
           
    protected function setCommand() {
        $this->xml->addChild("command", $this->type);
    }

    protected function setApiRequest() {
        $this->setRequest();
        $this->setCommand();
        $this->xml->addChild("request");
        if (strlen($this->customerId) > 0) { $this->xml->request->addChild("customerId", $this->customerId); }
        if (strlen($this->customerIdExt) > 0) { $this->xml->request->addChild("customerIdExt", $this->customerIdExt); }
        if (strlen($this->token)) { $this->xml->request->addChild("token", $this->token); }
        if (strlen($this->creditCardNumber) > 0) { $this->xml->request->addChild("creditCardNumber", $this->creditCardNumber); }
        if (strlen($this->expirationMonth) > 0) { $this->xml->request->addChild("expirationMonth", $this->expirationMonth); }
        if (strlen($this->expirationYear) > 0) { $this->xml->request->addChild("expirationYear", $this->expirationYear); }
        if (strlen($this->orderID) > 0) { $this->xml->request->addChild("orderID", $this->orderID); }
        $this->setAddress();
    }
    
    protected function setRapiRequest() {
        $this->setRequest();
        $this->setCommand();
        $this->xml->addChild("request");
        $this->xml->request->addChild("filterOptions");
        if (strlen($this->transactionID) > 0) {
            $this->xml->request->filterOptions->addChild("transactionId", $this->transactionID);
        }
        elseif (strtolower($this->period) == "range") {
            $this->xml->request->filterOptions->addChild("period", $this->period);
            $this->xml->request->filterOptions->addChild("pageSize", $this->pageSize);
            $this->xml->request->filterOptions->addChild("startDate", $this->startDate);
            $this->xml->request->filterOptions->addChild("endDate", $this->endDate);
            $this->xml->request->filterOptions->addChild("startTime", $this->startTime);
            $this->xml->request->filterOptions->addChild("endTime", $this->endTime);
            $this->xml->request->filterOptions->addChild("orderByName", $this->orderByName);
            $this->xml->request->filterOptions->addChild("orderByDirection", $this->orderByDirection);
        }
        elseif (in_array(strtolower($this->period), array("today", "yesterday", "lastmonth", "thismonth"))) {
            $this->xml->request->filterOptions->addChild("period", $this->period);
        }
        elseif ((strlen($this->pageToken) > 0) && (strlen($this->pageNumber) > 0)) {
            $this->xml->request->filterOptions->addChild("pageToken", $this->pageToken);
            $this->xml->request->filterOptions->addChild("pageNumber", $this->pageNumber);
        }
        else { throw new InvalidArgumentException("[maxiPago Class] Field 'filterOptions' is invalid. Please see documention for help."); }
    }

}
