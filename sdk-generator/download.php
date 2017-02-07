<?php // -->

// if download file is set
if(isset($_GET['type']) && isset($_GET['files'])) {
    // get the sdk zip file path
    $file = __DIR__ . '/zips/' . $_GET['type'] . '/' . $_GET['type'] . '-' . $_GET['files'] . '.zip';
    // get zip basename
    $name = basename($file);

    // are we getting just the size?
    if(isset($_GET['size'])) {
        // check if that file exists
        if(file_exists($file)) {
            // get filesize
            $size = filesize($file);

            // format file size into human readable file size
            die(json_encode(array('size' => formatBytes($size, 0))));
        } else {
            // just send out default size
            die(json_encode(array('size' => '0 KB')));
        }
    }

    // if file does not eixsts
    if(!file_exists($file)) {
        echo 'File does not exists.';
        exit;
    }

    // replace the zip name's binary to hash
    $hash = substr($name, strpos($name, '-') + 1);
    $hash = str_replace('.zip', '', $hash);
    $hash = substr(sha1($hash), -8);
    $name = substr($name, 0, strpos($name, '-')) . '-' . $hash . '.zip';

    // set headers
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
