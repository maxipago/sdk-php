## Introduction ##

This **PHP** library allows for easy integration with the **maxiPago! Smart Payments** API. Our payment platform allows online merchants to accept payments in many countries in Latin America and the US and includes such functionalities as Automated Recurring Billing, "Single-Click" payments, Online Returns, Credit Card Payment Reconciliation, Fraud Tools and more. You can find out more about **maxiPago!** by visiting [www.maxipago.com](http://www.maxipago.com/).

This library has all the functionalities currently available through our XML-based API and can be freely copied and used by Merchants and developers.

You can get a more comprehensive view of our API by our documentation, [which can be downloaded here](http://www.maxipago.com/docs/maxiPago_API_Latest.pdf). If you are looking for a hosted payment page solution, please see the section "**smartPages!**".


## Setup ##

Setup is pretty straightforward: simply copy the **maxipago_payment.php** file from this repository to your server and include it in your code.

To include use the following code:

		include_once "maxipago_payment.php";


## Environment and Credentials ##

In order to send requests you will need valid Merchant Credentials. They can be obtained with our Customer Support team.

**maxiPago!** provides a fully functional sandbox environment to simulate the transaction responses. You need to set the environment the transactions will be sent to, which can be done by sending either **"TEST"** or **"LIVE"** in the **\_maxipago_payment()_** function, described below.
		
You also need to provide your Merchant Credentials, which is done by setting the **$credentials** array, as shown below:

		$credentials = array("merchantId" => "100", "merchantKey" => "secret-key");

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


## Requests ##

To send a request to **maxiPago!** you need to call the **maxipago_payment()** function, as follows:

        maxipago_payment("command", $credentials, $data, version, url);

Each method has its own command, listed in the topic below.

You can find examples of each individual request type in this repository. If you have questions about the requests or responses received, [please see our documentation](http://www.maxipago.com/docs/maxiPago_API_Latest.pdf). You can also contact our Support Team if you'd like.


## Available methods ##

This is the complete list of actions that can be executed using this library

* **Credit Card Transactions**
 * Authorization **[command: "auth"]**
 * Capture **[command: "capture"]**
 * Sale (Authorization + Capture) **[command: "sale"]**
 * Token Authorization (Authorization with saved card) **[command: "token-auth"]**
 * Token Sale (Sale with saved card) **[command: "token-sale"]**
 * Automatically save card **[command: "auth" or "sale"]**
 * Void **[command: "void"]**
 * Refund **[command: "refund"]**
 
 
* **Recurring Transactions**
 * Create recurring credit card billing **[command: "sale"]**
 * Cancel a recurring billing **[command: "cancel-recurring"]**
 
 
* **Boleto Transactions**
 * Create boleto payment slip (Brazil only) **[command: "boleto"]**


* **Reports**
 * Query one single transaction **[command: "report"]**
 * Query a list of transactions **[command: "report"]** 
 * Flip through pages of a transaction list **[command: "report"]** 
 * Query a pending report **[command: "report"]** 


* **Customer Profile / Card On File**
 * Create a profile *(a customer profile must be created before saving a card)* **[command: "add-consumer"]**
 * Update a profile **[command: "update-consumer"]** 
 * Remove a profile **[command: "delete-consumer"]** 
 * Add a credit card **[command: "add-card-onfile"]**
 * Remove a credit card **[command: "remove-card-onfile"]**

## Documentation and Support ##

[**maxiPago!**'s full API documentation can be found here](http://www.maxipago.com/docs/maxiPago_API_Latest.pdf).

Our support team is happy to help you with any questions you might have, be it about the functionalities of our platform or about payments in general. They are available to customers and non-customers alike and can be reached at support [@] maxipago [.] com.