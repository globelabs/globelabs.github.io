<?php
$contents = include __DIR__ . '/copy.php';

$documentation = [];
foreach ($contents as $language => $sections) {
    $encoding = '';
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
    $documentation[] = '';
    $documentation[] = '## '.$language;
    foreach($sections as $section => $content) {
        $documentation[] = '';
        $documentation[] = '### '.$section;

        if(is_string($content)) {
            $documentation[] = '';
            if($content) {
                $documentation[] = $content;
            } else {
                $documentation[] = 'TODO';
            }

            continue;
        }

        if(isset($content['Overview'])) {
            $documentation[] = '';
            $documentation[] = '#### Overview';
            $documentation[] = '';
            if(!$content['Overview']) {
                $documentation[] = 'TODO';
            } else {
                $documentation[] = $content['Overview'];
            }
        }

        if(isset($content['Code'])) {
            $documentation[] = '';
            $documentation[] = '#### Sample Code';
            $documentation[] = '';
            $documentation[] = '```' . $encoding;
            $documentation[] = $content['Code'];
            $documentation[] = '```';
        }

        if(isset($content['Results'])) {
            $documentation[] = '';
            $documentation[] = '#### Sample Results';
            $documentation[] = '';
            if(!$content['Results']) {
                $documentation[] = 'TODO';
            } else {
                $documentation[] = $content['Results'];
            }
        }

        if(isset($content['Calls'])) {
            foreach($content['Calls'] as $action => $content) {
                $documentation[] = '';
                $documentation[] = '#### '.$section . ' ' . $action;
                if(isset($content['Overview'])) {
                    $documentation[] = '';
                    if(!$content['Overview']) {
                        $documentation[] = 'TODO';
                    } else {
                        $documentation[] = $content['Overview'];
                    }
                }

                if(isset($content['Code'])) {
                    $documentation[] = '';
                    $documentation[] = '##### Sample Code';
                    $documentation[] = '';
                    $documentation[] = '```' . $encoding;
                    $documentation[] = $content['Code'];
                    $documentation[] = '```';
                }

                if(isset($content['Results'])) {
                    $documentation[] = '';
                    $documentation[] = '##### Sample Results';
                    $documentation[] = '';
                    if(!$content['Results']) {
                        $documentation[] = 'TODO';
                    } else {
                        $documentation[] = $content['Results'];
                    }
                }
            }
        }
    }
}

$documentation[] = '';
file_put_contents(__DIR__ . '/results.md', implode("\n", $documentation));
