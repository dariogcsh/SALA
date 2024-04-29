<?php

$doc = new DOMDocument();
$file = "/home/u765957855/domains/agrotecnologiasala.com.ar/public_html/cron/indexdos.php";

if ($doc->loadHTMLFile($file)) {
    $span = $doc->getElementsByTagName('span')->item(0);
    $count = $span->textContent;
    $count++;

    $doc->getElementsByTagName('span')->item(0)->nodeValue = $count;
    $doc->saveHTMLFile($file);

    echo 'File has been uplodaded :)';

}

else {
    return false;
}