## Introduction ##

This PHP library allows for easy integration with the **maxiPago! Smart Payments** API. Our payment platform allows online merchants to accept payments in many countries in Latin America and the US and includes such functionalities as Automated Recurring Billing, "Single-Click" payments, Online Returns, Credit Card Payment Reconciliation, Fraud Tools and more. You can find out more about **maxiPago!** by visiting [www.maxipago.com](http://www.maxipago.com/).

This library has all the functionalities currently available through our XML-based API and can be freely copied and used by Merchants and developers.

You can get a more comprehensive view of our API by looking at our documentation, [which can be downloaded here](http://www.maxipago.com/docs/maxiPago_API_Latest.pdf). If you are looking for a hosted payment page solution, please see the section _**smartPages!**_ in the documentation.


## Available transaction types ##

* **Authorization:** checks if the credit card used is valid (number, security code and expiration date) and if the card holder has sufficient funds for that purchase.

* **Capture:** confirms the authorization previously made and completes the transaction. If the transaction is never captured the Merchant does not receive the funds and the Card Holder is never charged.

>*Separating the authorization and capture in two different moments is an excellent way to check if you have the purchased items in stock or to run a fraud check, while still guaranteeing payment.*

* **Sale:** combines the authorization and the capture in a single request. When performing a Sale we send the credit card for authorization and immediately capture that transaction, if approved.

* **Void:** cancels the transaction and no money is charged from the buyer. You can only void a transaction until 11:59pm of the day of capture.

* **Return:** reverses a credit card transaction, taking funds from the Merchant and giving them back to the buyer. This is a financial operation that might take a few days to be completed, depending on your credit card processor.

* **Recurring:** schedules a credit card transaction to be charged at a specific interval, defined by the Merchant.

* **Card On File:** saves a card in our system and returns a unique token, which can be used to process future transactions. **This allows the implementation of "single-click" payments.**

* **Boleto:** *(Brazil only)* Transactions made with Boletos are different than credit card purchases. This creates a boleto and returns an URL to the buyer to access the boleto payment slip. It can be accessed at any time before the boleto expiration and up to 60 days after it has expired.


## Installation and setup ##

The library has been tested on **PHP 5.1.6 and up** and consists of the following files:

```
  /lib/  
  |-- maxiPago.php  
  |-- maxipago  
    |-- maxiPagoRequest.php  
    |-- maxiPagoRequestBase.php  
    |-- maxiPagoResponseBase.php  
    |-- maxiPagoServiceBase.php  
    |-- maxiPagoTransaction.php  
    |-- maxiPagoXmlHandler.php
```

Copy **/lib/maxipago/** to your local server. In your code, include the **maxiPago.php** file, which checks the minimum requirements and includes the other necessary files:

```php
require_once "./lib/maxiPago.php"
```

Now, create a new object from the maxiPago class:

```php
$maxiPago = new maxiPago;
```

## Environment and Credentials ##

In order to send requests you will need valid Merchant Credentials. They can be obtained with our Customer Support team.

**maxiPago!** provides a fully functional sandbox environment to simulate the transaction responses. You need to set the environment the transactions will be sent to, which can be done by sending either **"TEST"** or **"LIVE"**.

To set the credentials and environment used to process requests:

```php
$maxiPago->setCredentials("100", "merchant_key");
$maxiPago->setEnvironment("TEST");
```

## Logging and Debug Mode ##

In June 2013 [Kenny Katzgrau's KLogger](https://github.com/katzgrau/KLogger) was added to this lib, allowing merchants to automatically log the transactions' request and response, following PCI compliance.

To enable logging use the **setLogger()** method, making sure your log file directory permissions are correct. The default logger level is INFO:

```php
    $maxiPago->setLogger(dirname(__FILE__).'/logs','INFO');
```

The Debug Mode prints the request and response XML's so you can easily identify any issues with the request. In order to enable debug use the **setDebug()** method:

```php
	$maxiPago->setDebug(true);
```

## Request ##

To send a request to **maxiPago!** you need to call one of the methods listed above, passing an array with the request parameters, as such:

```php
	$data = array(
		"processorID" => "1",
		"referenceNum" => "ORDER2937283",
		"chargeTotal" => "10.00",
		"number" => "4111111111111111",
		"expMonth" => "07",
		"expYear" => "2017",
		"cvvNumber" => "123"
	);
	
	$maxiPago->creditCardAuth($data);
```

## Response ##

There are methods to get each piece of information from the response. However, you can also call the **getResult()** method to retrieve all fields in the response as an array:

```
	print_r($maxiPago->getResult());
	
	Array
	(
	    [authCode] => 123456
	    [orderID] => 0AF90437:013CC42DDE87:F5D0:01E1101A
	    [referenceNum] => ORD29328493
	    [transactionID] => 422570
	    [transactionTimestamp] => 1312156800
	    [responseCode] => 0
	    [responseMessage] => AUTHORIZED
	    [avsResponseCode] =>
	    [cvvResponseCode] =>
	    [processorCode] => A
	    [processorMessage] => APPROVED
	    [errorMessage] => 
	)
```


## All request methods ##


#####Credit Card Transactions#####
* Authorization: **creditCardAuth()**
* Capture: **creditCardCapture()**
* Sale (Authorization + Capture): **creditCardSale()**
* Automatically save card: **creditCardAuth() or creditCardSale()**
* Void: **creditCardVoid()**
* Refund: **creditCardRefund()**
  
#####Recurring Transactions#####
* Create recurring credit card billing: **createRecurring()**
* Cancel a recurring billing: **cancelRecurring()**
 
#####Boleto Transactions#####
* Create boleto payment slip (Brazil only): **boletoSale()**

#####Reports#####
* Query one single transaction: **pullReport()**
* Query a list of transactions: **pullReport()** 
* Flip through pages of a transaction list: **pullReport()** 
* Query a pending report: **pullReport()** 


#####Customer Profile / Card On File#####
* Create a profile *(a profile must be created to save a card)*: **addProfile()**
* Update a profile: **updateProfile()** 
* Remove a profile: **deleteProfile()** 
* Add a credit card: **addCreditCard()**
* Remove a credit card: **deleteCreditCard()**


## All response methods ##


#####Request validators#####
* Checks if there was an error in the request: **isErrorResponse()**
* Checks if the request was successful: **isTransactionResponse()**

#####Main transaction response methods#####
* Gets the Response Code (transactions/orders): **getResponseCode()**
* Gets the Authorization Code, if any was replied: **getAuthCode()**
* Gets the Order ID created: **getOrderID()**
* Gets the Transaction ID created: **getTransactionID()**
* Gets the URL for the Boleto issued *(Brazil only)*: **getBoletoUrl()**
* Gets the Processor Code: **getProcessorCode()**
* Gets the Processor Reference Number: **getProcessorReferenceNumber()**
* Gets the Processor Transaction ID: **getProcessorTransactionID()**
* Gets an array with all response fields: **getResult()**

#####Other transaction response methods#####
* Gets the AVS Response Code *(US only)*: **getAvsResponseCode()**
* Gets the Command used in the request: **getCommand()**
* Gets the Customer ID created: **getCustomerId()**
* Gets the CVV Response Code *(US only)*: **getCvvResponseCode()**
* Gets the Fraud Score analysis: **getFraudScore()**
* Gets the Response Message: **getMessage()**
* Gets the report's number of pages: **getNumberOfPages()**
* Gets the report's current page: **getPageNumber()**
* Gets the report's page token: **getPageToken()**
* Gets the transaction list as array: **getReportResult()**
* Gets the report's time: **getTime()**
* Gets the Credit Card Token created: **getToken()**
* Gets the number of transactions in a report: **getTotalNumberOfRecords()**
* Gets the Transaction Unix time: **getTransactionTimestamp()**


## Documentation and Support ##

[**maxiPago!**'s full API documentation can be found here](http://www.maxipago.com/docs/maxiPago_API_Latest.pdf).

Our support team is happy to help you with any questions you might have, be it about the functionalities of our platform or about payments in general. They are available to customers and non-customers alike and can be reached at support [@] maxipago [.] com.

## License ##

Library for integration with the **maxiPago! Payment Gateway**     
**_Copyright (C) 2013, maxiPago!_**        
                                                                      
This program is free software: you can redistribute it and/or modify  it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.                                   
                                                                      
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.                          
                                                                      
You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
