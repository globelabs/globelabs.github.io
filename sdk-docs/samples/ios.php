<?php

$samples = array (

'Amax' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "[app_id]",
    appSecret: "[app_secret]"
)

globeConnect.sendRewardRequest(
    address: "[subscriber_number]",
    promo: "[promo]",
    rewardsToken: "[rewards_token]",
    success : { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)
',

'Authentication' => '
//
//  sample implementation of login using the ViewController.swift file
//

import UIKit
import GlobeConnectIOS

class ViewController: UIViewController {

    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    @IBAction func loginViaGlobe(_ sender: Any) {
        let authenticate = Authenticate()

        authenticate.login(
            viewController: self,
            appId: "[app_id]",
            appSecret: "[app_secret]",
            success: { results in
                // access token will returned here
                print(results)
            },
            failure: { error in
                print(error)
            }
        )
    }
}

//
// Add the following code at the bottom of your AppDelegate.swift file.
// Make sure that a URL scheme is set for this to work.
//

func application(_ app: UIApplication, open url: URL, options: [UIApplicationOpenURLOptionsKey : Any]) -> Bool {
    if let sourceApplication = options[UIApplicationOpenURLOptionsKey.sourceApplication] {

        if (String(describing: sourceApplication) == "com.apple.SafariViewService") {
            let authenticate = Authenticate()
            authenticate.listenForRequest(url: url)
            return true
        }
    }

    return true
}
',

'Location' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "[access_token]"
)

globeConnect.getLocation(
    address: "[subscriber_number]",
    success : { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'Payment Send' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "[app_id]",
    appSecret: "[app_secret]",
    accessToken: "[access_token]"
)

globeConnect.sendPaymentRequest(
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
import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "[app_id]",
    appSecret: "[app_secret]",
    accessToken: "[access_token]"
)

globeConnect.getLastReferenceCode(
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'SMS Send' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "[short_code]",
    accessToken: "[access_token]"
)

connect.sendMessage(
    address: "[subscriber_number]",
    message: "[message]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)
',

'SMS Binary' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "[short_code]",
    accessToken: "[access_token]"
)

globeConnect.sendBinaryMessage(
    address: "[subscriber_number]",
    message: "[message]",
    header: "[data_header]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)
',

'Subscriber Balance' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "[access_token]"
)

globeConnect.getSubscriberBalance(
    address: "[subscriber_number]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'Subscriber Reload' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "[access_token]"
)

globeConnect.getSubscriberReloadAmount(
    address: "[subscriber_number]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
',

'USSD Send' => '
import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "[short_code]",
    accessToken: "[access_token]"
)

globeConnect.sendUssdRequest(
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
import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "[short_code]",
    accessToken: "[access_token]"
)

globeConnect.replyUssdRequest(
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
