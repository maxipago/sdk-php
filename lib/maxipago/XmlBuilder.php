<?php

class maxiPago_XmlBuilder extends maxiPago_RequestBase {

    protected $xml;
    
    public function __construct($array) {
        $this->merchantId = $array["merchantId"];
        $this->merchantKey = $array["merchantKey"];
    }
  
    protected function setRequest() {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.$this->tag);
        if ($this->tag == "<transaction-request></transaction-request>") { 
        	$this->xml->addChild("version", $this->version); 
        }
        $this->xml->addChild("verification");
        $this->xml->verification->addChild("merchantId", $this->merchantId);
        $this->xml->verification->addChild("merchantKey", $this->merchantKey);
    }
     
    protected function setOrder() {
        $type = $this->type;
        $this->xml->addChild("order");
        $this->xml->order->addChild($type);
        if (strlen($this->processorID) > 0 ) {  
        	$this->xml->order->$type->addChild("processorID", $this->processorID); 
        }
        if (strlen($this->referenceNum) > 0 ) {  
        	$this->xml->order->$type->addChild("referenceNum", $this->referenceNum); 
        }
        if (strlen($this->customerIdExt) > 0) { 
        	$this->xml->order->$type->addChild("customerIdExt", $this->customerIdExt); 
        }
        if (strlen($this->fraudCheck) > 0) {
        	$this->xml->order->$type->addChild("fraudCheck", strtoupper($this->fraudCheck)); 
        }
        if (strlen($this->ipAddress) > 0 ) { 
        	$this->xml->order->$type->addChild("ipAddress", strtoupper($this->ipAddress)); 
        }
        if (strlen($this->invoiceNumber) > 0 ) {
        	$this->xml->order->$type->addChild("invoiceNumber", strtoupper($this->invoiceNumber));
        }
        if (strlen($this->userAgent) > 0 ) {
        	$this->xml->order->$type->addChild("userAgent", strtoupper($this->userAgent));
        }
        $this->setAddress();
    }
    
    protected function setAddress() {
        $type = $this->type;
        switch($type) {
            case "auth":
            case "sale":
            	$this->xml->order->$type->addChild("billing");
            	if (strlen($this->billingId) > 0) {
            		$this->xml->order->$type->billing->addChild("id", $this->billingId);
            	}
            	if (strlen($this->billingName) > 0) { 
            		$this->xml->order->$type->billing->addChild("name", $this->billingName); 
            	}
            	if (strlen($this->billingAddress) > 0) { 
            		$this->xml->order->$type->billing->addChild("address", $this->billingAddress); 
            	}
            	if (strlen($this->billingAddress2) > 0) { 
            		$this->xml->order->$type->billing->addChild("address2", $this->billingAddress2); 
            	}
            	if (strlen($this->billingDistrict) > 0) { 
            		$this->xml->order->$type->billing->addChild("district", $this->billingDistrict); 
            	}
            	if (strlen($this->billingCity) > 0) { 
            		$this->xml->order->$type->billing->addChild("city", $this->billingCity); 
            	}
            	if (strlen($this->billingState) > 0) { 
            		$this->xml->order->$type->billing->addChild("state", $this->billingState); 
            	}
            	if (strlen($this->billingPostalCode) > 0) { 
            		$this->xml->order->$type->billing->addChild("postalcode", $this->billingPostalCode); 
            	}
            	if (strlen($this->billingCountry) > 0) { 
            		$this->xml->order->$type->billing->addChild("country", $this->billingCountry); 
            	}
            	if (strlen($this->billingEmail) > 0) {
            		$this->xml->order->$type->billing->addChild("email", $this->billingEmail);
            	}
            	if (strlen($this->billingCompanyName) > 0) {
            		$this->xml->order->$type->billing->addChild("companyName", $this->billingCompanyName);
            	}
            	if (strlen($this->billingType) > 0) {
            		$this->xml->order->$type->billing->addChild("type", $this->billingType);
            	}
            	if (strlen($this->billingGender) > 0) { 
            		$this->xml->order->$type->billing->addChild("gender", $this->billingGender); 
            	}
            	if (strlen($this->billingBirthDate) > 0) {
            		$this->xml->order->$type->billing->addChild("birthDate", $this->billingBirthDate);
            	}
            	$this->setBillingPhone();
            	$this->setBillingDocuments();
            	$this->xml->order->$type->addChild("shipping");
            	if (strlen($this->shippingId) > 0) { 
            		$this->xml->order->$type->shipping->addChild("id", $this->shippingId); 
            	}
            	if (strlen($this->shippingName) > 0) { 
            		$this->xml->order->$type->shipping->addChild("name", $this->shippingName); 
            	}
            	if (strlen($this->shippingAddress) > 0) { 
            		$this->xml->order->$type->shipping->addChild("address", $this->shippingAddress); 
            	}
            	if (strlen($this->shippingAddress2) > 0) { 
            		$this->xml->order->$type->shipping->addChild("address2", $this->shippingAddress2); 
            	}
            	if (strlen($this->shippingDistrict) > 0) { 
            		$this->xml->order->$type->shipping->addChild("district", $this->shippingDistrict); 
            	}
            	if (strlen($this->shippingCity) > 0) { 
            		$this->xml->order->$type->shipping->addChild("city", $this->shippingCity); 
            	}
            	if (strlen($this->shippingState) > 0) { 
            		$this->xml->order->$type->shipping->addChild("state", $this->shippingState); 
            	}
            	if (strlen($this->shippingPostalCode) > 0) { 
            		$this->xml->order->$type->shipping->addChild("postalcode", $this->shippingPostalCode); 
            	}
            	if (strlen($this->shippingCountry) > 0) { 
            		$this->xml->order->$type->shipping->addChild("country", $this->shippingCountry); 
            	}
            	if (strlen($this->shippingPhone) > 0) { 
            		$this->xml->order->$type->shipping->addChild("phone", $this->shippingPhone); 
            	}
            	if (strlen($this->shippingEmail) > 0) { 
            		$this->xml->order->$type->shipping->addChild("email", $this->shippingEmail); 
            	}
            	if (strlen($this->shippingType) > 0) { 
            		$this->xml->order->$type->shipping->addChild("type", $this->shippingType); 
            	}
            	if (strlen($this->shippingGender) > 0) { 
            		$this->xml->order->$type->shipping->addChild("gender", $this->shippingGender); 
            	}
            	if (strlen($this->shippingBirthDate) > 0) { 
            		$this->xml->order->$type->shipping->addChild("birthDate", $this->shippingBirthDate); 
            	}
            	$this->setShippingPhone();
            	$this->setShippingDocuments();
            	break;
            case "recurringPayment":
            	$this->xml->order->$type->addChild("billing");
            	if (strlen($this->billingId) > 0) {
            		$this->xml->order->$type->billing->addChild("id", $this->billingId);
            	}
            	if (strlen($this->billingName) > 0) {
            		$this->xml->order->$type->billing->addChild("name", $this->billingName);
            	}
            	if (strlen($this->billingAddress) > 0) {
            		$this->xml->order->$type->billing->addChild("address", $this->billingAddress);
            	}
            	if (strlen($this->billingAddress2) > 0) {
            		$this->xml->order->$type->billing->addChild("address2", $this->billingAddress2);
            	}
            	if (strlen($this->billingDistrict) > 0) {
            		$this->xml->order->$type->billing->addChild("district", $this->billingDistrict);
            	}
            	if (strlen($this->billingCity) > 0) {
            		$this->xml->order->$type->billing->addChild("city", $this->billingCity);
            	}
            	if (strlen($this->billingState) > 0) {
            		$this->xml->order->$type->billing->addChild("state", $this->billingState);
            	}
            	if (strlen($this->billingPostalCode) > 0) {
            		$this->xml->order->$type->billing->addChild("postalcode", $this->billingPostalCode);
            	}
            	if (strlen($this->billingCountry) > 0) {
            		$this->xml->order->$type->billing->addChild("country", $this->billingCountry);
            	}
            	if (strlen($this->billingEmail) > 0) {
            		$this->xml->order->$type->billing->addChild("email", $this->billingEmail);
            	}
            	if (strlen($this->billingCompanyName) > 0) {
            		$this->xml->order->$type->billing->addChild("companyName", $this->billingCompanyName);
            	}
            	if (strlen($this->billingType) > 0) {
            		$this->xml->order->$type->billing->addChild("type", $this->billingType);
            	}
            	if (strlen($this->billingGender) > 0) {
            		$this->xml->order->$type->billing->addChild("gender", $this->billingGender);
            	}
            	if (strlen($this->billingBirthDate) > 0) {
            		$this->xml->order->$type->billing->addChild("birthDate", $this->billingBirthDate);
            	}
            	$this->xml->order->$type->addChild("shipping");
            	if (strlen($this->shippingId) > 0) {
            		$this->xml->order->$type->shipping->addChild("id", $this->shippingId);
            	}
            	if (strlen($this->shippingName) > 0) {
            		$this->xml->order->$type->shipping->addChild("name", $this->shippingName);
            	}
            	if (strlen($this->shippingAddress) > 0) {
            		$this->xml->order->$type->shipping->addChild("address", $this->shippingAddress);
            	}
            	if (strlen($this->shippingAddress2) > 0) {
            		$this->xml->order->$type->shipping->addChild("address2", $this->shippingAddress2);
            	}
            	if (strlen($this->shippingDistrict) > 0) {
            		$this->xml->order->$type->shipping->addChild("district", $this->shippingDistrict);
            	}
            	if (strlen($this->shippingCity) > 0) {
            		$this->xml->order->$type->shipping->addChild("city", $this->shippingCity);
            	}
            	if (strlen($this->shippingState) > 0) {
            		$this->xml->order->$type->shipping->addChild("state", $this->shippingState);
            	}
            	if (strlen($this->shippingPostalCode) > 0) {
            		$this->xml->order->$type->shipping->addChild("postalcode", $this->shippingPostalCode);
            	}
            	if (strlen($this->shippingCountry) > 0) {
            		$this->xml->order->$type->shipping->addChild("country", $this->shippingCountry);
            	}
            	if (strlen($this->shippingPhone) > 0) {
            		$this->xml->order->$type->shipping->addChild("phone", $this->shippingPhone);
            	}
            	if (strlen($this->shippingEmail) > 0) {
            		$this->xml->order->$type->shipping->addChild("email", $this->shippingEmail);
            	}
            	if (strlen($this->shippingType) > 0) {
            		$this->xml->order->$type->shipping->addChild("type", $this->shippingType);
            	}
            	if (strlen($this->shippingGender) > 0) {
            		$this->xml->order->$type->shipping->addChild("gender", $this->shippingGender);
            	}
            	if (strlen($this->shippingBirthDate) > 0) {
            		$this->xml->order->$type->shipping->addChild("birthDate", $this->shippingBirthDate);
            	}
            	break;
            case "add-consumer":
            case "update-consumer":
                $this->xml->request->addChild("firstName", $this->firstName);
                $this->xml->request->addChild("lastName", $this->lastName);
                if (strlen($this->address1) > 0) { 
                	$this->xml->request->addChild("address1", $this->address1);
                }
                if (strlen($this->address2) > 0) { 
                	$this->xml->request->addChild("address2", $this->address2); 
                }
                if (strlen($this->city) > 0) {
                	$this->xml->request->addChild("city", $this->city); 
                }
                if (strlen($this->state) > 0) {
                	$this->xml->request->addChild("state", $this->state); 
                }
                if (strlen($this->zip) > 0) { 
                	$this->xml->request->addChild("zip", $this->zip); 
                }
                if (strlen($this->country) > 0) { 
                	$this->xml->request->addChild("country", $this->country); 
                }
                if (strlen($this->phone) > 0) { 
                	$this->xml->request->addChild("phone", $this->phone); 
                }
                if (strlen($this->email) > 0) {
                	$this->xml->request->addChild("email", $this->email); 
                }
                if (strlen($this->dob) > 0) {
                	$this->xml->request->addChild("dob", $this->dob); 
                }
                if (strlen($this->sex) > 0) {
                	$this->xml->request->addChild("sex", strtoupper($this->sex)); 
                }
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
    
    protected function setBillingPhone(){
    	$type = $this->type;
    	$this->xml->order->$type->billing->addChild("phones");
    	$this->xml->order->$type->billing->phones->addChild("phone");
    	if (strlen($this->billingPhoneType) > 0) {
    		$this->xml->order->$type->billing->phones->phone->addChild("phoneType", $this->billingPhoneType);
    	}
    	if (strlen($this->billingPhoneCountryCode) > 0) {
    		$this->xml->order->$type->billing->phones->phone->addChild("phoneCountryCode", $this->billingPhoneCountryCode);
    	}
    	if (strlen($this->billingPhoneAreaCode) > 0) {
    		$this->xml->order->$type->billing->phones->phone->addChild("phoneAreaCode", $this->billingPhoneAreaCode);
    	}
    	if (strlen($this->billingPhoneNumber) > 0) {
    		$this->xml->order->$type->billing->phones->phone->addChild("phoneNumber", $this->billingPhoneNumber);
    	}
    	if (strlen($this->billingPhoneExtension) > 0) {
    		$this->xml->order->$type->billing->phones->phone->addChild("phoneExtension", $this->billingPhoneExtension);
    	}
    }
    
    protected function setBillingDocuments(){
    	$type = $this->type;
    	$this->xml->order->$type->billing->addChild("documents");
    	$this->xml->order->$type->billing->documents->addChild("document");
    	if (strlen($this->billingDocumentType) > 0) {
    		$this->xml->order->$type->billing->documents->document->addChild("documentType", $this->billingDocumentType);
    	}
    	if (strlen($this->billingDocumentValue) > 0) {
    		$this->xml->order->$type->billing->documents->document->addChild("documentValue", $this->billingDocumentValue);
    	}
    	
    }
    
    protected function setShippingPhone(){
    	$type = $this->type;
    	$this->xml->order->$type->shipping->addChild("phones");
    	$this->xml->order->$type->shipping->phones->addChild("phone");
    	if (strlen($this->shippingPhoneType) > 0) {
    		$this->xml->order->$type->shipping->phones->phone->addChild("phoneType", $this->shippingPhoneType);
    	}
    	if (strlen($this->shippingPhoneCountryCode) > 0) {
    		$this->xml->order->$type->shipping->phones->phone->addChild("phoneCountryCode", $this->shippingPhoneCountryCode);
    	}
    	if (strlen($this->shippingPhoneAreaCode) > 0) {
    		$this->xml->order->$type->shipping->phones->phone->addChild("phoneAreaCode", $this->shippingPhoneAreaCode);
    	}
    	if (strlen($this->shippingPhoneNumber) > 0) {
    		$this->xml->order->$type->shipping->phones->phone->addChild("phoneNumber", $this->shippingPhoneNumber);
    	}
    	if (strlen($this->shippingPhoneExtension) > 0) {
    		$this->xml->order->$type->shipping->phones->phone->addChild("phoneExtension", $this->shippingPhoneExtension);
    	}
    }
    
    protected function setShippingDocuments(){
    	$type = $this->type;
    	$this->xml->order->$type->shipping->addChild("documents");
    	$this->xml->order->$type->shipping->documents->addChild("document");
    	if (strlen($this->shippingDocumentType) > 0) {
    		$this->xml->order->$type->shipping->documents->document->addChild("documentType", $this->shippingDocumentType);
    	}
    	if (strlen($this->shippingDocumentValue) > 0) {
    		$this->xml->order->$type->shipping->documents->document->addChild("documentValue", $this->shippingDocumentValue);
    	}
    	
    }
    
    protected function setItens(){
    	$type = $this->type;
    	$this->xml->order->$type->addChild("itemList");
    	$this->xml->order->$type->itemList->addChild("item");
    	if (strlen($this->itemIndex) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemIndex", $this->itemIndex);
    	}
    	if (strlen($this->itemProductCode) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemProductCode", $this->itemProductCode);
    	}
    	if (strlen($this->itemDescription) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemDescription", $this->itemDescription);
    	}
    	if (strlen($this->itemQuantity) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemQuantity", $this->itemQuantity);
    	}
    	if (strlen($this->itemTotalAmount) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemTotalAmount", $this->itemTotalAmount);
    	}
    	if (strlen($this->itemUnitCost) > 0) {
    		$this->xml->order->$type->itemList->item->addChild("itemUnitCost", $this->itemUnitCost);
    	}
    }
    
    protected function setFraudDetails(){
    	$type = $this->type;
    	$this->xml->order->$type->addChild("fraudDetails");
    	if (strlen($this->fraudProcessorID) > 0) {
    		$this->xml->order->$type->fraudDetails->addChild("fraudProcessorID", $this->fraudProcessorID);
    	}
    	if (strlen($this->captureOnLowRisk) > 0) {
    		$this->xml->order->$type->fraudDetails->addChild("captureOnLowRisk", $this->captureOnLowRisk);
    	}
    	if (strlen($this->voidOnHighRisk) > 0) {
    		$this->xml->order->$type->fraudDetails->addChild("voidOnHighRisk", $this->voidOnHighRisk);
    	}
    	if (strlen($this->websiteId) > 0) {
    		$this->xml->order->$type->fraudDetails->addChild("websiteId", $this->websiteId);
    	}
    	if (strlen($this->fraudToken) > 0) {
    		$this->xml->order->$type->fraudDetails->addChild("fraudToken", $this->fraudToken);
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
            if (strlen($this->cvvNumber) > 0) { 
            	$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("cvvNumber", $this->cvvNumber); 
            }
        }
        elseif ((strlen($this->token) > 0) && (strlen($this->customerId) > 0)) {
            $this->xml->order->$type->transactionDetail->payType->addChild("onFile");
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("token", $this->token);
            $this->xml->order->$type->transactionDetail->payType->onFile->addChild("customerId", $this->customerId);
        }
        else { 
        	throw new InvalidArgumentException('[maxiPago Class] Invalid payment data for Credit Card transaction.'); 
        }
        $this->setPayment();
        if (($this->saveOnFile) && (!$this->token) && ($this->type != "recurringPayment")) { 
        	$this->setSaveOnFile(); 
        }
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
        if (strlen($this->instructions) > 0) { 
        	$this->xml->order->$type->transactionDetail->payType->boleto->addChild("instructions", $this->instructions); 
        }
        $this->setPayment();
    }
    
    protected function setRedepay(){
    	$this->setRequest();
    	$this->setOrder();
    	$type = $this->type;
    	$this->xml->order->$type->addChild("transactionDetail");
    	$this->xml->order->$type->transactionDetail->addChild("payType");
    	$this->xml->order->$type->transactionDetail->payType->addChild("eWallet");
    	$this->xml->order->$type->transactionDetail->payType->eWallet->addChild("parametersURL", $this->parametersURL);
    	$this->setItens();
    	$this->setPayment();
    }
    
    protected function setAutentication(){
    	$type = $this->type;
    	$this->xml->order->$type->addChild("authentication");
    	if (strlen($this->mpiProcessorID) > 0) {
    		$this->xml->order->$type->authentication->addChild("mpiProcessorID", $this->mpiProcessorID);
    	}
    	if (strlen($this->onFailure) > 0) {
    		$this->xml->order->$type->authentication->addChild("onFailure", $this->onFailure);
    	}
    }
    
    protected function setAuthCreditCard3DS(){
    	$this->setRequest();
    	$this->setOrder();
    	$this->setAutentication();
    	$type = $this->type;
    	$this->xml->order->$type->addChild("transactionDetail");
    	$this->xml->order->$type->transactionDetail->addChild("payType");
    	$this->xml->order->$type->transactionDetail->payType->addChild("creditCard");
    	if (strlen($this->number) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("number", $this->number);
    	}
    	if (strlen($this->expMonth) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expMonth", $this->expMonth);
    	}
    	if (strlen($this->expYear) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expYear", $this->expYear);
    	}
    	if (strlen($this->cvvNumber) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("cvvNumber", $this->cvvNumber);
    	}
    	$this->setPayment();
    	$this->setItens();
    }
    
    protected function setSaleCreditCard3DS(){
    	$this->setRequest();
    	$this->setOrder();
    	$this->setAutentication();
    	$type = $this->type;
    	$this->xml->order->$type->addChild("transactionDetail");
    	$this->xml->order->$type->transactionDetail->addChild("payType");
    	$this->xml->order->$type->transactionDetail->payType->addChild("creditCard");
    	if (strlen($this->number) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("number", $this->number);
    	}
    	if (strlen($this->expMonth) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expMonth", $this->expMonth);
    	}
    	if (strlen($this->expYear) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("expYear", $this->expYear);
    	}
    	if (strlen($this->cvvNumber) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->creditCard->addChild("cvvNumber", $this->cvvNumber);
    	}
    	$this->setPayment();
    	$this->setItens();
    }
    
    protected function setSaleDebitCard3DS(){
    	$this->setRequest();
    	$this->setOrder();
    	$this->setAutentication();
    	$type = $this->type;
    	$this->xml->order->$type->addChild("transactionDetail");
    	$this->xml->order->$type->transactionDetail->addChild("payType");
    	$this->xml->order->$type->transactionDetail->payType->addChild("debitCard");
    	if (strlen($this->number) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->debitCard->addChild("number", $this->number);
    	}
    	if (strlen($this->expMonth) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->debitCard->addChild("expMonth", $this->expMonth);
    	}
    	if (strlen($this->expYear) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->debitCard->addChild("expYear", $this->expYear);
    	}
    	if (strlen($this->cvvNumber) > 0) {
    		$this->xml->order->$type->transactionDetail->payType->debitCard->addChild("cvvNumber", $this->cvvNumber);
    	}
    	$this->setPayment();
    	$this->setItens();
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
        if (strlen($this->softDescriptor) > 0) { 
        	$this->xml->order->$type->payment->addChild("softDescriptor", $this->softDescriptor); 
        }
        if (strlen($this->iataFee) > 0) { 
        	$this->xml->order->$type->payment->addChild("iataFee", $this->iataFee); 
        }
        if (strlen($this->currencyCode) > 0) { 
        	$this->xml->order->$type->payment->addChild("currencyCode", strtoupper($this->currencyCode)); 
        }
        if (in_array($type, array("auth", "sale", "recurringPayment"))) {
            if ($this->numberOfInstallments > 1) {
                $this->xml->order->$type->payment->addChild("creditInstallment");
                $this->xml->order->$type->payment->creditInstallment->addChild("numberOfInstallments", $this->numberOfInstallments);
                if ((strlen($this->chargeInterest) > 0) && (!in_array(strtoupper($this->chargeInterest), array("Y", "N")))) { 
                	throw new InvalidArgumentException("[maxiPago Class] Field 'chargeInterest' accepts only Y or N."); 
                }
                elseif (strlen($this->chargeInterest) == 0) { 
                	$this->chargeInterest = "N"; 
                }
                $this->xml->order->$type->payment->creditInstallment->addChild("chargeInterest", strtoupper($this->chargeInterest));
            }
        }
    }
    
    protected function setSaveOnFile() {
        $type = $this->type;
        $this->xml->order->$type->addChild("saveOnFile");
        $this->xml->order->$type->saveOnFile->addChild("customerToken", $this->customerId);
        if (strlen($this->onFileEndDate) > 0) { 
        	$this->xml->order->$type->saveOnFile->addChild("onFileEndDate", $this->onFileEndDate); 
        }
        if (strlen($this->onFilePermission) > 0) { 
        	$this->xml->order->$type->saveOnFile->addChild("onFilePermission", $this->onFilePermission); 
        }
        if (strlen($this->onFileComment) > 0) { 
        	$this->xml->order->$type->saveOnFile->addChild("onFileComment", $this->onFileComment); 
        }
        if (strlen($this->onFileMaxChargeAmount) > 0) { 
        	$this->xml->order->$type->saveOnFile->addChild("onFileMaxChargeAmount", $this->onFileMaxChargeAmount); 
        }
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
        if (strlen($this->action) > 0) {
        	$this->xml->order->$type->recurring->addChild("startDate", $this->startDate);
        }
        if (strlen($this->frequency) > 0) {
        	$this->xml->order->$type->recurring->addChild("frequency", $this->frequency);
        }
        if (strlen($this->period) > 0) {
        	$this->xml->order->$type->recurring->addChild("period", $this->period);
        }
        if (strlen($this->installments) > 0) {
        	$this->xml->order->$type->recurring->addChild("installments", $this->installments);
        }
        if (strlen($this->failureThreshold) > 0) {
        	$this->xml->order->$type->recurring->addChild("failureThreshold", $this->failureThreshold);
        }
        if (strlen($this->firstAmount) > 0) {
        	$this->xml->order->$type->recurring->addChild("firstAmount", $this->firstAmount);
        }
        if (strlen($this->lastAmount) > 0) {
        	$this->xml->order->$type->recurring->addChild("lastAmount", $this->lastAmount);
        }
        if (strlen($this->lastDate) > 0) {
        	$this->xml->order->$type->recurring->addChild("lastDate", $this->lastDate);
        }
    }
           
    protected function setCommand() {
        $this->xml->addChild("command", $this->type);
    }

    protected function setApiRequest() {
        $this->setRequest();
        $this->setCommand();
        $this->xml->addChild("request");
        if (strlen($this->customerId) > 0) { 
        	$this->xml->request->addChild("customerId", $this->customerId); 
        }
        if (strlen($this->customerIdExt) > 0) { 
        	$this->xml->request->addChild("customerIdExt", $this->customerIdExt); 
        }
        if (strlen($this->token)) { 
        	$this->xml->request->addChild("token", $this->token); 
        }
        if (strlen($this->creditCardNumber) > 0) { 
        	$this->xml->request->addChild("creditCardNumber", $this->creditCardNumber); 
        }
        if (strlen($this->expirationMonth) > 0) { 
        	$this->xml->request->addChild("expirationMonth", $this->expirationMonth); 
        }
        if (strlen($this->expirationYear) > 0) { 
        	$this->xml->request->addChild("expirationYear", $this->expirationYear); 
        }
        if (strlen($this->orderID) > 0) { 
        	$this->xml->request->addChild("orderID", $this->orderID); 
        }
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