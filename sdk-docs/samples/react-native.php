<?php

$samples = array (

'Amax' => "
import GlobeConnect from 'react-native-globeapi';

var amax = GlobeConnect.Amax(
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
var auth = GlobeConnect.Authentication(
  '[app_id]',
  '[app_secret]');

auth.startAuthActivity(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
",

'Location' => "
import GlobeConnect from 'react-native-globeapi';

var location = GlobeConnect.Location('[access_token]');

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
import GlobeConnect from 'react-native-globeapi';

var payment = GlobeConnect.Payment('[access_token]');

payment
    .setAppId('[app_id]')
    .setAppSecret('[app_secret]')
    .setAmount([amount])
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
import GlobeConnect from 'react-native-globeapi';

var payment = GlobeConnect.Payment('[access_token]');

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
import GlobeConnect from 'react-native-globeapi';

var sms = GlobeConnect.Sms(
    '[short_code]',
    '[access_token]'
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
import GlobeConnect from 'react-native-globeapi';

var binary = GlobeConnect.BinarySms(
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
import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('[access_token]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'Subscriber Reload' => "
import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('[access_token]');

subscriber
    .setAddress('[subscriber_address]')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'USSD Send' => "
import GlobeConnect from 'react-native-globeapi';

var ussd = GlobeConnect.Ussd('[access_token]');

ussd
    .setSenderAddress('[short_code]')
    .setUssdMessage('[message]')
    .setAddress('[subscriber_address]')
    .setFlash([flash])
    .sendUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
",

'USSD Reply' => "
import GlobeConnect from 'react-native-globeapi';

var ussd = GlobeConnect.Ussd('[access_token]');

ussd
    .setSessionId('[session_id]')
    .setAddress('[subscriber_address]')
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
