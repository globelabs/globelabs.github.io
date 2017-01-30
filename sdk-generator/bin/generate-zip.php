<?php // -->

class SdkZipGenerator {
    protected $names = array(
        'Amax',
        'Authentication',
        'BinarySms',
        'Location',
        'Payment',
        'Sms',
        'Subscriber',
        'Ussd'
    );

    protected $keys = array(
        'Amax' => 0,
        'Authentication' => 1,
        'BinarySms' => 4,
        'Location' => 2,
        'Payment' => 3,
        'Sms' => 4,
        'Subscriber' => 5,
        'Ussd' => 6
    );

    protected $types = array('android', 'ios', 'phonegap', 'react');

    public function __construct($argv) {
        print 'Generating SDK Zip files for android, ios, phonegap, react-native.' . PHP_EOL;

        if(!file_exists($argv[1])) {
            mkdir($argv[1]);
        }

        foreach($this->types as $type) {
            $names = $this->names;

            if($type == 'ios') {
                unset($names[2]);
            }

            if(isset($argv[2]) && $argv[2] != $type) {
                continue;
            }

            if(isset($argv[3])) {
                $this->generateZip($argv[3], $type, implode(array($argv[1], $type), DIRECTORY_SEPARATOR));
                exit;
            }

            print 'Getting possible permutations for ' . $type . PHP_EOL;

            $permutations = array();

            $this->getPossiblePermutations($names, ' ', $permutations);

            unset($permutations[0]);

            foreach($names as $value) {
                $permutations[] = $value;
            }

            $permutations = array_unique($permutations);

            $copy = array();

            foreach($permutations as $value) {
                $copy[] = $value;
            }

            $out = implode(array($argv[1], $type), DIRECTORY_SEPARATOR);

            print 'Generating ' . count($copy) . ' zip files for ' . $type . PHP_EOL . PHP_EOL;

            $total = 0;

            foreach($copy as $files) {
                $this->generateZip($files, $type, $out);

                print ++$total . ' out of ' . count($copy) . ' zip files for ' . $type . ' has been successfully generated.' . PHP_EOL;
            }

            print 'Done generating ' . count($copy) . ' zip files for ' . $type . PHP_EOL . PHP_EOL;

            exec('rm -rf ' . implode(array('.', 'out', $type), DIRECTORY_SEPARATOR));
        }
    }

    public function generateZip($files, $type, $out) {
        $script = __DIR__ . '/gl-sdk-build.js';

        if(!file_exists($out)) {
            mkdir($out);
        }

        if($type == 'android') {
            $script = $script . ' android -i %s -f %s -p %s -n %s -s %s -o %s';
            $key    = $this->getKey($files);

            $tmp = explode(' ', $files);

            foreach($tmp as $i => $v) {
                $tmp[$i] = $v . '.java';
            }

            $files = implode($tmp, ',');

            $target = implode(array('repo', 'globe-connect-android'), DIRECTORY_SEPARATOR);
            $sdkOut = implode(array('.', 'out', 'android'), DIRECTORY_SEPARATOR);
            $folder = implode(array($sdkOut, 'android-' . $key, ''), DIRECTORY_SEPARATOR);
            $root   = 'globe-connect-android';

            $script = sprintf($script,
                $key,
                $files,
                'GlobeConnectIOS',
                'ph.com.globe.connect',
                $target,
                $sdkOut);

            echo $script;

            print 'Generating sdk for android with id ' . $key . PHP_EOL;

            exec($script);

            if(!file_exists($folder)) {
                print $folder . ' does not exists, skipping.' . PHP_EOL;
                return;
            }

            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array(realpath($out), 'android-' . $key . '.zip'), DIRECTORY_SEPARATOR),
                $root);

            exec($zip);

            print 'Zip file generated for android with id ' . $key . PHP_EOL;
        } else if ($type == 'ios'){
            $script = $script . ' ios -i %s -f %s -p %s -s %s -o %s';
            $key    = $this->getKey($files);

            $tmp = explode(' ', $files);

            foreach($tmp as $i => $v) {
                if($v == 'Authentication') {
                    $v = 'Authenticate';
                }

                if($v == 'Location') {
                    $v = 'LocationQuery';
                }

                $tmp[$i] = 'GlobeConnect' . $v . '.swift';
            }

            $files = implode($tmp, ',');

            $target = implode(array('repo', 'globe-connect-ios'), DIRECTORY_SEPARATOR);
            $sdkOut = implode(array('.', 'out', 'ios'), DIRECTORY_SEPARATOR);
            $folder = implode(array($sdkOut, 'ios-' . $key, ''), DIRECTORY_SEPARATOR);
            $root   = 'globe-connect-ios';

            $script = sprintf($script,
                $key,
                $files,
                'GlobeConnect',
                $target,
                $sdkOut);

            echo $script;

            print 'Generating sdk for ios with id ' . $key . PHP_EOL;

            exec($script);

            if(!file_exists($folder)) {
                print $folder . ' does not exists, skipping.' . PHP_EOL;
                return;
            }

            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array(realpath($out), 'ios-' . $key . '.zip'), DIRECTORY_SEPARATOR),
                $root);

            exec($zip);

            print 'Zip file generated for android with id ' . $key . PHP_EOL;
        } else if($type == 'phonegap') {
            $script = $script . ' phonegap -i %s -f %s -s %s -o %s';
            $key    = $this->getKey($files);

            $tmp = explode(' ', $files);

            foreach($tmp as $i => $v) {
                $tmp[$i] = $v;
            }

            $files = implode($tmp, ',');

            $target = implode(array('repo', 'globe-connect-phonegap', 'cordova-plugin-globeconnect'), DIRECTORY_SEPARATOR);
            $sdkOut = implode(array('.', 'out', 'phonegap'), DIRECTORY_SEPARATOR);
            $folder = implode(array($sdkOut, 'phonegap-' . $key, ''), DIRECTORY_SEPARATOR);
            $root   = 'cordova-plugin-globeconnect';

            $script = sprintf($script,
                $key,
                $files,
                $target,
                $sdkOut);

            echo $script;

            print 'Generating sdk for phonegap with id ' . $key . PHP_EOL;

            exec($script);

            if(!file_exists($folder)) {
                print $folder . ' does not exists, skipping.' . PHP_EOL;
                return;
            }

            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array(realpath($out), 'phonegap-' . $key . '.zip'), DIRECTORY_SEPARATOR),
                $root);

            exec($zip);

            print 'Zip file generated for phonegap with id ' . $key . PHP_EOL;
        } else if($type == 'react') {
            $script = $script . ' react -i %s -f %s -s %s -o %s';
            $key    = $this->getKey($files);

            $tmp = explode(' ', $files);

            foreach($tmp as $i => $v) {
                $tmp[$i] = $v;
            }

            $files = implode($tmp, ',');

            $target = implode(array('repo', 'globe-connect-react-native', 'react-native-globeconnect'), DIRECTORY_SEPARATOR);
            $sdkOut = implode(array('.', 'out', 'react'), DIRECTORY_SEPARATOR);
            $folder = implode(array($sdkOut, 'react-' . $key, ''), DIRECTORY_SEPARATOR);
            $root   = 'react-native-globeconnect';

            $script = sprintf($script,
                $key,
                $files,
                $target,
                $sdkOut);

            echo $script;

            print 'Generating sdk for react with id ' . $key . PHP_EOL;

            exec($script);

            if(!file_exists($folder)) {
                print $folder . ' does not exists, skipping.' . PHP_EOL;
                return;
            }

            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array(realpath($out), 'react-' . $key . '.zip'), DIRECTORY_SEPARATOR),
                $root);

            exec($zip);

            print 'Zip file generated for react with id ' . $key . PHP_EOL;
        }
    }

    public function getKey($files) {
        $key   = array();
        $files = explode(' ', $files);

        foreach($this->keys as $k => $v) {
            foreach($files as $file) {
                if($k == $file) {
                    $key[] = $v;
                }
            }
        }

        sort($key);

        return implode(array_unique($key), '');
    }

    public function getPossiblePermutations($array, $tmp, &$collect) {
        if($tmp != '') {
            $collect []= $tmp;
        }

        for($i = 0; $i < sizeof($array); $i ++) {
            $copy = $array;
            $elem = array_splice($copy, $i, 1);

            $pattern = trim($tmp . ' ' . $elem[0]);

            $pattern = explode(' ', $pattern);

            sort($pattern);

            $pattern = implode($pattern, ' ');

            if(sizeof($copy) > 0) {
                $this->getPossiblePermutations($copy, $pattern, $collect);
            } else {
                $collect []= $pattern;
            }
        }
    }
}

new SdkZipGenerator($argv);
