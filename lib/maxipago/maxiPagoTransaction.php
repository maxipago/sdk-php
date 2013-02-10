<?php

class maxiPago extends maxiPagoResponseBase {

    private $request;
    public $response;

    /**
     * Performs a credit card authorization
     * 
     * The Authorization checks if the credit card used is valid
     * (number, security code and expiration date), if the card 
     * holder has sufficient funds for that purchase and if the 
     * transaction has passed the Acquirer's and Bank's risk 
     * assessment process.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function creditCardAuth($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("auth");
        $this->response = $req->processRequest();
    }

    /**
     * Performs a credit card capture
     * 
     * Capturing a transaction confirms and completes the order.
     * If the transaction is never captured the Merchant does not
     * receive the funds and the Card Holder is never charged.
     * In these cases the authorization expires within 5 days.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function creditCardCapture($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("capture");
        $this->response = $req->processRequest();
    }

    /**
     * Performs a credit card sale
     * 
     * A Sale transaction combines the  authorization  and the
     * capture in a single request. When performing a Sale
     * maxiPago! sends the credit card for authorization and
     * immediately captures that transaction, if approved.
     * The response sent is final.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function creditCardSale($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("sale");
        $this->response = $req->processRequest();
    }
    
    /**
     * Creates a recurring payment
     * 
     * A recurring payment schedules a transaction to be run
     * at a specific interval, starting at a specific date.
     * A recurring payment is always a Sale (you cannot
     * authorize a recurring payment to capture it later).
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function createRecurring($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("recurringPayment");
        $this->response = $req->processRequest();
    }

    /**
     * Performs a credit card void
     * 
     * A transaction can be Voided until the closing of the
     * final batch of the day, allowing the Merchant to cancel 
     * a transaction before any funds change hands.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function creditCardVoid($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("void");        
        $this->response = $req->processRequest();
    }

    /**
     * Performs a credit card refund
     * 
     * A  Return  (or  Refund) is the reversal of a credit
     * card transaction, where the funds are taken from the
     * Merchant and given back to the Card Holder. This is
     * a financial operation that usually takes a few days
     * to be completed.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function creditCardRefund($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("return");
        $this->response = $req->processRequest();
    }

    /**
     * Performs a boleto sale
     * 
     * Transactions made with Boletos are different than credit
     * card purchases. When we receive a transaction we create a
     * boleto, available online, and return to the Merchant an URL
     * to access the boleto payment slip.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function boletoSale($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postXML');
        $req->setTransactionType("boleto");
        $this->response = $req->processRequest();
    }

    /**
     * Cancels a recurring payment
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function cancelRecurring($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("cancel-recurring");
        $this->response = $req->processRequest();
    }

    /**
     * Creates a new a customer profile
     * 
     * A customer profile is used to store credit
     * card information
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function addProfile($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("add-consumer");
        $this->response = $req->processRequest();
    }

    /**
     * Updates an existing customer profile
     * 
     * A customer profile is used to store credit
     * card information
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function updateProfile($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("update-consumer");
        $this->response = $req->processRequest();
    }

    /**
     * Removes a customer profile
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function deleteProfile($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("delete-consumer");
        $this->response = $req->processRequest();
    }

    /**
     * Adds a credit card to a customer's profile
     * 
     * This allows the Merchant to securely store the 
     * customer's credit card information in our platform
     * for future purchases. The Merchant receives a unique
     * token that can be used when sending new transactions.
     * 
     * @param array $array
     * @return array
     * @throws Exception
     */
    public function addCreditCard($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("add-card-onfile");
        $this->response = $req->processRequest();
    }


    /**
     * Removes a credit card previously saved
     * @param array $array
     * @return array
     * @throws Exception
     */
    public  function deleteCreditCard($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/UniversalAPI/postAPI');
        $req->setTransactionType("delete-card-onfile");
        $this->response = $req->processRequest();
    }

    /**
     * Extracts a transaction report
     * @param array $array 
     * @return array
     * @throws Exception
     */
    public function pullReport($array) {
        if (!is_array($array)) { throw new Exception('[maxiPago Class] Method '.__METHOD__.' must receive array as input'); }
        $this->request = $array;
        $req = new maxiPagoRequest($this->credentials);
        $req->setVars($this->request);
        $req->setEndpoint($this->host.'/ReportsAPI/servlet/ReportsAPI');
        $req->setTransactionType("report");
        $this->response = $req->processRequest();
    }
   
}
?>