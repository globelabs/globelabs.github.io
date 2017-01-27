<?php

$samples = array (

'Amax' => "
var amax = globeconnect.Amax(
    '[app_id]',
    '[app_secret]'
);

amax
    .setAddress('[subscriber_number]')
    .setRewardsToken('[rewards_token]')
    .setPromo('[promo]');

amax.sendRewardRequest(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'Authentication' => "
var auth = globeconnect.Authentication(
    '[app_id]',
    '[app_secret]');

auth.startAuthActivity(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'Location' => "
var location = globeconnect.Location('[app_secret]');

location
    .setAddress('[subscriber_number]')
    .setRequestedAccuracy([accuracy]);

location.getLocation(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'Payment Send' => "
var payment = globeconnect.Payment('[app_secret]');

payment
    .setAppId('[app_id]')
    .setAppSecret('[app_secret]')
    .setAmount(0.00)
    .setDescription('[description]')
    .setEndUserId('[subscriber_number]')
    .setReferenceCode('[reference]')
    .setTransactionOperationStatus('[status]')
    .sendPaymentRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'Payment Reference' => "
var payment = globeconnect.Payment('[app_secret]');

payment
    .setAppId('[app_id]')
    .setAppSecret('[app_secret]')
    .getLastReferenceCode(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'SMS Send' => "
var sms = globeconnect.Sms(
    '[short_code]',
    '[app_secret]'
);

sms
    .setClientCorrelator('[client_correlator]')
    .setReceiverAddress('[subscriber_number]')
    .setMessage('[message]');

sms.sendMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'SMS Binary' => "
var binary = globeconnect.BinarySms(
    '[short_code]',
    '[access_token]'
);

binary
    .setUserDataHeader('[data_header]')
    .setDataCodingScheme([coding_scheme])
    .setReceiverAddress('[receiver_address]')
    .setBinaryMessage('[message]');

binary.sendBinaryMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'Subscriber Balance' => "
var subscriber = globeconnect.Subscriber('[app_secret]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'Subscriber Reload' => "
var subscriber = globeconnect.Subscriber('[app_secret]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'USSD Send' => "
var ussd = globeconnect.Ussd('[app_secret]');

ussd
    .setSenderAddress('[short_code]')
    .setUssdMessage('[message]')
    .setAddress('[subscriber_number]')
    .setFlash([flash])
    .sendUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'USSD Reply' => "
var ussd = globeconnect.Ussd('[app_secret]');

ussd
    .setSessionId('[session_id]')
    .setAddress('[subscriber_number]')
    .setSenderAddress('[short_code]')
    .setUssdMessage('[message]')
    .setFlash([flash])
    .replyUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
"
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
