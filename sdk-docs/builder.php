<?php
$contents = include __DIR__ . '/copy.php';

$individual    = [];
$documentation = [];
foreach ($contents as $language => $sections) {
    $encoding = '';
    $individual = [];

    switch($language) {
        case 'Android':
            $encoding = 'java';
            break;
        case 'iOS 10':
            $encoding = 'swift';
            break;
        case 'React Native':
            $encoding = 'js';
            break;
        case 'PhoneGap':
            $encoding = 'js';
            break;
        case 'CLI':
            $encoding = 'bash';
            break;
        case 'PHP':
            $encoding = 'php';
            break;
        case 'Python':
            $encoding = 'python';
            break;
        case 'Ruby':
            $encoding = 'ruby';
            break;
        case 'NodeJS':
            $encoding = 'js';
            break;
        case 'Java':
            $encoding = 'java';
            break;
        case 'C Sharp':
            $encoding = 'csharp';
            break;
    }

    $individual[] = $documentation[] = '';

    $individual[] = '## Globe Connect for ' . $language;
    $documentation[] = '## '.$language;
    foreach($sections as $section => $content) {
        $individual[] = $documentation[] = '';
        $individual[] = $documentation[] = '### '.$section;

        if(is_string($content)) {
            $individual[] = $documentation[] = '';
            if($content) {
                $individual[] = $documentation[] = $content;
            } else {
                $individual[] = $documentation[] = 'TODO';
            }

            continue;
        }

        if(isset($content['Overview'])) {
            $individual[] = $documentation[] = '';
            $individual[] = $documentation[] = '#### Overview';
            $individual[] = $documentation[] = '';
            if(!$content['Overview']) {
                $individual[] = $documentation[] = 'TODO';
            } else {
                $individual[] = $documentation[] = $content['Overview'];
            }
        }

        if(isset($content['Code'])) {
            $individual[] = $documentation[] = '';
            $individual[] = $documentation[] = '#### Sample Code';
            $individual[] = $documentation[] = '';
            $individual[] = $documentation[] = '```' . $encoding;
            $individual[] = $documentation[] = $content['Code'];
            $individual[] = $documentation[] = '```';
        }

        if(isset($content['Results'])) {
            $individual[] = $documentation[] = '';
            $individual[] = $documentation[] = '#### Sample Results';
            $individual[] = $documentation[] = '';
            if(!$content['Results']) {
                $individual[] = $documentation[] = 'TODO';
            } else {
                $individual[] = $documentation[] = '```json';
                $individual[] = $documentation[] = $content['Results'];
                $individual[] = $documentation[] = '```';
            }
        }

        if(isset($content['Calls'])) {
            foreach($content['Calls'] as $action => $content) {
                $individual[] = $documentation[] = '';
                $individual[] = $documentation[] = '#### '.$section . ' ' . $action;
                if(isset($content['Overview'])) {
                    $individual[] = $documentation[] = '';
                    if(!$content['Overview']) {
                        $individual[] = $documentation[] = 'TODO';
                    } else {
                        $individual[] = $documentation[] = $content['Overview'];
                    }
                }

                if(isset($content['Code'])) {
                    $individual[] = $documentation[] = '';
                    $individual[] = $documentation[] = '##### Sample Code';
                    $individual[] = $documentation[] = '';
                    $individual[] = $documentation[] = '```' . $encoding;
                    $individual[] = $documentation[] = $content['Code'];
                    $individual[] = $documentation[] = '```';
                }

                if(isset($content['Results'])) {
                    $individual[] = $documentation[] = '';
                    $individual[] = $documentation[] = '##### Sample Results';
                    $individual[] = $documentation[] = '';
                    if(!$content['Results']) {
                        $individual[] = $documentation[] = 'TODO';
                    } else {
                        $individual[] = $documentation[] = '```json';
                        $individual[] = $documentation[] = $content['Results'];
                        $individual[] = $documentation[] = '```';
                    }
                }
            }
        }
    }

    $individual[] = '';
    $lang = $language;

    $lang = strtolower($lang);

    if($lang == 'ios 10') {
        $lang = 'ios';
    }

    if($lang == 'c sharp') {
        $lang = 'csharp';
    }

    if($lang == 'react native') {
        $lang = 'react-native';
    }

    $path = __DIR__ . '/../../connect-' . $lang;

    if(file_exists($path)) {
        file_put_contents($path . '/README.md', implode("\n", $individual));
    }
}

$documentation[] = '';
file_put_contents(__DIR__ . '/results.md', implode("\n", $documentation));

$original = file_get_contents(__DIR__ . '/../docs/docs.md');
$current  = file_get_contents(__DIR__ . '/results.md');

$original .= PHP_EOL;
$original .= 'SDK\'s & Libraries' . PHP_EOL . '===================' . PHP_EOL;
$original .= $current;

file_put_contents(__DIR__ . '/../docs/docs-all.md', $original);
