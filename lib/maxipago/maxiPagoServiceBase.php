<?php
class maxiPagoServiceBase {
    
    protected $credentials = array();
    protected $host;
    private $libVersion = "1.0b";
    
    /**
     * Sets the Merchant Credentials
     * @param string $mid
     * @param string $key
     */
    public function setCredentials($mid=null,$key=null) {
        if ((ctype_digit((string)$mid)) && (strlen($key) == 24)) {
            $this->credentials["merchantId"] = $mid;
            $this->credentials["merchantKey"] = $key;
        }
        else { throw new Exception('[maxiPago Class error] Invalid credentials.', 401); }
    }
    
    /**
     * Sets the environment of the transaction (TEST or LIVE)
     * @param string $param
     */
    public function setEnvironment($param=null) {
        if (strtoupper($param) == 'TEST') { $this->host = 'https://testapi.maxipago.net'; }
        elseif (strtoupper($param) == 'LIVE') { $this->host = 'https://api.maxipago.net'; }
        else { throw new Exception('[maxiPago Class error] Invalid environment. '.__METHOD__.' accepts either "TEST" or "LIVE"', 400); }
    }
    
    /**
     * Enables the debug ouput
     * @param boolean $param
     */
    public function setDebug($param=false) {
        if (($param == true) || ($param == "1")) { maxiPagoRequestBase::$debug = true; }
    }
    
    /**
     * Checks if the card number is valid (Lunh check)
     * @param string $param
     * @return boolean
     */
    public function checkCreditCard($param='1',$str='') {
        foreach (array_reverse(str_split($param)) as $i => $c) $str .= ($i % 2 ? $c * 2 : $c);
        return array_sum(str_split($str)) % 10 == 0 ? true : false;
    }
    
    public function getVersion() { echo "[maxiPago Class] Current version: ".$this->libVersion; }
    
}
?>