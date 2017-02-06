<?php // -->

/**
 * Generates SDK zip files and SDK file sizes.
 *
 * This file is part of the Globe Labs SDK Builder.
 *
 * @author Charles Zamora <czamora@openovate.com>
 */
class SdkZipGenerator {
    /**
     * Sdk types.
     *
     * @var array
     */
    protected $types = array('android', 'ios', 'phonegap', 'react-native');

    /**
     * File names to include.
     *
     * @var array
     */
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

    /**
     * Root path.
     *
     * @var string
     */
    protected $root = null;

    /**
     * Repo path.
     *
     * @var string
     */
    protected $repo = null;

    /**
     * Temp path.
     *
     * @var string
     */
    protected $temp = null;

    /**
     * Output path.
     *
     * @var string
     */
    protected $out = null;

    /**
     * Zips path.
     *
     * @var string
     */
    protected $zips = null;

    /**
     * Script path.
     *
     * @var string
     */
    protected $script = null;

    /**
     * Prepares and execute generate process.
     *
     * @param array
     */
    public function __construct($argv) {
        // prepare folders
        $this->prepare();

        // generate binary permutations
        $permutations = $this->generateBinaryPermutations();

        $this->log('Preparing sdk generator ...');

        // iterate on each types
        foreach($this->types as $type) {
            // is argument set, are we generating specific type?
            if(isset($argv[1]) && $argv[1] != $type) {
                continue;
            }

            // switch on each types
            switch($type) {
                // android?
                case 'android' :
                    $this->generateAndroid($permutations);
                    break;

                // ios?
                case 'ios' :
                    $this->generateIos($permutations);
                    break;

                // phonegap?
                case 'phonegap' :
                    $this->generatePhonegap($permutations);
                    break;

                // react native?
                case 'react-native' :
                    $this->generateReact($permutations);
                    break;

                // unknown?
                default :
                    $this->log('Unable to generate zip files for `unknown`.');
                    break;
            }
        }
    }

    /**
     * Prepares folder and necessary files
     * for generating sdk zips e.g repos.
     *
     * @return void
     */
    protected function prepare()
    {
        $this->log('Preparing zip generator ...');
        $this->log('Checking repositories directory ...');

        // get root path
        $this->root     = realpath(__DIR__ . '/../');
        // formulate repo directory
        $this->repo     = $this->root . '/repo';
        // formulate temp directory
        $this->temp     = $this->root . '/tmp';
        // formualte out directory
        $this->out      = $this->root . '/out';
        // formulate zips directory
        $this->zips     = $this->root . '/zips';
        // formulate script path
        $this->script  = $this->root . '/bin/gl-sdk-build.js';

        // check script file first
        if(!file_exists($this->script)) {
            $this->log('Script file for generating sdk does not exists.');
            exit;
        }

        // if repo folder does not exists
        // if(!file_exists($this->repo)) {
        //     $this->log('Cloning repositories ...');
        //
        //     // checkout repositories
        //     exec(__DIR__ . '/checkout-repo.sh');
        // } else {
        //     $this->log('Repositories exists, updating repositories ...');
        //
        //     // update repositories
        //     exec(__DIR__ . '/update-repo.sh');
        // }

        $this->log('...');
        $this->log('Checking required directories ...');

        // create temp directory
        if(!file_exists($this->temp)) {
            mkdir($this->temp);
        } else {
            // we are just making sure we'll not deleting root folders :p
            if(strpos($this->temp, 'globelabs.github.io') !== false) {
                exec('rm -rf ' . $this->temp);
            }

            mkdir($this->temp);
        }

        // create output directory
        if(!file_exists($this->out)) {
            mkdir($this->out);
        } else {
            // we are just making sure we'll not deleting root folders :p
            if(strpos($this->out, 'globelabs.github.io') !== false) {
                exec('rm -rf ' . $this->out);
            }

            mkdir($this->out);
        }

        // create zips directory
        if(!file_exists($this->zips)) {
            mkdir($this->zips);
        } else {
            // we are just making sure we'll not deleting root folders :p
            if(strpos($this->zips, 'globelabs.github.io') !== false) {
                exec('rm -rf ' . $this->zips);
            }

            mkdir($this->zips);
        }

        $this->log('Done processing required repositories and directories ...');
    }

    /**
     * Generate zip files for android base
     * on the given permutations.
     *
     * @param  array
     * @return void
     */
    protected function generateAndroid($permutations)
    {
        $this->log('Generating zip files for android ...');

        // iterate on each permutations
        foreach($permutations as $index => $permutation) {
            // formulate script command
            $script = $this->script . ' android -i %s -f %s -p %s -n %s -s %s -o %s';
            // get the readable file names
            $files  = $this->convertToString($permutation);

            // copy files and explode it
            $tmp = explode(' ', $files);

            // iterate on each files and append type
            foreach($tmp as $i => $v) {
                $tmp[$i] = $v . '.java';
            }

            // join file names again
            $files  = implode($tmp, ',');
            // get target repository
            $target = implode(array($this->repo, 'globe-connect-android'), DIRECTORY_SEPARATOR);
            // formulate sdk out
            $sdkOut = implode(array($this->out, 'android'), DIRECTORY_SEPARATOR);
            // formulate output folder name
            $folder = implode(array($sdkOut, 'android-' . $permutation, ''), DIRECTORY_SEPARATOR);
            // formulate zip output folder
            $zipOut = implode(array($this->zips, 'android'), DIRECTORY_SEPARATOR);
            // sdk name
            $name   = 'globe-connect-android';
            // zip name
            $zip    = sprintf('android-%s.zip', $permutation);

            // formulate script command
            $script = sprintf($script,
                $permutation,
                $files,
                'GlobeConnect',
                'ph.com.globe.connect',
                $target,
                $sdkOut);

            // execute script
            exec($script);

            // check for the output
            if(!file_exists($folder)) {
                $this->log($folder . ' does not exists, skipping ...');
                return;
            }

            // check for the zip output folder
            if(!file_exists($zipOut)) {
                mkdir($zipOut);
            }

            // formulate zip command
            $zip = sprintf(
                'cd %s && ls && zip -r %s %s',
                $folder,
                implode(array($this->zips, 'android', $zip), DIRECTORY_SEPARATOR),
                $name);

            // execute zip generation
            $this->log('===> *zip* <===');
            $this->log(exec($zip));
            $this->log('  zip file generated for android with id ' . $permutation);
            $this->log('===> *end zip* <===');

            $this->log($index + 1 . ' out of ' . count($permutations) . ' android zip files has been successfully generated ...');

            break;
        }

        $this->log('Android zip files has been successfully generated ...');
        $this->log('...');
        $this->log('...');
    }

    /**
     * Generate zip files for ios base
     * on the given permutations.
     *
     * @param  array
     * @return void
     */
    protected function generateIos($permutations)
    {
        $this->log('Generating zip files for ios ...');

        // iterate on each permutations
        foreach($permutations as $index => $permutation) {
            // formulate script
            $script = $this->script . ' ios -i %s -f %s -p %s -s %s -o %s';
            // get the readable file names
            $files  = $this->convertToString($permutation);

            // copy files and explode it
            $tmp = explode(' ', $files);

            // iterate on each files and format it
            foreach($tmp as $i => $v) {
                // replace authentication with authenticate
                if($v == 'Authentication') {
                    $v = 'Authenticate';
                }

                // replace location with location query
                if($v == 'Location') {
                    $v = 'LocationQuery';
                }

                // append prefix
                $tmp[$i] = 'GlobeConnect' . $v . '.swift';
            }

            // join back the files
            $files =  implode($tmp, ',');
            // formulate target repository folder
            $target = implode(array($this->repo, 'globe-connect-ios'), DIRECTORY_SEPARATOR);
            // formulate sdk output folder
            $sdkOut = implode(array($this->out, 'ios'), DIRECTORY_SEPARATOR);
            // formulate output folder
            $folder = implode(array($sdkOut, 'ios-' . $permutation, ''), DIRECTORY_SEPARATOR);
            // formulate zip output folder
            $zipOut = implode(array($this->zips, 'ios'), DIRECTORY_SEPARATOR);
            // sdk name
            $name   = 'globe-connect-ios';
            // zip name
            $zip    = sprintf('ios-%s.zip', $permutation);

            // formulate script
            $script = sprintf($script,
                $permutation,
                $files,
                'GlobeConnectIOS',
                $target,
                $sdkOut);

            // execute script
            exec($script);

            // check for the output
            if(!file_exists($folder)) {
                $this->log($folder . ' does not exists, skipping ...');
                return;
            }

            // check for the zip output folder
            if(!file_exists($zipOut)) {
                mkdir($zipOut);
            }

            // formulate zip command
            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array($this->zips, 'ios', $zip), DIRECTORY_SEPARATOR),
                $name);

            // execute zip generation
            $this->log('===> *zip* <===');
            $this->log(exec($zip));
            $this->log('  zip file generated for ios with id ' . $permutation);
            $this->log('===> *end zip* <===');

            break;
        }

        $this->log('iOS zip files has been successfully generated ...');
        $this->log('...');
        $this->log('...');
    }

    /**
     * Generate zip files for phonegap base
     * on the given permutations.
     *
     * @param  array
     * @return void
     */
    protected function generatePhonegap($permutations)
    {
        $this->log('Generating zip files for phonegap ...');

        // iterate on each permutations
        foreach($permutations as $index => $permutation) {
            // formulate script
            $script = $this->script . ' phonegap -i %s -f %s -s %s -o %s';
            // get the readable file names
            $files  = $this->convertToString($permutation);

            // copy files and explode it
            $tmp = explode(' ', $files);

            // iterate on each files and format it
            foreach($tmp as $i => $v) {
                $tmp[$i] = $v;
            }

            // join back the files
            $files  = implode($tmp, ',');
            // formulate target repository folder
            $target = implode(array($this->repo, 'globe-connect-phonegap', 'cordova-plugin-globeconnect'), DIRECTORY_SEPARATOR);
            // formulate sdk output folder
            $sdkOut = implode(array($this->out, 'phonegap'), DIRECTORY_SEPARATOR);
            // formulate output folder
            $folder = implode(array($sdkOut, 'phonegap-' . $permutation, ''), DIRECTORY_SEPARATOR);
            // formulate zip output folder
            $zipOut = implode(array($this->zips, 'phonegap'), DIRECTORY_SEPARATOR);
            // zip name
            $zip    = sprintf('phonegap-%s.zip', $permutation);

            // formulate script
            $script = sprintf($script,
                $permutation,
                $files,
                $target,
                $sdkOut);

            // execute script
            exec($script);

            // check for the output
            if(!file_exists($folder)) {
                $this->log($folder . ' does not exists, skipping ...');
                return;
            }

            // check for the zip output folder
            if(!file_exists($zipOut)) {
                mkdir($zipOut);
            }

            // formulate script
            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array($this->zips, 'phonegap', $zip), DIRECTORY_SEPARATOR),
                'cordova-plugin-globeconnect');

            // execute zip generation
            $this->log('===> *zip* <===');
            $this->log(exec($zip));
            $this->log('  zip file generated for ios with id ' . $permutation);
            $this->log('===> *end zip* <===');

            break;
        }

        $this->log('Phonegap zip files has been successfully generated ...');
        $this->log('...');
        $this->log('...');
    }

    /**
     * Generate zip files for react base
     * on the given permutations.
     *
     * @param  array
     * @return void
     */
    protected function generateReact($permutations)
    {
        $this->log('Generating zip files for react ...');

        // iterate on each permutations
        foreach($permutations as $index => $permutation) {
            // formulate script
            $script = $this->script . ' react -i %s -f %s -s %s -o %s';
            // get the readable file names
            $files  = $this->convertToString($permutation);

            // copy files and explode it
            $tmp = explode(' ', $files);

            // iterate on each file and format it
            foreach($tmp as $i => $v) {
                $tmp[$i] = $v;
            }

            // join back files
            $files  = implode($tmp, ',');
            // formulate target repository folder
            $target = implode(array($this->repo, 'globe-connect-react-native', 'react-native-globeconnect'), DIRECTORY_SEPARATOR);
            // formulate sdk output folder
            $sdkOut = implode(array($this->out, 'react'), DIRECTORY_SEPARATOR);
            // formulate output folder
            $folder = implode(array($sdkOut, 'react-' . $permutation, ''), DIRECTORY_SEPARATOR);
            // formulate zip output folder
            $zipOut = implode(array($this->zips, 'react'), DIRECTORY_SEPARATOR);
            // zip name
            $zip    = sprintf('react-%s.zip', $permutation);

            // formulate script
            $script = sprintf($script,
                $permutation,
                $files,
                $target,
                $sdkOut);

            // execute script
            exec($script);

            // check for the output
            if(!file_exists($folder)) {
                $this->log($folder . ' does not exists, skipping ...');
                return;
            }

            // check for the zip output folder
            if(!file_exists($zipOut)) {
                mkdir($zipOut);
            }

            // formulate script
            $zip = sprintf(
                'cd %s && zip -r %s %s',
                $folder,
                implode(array($this->zips, 'react', $zip), DIRECTORY_SEPARATOR),
                'react-native-globeconnect');

            // execute zip generation
            $this->log('===> *zip* <===');
            $this->log(exec($zip));
            $this->log('  zip file generated for ios with id ' . $permutation);
            $this->log('===> *end zip* <===');

            break;
        }

        $this->log('React Native zip files has been successfully generated ...');
        $this->log('...');
        $this->log('...');
    }

    /**
     * Generates binary permutations.
     *
     * @return array
     */
    protected function generateBinaryPermutations()
    {
        $this->log('Generating binary permutations ...');

        // get bits based on file count
        $bits = count($this->names);
        // mask max bits
        $max  = (1 << $bits);

        // permutations
        $permutations = array();

        // calculate permutations
        for ($i = 1; $i < $max; $i++) {
            // push formatted binary
            $permutations[] = str_pad(decbin($i), $bits, '0', STR_PAD_LEFT);
        }

        return $permutations;
    }

    /**
     * Convert binary pattern to string equivalent.
     *
     * @param  string
     * @return string
     */
    protected function convertToString($binary)
    {
        // split binary
        $binary = str_split($binary);

        // string pattern
        $string = array();

        // iterate on each binary
        foreach($binary as $index => $value) {
            // value is 1?
            if($value == 1) {
                $string[] = $this->names[$index];
            }
        }

        return implode(',', $string);
    }

    /**
     * Log helper.
     *
     * @param  string
     * @param  bool
     * @return void
     */
    protected function log($message = '', $newline = true)
    {
        $message = '[zip-generator]: ' . $message;

        if($newline) {
            $message .= PHP_EOL;
        }

        print $message;
    }
}

// driver
new SdkZipGenerator($argv);
