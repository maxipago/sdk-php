<?php
if (!function_exists('curl_init')) { throw new Exception('[maxiPago Class] cURL PHP extension is required', 500); }
if (!extension_loaded('simplexml')) { throw new Exception('[maxiPago Class] SimpleXML PHP extension is required', 500); }

require_once dirname(__FILE__)."/maxipago/maxiPagoServiceBase.php";
require_once dirname(__FILE__)."/maxipago/maxiPagoResponseBase.php";
require_once dirname(__FILE__)."/maxipago/maxiPagoRequestBase.php";
require_once dirname(__FILE__)."/maxipago/maxiPagoXmlHandler.php";
require_once dirname(__FILE__)."/maxipago/maxiPagoRequest.php";
require_once dirname(__FILE__)."/maxipago/maxiPagoTransaction.php";
?>