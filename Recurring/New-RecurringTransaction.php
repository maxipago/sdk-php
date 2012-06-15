// Command: "sale"
$recurring = array(
  "debug" => "1",
  "processorID" => "1",
  "referenceNum" => "TestTransaction123",
  "chargeTotal" => "10.00",
  "numberOfInstallments" => "2",
  "chargeInterest" => "N",
  "number" => "4111111111111111",
  "expMonth" => "07",
  "expYear" => "2020", 
  "cvvNumber" => "123", 
  "ipAddress" => "123.123.123.123", 
  "bname" => "Fulano de Tal", // Billing information //
  "baddress" => "Av. República do Chile, 230",
  "baddress2" => "16 Andar",/
  "bcity" => "Rio de Janeiro",
  "bstate" => "RJ",
  "bpostalcode" => "20031-170", 
  "bcountry" => "BR", 
  "bphone" => "2140099400",
  "bemail" => "fulanodetal@email.com",
  "sname" => "Ciclano de Tal", // Shipping information //
  "saddress" => "Av. Prestes Maia, 737",
  "saddress2" => "20 Andar",
  "scity" => "São Paulo",
  "sstate" => "SP", 
  "spostalcode" => "01031-001", 
  "scountry" => "BR", 
  "sphone" => "1121737900",
  "semail" => "ciclanodetal@email.com", 
  "comments" => "Comments about this transaction",
  // Below is a recurring order charged every MONTH, for 12 MONTHS, starting on DEC-12-2015 //
  "recurring" => "1", // Recurring transaction flag. 1=Recurring //
  "startDate" => "2015-12-25", // YYYY-MM-DD //
  "frequency" => "1", // Frequency of payment (1, 3, 6, …) //
  "period" => "monthly", // Internval: 'daily', 'weekly', 'monthly' //
  "installments" => "12", // Total number of payments //
  "failureThreshold" => "2" // Number of retries if Declined/Error //
);