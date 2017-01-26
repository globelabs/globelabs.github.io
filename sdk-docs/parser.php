<?php

$languages = [];
$paths = scandir(__DIR__ . '/../api/samples');

foreach($paths as $path) {
    if(!file_exists(__DIR__ . '/../api/samples/' . $path) || strpos($path, '.md') === false) {
        continue;
    }

    $contents = file_get_contents(__DIR__ . '/../api/samples/' . $path);
    $contents = preg_replace('#```[a-z]+#', '```', $contents);

    $parts = explode('```', $contents);

    $samples = [];
    foreach($parts as $i => $part) {
        if($i % 2 === 1) {
            $samples[] = $part;
        }
    }

    $lines = explode("\n", $contents);

    $titles = [];
    foreach($lines as $i => $line) {
        if(strpos($line, '### ') === false) {
            continue;
        }

        $title = trim(str_replace('###', '', $line));

        switch($title) {
            case 'Send SMS:':
            case 'SMS (Send Message)':
            case 'Sms':
                $title = 'SMS Send';
                break;
            case 'Binary SMS:':
            case 'SMS (Binary Message)':
            case 'Binary SMS':
                $title = 'SMS Binary';
                break;
            case 'Payment:':
            case 'Payment(Send Payment Request)':
            case 'Payment (Send Payment Request)':
                $title = 'Payment Send';
                break;
            case 'Payment GET Last reference:':
            case 'Payment(Get Last Reference Code)':
            case 'Payment (Get Last Reference Code)':
            case 'Payment (Get Last Reference ID)':
                $title = 'Payment Reference';
                break;
            case 'Subscriber Balance:':
            case 'Subscriber (Get Subscriber Balance)':
            case 'Subscriber (Get Balance)':
                $title = 'Subscriber Balance';
                break;
            case 'Subscriber Reload Amount:':
            case 'Subscriber (Get Subscriber Reload Amount)':
            case 'Subscriber (Get Reload Amount)':
                $title = 'Subscriber Reload';
                break;
            case 'USSD (Send USSD Request)':
            case 'USSD (Send Request)':
            case 'USSD (Send)':
                $title = 'USSD Send';
                break;
            case 'USSD (Reply USSD Request)':
            case 'USSD (Reply Request)':
            case 'USSD (Reply)':
                $title = 'USSD Reply';
                break;
            case 'Location:':
                $title = 'Location';
                break;
            case 'AMAX':
                $title = 'Amax';
                break;
            default:
                echo $title.' not found'.PHP_EOL;
                break;
        }

        $titles[] = $title;
    }

    //echo $path . ' - ' . count($samples).' - '.count($titles).PHP_EOL;
    //echo json_encode($titles).PHP_EOL;

    if(count($samples) !== count($titles)) {
        continue;
    }

    $final = array_combine($titles, $samples);
    $languages[substr($path, 0, -3)] = $final;
}

$paths = scandir(__DIR__ . '/../api/samples/voice');

foreach($paths as $path) {
    if(!file_exists(__DIR__ . '/../api/samples/voice/' . $path) || strpos($path, '.md') === false) {
        continue;
    }

    $contents = file_get_contents(__DIR__ . '/../api/samples/voice/' . $path);
    $contents = preg_replace('#```[a-z]+#', '```', $contents);

    $parts = explode('```', $contents);

    $samples = [];
    foreach($parts as $i => $part) {
        if($i % 2 === 1) {
            $samples[] = $part;
        }
    }

    $lines = explode("\n", $contents);

    $titles = [];
    foreach($lines as $i => $line) {
        if(strpos($line, '### ') === false) {
            continue;
        }

        switch($title) {
            case 'Voice Ask/Answer':
                $title = 'Voice Ask-Answer';
                break;
        }

        $title = 'Voice ' . trim(str_replace('###', '', $line));

        $titles[] = $title;
    }

    echo $path . ' - ' . count($samples).' - '.count($titles).PHP_EOL;
    echo json_encode($titles).PHP_EOL;

    if(count($samples) !== count($titles)) {
        continue;
    }

    $final = array_combine($titles, $samples);

    if(!isset($languages[substr($path, 0, -3)])) {
        $languages[substr($path, 0, -3)] = $final;
    } else {
        $languages[substr($path, 0, -3)] = array_merge($languages[substr($path, 0, -3)], $final);
    }
}

foreach($languages as $name => $code) {
    $destination = __DIR__ . '/samples/' . $name . '.php';
    file_put_contents($destination, '<?php return '.var_export($code, true).';');
}
