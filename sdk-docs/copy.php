<?php

$samples = [
    'android' => include(__DIR__ . '/samples/android.php'),
    'csharp' => include(__DIR__ . '/samples/csharp.php'),
    'ios' => include(__DIR__ . '/samples/ios.php'),
    'java' => include(__DIR__ . '/samples/java.php'),
    'nodejs' => include(__DIR__ . '/samples/nodejs.php'),
    'phonegap' => include(__DIR__ . '/samples/phonegap.php'),
    'php' => include(__DIR__ . '/samples/php.php'),
    'python' => include(__DIR__ . '/samples/python.php'),
    'react' => include(__DIR__ . '/samples/react-native.php'),
    'ruby' => include(__DIR__ . '/samples/ruby.php'),
    'swift' => include(__DIR__ . '/samples/swift.php'),
    'cli' => include(__DIR__ . '/samples/cli.php'),
];

$copy = [
    'Authentication' => 'If you haven\'t signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.',
    'SMS' => [
        'Overview' => 'Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.',
        'Calls' => [
            'Sending' => 'Send an SMS message to one or more mobile terminals:',
            'Binary' => 'Send binary data through SMS:',
        ]
    ],
    'Voice' => [
        'Overview' => 'The Globe APIs has a detailed list of voice features you can use with your application.',
        'Calls' => [
            'Ask' => 'You can take advantage of Globe\'s automated Ask protocols to help service your customers without manual intervention for common questions in example.',
            'Answer' => 'Combining the Ask and Answer features of Globe Voice, it\'s possible to create an automated dialog.',
            'Ask Answer' => 'A better sample of the Ask and Answer dialog would look like the following.',
            'Call' => 'You can connect your app to also call a customer to initiate the Ask and Answer features.',
            'Conference' => 'It\'s also possible through your application, to automatically start a conference call between two(2) or more people across all networks. This feature optionally allows you to play music and incorporate the Answer feature.',
            'Event' => 'Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.',
            'Hangup' => 'Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. ',
            'Record' => 'It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.',
            'Reject' => 'To filter incoming calls automatically, you can use the following example below. ',
            'Routing' => 'To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.',
            'Say' => 'The message you pass to `say` will be transformed to an automated voice.',
            'Transfer' => 'The following sample explains the dialog needed to transfer the receiver to another phone number.',
            'Transfer Whisper' => '',
            'Wait' => 'To put a receiver on hold, you can use the following sample.'
        ]
    ],
    'USSD' => [
        'Overview' => 'USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.',
        'Calls' => [
            'Sending' => 'The following example shows how to send a USSD request.',
            'Replying' => 'The following example shows how to send a USSD reply.'
        ]
    ],
    'Payment' => [
        'Overview' => 'Your application can monetize services from customer\'s phone load by sending a payment request to the customer, in which they can opt to accept.',
        'Calls' => [
            'Requests' => 'The following example shows how you can request for a payment from a customer.',
            'Last Reference' => 'The following example shows how you can get the last reference of payment.',
        ]
    ],
    'Amax' => 'Amax is an automated promo builder you can use with your app to award customers with certain globe perks.',
    'Location' => 'To determine a general area (lat,lng) of your customers you can utilize this feature.',
    'Subscriber' => [
        'Overview' => '',
        'Calls' => [
            'Balance' => 'The following example shows how you can get the subscriber balance.',
            'Reload' => 'The following example shows how you can get the subscriber reload amount.',
        ]
    ],
];

return [
    'Android' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['android']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['android']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['android']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['android']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['android']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['android']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['android']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['android']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['android']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['android']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['android']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'iOS 10' => [
        'Setting Up' => '',
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['ios']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['ios']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['ios']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['ios']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['ios']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['ios']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['ios']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['ios']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['ios']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['ios']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'React Native' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['react']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['react']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['react']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['react']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['react']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['react']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['react']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['react']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['react']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['react']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['react']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'PhoneGap' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['phonegap']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['phonegap']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['phonegap']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['phonegap']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['phonegap']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['phonegap']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['phonegap']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['phonegap']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['phonegap']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['phonegap']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['phonegap']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'CLI' => [
        'Setting Up' => '',
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['cli']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['cli']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['cli']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['cli']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['cli']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['cli']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['cli']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'PHP' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['php']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['php']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['php']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['php']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['php']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['php']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['php']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['php']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['php']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['php']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['php']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['php']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['php']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['php']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['php']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['php']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['php']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['php']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['php']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['php']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['php']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['php']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['php']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['php']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['php']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'Python' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['python']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['python']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['python']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['python']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['python']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['python']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['python']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['python']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['python']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['python']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['python']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['python']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['python']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['python']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['python']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['python']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['python']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['python']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['python']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['python']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['python']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['python']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['python']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['python']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['python']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'Ruby' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['ruby']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['ruby']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['ruby']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['ruby']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['ruby']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['ruby']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['ruby']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['ruby']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['ruby']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['ruby']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['ruby']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['ruby']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['ruby']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['ruby']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['ruby']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['ruby']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['ruby']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['ruby']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['ruby']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['ruby']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['ruby']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['ruby']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['ruby']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['ruby']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['ruby']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'NodeJS' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['nodejs']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['nodejs']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['nodejs']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['nodejs']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['nodejs']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['nodejs']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['nodejs']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['nodejs']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['nodejs']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['nodejs']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['nodejs']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['nodejs']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['nodejs']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['nodejs']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['nodejs']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['nodejs']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['nodejs']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['nodejs']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['nodejs']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['nodejs']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['nodejs']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['nodejs']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['nodejs']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['nodejs']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['nodejs']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'Java' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['java']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['java']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['java']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['java']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['java']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['java']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['java']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['java']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['java']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['java']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['java']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['java']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['java']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['java']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['java']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['java']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['java']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['java']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['java']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['java']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['java']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['java']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['java']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['java']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['java']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
    'C Sharp' => [
        'Setting Up' => '',
        'Authentication' => [
            'Overview' => $copy['Authentication'],
            'Code' => $samples['csharp']['Authentication'],
            'Results' => ''
        ],
        'SMS' => [
            'Overview' => $copy['SMS']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['SMS']['Calls']['Sending'],
                    'Code' => $samples['csharp']['SMS Send'],
                    'Results' => ''
                ],
                'Binary' => [
                    'Overview' => $copy['SMS']['Calls']['Binary'],
                    'Code' => $samples['csharp']['SMS Binary'],
                    'Results' => ''
                ],
            ]
        ],
        'Voice' => [
            'Overview' => $copy['Voice']['Overview'],
            'Calls' => [
                'Ask' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['csharp']['Voice Ask'],
                    'Results' => ''
                ],
                'Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['csharp']['Voice Answer'],
                    'Results' => ''
                ],
                'Ask Answer' => [
                    'Overview' => $copy['Voice']['Calls']['Ask Answer'],
                    'Code' => $samples['csharp']['Voice Ask-Answer'],
                    'Results' => ''
                ],
                'Call' => [
                    'Overview' => $copy['Voice']['Calls']['Call'],
                    'Code' => $samples['csharp']['Voice Call'],
                    'Results' => ''
                ],
                'Conference' => [
                    'Overview' => $copy['Voice']['Calls']['Ask'],
                    'Code' => $samples['csharp']['Voice Conference'],
                    'Results' => ''
                ],
                'Event' => [
                    'Overview' => $copy['Voice']['Calls']['Event'],
                    'Code' => $samples['csharp']['Voice Event'],
                    'Results' => ''
                ],
                'Hangup' => [
                    'Overview' => $copy['Voice']['Calls']['Hangup'],
                    'Code' => $samples['csharp']['Voice Hangup'],
                    'Results' => ''
                ],
                'Record' => [
                    'Overview' => $copy['Voice']['Calls']['Record'],
                    'Code' => $samples['csharp']['Voice Record'],
                    'Results' => ''
                ],
                'Reject' => [
                    'Overview' => $copy['Voice']['Calls']['Reject'],
                    'Code' => $samples['csharp']['Voice Reject'],
                    'Results' => ''
                ],
                'Routing' => [
                    'Overview' => $copy['Voice']['Calls']['Routing'],
                    'Code' => $samples['csharp']['Voice Routing'],
                    'Results' => ''
                ],
                'Say' => [
                    'Overview' => $copy['Voice']['Calls']['Say'],
                    'Code' => $samples['csharp']['Voice Say'],
                    'Results' => ''
                ],
                'Transfer' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer'],
                    'Code' => $samples['csharp']['Voice Transfer'],
                    'Results' => ''
                ],
                'Transfer Whisper' => [
                    'Overview' => $copy['Voice']['Calls']['Transfer Whisper'],
                    'Code' => $samples['csharp']['Voice Transfer Whisper'],
                    'Results' => ''
                ],
                'Wait' => [
                    'Overview' => $copy['Voice']['Calls']['Wait'],
                    'Code' => $samples['csharp']['Voice Wait'],
                    'Results' => ''
                ]
            ]
        ],
        'USSD' => [
            'Overview' => $copy['USSD']['Overview'],
            'Calls' => [
                'Sending' => [
                    'Overview' => $copy['USSD']['Calls']['Sending'],
                    'Code' => $samples['csharp']['USSD Send'],
                    'Results' => ''
                ],
                'Replying' => [
                    'Overview' => $copy['USSD']['Calls']['Replying'],
                    'Code' => $samples['csharp']['USSD Reply'],
                    'Results' => ''
                ]
            ]
        ],
        'Payment' => [
            'Overview' => $copy['Payment']['Overview'],
            'Calls' => [
                'Requests' => [
                    'Overview' => $copy['Payment']['Calls']['Requests'],
                    'Code' => $samples['csharp']['Payment Send'],
                    'Results' => ''
                ],
                'Last Reference' => [
                    'Overview' => $copy['Payment']['Calls']['Last Reference'],
                    'Code' => $samples['csharp']['Payment Reference'],
                    'Results' => ''
                ],
            ]
        ],
        'Amax' => [
            'Overview' => $copy['Amax'],
            'Code' => $samples['csharp']['Amax'],
            'Results' => ''
        ],
        'Location' => [
            'Overview' => $copy['Location'],
            'Code' => $samples['csharp']['Location'],
            'Results' => ''
        ],
        'Subscriber' => [
            'Overview' => $copy['Subscriber']['Overview'],
            'Calls' => [
                'Balance' => [
                    'Overview' => $copy['Subscriber']['Calls']['Balance'],
                    'Code' => $samples['csharp']['Subscriber Balance'],
                    'Results' => ''
                ],
                'Reload' => [
                    'Overview' => $copy['Subscriber']['Calls']['Reload'],
                    'Code' => $samples['csharp']['Subscriber Reload'],
                    'Results' => ''
                ],
            ]
        ],
    ],
];
