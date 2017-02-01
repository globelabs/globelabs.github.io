<?php // -->

class SdkZipSizeGenerator {
    protected $data  = array();
    protected $types = array('android', 'ios', 'phonegap', 'react');

    public function __construct($argv) {
        if(!file_exists($argv[1])) {
            print 'Path does not exists.' . PHP_EOL;
            exit;
        }

        foreach($this->types as $type) {
            $path = $argv[1] . DIRECTORY_SEPARATOR . $type;

            if(!file_exists($path)) {
                print $path . ' does not exists skipping...';
                continue;
            }

            $zips = scandir($path);

            $zips = array_filter($zips, function($zip) {
                if($zip !== '.' && $zip !== '..') {
                    return $zip;
                }
            });

            foreach($zips as $zip) {
                $file = $path . DIRECTORY_SEPARATOR . $zip;
                $size = $this->formatBytes(filesize($file), 0);
                $name = basename($zip, '.zip');

                $this->data[$type][$name] = $size;
            }
        }

        $path = $argv[1] . DIRECTORY_SEPARATOR . 'sizes.js';

        if(!file_exists($path)) {
            touch($path);
        }

        file_put_contents($path, 'window.sdkSize = ' . json_encode($this->data, JSON_PRETTY_PRINT));
    }

    public function formatBytes($bytes, $decimals = 2) {
        $size   = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        $total  = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor));

        return $total . ' ' . @$size[$factor];
    }
}

new SdkZipSizeGenerator($argv);
