<?php // -->

// if download file is set
if(isset($_GET['type']) && isset($_GET['files'])) {
    $file = __DIR__ . '/zips/' . $_GET['type'] . '/' . $_GET['type'] . '-' . $_GET['files'] . '.zip';
    $name = basename($file);

    if(!file_exists($file)) {
        echo 'File does not exists.';
        exit;
    }

    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=$name");
    header("Content-length: " . filesize($file));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile("$file");

    exit;
}
