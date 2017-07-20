<?php
class maxiPago_ServiceBase {
    
    protected $credentials = array();
    protected $host;
    
    /**
     * Sets the Merchant Credentials
     * @param string $mid
     * @param string $key
     */
    public function setCredentials($mid=null,$key=null) {
        try {
            if ((ctype_digit((string)$mid)) && (strlen($key) == 24)) {
                $this->credentials["merchantId"] = $mid;
                $this->credentials["merchantKey"] = $key;
                if (is_object(maxiPago_RequestBase::$logger)) { 
                	maxiPago_RequestBase::$logger->logNotice('Setting credentials "'.$mid.'" and "'.maxiPago_RequestBase::clearForLog($key).'"'); 
                }
            }
            else { throw new InvalidArgumentException('[maxiPago Class error] Invalid credentials.', 401); }
        }
        catch (Exception $e) {
            if (is_object(maxiPago_RequestBase::$logger)) { maxiPago_RequestBase::$logger->logFatal($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); }
            throw $e;
        }
    }
    
    /**
     * Sets the environment of the transaction (TEST or LIVE)
     * @param string $param
     */
    public function setEnvironment($param=null) {
        try {
            if (strtoupper($param) == 'TEST') {
            	maxiPago_RequestBase::setSslVerify(false);
            	$this->host = 'https://testapi.maxipago.net';
            }
            elseif (strtoupper($param) == 'LIVE') { 
            	$this->host = 'https://api.maxipago.net'; 
            }
            else { throw new BadMethodCallException('[maxiPago Class error] Invalid environment. '.__METHOD__.' accepts either "TEST" or "LIVE"', 400); }
            if (is_object(maxiPago_RequestBase::$logger)) { 
            	maxiPago_RequestBase::$logger->logNotice('Setting enviroment to "'.$param.'"'); 
            }
        }
        catch (Exception $e) {
            if (is_object(maxiPago_RequestBase::$logger)) { 
            	maxiPago_RequestBase::$logger->logCrit($e->getMessage()." in ".$e->getFile()." on line ".$e->getLine()); }
            throw $e;
        }
    }
    
    /**
     * Enables the debug output
     * @param boolean $param
     */
    public function setDebug($param=false) {
        if (($param == true) || ($param == "1")) { 
            maxiPago_RequestBase::$debug = true;
            if (is_object(maxiPago_RequestBase::$logger)) { 
            	maxiPago_RequestBase::$logger->logDebug('Enabling on-screen debug ouput'); 
            }
        }
    }
    
    /**
     * Enables logger output
     * @param string $path
     * @param string $severity
     * @throws Exception
     */
    public function setLogger($path, $severity='NOTICE') {
        if (!isset($path)) { 
        	throw new Exception('Logger path '.$path.' is required'); 
        }
        maxiPago_RequestBase::setLogger($path, $severity);
        if (is_object(maxiPago_RequestBase::$logger)) {
          maxiPago_RequestBase::$logger->logInfo('Starting transaction log');
          maxiPago_RequestBase::$logger->logDebug('PLEASE DO NOT USE "DEBUG" LOGGING MODE IN PRODUCTION');
        }
    }
    
    /**
     * Checks if the card number is valid (Lunh check)
     * @param string $param
     * @return boolean
     */
    public static function checkCreditCard($param='1') {
        $str='';
        foreach (array_reverse(str_split($param)) as $i => $c) $str .= ($i % 2 ? $c * 2 : $c);
        return array_sum(str_split($str)) % 10 == 0 ? true : false;
    }
    
}