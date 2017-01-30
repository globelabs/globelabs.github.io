<?php

$samples = array (

'Amax' => '
globe-cli.js amax -i "[app_id]" -s "[app_secret]" -t "[rewards_token]" -p "[promo]" -a [subscriber_number] --verbose
',

'Authentication' => 'Authentication is not available in Globe Connect CLI.',

'Location' => '
globe-connect location -a [subscriber_number] -c [accuracy] -t "[access_token]" --verbose
',

'Payment Send' => '
globe-connect payment -a [amount] -d "[description]" -e [subscriber_number] -r [reference] -s [status] -t "[access_token]" --verbose
',

'Payment Reference' => '
globe-connect get-last-reference -ai "[app_id]" -as "[app_secret]" --verbose
',

'SMS Send' => '
globe-connect sms -a [subscriber_number] -m "[message]" -s [short_code] -c [client_correlator] -t "[access_token]"
',

'SMS Binary' => '
globe-connect binarysms -c "[short_code]" -t "[access_token]" -u "[data_header]" -d [coding_scheme] -a "[subscriber_number]" -m "[message]" --verbose
',

'SMS Mobile Originating (SMS-MO)' => '',

'Subscriber Balance' => '
globe-connect subscr-bal -a [subscriber_number] -t "[access_token]" --verbose
',

'Subscriber Reload' => '
globe-connect subscr-reload-amt -a [subscriber_number] -t "[access_token]" --verbose
',

'USSD Send' => '
globe-connect ussd-send -m [message] -a [address] -s [short_code] -f [flash] -t [access_token]
',

'USSD Reply' => '
globe-connect ussd-send -m [message] -a [address] -s [short_code] -f [flash] -t [access_token] -i [session_id]
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
