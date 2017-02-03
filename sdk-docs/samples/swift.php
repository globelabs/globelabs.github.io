<?php

$samples = array (

'Amax' => '
import ConnectSwift

let amax = Amax(
    appId: "[app_id]",
    appSecret: "[app_secret]"
)

amax.sendRewardRequest(
    address: "[subscriber_number]",
    promo: "[promo]",
    rewardsToken: "[rewards_token]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'Authentication' => '
import ConnectSwift

Authentication().getAccessToken(
    appId: "[app_id]",
    appSecret: "[app_secret]",
    code: "[code]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

let url = Authentication().getDialogUrl(appId: "[app_id]")
print(url)
',

'Location' => '
import ConnectSwift

let locationQuery = LocationQuery(accessToken: "[access_token]")

locationQuery
    .getLocation(
        address: "[subscriber_number]",
        success: { json in
            dump(json)
        },
        failure: { error in
            print(error)
        })
',

'Payment Send' => '
import ConnectSwift

let payment = Payment(
    appId: "[app_id]",
    appSecret: "[app_secret]",
    accessToken: "[access_token]"
)

payment.sendPaymentRequest(
    amount: [amount],
    description: "[description]",
    endUserId: "[subscriber_number]",
    referenceCode: "[reference]",
    transactionOperationStatus: "[status]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'Payment Reference' => '
import ConnectSwift

let payment = Payment(
    appId: "[app_id]",
    appSecret: "[app_secret]",
    accessToken: "[access_token]"
)

payment.getLastReferenceCode(
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'SMS Send' => '
import ConnectSwift

let sms = Sms(
    accessToken: "[access_token]",
    shortCode: "[short_code]"
)

sms.sendBinaryMessage(
    address: "[subscriber_number]",
    message: "[message]",
    header: "[data_header]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'SMS Binary' => '
import ConnectSwift

let sms = Sms(
    accessToken: "[access_token]",
    shortCode: "[short_code]"
)

sms.sendMessage(
    address: "[subscriber_number]",
    message: "[message]",
    success: { json in
        dump(json)
        expectation.fulfill()
    },
    failure: { error in
        expectation.fulfill()
    })
',

'Subscriber Balance' => '
import ConnectSwift

let subscriber = Subscriber(accessToken: "[access_token]")

subscriber.getSubscriberBalance(
    address: "[subscriber_number]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'Subscriber Reload' => '
import ConnectSwift

let subscriber = Subscriber(accessToken: "[access_token]")

subscriber
    .getSubscriberReloadAmount(
        address: "[subscriber_number]",
        success: { json in
            dump(json)
        },
        failure: { error in
            print(error)
        })
',

'USSD Send' => '
import ConnectSwift

let ussd = Ussd(
    accessToken: "[access_token]",
    shortCode: "[short_code]"
)

ussd.sendUssdRequest(
    address: "[subscriber_number]",
    message: "[message]",
    flash: [flash],
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'USSD Reply' => '
import ConnectSwift

let ussd = Ussd(
    accessToken: "[access_token]",
    shortCode: "[short_code]"
)

ussd.replyUssdRequest(
    address: "[subscriber_number]",
    message: "[message]",
    sessionId: "[session_id]",
    flash: [flash],
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
