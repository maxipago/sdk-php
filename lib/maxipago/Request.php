<?php
class maxiPago_Request extends maxiPago_XmlBuilder {

    protected function sendXml() {
        $this->xml = $this->xml->asXML();
        if ((!isset($this->xml)) || (!$this->xml)) { 
        	throw new RuntimeException('[maxiPago Class] INTERNAL ERROR on '.__METHOD__.' method:'); 
        }
        if (is_object(maxiPago_RequestBase::$logger)) { 
            self::$logger->logInfo('XML has been generated');
            self::$logger->logDebug(' ', $this->xml);
        }
        $curl = curl_init($this->endpoint);
        $opt = array(CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array('Content-Type: text/xml; charset=UTF-8'),
            CURLOPT_SSL_VERIFYHOST => self::$sslVerifyHost,
            CURLOPT_SSL_VERIFYPEER => self::$sslVerifyPeer,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $this->xml);
        curl_setopt_array($curl, $opt);
        $this->xmlResponse = curl_exec($curl);
        if (is_object(maxiPago_RequestBase::$logger)) { 
        	self::$logger->logInfo('Sending XML to '.$this->endpoint); 
        }
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        if (maxiPago_RequestBase::$debug == true) { 
        	$this->printDebug($curlInfo); 
        }
        if ($this->xmlResponse) { 
        	return $this->parseXml(); 
        }
        else { 
        	throw new UnexpectedValueException('[maxiPago Class] Connection error with maxiPago! server', 503); 
        }
    }
    
    private function parseXml($array = array(),$c = 0) {
        $xmlResponse = new SimpleXMLElement($this->xmlResponse);
        if (is_object(maxiPago_RequestBase::$logger)) { 
            self::$logger->logInfo('XML Response received');
            self::$logger->logDebug(' ', $xmlResponse->asXML());
        }
        if ($this->type != "transactionDetailReport") {
            foreach ($xmlResponse->children() as $key => $value) {
                if ($xmlResponse->$key->children()) {
                    foreach ($xmlResponse->$key->children() as $k => $v) { 
                    	$array[$key][$k] = (string)$v; 
                    }
                }
                else {
                    if (($key == "transactionTimestamp") || ($key == "time")) {
                        $value = (string)$value;
                        if (strlen($value) == 13) { 
                        	$value = substr($value, 0, 10); 
                        }
                        else { 
                        	$array[$key] = $value; 
                        }
                    }
                    $array[$key] = (string)$value;
                }
            }
        }
        else {
            foreach ($xmlResponse->children() as $key => $value) {
                if ($key == "header") {
                    foreach ($value as $k => $v) { 
                    	$array[$k] = (string)$v; 
                    }
                }
                elseif ($key == "result") {
                    $resultSetInfo = $xmlResponse->result->resultSetInfo[0];
                    if (!empty($resultSetInfo)) {
                        foreach ($resultSetInfo as $key => $value)  { 
                        	$array[$key] = (string)$value; 
                        }
                        $records = $xmlResponse->result->records[0];
                        foreach ($records as $key => $val) {
                            foreach ($val as $k => $v) { 
                            	$array["records"][$c][$k] = (string)$v; 
                            }
                            $c++;
                        }
                    }
                }
            }
        }
        if (is_object(maxiPago_RequestBase::$logger)) { 
        	self::$logger->logNotice('Parsed parameters received', $array); 
        }
        return $array;
    }
    
    private function printDebug($param,$_mpInfo='') {
        $this->debugger("Target URL: ".$this->endpoint);
        $this->debugger("XML Request: ".htmlentities(mb_convert_encoding($this->xml, "UTF-8")));
        if ($param["http_code"] == "200") {
            $this->debugger("XML Response: ".htmlentities(mb_convert_encoding($this->xmlResponse, "UTF-8")));
            $this->debugger("Response time: ".round($param["total_time"],3)." secs.");
        }
        else {
            $this->debugger("XML Response: Connection problems with maxiPago!");
            foreach ($param as $k => $v) { 
                if ($k != "certinfo") { $_mpInfo .= $k.": ".$v.", "; }
            }
            $this->debugger("cURL_getinfo data: ".$_mpInfo);
        }
    }
    
    private function debugger($string) {
        $_d = date('Y-m-d H:m:s',substr(microtime(),"11","10")).":".substr(microtime(),"2","5");
        echo("<br>".str_repeat("-",20)."<br>[".$_d."] ".$string."<br>".str_repeat("-",20)."<br>");
    }
    
}