<?php

$samples = array (
'Amax' => '',
'Authentication' => '',
'Location' => '',
'Payment Send' => '',
'Payment Reference' => '',
'SMS Send' => '',
'SMS Binary' => '',
'Subscriber Balance' => '',
'Subscriber Reload' => '',
'USSD Send' => '',
'USSD Reply' => ''
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
