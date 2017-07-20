<?php
class maxiPago_ResponseBase extends maxiPago_ServiceBase {

    public $response;
    
	/**
	 * Checks if the transaction syntax was valid
	 * @return boolean
	 */
	public function isTransactionResponse() {
	    if ((isset($this->response["responseCode"])) && ($this->response["responseCode"] >= 0)) { return true; }
	    elseif ((isset($this->response["errorCode"])) && ($this->response["errorCode"] == 0)) { return true; }
	    else { return false; }
	}
	
	/**
	 * Checks if the transaction syntax was invalid
	 * @return boolean
	 */
	public function isErrorResponse() {
	    if ((isset($this->response["errorCode"])) && ($this->response["errorCode"] > 0)) { return true; }
	    else { return false; }
	}
	
    /**
     * Gets the request's response code
     * 
     * List of available response codes:
     *     0 = Approved
     *     1 = Declined
     *     2 = Fraud Declined
     *     5 = Fraud Review
     *     1022 = Acquirer error
     *     1024 = Error in parameters sent (INVALID TRANSACTION)
     *     1025 = Credentials error
     *     2048 = Internal error
     * 
     * @return int
     */
    public function getResponseCode() {
        if ((isset($this->response["responseCode"])) && ($this->response["responseCode"] >= 0)) { return $this->response["responseCode"]; }
        elseif ((isset($this->response["errorCode"])) && ($this->response["errorCode"] >= 0)) { return (string)$this->response["errorCode"]; }
        else { return null; }
    }

    /**
     * Maps the responseCode to HTTP status code.
     *  
     * @return int
     */
    public function getHTTPStatusCode() { 
        if ($this->isErrorResponse()) {
            return 500;
        }
        switch ($this->getResponseCode()) {
            case 0: 
                return 200;
            case 1:
            case 2:
            case 1025:
                return 403;
            case 5:
                return 202;
            case 1022:
            case 2048:
                return 502;
            case 1024:
                return 400;
        }
        return 502;
    }
    
    /**
     * Gets the request's error message, if any
     * 
     * If there is a problem with the request that the maxiPago! API has detected,
     * such as invalid credit card number, an 'errorMessage' is replied.
     * 
     * If, however, the error was at the processor, such as insufficient funds, then
     * a 'processorMessage' is replied.
     * 
     * This method gets whichever message was thrown by the API response.
     * 
     * @return string
     */
    public function getMessage() {
        if ((isset($this->response["processorMessage"])) && (strlen($this->response["processorMessage"]) > 0)) { return $this->response["processorMessage"]; }
        elseif ((isset($this->response["errorMessage"])) && (strlen($this->response["errorMessage"]) > 0)) { return $this->response["errorMessage"]; }
        elseif ((isset($this->response["errorMsg"])) && (strlen($this->response["errorMsg"]) > 0)) { return $this->response["errorMsg"]; }
        else { return null; }
    }

    /**
     * Gets authotization code returned by the Acquirer
     * @return string
     */
    public function getAuthCode() {
        if ((isset($this->response["authCode"])) && (strlen($this->response["authCode"]) > 0)) { return $this->response["authCode"]; }
    }

    /**
     * Gets the Order ID created by maxiPago!
     * @return string
     */
    public function getOrderID() {
        if ((isset($this->response["orderID"])) && (strlen($this->response["orderID"]) > 0)) { return $this->response["orderID"]; }
    }

    /**
     * Gets the Reference Number sent by the Merchant
     * @return string
     */
    public function getReferenceNum() {
        if ((isset($this->response["referenceNum"])) && (strlen($this->response["referenceNum"]) > 0)) { return $this->response["referenceNum"]; }
    }
    
    /**
     * Gets the Transaction ID created by maxiPago!
     * @return string
     */
    public function getTransactionID() {
        if ((isset($this->response["transactionID"])) && (strlen($this->response["transactionID"]) > 0)) { return $this->response["transactionID"]; }
    }
    
    /**
     * Gets the transaction timestamp in Unix time
     * @return string
     */
    public function getTransactionTimestamp() {
        if ((isset($this->response["transactionTimestamp"])) && (strlen($this->response["transactionTimestamp"]) > 0)) { return $this->response["transactionTimestamp"]; }
    }
    
    /**
     * Gets the AVS response code (US only)
     * @return string
     */
    public function getAvsResponseCode() {
        if ((isset($this->response["avsResponseCode"])) && (strlen($this->response["avsResponseCode"]) > 0)) { return $this->response["avsResponseCode"]; }
    }
    
    /**
     * Gets the CVV response code (US only)
     * @return string
     */
    public function getCvvResponseCode() {
        if ((isset($this->response["cvvResponseCode"])) && (strlen($this->response["cvvResponseCode"]) > 0)) { return $this->response["cvvResponseCode"]; }
    }
    
    /**
     * Gets the Acquirer's return code
     * @return string
     */
    public function getProcessorCode() {
        if ((isset($this->response["processorCode"])) && (strlen($this->response["processorCode"]) > 0)) { return $this->response["processorCode"]; }
    }

    /**
     * Gets the Boleto URL
     * @return string
     */
    public function getBoletoUrl() {
        if ((isset($this->response["boletoUrl"])) && (strlen($this->response["boletoUrl"]) > 0)) { return $this->response["boletoUrl"]; }
    }
    
    /**
     * Gets the Online Debit URL
     * @return string
     */
    public function getDebitURL() {
        if ((isset($this->response["onlineDebitUrl"])) && (strlen($this->response["onlineDebitUrl"]) > 0)) { return $this->response["onlineDebitUrl"]; }
    }
    
    /**
     * Gets the Authentication URL
     * @return string
     */
    public function getAuthenticationURL() {
         if ((isset($this->response["authenticationURL"])) && (strlen($this->response["authenticationURL"]) > 0)) { return $this->response["authenticationURL"]; }
     }
    
    /**
     * Gets the Acquirer's reference number
     * @return string
     */ 
    public function getProcessorReferenceNumber() {
        if ((isset($this->response["processorReferenceNumber"])) && (strlen($this->response["processorReferenceNumber"]) > 0)) { return $this->response["processorReferenceNumber"]; }
    }
    
    /**
     * Gets the Acquirer's transaction ID
     * @return string
     */ 
    public function getProcessorTransactionID() {
        if ((isset($this->response["processorTransactionID"])) && (strlen($this->response["processorTransactionID"]) > 0)) { return $this->response["processorTransactionID"]; }
    }
    
    /**
     * Gets the fraud score
     * @return string
     */ 
    public function getFraudScore() {
        if ((isset($this->response["fraudScore"])) && (strlen($this->response["fraudScore"]) > 0)) { return $this->response["fraudScore"]; }
    }
    
    /**
     * Gets the credit card token created by maxiPago!
     * @return string
     */ 
    public function getToken() {
        if ((isset($this->response["save-on-file"]["token"])) && (strlen($this->response["save-on-file"]["token"]) > 0)) { return $this->response["save-on-file"]["token"]; }
        elseif ((isset($this->response["result"]["token"])) && (strlen($this->response["result"]["token"]) > 0)) { return $this->response["result"]["token"]; }
    }
    
    /**
     * Gets the command returned in the API call
     * @return string
     */ 
    public function getCommand() {
        if ((isset($this->response["command"])) && (strlen($this->response["command"]) > 0)) { return $this->response["command"]; }
    }
    
    /**
     * Gets the request timestamp
     * @return string
     */ 
    public function getTime() {
        if ((isset($this->response["time"])) && (strlen($this->response["time"]) > 0)) { return $this->response["time"]; }
    }
    
    /**
     * Gets the Customer ID created by maxiPago!
     * @return string
     */ 
    public function getCustomerId() {
        if ((isset($this->response["result"]["customerId"])) && (strlen($this->response["result"]["customerId"]) > 0)) { return $this->response["result"]["customerId"]; }
    }
    
    /**
     * Gets the report results
     * @return array
     */ 
     public function getReportResult() {
        if ((isset($this->response["records"])) && (is_array($this->response["records"]))) { return $this->response["records"]; }
     }
     
     /**
      * Gets the total number of records in the report results
      * @return string
      */
    public function getTotalNumberOfRecords() {
        if ((isset($this->response["totalNumberOfRecords"])) && (strlen($this->response["totalNumberOfRecords"]) > 0)) { return $this->response["totalNumberOfRecords"]; }
    }
    
    /**
     * Gets the page token from the report results
     * @return array
     */ 
     public function getPageToken() {
        if ((isset($this->response["pageToken"])) && (strlen($this->response["pageToken"]) > 0)) { return $this->response["pageToken"]; }
     }
     
     public function getNumberOfPages() {
         if ((isset($this->response["numberOfPages"])) && (strlen($this->response["numberOfPages"]) > 0)) { return $this->response["numberOfPages"]; }
     }
     
     /**
     * Gets the page number from the report results
     * @return array
     */ 
     public function getPageNumber() {
        if ((isset($this->response["pageNumber"])) && (strlen($this->response["pageNumber"]) > 0)) { return $this->response["pageNumber"]; }
     }

    /**
     * Gets ALL the transaction response data
     * @return array
     */
    public function getResult() {
        if ((isset($this->response)) && (is_array($this->response))) { return $this->response; }
        else { return null; }
    }
   
    public function getauthenticated() {
    	if ((isset($this->response["authenticated"])) && (strlen($this->response["authenticated"]) > 0)) { return $this->response["authenticated"]; }
    }
    
}