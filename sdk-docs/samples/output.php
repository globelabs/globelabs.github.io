<?php
$output = array (

'SMS Send' => '
{
    "outboundSMSMessageRequest": {
        "address": "tel:+639175595283",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/8011/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g"
        },
        "senderAddress": "8011",
        "outboundSMSTextMessage": {
            "message": "Hello World"
        },
        "receiptRequest": {
            "notifyURL": "http://test-sms1.herokuapp.com/callback",
            "callbackData": null,
            "senderName": null,
            "resourceURL": "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/8011/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g"
        }
    }
}
',

'SMS Binary' => '
{
    "outboundBinaryMessageRequest": {
        "address": "9171234567",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}",
        "senderAddress": "21581234",
        "userDataHeader": "06050423F423F4",
        "dataCodingScheme": 1,
        "outboundBinaryMessage": {
            "message": "samplebinarymessage"
        },
        "receiptRequest": {
          "notifyURL": "http://example.com/notify",
          "callbackData": null,
          "senderName": null
        },
        "resourceURL": "https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}"
    }
}
',

'Location' => '
{
    "terminalLocationList": {
        "terminalLocation": {
            "address": "tel:9171234567",
            "currentLocation": {
                "accuracy": 100,
                "latitude": "14.5609722",
                "longitude": "121.0193394",
                "map_url": "http://maps.google.com/maps?z=17&t=m&q=loc:14.5609722+121.0193394",
                "timestamp": "Fri Jun 06 2014 09:25:15 GMT+0000 (UTC)"
            },
            "locationRetrievalStatus": "Retrieved"
        }
    }
}
',

'Payment Send' => '
{
    "amountTransaction":
    {
        "endUserId": "9171234567",
        "paymentAmount":
        {
            "chargingInformation":
            {
                "amount": "0.00",
                "currency": "PHP",
                "description": "my application"
            },
            "totalAmountCharged": "0.00"
        },
        "referenceCode": "12341000023",
        "serverReferenceCode": "528f5369b390e16a62000006",
        "resourceURL": null
    }
}
',

'Payment Reference' => '
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
',

'Subscriber Balance' => '
{
    terminalLocationList:
    {
        terminalLocation:
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
',

'Subscriber Reload' => '
{
    terminalLocationList:
    {
        terminalLocation:
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
',

'USSD Send' => '
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\\nOption - 1\\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
',

'USSD Reply' => '
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\\nOption - 1\\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
',

'Amax' => '
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
',

'Authentication' => '
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
',

'Voice Answer' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            hangup: { }
        }
    ]
}
',

'Voice Ask' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: {
                    value: "Please enter your 5 digit zip code."
                },
                timeout: 10
            }
        },
        {
            on: {
                event: "continue",
                next: "http://somefakehost.com:8000/",
                required: true
            }
        }
    ]
}
',

'Voice Ask-Answer' => '
if path is ask?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: {
                    value: "Please enter your 5 digit zip code."
                },
                timeout: 10
            }
        },
        {
            on: {
                event: "continue",
                next: "/askanswer/answer",
                required: true
            }
        }
    ]
}

if path is answer?

{
    tropo: [
        {
            say: {
                value: "Your zip code is 52521, thank you!"
            }
        }
    ]
}
',

'Voice Call' => '
{
    tropo: [
        {
            call: {
                to: "9065272450",
                from: "sip:21584130@sip.tropo.net"
            }
        },
        [
            {
                value: "Hello World"
            }
        ]
    ]
}
',

'Voice Conference' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API Conference Call."
        }
        },
        {
            conference: {
                id: "12345",
                mute: false,
                name: "foo",
                playTones: true,
                terminator: "#",
                joinPrompt: {
                    value: "http://openovate.com/hold-music.mp3"
                },
                leavePrompt: {
                    value: "http://openovate.com/hold-music.mp3"
                }
            }
        }
    ]
}
',

'Voice Event' => '
{
tropo: [
    {
        say: {
            value: "Welcome to my Tropo Web API."
        }
    },
    {
        ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: [
                    {
                        value: "Sorry, I did not hear anything.",
                        event: "timeout"
                    },
                    {
                        value: "Sorry, that was not a valid option.",
                        event: "nomatch:1"
                    },
                    {
                        value: "Nope, still not a valid response",
                        event: "nomatch:2"
                    },
                    {
                        value: "Please enter your 5 digit zip code."
                    }
                ],
                timeout: 5
            }
        },
        {
            on: {
                event: "continue",
                next: "http://somefakehost:8000/",
                required: true
            }
        }
    ]
}
',

'Voice Hangup' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, thank you!"
            }
        },
        {
            hangup: { }
        }
    ]
}
',

'Voice Record' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            record: {
                attempts: 3,
                bargein: false,
                method: "POST",
                required: true,
                say: [
                    {
                        value: "Sorry, I did not hear anything. Please call back.",
                        event: "timeout"
                    },
                    {
                        value: "Please leave a message"
                    }
                ],
                name: "foo",
                url: "http://openovate.com/globe.php",
                format: "audio/wav",
                choices: {
                    terminator: "#"
                },
                transcription: {
                    id: "1234",
                    url: "mailto:charles.andacc@gmail.com"
                }
            }
        }
    ]
}
',

'Voice Reject' => '
{
    tropo: [
        {
            reject: { }
        }
    ]
}
',

'Voice Routing' => '

if path is routing?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            on: {
                next: "/VoiceSample/RoutingTest1",
                event: "continue"
            }
        }
    ]
}

if path is routing1?

{
    tropo: [
        {
            say: {
                value: "Hello from resource one!"
            }
        },
        {
            on: {
                next: "/VoiceSample/RoutingTest2",
                event: "continue"
            }
        }
    ]
}

if path is routing2?

{
    tropo: [
        {
            say: {
                value: "Hello from resource two! thank you."
            }
        }
    ]
}
',

'Voice Say' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            say: {
                value: "I will play an audio file for you, please wait."
            }
        },
        {
            say: {
                value: "http://openovate.com/tropo-rocks.mp3"
            }
        }
    ]
}
',

'Voice Transfer' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, you are now being transferred."
            }
        },
        {
            transfer: {
                to: "9053801178",
                ringRepeat: 2,
                on: [
                    {
                        event: "ring",
                        say: {
                            value: "http://openovate.com/hold-music.mp3"
                        }
                    },
                    {
                        event: "connect",
                        ask: {
                            choices: {
                                value: "[5 DIGITS]"
                            },
                            attempts: 3,
                            bargein: false,
                            name: "foo",
                            required: true,
                            say: [
                                {
                                    value: "Sorry, I did not hear anything.",
                                    event: "timeout"
                                },
                                {
                                    value: "Sorry, that was not a valid option.",
                                    event: "nomatch:1"
                                },
                                {
                                    value: "Nope, still not a valid response",
                                    event: "nomatch:2"
                                },
                                {
                                    value: "Please enter your 5 digit zip code."
                                }
                            ],
                            timeout: 5
                        }
                    }
                ]
            }
        }
    ]
}
',

'Voice Transfer Whisper' => '
if transfer whisper?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, please hold while you are being transferred."
            }
        },
        {
            transfer: {
                to: "9054799241",
                name: "foo",
                on: [
                    {
                        event: "ring",
                        say: {
                            value: "http://openovate.com/hold-music.mp3"
                        }
                    },
                    {
                        event: "connect",
                        ask: {
                            choices: {
                                value: "1",
                                mode: "dtmf"
                            },
                            name: "color",
                            say: {
                                value: "Press 1 to accept this call or any other number to reject"
                            },
                            timeout: 60
                        }
                    },
                    {
                        event: "connect",
                        say: {
                            value: "You are now being connected."
                        }
                    }
                ],
                required: true,
                terminator: "*"
            }
        },
        {
            on: {
                event: "incomplete",
                next: "/transferwhisper/hangup",
                say: {
                    value: "You are now being disconnected."
                }
            }
        }
    ]
}

if hangup?

{
    tropo: [
        {
            hangup: { }
        }
    ]
}
',

'Voice Wait' => '
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, please wait for a while."
            }
        },
        {
            wait: {
                milliseconds: 5000,
                allowSignals: true
            }
        },
        {
            say: {
                value: "Thank you for waiting!"
            }
        }
    ]
}
',
);

foreach($output as $key => $value) {
    $output[$key] = trim($value);
}

return $output;
