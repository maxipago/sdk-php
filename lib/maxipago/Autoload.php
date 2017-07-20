<?php
// This is an autoloader for the maxiPago! SDK.
// If you are not using a global autoloader do the following
// before any other maxiPago files:
// 
//     require_once "<path>/maxipago/Autoload.php"

function maxiPago_Autoload($className) {
    if ($className === "KLogger") { $fileName = $className.".php"; }
    else { $fileName = substr($className, 9).".php"; }
    require $fileName;
}

spl_autoload_register('maxiPago_Autoload');