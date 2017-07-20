<?php
require_once "../lib/maxipago/Autoload.php"; // Remove if using a globa autoloader
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    // Define Logger parameters if preferred
    // Do *NOT* use 'DEBUG' for Production environment as Credit Card details WILL BE LOGGED
    // Severities INFO and up are safe to use in Production as Credi Card info are NOT logged
    $maxiPago->setLogger(dirname(__FILE__).'/logs','INFO');
    
    // Set your credentials before any other transaction methods
    $maxiPago->setCredentials("12345", "123456789");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "period" => "range", // REQUIRED - Filter range: 'today', 'yesterday', 'range' (12/25/2010 - 12/30/2010) //
        "startDate" => "02/07/2013", // REQUIRED - Start date if 'period = range' //
        "endDate" => "02/07/2013", // REQUIRED - End date if 'period = range' //
    );
    $maxiPago->pullReport($data);
    
    // If request failed
    if ($maxiPago->isErrorResponse()) {
        echo "Request has failed<br>Error message: ".$maxiPago->getMessage();
    }
    
    // If more than one page of results, flip through them
    elseif ($maxiPago->getNumberOfPages()  > 1) {
        $result = $maxiPago->getReportResult();
        $pages = $maxiPago->getNumberOfPages();
        for ($page=2; $page <= $pages; $page++) {
            $data = array(
                    "pageToken" => $maxiPago->getPageToken(),
                    "pageNumber" => $page,
            );
            $maxiPago->pullReport($data);
            $tp = $maxiPago->getReportResult();
            $result = array_merge($result, $maxiPago->getReportResult());
        }
        print_r($result);
    }
    
    // If just one page of results
    elseif ($maxiPago->getTotalNumberOfRecords() > 0) {
        $result = $maxiPago->getReportResult();
        print($result);
    }
    
    // If no results
    else { echo "Query was executed sucessfully but no transactions were found."; }


}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>
