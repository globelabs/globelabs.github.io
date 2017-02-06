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
     * Prepares and execute generate process.
     *
     * @param array
     */
    public function __construct($argv) {
        // prepare folders
        // $this->prepare();

        // generate binary permutations
        $permutations = $this->generateBinaryPermutations();

        
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
        $this->root = realpath(__DIR__ . '/../');
        // formulate repo directory
        $this->repo = $this->root . '/repo';
        // formulate temp directory
        $this->temp = $this->root . '/tmp';
        // formualte out directory
        $this->out  = $this->root . '/out';
        // formulate zips directory
        $this->zips = $this->root . '/zips';

        // if repo folder does not exists
        if(!file_exists($this->repo)) {
            $this->log('Cloning repositories ...');

            // checkout repositories
            exec(__DIR__ . '/checkout-repo.sh');
        } else {
            $this->log('Repositories exists, updating repositories ...');

            // update repositories
            exec(__DIR__ . '/update-repo.sh');
        }

        $this->log('...');
        $this->log('Checking required directories ...');

        // create temp directory
        if(!file_exists($this->temp)) {
            mkdir($this->temp);
        }

        // create output directory
        if(!file_exists($this->out)) {
            mkdir($this->out);
        }

        // create zips directory
        if(!file_exists($this->zips)) {
            mkdir($this->zips);
        }

        $this->log('Done processing required repositories and directories ...');
    }

    protected function generateAndroid()
    {}
    protected function generateIos()
    {}
    protected function generatePhonegap()
    {}
    protected function generateReact()
    {}

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
        for ($i = 0; $i < $max; $i++) {
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
