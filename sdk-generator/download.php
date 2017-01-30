<?php // -->

// if download file is set
if(isset($_GET['type']) && isset($_GET['files'])) {
    $file = __DIR__ . '/zips/' . $_GET['type'] . '/' . $_GET['type'] . '-' . $_GET['files'] . '.zip';
    $name = basename($file);

    if(isset($_GET['size'])) {
        if(file_exists($file)) {
            $size = filesize($file);

            die(json_encode(array('size' => formatBytes($size, 0))));
        } else {
            die(json_encode(array('size' => '0 KB')));
        }
    }

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

function formatBytes($bytes, $decimals = 2) {
    $size   = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    $total  = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor));

    return $total . ' ' . @$size[$factor];
}
