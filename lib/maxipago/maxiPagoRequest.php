<?php
class maxiPagoRequest extends maxiPagoXmlBuilder {
    
    protected function sendXml() {
        $this->xml = $this->xml->asXML();
        $curl = curl_init($this->endpoint);
        $opt = array(CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array('Content-Type: text/xml', 'charset=utf-8'),
            CURLOPT_SSL_VERIFYHOST => $this->sslVerify,
            CURLOPT_SSL_VERIFYPEER => $this->sslVerify,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $this->xml);
        curl_setopt_array($curl, $opt);
        $this->xmlResponse = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);
        if (maxiPagoRequestBase::$debug == true) { $this->printDebug($curlInfo); }
        if ($this->xmlResponse) { return $this->parseXml(); }
        else { throw new Exception('[maxiPago Class] Connection error with maxiPago! server.', 503); }
    }
    
    private function parseXml($array = array(),$c = 0) {
        $xmlResponse = new SimpleXMLElement($this->xmlResponse);
        if ($this->type != "transactionDetailReport") {
            foreach ($xmlResponse->children() as $key => $value) {
                if ($xmlResponse->$key->children()) {
                    foreach ($xmlResponse->$key->children() as $k => $v) { $array[$key][$k] = (string)$v; }
                }
                else {
                    if (($key == "transactionTimestamp") || ($key == "time")) {
                        $value = (string)$value;
                        if (strlen($value) == 13) { $value = $value/1000; }
                        else { $array[$key] = $value; }
                    }
                    $array[$key] = (string)$value;
                }
            }
        }
        else {
            foreach ($xmlResponse->children() as $key => $value) {
                if ($key == "header") {
                    foreach ($value as $k => $v) { $array[$k] = (string)$v; }
                }
                elseif ($key == "result") {
                    $resultSetInfo = $xmlResponse->result->resultSetInfo[0];
                    if (!empty($resultSetInfo)) {
                        foreach ($resultSetInfo as $key => $value)  { $array[$key] = (string)$value; }
                        $records = $xmlResponse->result->records[0];
                        foreach ($records as $key => $val) {
                            foreach ($val as $k => $v) { $array["records"][$c][$k] = (string)$v; }
                            $c++;
                        }
                    }
                }
            }
        }
        return $array;
    }
    
    private function printDebug($param) {
        $this->debugger("Target URL: ".$this->endpoint);
        $this->debugger("XML Request: ".htmlentities(mb_convert_encoding($this->xml, "UTF-8")));
        if ($param["http_code"] == "200") {
            $this->debugger("XML Response: ".htmlentities(mb_convert_encoding($this->xmlResponse, "UTF-8")));
            $this->debugger("Response time: ".round($param["total_time"],3)." secs.");
        }
        else {
            $this->debugger("XML Response: Something went wrong with the cURL call.");
            foreach ($param as $k => $v) { $_mpInfo .= $k.": ".$v.", "; }
            $this->debugger("cURL_getinfo data:\n".$_mpInfo);
        }
    }
    
    private function debugger($string) {
        $_d = date('Y-m-d H:m:s',substr(microtime(),"11","10")).":".substr(microtime(),"2","5");
        echo("<br>".str_repeat("-",20)."<br>[".$_d."] ".$string."<br>".str_repeat("-",20)."<br>");
    }
    
}
?>