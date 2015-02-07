<?php
sleep(1);
require_once ("../admin/src/bootstrap.php");
$result = array();

$directory = new DirectoryIterator(__DIR__ . '/../admin/');

foreach ($directory as $file) {
    if ($file->getFilename() == "config.xml") {
        $result[] = array(
            'id' => 'config-xml',
            'perms' => ($file->isReadable() && $file->isWritable())
        );
    }
}

$dbms = Lib\Data::$dbms . ".sql";
$result['dbdriver'] = $dbms;

$directory = new DirectoryIterator(__DIR__ . '/database/');

if ($directory->isWritable() && $directory->isReadable()) {
    foreach ($directory as $file) {
        if ($file->getFilename() == $dbms) {
            $result[] = array(
                'id' => 'dbdriverfile',
                'perms' => ($file->isReadable() && $file->isWritable())
            );
        }
    }
} else {
    $result[] = array(
        'id' => 'dbdriverfile',
        'perms' => false
    );
}

print_r(json_encode($result));