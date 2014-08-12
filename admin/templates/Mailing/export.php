<?php
require_once("../../src/bootstrap.php");
$mailing = new Model\Mailing();
$csv = $mailing->getStringCSV();
$options = array(
    "mimeType" => "text/csv",
    "extension" => ".csv"
);
\Extensions\Files::writeAndExport($csv, $options);