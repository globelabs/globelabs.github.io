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
'USSD Reply' => '',
'Voice Ask' => '',
'Voice Answer' => '',
'Voice Ask-Answer' => '',
'Voice Call' => '',
'Voice Conference' => '',
'Voice Event' => '',
'Voice Hangup' => '',
'Voice Record' => '',
'Voice Reject' => '',
'Voice Routing' => '',
'Voice Say' => '',
'Voice Transfer' => '',
'Voice Transfer Whisper' => '',
'Voice Wait' => ''
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
