
## Android

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```java

import ph.com.globe.connect.Authentication;

String appId = "5ozgSgeRyeHzacXo55TR65HnqoAESbAz";
String appSecret = "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e";

Authentication auth = new Authentication(appId, appSecret);

String dialogUrl = auth.getDialogUrl();

EditText out = (EditText) findViewById(R.id.output);
out.setText(dialogUrl);

try {
    auth.getAccessToken("G4HBMexKfaM9E7SG4LpkHRBoLGf9Go6qSnBno8HRKXnes7doqEukgq4bCq59nKfR7KX6Uorknysa8EXyHoxEaRhzGo57tLn4gduLkaE7S9ke9RtpBjgauaeRKpu4RcoX6y4cRaxuGzjkKuyzedXtkra8qSbe47LueyonxtgoEorhpkEoaHLkkResXyKR4U4K996f4EqB7CRLoKGuBjXorsAxnrpH9poqrSAEo6ef7XLGXHyK9R9SLregxfaM6XxH",
    new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        System.out.println(json.toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(HttpResponseException e) {
}

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```java

import ph.com.globe.connect.Sms;

Sms sms = new Sms("21584130", "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

try {
    sms
        .setClientCorrelator("12345")
        .setReceiverAddress("+639065272450")
        .setMessage("Hello World")
        .sendMessage(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());
                    EditText out = (EditText) findViewById(R.id.output);
                    out.setText(json.toString(5));
                } catch(JSONException e) {
                    e.printStackTrace();
                }
            }
        });

} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```java

import ph.com.globe.connect.BinarySms;

BinarySms sms = new BinarySms("21584130", "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

try {
    sms
        .setUserDataHeader("0605040B8423")
        .setDataCodingScheme(1)
        .setReceiverAddress("9065272450")
        .setBinaryMessage("02056A0045C60C037777772E6465762E6D6F62692F69735F66756E2E68746D6C0")
        .sendBinaryMessage(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());
                    EditText out = (EditText) findViewById(R.id.output);
                    out.setText(json.toString(5));
                } catch(JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```java

import ph.com.globe.connect.Ussd;

try {
    Ussd ussd = new Ussd("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    ussd
            .setSenderAddress("21584130")
            .setUssdMessage("Simple USSD Message\n1: Hello \n2: Hello")
            .setAddress("9065272450")
            .setFlash(false)
            .sendUssdRequest(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```java

import ph.com.globe.connect.Ussd;

Ussd ussd = new Ussd("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

ussd
        .setSessionId("12345")
        .setAddress("9065272450")
        .setSenderAddress("21584130")
        .setUssdMessage("Simple USSD Message\n1: Foo\n2: Foo")
        .setFlash(false)
        .replyUssdRequest(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());
                    EditText out = (EditText) findViewById(R.id.output);
                    out.append(json.toString(5));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```java

import ph.com.globe.connect.Payment;

try {
    Payment payment = new Payment("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    payment
            .setAmount(0.00)
            .setDescription("My Description")
            .setEndUserId("9065272450")
            .setReferenceCode("41301000221")
            .setTransactionOperationStatus("Charged")
            .sendPaymentRequest(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```java

import ph.com.globe.connect.Payment;

try {
    Payment payment = new Payment("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    payment
            .setAppId("5ozgSgeRyeHzacXo55TR65HnqoAESbAz")
            .setAppSecret("3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e")
            .getLastReferenceCode(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.append(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```java

import ph.com.globe.connect.Amax;

String appId = "5ozgSgeRyeHzacXo55TR65HnqoAESbAz";
String appSecret = "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e";

Amax amax = new Amax(appId, appSecret);

try {
    amax
            .setRewardsToken("w7hYKxrE7ooHqXNBQkP9lg")
            .setAddress("9065272450")
            .setPromo("FREE10MB")
            .sendRewardRequest(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(HttpResponseException e) {
}

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```java

Location location = new Location("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

try {
    location
            .setAddress("9065272450")
            .setRequestedAccuracy(10)
            .getLocation(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```java

import ph.com.globe.connect.Subscriber;

try {
    Subscriber subscriber = new Subscriber("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    subscriber
            .setAddress("639065272450")
            .getSubscriberBalance(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.setText(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });

    Subscriber subscriber2 = new Subscriber("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    subscriber2
            .setAddress("639065272450")
            .getSubscriberReloadAmount(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.append(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```java

import ph.com.globelabs.Subscriber;

try {
    Subscriber subscriber = new Subscriber("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

    subscriber
            .setAddress("639065272450")
            .getSubscriberReloadAmount(new AsyncHandler() {
                @Override
                public void response(HttpResponse response) throws HttpResponseException {
                    try {
                        JSONObject json = new JSONObject(response.getJsonResponse().toString());
                        EditText out = (EditText) findViewById(R.id.output);
                        out.append(json.toString(5));
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            });
} catch(ApiException e) {
} catch(HttpResponseException e) {
}

```

##### Sample Results

TODO

## iOS 10

### Setting Up

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "21584130",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

connect.sendMessage(
    address: "+639271223448",
    message: "Lorem ipsum",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "21584130",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.sendBinaryMessage(
    address: "09271223448",
    message: "Lorem ipsum",
    header: "06050423F423F4",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "21584130",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.sendUssdRequest(
    address: "639271223448",
    message: "Simple USSD Message\nOption - 1\nOption - 2",
    flash: false,
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    shortCode: "21584130",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.replyUssdRequest(
    address: "639271223448",
    message: "Simple USSD Message\nOption - 1\nOption - 2",
    sessionId: "012345678912",
    flash: false,
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "5ozgSgeRyeHzacXo55TR65HnqoAESbAz",
    appSecret: "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.sendPaymentRequest(
    amount: 0.00,
    description: "My Application",
    endUserId: "9271223448",
    referenceCode: "41301000112",
    transactionOperationStatus: "Charged",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "5ozgSgeRyeHzacXo55TR65HnqoAESbAz",
    appSecret: "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e",
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.getLastReferenceCode(
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    appId: "5ozgSgeRyeHzacXo55TR65HnqoAESbAz",
    appSecret: "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e"
)

globeConnect.sendRewardRequest(
    address: "9271223448",
    promo: "FREE10MB",
    rewardsToken: "w7hYKxrE7ooHqXNBQkP9lg",
    success : { json in
        dump(json)
    },
    failure: { error in
        print(error)
    }
)

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.getLocation(
    address: "092XXXXXXXX",
    success : { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.getSubscriberBalance(
    address: "639271223448",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```swift

import GlobeConnect

let globeConnect = GlobeConnect(
    accessToken: "kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA"
)

globeConnect.getSubscriberReloadAmount(
    address: "639271223448",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })

```

##### Sample Results

TODO

## React Native

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var auth = GlobeConnect.Authentication(
    '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
    '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e');

auth.getDialogUrl(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

var code = 'M8s6gAarub9pebhgEAqKsxdByxHoM5kzf4Mp5js98Bzot8bqjrfaRdG4H4jknpFzr8gKtdx4jnUqbA8KsxqA48frR698IKLRb5S5LBxauo9EkxCMrzk6uorxGEu67Tay49aTxxzu8ozznukMEaXCBRB8GuKjR5MSpB65zIbkA8Bf5eA94se848KUb589RteGkdEFBEddEH6xqRyfjMBqatE4ppBsAe56Bfq4BkjHrXA9Rsqzp5RhMAA6Mu65MAds';

auth.getAccessToken(code, function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var sms = GlobeConnect.Sms(
    '21584130',
    'JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc'
);

sms
    .setClientCorrelator('12345')
    .setReceiverAddress('+639065272450')
    .setMessage('Hello World');

sms.sendMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var binary = GlobeConnect.BinarySms(
    '21584130',
    'kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA'
);

binary
    .setUserDataHeader('06050423F423F4')
    .setDataCodingScheme(1)
    .setReceiverAddress('9271223448')
    .setBinaryMessage('02056A0045C60C037777772E6465762E6D6F62692F69735F66756E2E68746D6C0');

binary.sendBinaryMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var ussd = GlobeConnect.Ussd('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

ussd
    .setSenderAddress('21584130')
    .setUssdMessage('Simple USSD Message\n1: Hello \n2: Hello')
    .setAddress('9065272450')
    .setFlash(false)
    .sendUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var ussd = GlobeConnect.Ussd('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

ussd
    .setSessionId('12345')
    .setAddress('9065272450')
    .setSenderAddress('21584130')
    .setUssdMessage('Simple USSD Message\n1: Foo\n2: Foo')
    .setFlash(false)
    .replyUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var payment = GlobeConnect.Payment('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

payment
    .setAppId('5ozgSgeRyeHzacXo55TR65HnqoAESbAz')
    .setAppSecret('3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
    .setAmount(0.00)
    .setDescription('My Description')
    .setEndUserId('9065272450')
    .setReferenceCode('41301000301')
    .setTransactionOperationStatus('Charged')
    .sendPaymentRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var payment = GlobeConnect.Payment('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

payment
    .setAppId('5ozgSgeRyeHzacXo55TR65HnqoAESbAz')
    .setAppSecret('3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
    .getLastReferenceCode(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var amax = GlobeConnect.Amax(
    '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
    '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e'
);

amax
    .setAddress('9065272450')
    .setRewardsToken('w7hYKxrE7ooHqXNBQkP9lg')
    .setPromo('FREE10MB');

amax.sendRewardRequest(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var location = GlobeConnect.Location('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

location
    .setAddress('09065272450')
    .setRequestedAccuracy(10);

location.getLocation(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

subscriber
    .setAddress('639065272450')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js

import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

subscriber
    .setAddress('639065272450')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

## PhoneGap

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js

var auth = globeconnect.Authentication(
    '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
    '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e');

auth.getDialogUrl(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

var code = 'M8s6gAarub9pebhgEAqKsxdByxHoM5kzf4Mp5js98Bzot8bqjrfaRdG4H4jknpFzr8gKtdx4jnUqbA8KsxqA48frR698IKLRb5S5LBxauo9EkxCMrzk6uorxGEu67Tay49aTxxzu8ozznukMEaXCBRB8GuKjR5MSpB65zIbkA8Bf5eA94se848KUb589RteGkdEFBEddEH6xqRyfjMBqatE4ppBsAe56Bfq4BkjHrXA9Rsqzp5RhMAA6Mu65MAds';

auth.getAccessToken(code, function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```js

var sms = globeconnect.Sms(
    '21584130',
    'JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc'
);

sms
    .setClientCorrelator('12345')
    .setReceiverAddress('+639065272450')
    .setMessage('Hello World');

sms.sendMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js

var binary = globeconnect.BinarySms(
    '21584130',
    'kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA'
);

binary
    .setUserDataHeader('06050423F423F4')
    .setDataCodingScheme(1)
    .setReceiverAddress('9271223448')
    .setBinaryMessage('02056A0045C60C037777772E6465762E6D6F62692F69735F66756E2E68746D6C0');

binary.sendBinaryMessage(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js

var ussd = globeconnect.Ussd('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

ussd
    .setSenderAddress('21584130')
    .setUssdMessage('Simple USSD Message\n1: Hello \n2: Hello')
    .setAddress('9065272450')
    .setFlash(false)
    .sendUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js

var ussd = globeconnect.Ussd('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

ussd
    .setSessionId('12345')
    .setAddress('9065272450')
    .setSenderAddress('21584130')
    .setUssdMessage('Simple USSD Message\n1: Foo\n2: Foo')
    .setFlash(false)
    .replyUssdRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js

var payment = globeconnect.Payment('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

payment
    .setAppId('5ozgSgeRyeHzacXo55TR65HnqoAESbAz')
    .setAppSecret('3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
    .setAmount(0.00)
    .setDescription('My Description')
    .setEndUserId('9065272450')
    .setReferenceCode('41301000301')
    .setTransactionOperationStatus('Charged')
    .sendPaymentRequest(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js

var payment = globeconnect.Payment('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

payment
    .setAppId('5ozgSgeRyeHzacXo55TR65HnqoAESbAz')
    .setAppSecret('3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
    .getLastReferenceCode(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js

var amax = globeconnect.Amax(
    '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
    '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e'
);

amax
    .setAddress('9065272450')
    .setRewardsToken('w7hYKxrE7ooHqXNBQkP9lg')
    .setPromo('FREE10MB');

amax.sendRewardRequest(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js

var location = globeconnect.Location('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

location
    .setAddress('09065272450')
    .setRequestedAccuracy(10);

location.getLocation(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js

var subscriber = globeconnect.Subscriber('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

subscriber
    .setAddress('639065272450')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js

var subscriber = globeconnect.Subscriber('JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc');

subscriber
    .setAddress('639065272450')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });

```

##### Sample Results

TODO

## CLI

### Setting Up

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```bash

globe-connect sms -a 9065272450 -m "Hello World" -s 21584130 -c 12345 -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc"

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```bash

globe-connect binarysms -c "21584130" -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc" -u "12345" -d 1 -a "9065272450" -m "samplebinarymessage" --verbose

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```bash

globe-connect payment -a 0.00 -d "description" -e 9065272450 -r 41301000206 -s Charged -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc" --verbose

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```bash

globe-connect get-last-reference -ai "5ozgSgeRyeHzacXo55TR65HnqoAESbAz" -as "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e" --verbose

```

##### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```bash

globe-connect location -a 9065272450 -c 10 -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc" --verbose

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```bash

globe-connect subscr-bal -a 9065272450 -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc" --verbose

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```bash

globe-connect subscr-reload-amt -a 9065272450 -t "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc" --verbose

```

##### Sample Results

TODO

## PHP

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```php

use Globe\Connect\Oauth;

$oauth = new Oauth('[key]', '[secret]');

// get redirect url
echo $oauth->getRedirectUrl();

// get access token
$oauth->setCode('[code]');
echo $oauth->getAccessToken();

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```php

use Globe\Connect\Sms;

$sms = new Sms('[sender]', '[token]');

$sms->setReceiverAddress('[address]');
$sms->setMessage('[message]');
$sms->setClientCorrelator('[correlator]');
echo $sms->sendMessage();

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```php


use Globe\Connect\Sms;

$sms = new Sms('[sender]', '[token]');
$sms->setReceiverAddress('[address]');
$sms->setUserDataHeader('[header]');
$sms->setDataEncodingScheme('[scheme]');
$sms->setMessage('[message]');
echo $sms->sendBinaryMessage();

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web Api');
$choices = $voice->choices('[5 DIGITS]');
$askSay = $voice->say("Please enter yout 5 digit zip code.");

$ask = $voice->ask($askSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on('continue')
    ->setNext('http://somefakehost.com:8000/')
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);

```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say('Welcome to my Tropo Web Api.');
echo $voice->addSay($say);

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web API');

$voice->addSay($say);

if($url == '/ask') {
    $choices = $voice->choices('[5 DIGITS]');
    $askSay = $voice->say("Please enter yout 5 digit zip code.");

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setAttempts(3)
        ->setBargein(false)
        ->setName('foo')
        ->setRequired(true)
        ->setTimeout(10);

    $on = $voice->on('continue')
        ->setNext('/answer')
        ->setRequired(true);

    $voice->addSay($say)
        ->addAsk($ask)
        ->addOn($on);
} elseif($url == '/answer') {
    $result = $voice->result($data)
        ->getObject();

    $interprertation = $result['actions']['ineterpretation'];
    $say = $voice->say('Your zip is ' . $interpretation . ', thank you!');

    $voice->addSay($say);
}

echo $voice;

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();
$call = $voice->call('9065263453')
    ->setFrom('sip:21584130@sip.tropo.net');

$say = $voice->say('Hello World');

echo $voice->addCall($call)
    ->addSay($say);

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say('Welcome to my Tropo Web API Conference Call.');

$jPrompt = $voice->joinPrompt('http://openovate.com/hold-music.mp3');
$lPrompt = $voice->leavePrompt('http://openovate.com/hold-music.mp3');

$conference = $voice->conference('12345')
    ->setMute(false)
    ->setName('foo')
    ->setPlayTones(true)
    ->setTerminator('#')
    ->setJoinPrompt($jPrompt)
    ->setLeavePrompt($lPrompt);

echo $voice->addSay($say)
    ->addConference($conference);

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$e1 = $voice->say('Sorry, I did not hear anything.')
    ->setEvent('timeout');

$e2 = $voice->say('Sorry, that was not a valid option.')
    ->setEvent('nomatch:1');

$e3 = $voice->say('Nope, still not a valid response.')
    ->setEvent('nomatch:2');

$say = $voice->say('Welcome to my Tropo Web API');
$eventSay = $voice->say('Please enter your 5 digit zip code.')
    ->setEvent(array($e1, $e2, $e3));

$choices = $voice->choices('[5 DIGITS]');
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on('continue')
    ->setNext('/answer')
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);


```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web Api, Thank you');
echo $say->addSay($say)
    ->addHangup('');

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```php

require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web API.');
$sayTimeout = $voice->say('Sorry, I did not here anything. Please call back.')
    ->setEvent('timeout');

$say2 = $voice->say('Please leave a message')
    ->setEvent(array($sayTimeout));

$choices = $voice->choices()
    ->setTerminator('#');

$transcription = $voice->transcription('1234')
    ->setUrl('mailto:charles.andacc@gmail.com');

$record = $voice->record('foo', 'http://openovate.com/globe.php')
    ->setFormat('wav')
    ->setAttempts(3)
    ->setBargein(false)
    ->setMethod('POST')
    ->setRequired(true)
    ->setSay($say2)
    ->setChoices($choices)
    ->setTranscription($transcription);

echo $voice->addSay($say)
    ->addRecord($record);

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();

echo $voice->addreject('');

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();

if($url == '/routing') {
    $say = $voice->say('Welcome to my Tropo Web API.');
    $on = $voice->on('continue')
        ->setNext('/routing1');

    $voice->addSay($say)
        ->addOn($on);
} else if($url == '/routing1') {
    $say = $voice->say('Hello from resource one.');
    $on = $voice->on('continue')
        ->setNext('/routing2');

    $voice->addSay($say)
        ->addOn($on);
} else if($url == '/routing2') {
    $say = $voice->say('Hello from resource two! Thank you.');
    $voice->addSay($say);
}

echo $voice;

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();
$say = $voice->say('Welcome to my Tropo web API');
$say2 = $voice->say('I will play an audio file for you, please wait.');
$say3 = $voice->say('http://openovate.com/tropo-rocks.mp3');

echo $voice->addSay($say)
    ->addSay($say2)
    ->addSay($say3);

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();

$say = $voice->say('Welcome to my Tropo Web API, you are now being transfered.');

$e1 = $voice->say('Sorry I did not hear anything')
    ->setEvent('timeout');

$e2 = $voice->say('Sorry, that was an invalid option')
    ->setEvent('nomatch:1');

$eventSay = $voice->say('Please enter your 5 digit zip code')
    ->setEvent(array($e1, $e2));

$choices = $voice->choices('[5 DIGITS]');
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(5);

$ringSay = $voice->say('http://openovate.com/hold-music.mp3');
$onRing = $voice->on('ring')
    ->setSay($ringSay);

$onConnect = $voice->on('connect')
    ->setAsk($ask);

$on = array($onRing, $onConnect);
$transfer = $voice->transfer('9053801178')
    ->setRingRepeat(2)
    ->setOn($on);

echo $voice->addSay($say)
    ->addTransfer($transfer);

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();

if($url == '/whisper') {
    $say = $voice->say('Welcome to my Tropo Web API');
    $askSay = $voice->say('Press 1 to continue this call or any other to reject');
    $choices = $voice->choices('1')
        ->setMode('DTMF');

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setName('color')
        ->setTimeout(60);

    $onConnect1 = $voice->on('connect')
        ->setAsk($ask);

    $sayCon2 = $voice->say('You are now being connected');
    $onConnect2 = $voice->on('connect')
        ->setSay($sayCon2);

    $sayRing = $voice->say('http://openovate.com/hold-music.mp3');
    $onRing = $voice->on('ring')
        ->setSay($say);

    $on = array($onRing, $onConnect1, $onConnect2);
    $transfer = $voice->transfer('9054799241')
        ->setName('foo')
        ->setOn($on)
        ->setRequired(true)
        ->terminator('*')

    $incompleteSay = $voice->say('Your are now being disconnected');
    $onIncomplete = $voice->on('incomplete')
        ->setNext('/whisperIncomplete')
        ->setSay($incompleteSay);

    echo $voice->addSay($say)
        ->addTransfer($transfer)
        ->addOn($onIncomplete);
} else if($url == '/whisperIncomplete') {
    echo $voice->addHangup('');
}

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```php

require(__dir__ . '/../tests/autoload.php');

use globe\api\voice;

$voice = new voice();
$say = $voice->say('Welcome to my Tropo Web API.');
$wait = $voice->wait(5000)
    ->setAllowSignals(true);

$say2 = $voice->say('Thank you for waiting.');

echo $voice->addSay($say)
    ->addWait($wait)
    ->addSay($say2);

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```php

use Globe\Connect\Ussd;

$ussd = new Ussd('[token]', '[shortcode]');

// send ussd request
$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');

print $ussd->sendUssdRequest();


```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```php

use Globe\Connect\Ussd;

$ussd = new Ussd('[token]', '[shortcode]');

$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');
$ussd->setSessionId('[session_id]');

print $ussd->replyUssdRequest();


```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```php

use Globe\Connect\Payment;

$payment = new Payment('[token]');

// payment request
$payment->setEndUserId('[user_id]');
$payment->setAmount('[amount]');
$payment->setDescription('[description]');
$payment->setReferenceCode('[reference_code]');
$payment->setTransactionOperationStatus('[status]');
print $payment->sendPaymentRequest();

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```php

use Globe\Connect\Payment;

// get last reference code request
$payment->setAppKey('[key]');
$payment->setAppSecret('[secret]');
print $payment->getLastReferenceCode();

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```php

use Globe\Connect\Amax;

$amax = new Amax('[app_id]', '[app_secret]');
$amax->setToken('[token]');
$amax->setAddress('[address]');
$amax->setPromo('[promo]');
echo $amax->sendReward();

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```php

use Globe\Connect\Location;

$loc = new Location('[token]');
$loc->setAddress('[address]');
$loc->setRequestedAccuracy('[accuracy]');
echo $loc->getLocation();

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```php

use Globe\Connect\Subscriber;

$subscriber = new Subscriber('[token]');
$subscriber->setAddress('[address]');
print $subscriber->getSubscriberBalance();

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```php


use Globe\Connect\Subscriber;

$subscriber = new Subscriber('[token]');
$subscriber->setAddress('[address]');
print $subscriber->getReloadAmount();


```

##### Sample Results

TODO

## Python

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```python

from globe.connect import oauth
oauth = oauth.Oauth("[key]", "[secret]")

# get redirect url
print oauth.getRedirectUrl()

# get access token
print oauth.getAccessToken("[code]")

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```python

from globe.connect import sms
sms = sms.Sms("[shortcode]","[token]")
sms.setReceiverAddress("[receiver_address]")
sms.setMessage("[message]")
sms.setClientCorrelator("[correlator]")
print sms.getResponse()

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```python

from globe.connect import sms
sms = sms.setUserDataHeader("[header]")
sms.setDataEncodingScheme("[encoding]")
sms.setReceiverAddress("[address]")
sms.setMessage("[msg]")
sms.sendBinaryMessage()
print sms.getResponse()

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API")
choices = voice.choices("[5 DIGITS]")
askSay = voice.say("Please enter your 5 digit zip code.")

ask = voice.ask(askSay)
ask.setChoices(choices)
ask.setAttempts(3)
ask.setBargein(false)
ask.setName("foo")
ask.setRequired(true)
ask.setTimeount(10)

on = voice.on("continue")
on.setNext("http://somfakehost.com:8080/")
on.setRequired(true)

voice.addSay(askSay)
voice.addAsk(ask)
voice.addOn(on)
print voice.getObject()


```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()
say = voice.say('Welcome to my Tropo Web API')

print voice.addSay(say).getObject())

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API.")

if url == "/ask":
    choices = voice.choices("[5 DIGITS]")
    askSay = voice.say("Please enter your 5 digit zip code.")

    ask = voice.ask(askSay)
    ask.setChoices(choices)
    ask.setAttempts(3)
    ask.setBargein(false)
    ask.setName("foo")
    ask.setRequired(true)
    ask.setTimeout(10)

    on = voice.on("continue")
    on.setNext("/answer")
    on.setRequired(true)

    voice.addSay(say)
    voice.addAsk(ask)
    voice.addOn(on)

    obj = voice.getObject()
elif url == '/answer':
    result = voice.result(data).getObject()
    interpretation = result.actions.interpretation

    say = ("Your zip is %s, thank you!" % (interpretation))
    say = voice.say(say)
    voice.setSay(say)

    obj = voice.getObject()

print obj

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Hello World")

call = voice.call("9065263453")
call.setFrom("sip:21584130@sip.tropo.net")

voice.addCall(call)
voice.addSay(say)

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API Conference Call.")

jPrompt = voice.joinPrompt("http://openovate.com/hold-music.mp3")
lPrompt = voice.leavePrompt("http://openovate.com/hold-music.mp3")

conference = voice.conference("12345")
conference.setMute(false)
conference.setName("foo")
conference.setPlayTones(true)
conference.setTerminator("#")
conference.setJoinPrompt(jPrompt)
conference.setLeavePrompt(lPrompt)

voice.addSay(say)
voice.addConference(conference)

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

e1 = voice.say("sorry, I did not hear anything.")
e1.setEvent("timeout")

e2 = voice.say("sorry, that was not a valid option.")
e2.setEvent("nomatch:1")

e3 = voice.say("Nope, still not a valid response.")
e3.setEvent("nomatch:3")

say = voice.say("Welcome to my tropo web API.")
eSay = voice.say("Please enter your 5 digit zip code.")
eSay.event([e1, e2, e3]);

choices = voice.choices("[5 DIGITS]")
ask = voice.ask(eSay)
ask.setChoices(choices)
ask.setAttempts(3)
ask.setBargein(false)
ask.setName("foo")
ask.setRequired(true)
ask.setTimeout(10)

on = voice.on("continue")
on.setNext("/answer")
on.setRequired(true)

voice.addSay(say)
voice.addAsk(ask)
voice.addOn(on)

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API, thank you")
voice.addSay(say)
voice.addHangup()

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API.")
e1 = voice.say("Sorry, I did not hear anything. Please call back.")
e1.setEvent("timeout")

say2 = voice.say("Please leave a message")
say2.setEvent([e1])

choices = voice.choices()
choices.setTerminator("#")

transcription = voice.transcription("1234")
transcription.setUrl("mailto:charles.andacc@gmail.com")

record = voice.record("foo", "http://openovate.com/globe.php")
record.setFormat("wav")
record.setAttempts(3)
record.setBargein(false)
record.setMethod("POST")
record.setRequired(true)
record.setSay(say2)
record.setChoices(choices)
record.setTranscription(transcription)

voice.addSay(say)
voice.addRecord(record)

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

voice.addReject()
print voice.getObject()

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

if url == "/routing":
    say = voice.say("Welcome to my Tropo Web API.")

    on = voice.on("continue")
    on.setNext("/routing1")

    voice.addSay(say)
    voice.addOn(on)
elif url == "/routing1":
    say = voice.say("Hello from resource one.")

    on = voice.on("continue")
    on.setNext("/routing2")

    voice.addSay(say)
    voice.on(on)
elif(url == "/routing2":
    say = voice.say("Hello from resource two! Thank you.")
    voice.addSay(say)


print voice.getObject()

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API.")
say2 = voice.say("I will play an audio file for you, please wait.")
say3 = voice.say("http://openovate.com/tropo-rocks.mp3")

voice.addSay(say)
voice.addSay(say2)
voice.addSay(say3)

print voice.getObject()

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API, you are now being transfered.")

e1 = voice.say("Sorry, I did not hear anything")
e1.setEvent("timeout")

e2 = voice.say("Sorry, that was an invalid option.")
e2.setEvent("nomatch:1")

eventSay = voice.say("Please enter your 5 digit zip code.")
eventSay.setEvent([e1, e2])

choices = voice.choices("[5 DIGITS]")

ask = voice.ask(eventSay)
ask.setChoices(choices)
ask.setAttempts(3)
ask.setBargein(false)
ask.setName("foo")
ask.setRequired(true)
ask.setTimeout(10)

ringSay = voice.say("http://openovate.com/hold-music.mp3")

onRing = voice.on("ring")
onRing.setSay(ringSay);

onConnect = voice.on("connect")
onConnect.setSay(ringSay)

on = [onRing, onConnect]

var transfer = voice.transfer("9053801178")
transfer.setRingRepeat(2)
transfer.setOn(on)

voice.addSay(say)
voice.addTransfer(transfer)

print voice.getObject();

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

if url == "/whisper":
    say = voice.say("Welcome to my Tropo Web API")
    askSay = voice.say("Press 1 to continue this call or any other to reject")
    choices = voice.choices("1")
    choices.setMode("DTMF")

    ask = voice.ask(askSay)
    ask.setChoices(choices)
    ask.setName("color")
    ask.setTimeout(60)

    onConnect1 = voice.on("connect")
    onConnect1.setAsk(ask)

    sayCon2 = voice.say("You are now being connected")
    onConnect2 = voice.on("connect")
    onConnect2.setSay(sayCon2)

    sayRing = voice.say("http://openovate.com/hold-music.mp3")
    onRing = voice.on("ring")
    onRing.setSay(say)

    on = [onRing, onConnect1, onConnect2]
    transfer = voice.transfer("9054799241")
    transfer.setName("foo")
    transfer.setOn(on)
    transfer.setRequired(true)
    transfer.terminator("*")

    incompleteSay = voice.say("Your are now being disconnected")
    onIncomplete = voice.on("incomplete")
    onIncomplete.setNext("/whisperIncomplete")
    onIncomplete.setSay(incompleteSay)

    voice.addSay(say)
    voice.addTransfer(transfer)
    voice.addOn(onIncomplete)

    print voice.getObject()
elif url == "/whisperIncomplete":
    voice.addHangup()
    print voice.getObject()

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```python

from globe.connect import voice
voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API.")
wait = voice.wait(5000)
wait.setAllowSignals(true)

say2 = voice.say("Thank you for waiting.")

voice.addSay(say)
voice.addWait(wait)
voice.addSay(say2)

print voice.getObjet()

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```python

from globe.connect import ussd
ussd = ussd.Ussd("[token]", "[shortcode]")
ussd.setAddress("[address]")
ussd.setMessage("[message]")
ussd.setFlash("[flash]")
ussd.sendUsssdRequest()
print ussd.getResponse()

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```python

from globe.connect import ussd
ussd = ussd.Ussd("[token]", "[shortcode]")
ussd.setAddress("[address]")
ussd.setMessage("[message]")
ussd.setFlash("[flash]")
ussd.setSessionId("[session_id]")
ussd.replyUssdRequest()
print ussd.getResponse()

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```python

from globe.connect import payment
payment = payment.Payment("[token]")
payment.setAmount("[amount]")
payment.setDescription("[description]")
payment.setEndUserId("[number]")
payment.setReferenceCode("[referenceCode]")
payment.setTransactionOperationStatus("[status]")
payment.sendPaymentRequest()
print payment.getResponse()

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```python

from globe.connect import payment
payment = payment.Payment("[token]")
payment.setAppKey("[app_key]")
payment.setAppSecret("[app_secret]")
payment.getLastReferenceCode()
print payment.getResponse()

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```python

from globe.connect import amax
amax = amax.Amax("[app_id]", "[app_secret]")
amax.setAddress("[address]")
amax.setToken("[token]")
amax.setPromo("[promo]")
amax.sendReward()
print amax.getResponse()

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```python

from globe.connect import location
loc = location.Location("[token]")
loc.setAddress("[address]")
loc.setRequestedAccuracy("[accuracy]")
loc.getLocation()
print loc.getResponse()

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```python

from globe.connect import subscriber
subscriber = subscriber.Subscriber("[token]")
subscriber.setAddress("[address]")
subscriber.getSubscriberBalance()
print subscriber.getResponse()

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```python

from globe.connect import subscriber
subscriber = subscriber.Subscriber("[token]")
subscriber.setAddress("[address]")
subscriber.getReloadAmount()
print subscriber.getResponse()

```

##### Sample Results

TODO

## Ruby

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```ruby

require 'globe_connect'

authenticate = Authentication.new
url = authenticate.get_access_url('5ozgSgeRyeHzacXo55TR65HnqoAESbAz')

print url

response = authenticate
  .get_access_token(
    '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
    '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e',
    'M8s6gAarub9pebhgEAqKsxdByxHoM5kzf4Mp5js98Bzot8bqjrfaRdG4H4jknpFzr8gKtdx4jnUqbA8KsxqA48frR698IKLRb5S5LBxauo9EkxCMrzk6uorxGEu67Tay49aTxxzu8ozznukMEaXCBRB8GuKjR5MSpB65zIbkA8Bf5eA94se848KUb589RteGkdEFBEddEH6xqRyfjMBqatE4ppBsAe56Bfq4BkjHrXA9Rsqzp5RhMAA6Mu65MAds'
  )

puts response

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```ruby

require 'globe_connect'

sms = Sms.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA', 21584130)
response = sms.send_message('+639271223448', 'Lorem ipsum')

puts response

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```ruby

require 'globe_connect'

binary = Sms.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA', 21584130)
response = binary.send_binary_message('09271223448', 'Lorem ipsum', '06050423F423F4')

puts response

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.");

  say = voice.say("Please enter your 5 digit zip code.", {}, true)
  choices = voice.choices({ :value => "[5 DIGITS]" }, true)

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => "foo",
      :required => true,
      :say => say,
      :timeout => 10
    })

  voice.on({
      :name => "continue",
      :next => "http://somefakehost.com:8000",
      :required => true
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.")
  voice.hangup

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'
require 'json'

get '/ask-test' do
  voice = Voice.new

  say = voice.say("Please enter your 5 digit zip code.", {}, true)
  choices = voice.choices({:value => "[5 DIGITS]"})

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => "foo",
      :required => true,
      :say => say,
      :timeout => 10
    })

  voice.on({
      :name => "continue",
      :next => "http://somefakehost.com:8000",
      :required => true
    })

  content_type :json
  voice.render
end

post '/ask-answer' do
  # get data from post
  payload = JSON.parse(request.body.read)

  voice = Voice.new
  voice.say("Your zip code is " + payload[:result][:actions][:disposition] + ", thank you!")

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.call({
      :to => "9065263453",
      :from => "sip:21584130@sip.tropo.net"
    })

  say = Array.new
  say << voice.say("Hello world", {}, true)
  voice.say(say)

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API Conference Call.");

  voice.conference({
      :id => "12345",
      :mute => false,
      :name => "foo",
      :play_tones => true,
      :terminator => "#",
      :join_prompt => voice.join_prompt({:value => "http://openovate.com/hold-music.mp3"}, true),
      :leave_prompt => voice.join_prompt({:value => "http://openovate.com/hold-music.mp3"}, true),
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.")

  say1 = voice.say("Sorry, I did not hear anything", {:event => "timeout"}, true)

  say2 = voice.say({
      :value => "Sorry, that was not a valid option.",
      :event => "nomatch:1"
    }, {}, true)

  say3 = voice.say({
      :value => "Nope, still not a valid response",
      :event => "nomatch:2"
    }, {}, true)

  say4 = voice.say({
      :value => "Please enter your 5 digit zip code.",
      :array => [say1, say2, say3]
    }, {}, true)

  choices = voice.choices({ :value => "[5 DIGITS]" }, true)

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :required => true,
      :say => say4,
      :timeout => 5
    })

  voice.on({
      :event => "continue",
      :next => "http://somefakehost:8000/",
      :required => true
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API, thank you!")
  voice.hangup

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.");

  timeout = voice.say(
    "Sorry, I did not hear anything. Please call back.",
    { :event => "timeout"},
    true)

  say = voice.say("Please leave a message", {:array => timeout}, true);

  choices = voice.choices({:terminator => "#"}, true)

  transcription = voice.transcription({
      :id => "1234",
      :url => "mailto:address@email.com"
    }, true)

  voice.record({
      :attempts => 3,
      :bargein => false,
      :method => "POST",
      :required => true,
      :say => say,
      :name => "foo",
      :url => "http://openovate.com/globe.php",
      :format => "audio/wav",
      :choices => choices,
      :transcription => transcription
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.reject

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/routing' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.");
  voice.on({
    :event => "continue",
    :next => '/routing-1'
  });

  content_type :json
  voice.render
end

get '/routing-1' do
  voice = Voice.new

  voice.say("Hello from resource one!");
  voice.on({
    :event => "continue",
    :next => '/routing-2'
  });

  content_type :json
  voice.render
end

get '/routing-2' do
  voice = Voice.new

  voice.say("Hello from resource two! thank you.");

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API.");
  voice.say("I will play an audio file for you, please wait.");
  voice.say({
      :value => "http://openovate.com/tropo-rocks.mp3"
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/transfer' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API, you are now being transferred.");

  e1 = voice.say({
    :value => "Sorry, I did not hear anything.",
    :event => "timeout"
  }, {} ,true)

  e2 = voice.say({
    :value => "Sorry, that was not a valid option.",
    :event => "nomatch:1"
  }, {} ,true)

  e3 = voice.say({
    :value => "Nope, still not a valid response",
    :event => "nomatch:2"
  }, {} ,true)

  # TODO: [e1, e2, e3]
  say = voice.say("Please enter your 5 digit zip code", {}, true)

  choices = voice.choices({:value => "[5 DIGITs]"}, true)

  ask = voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => "foo",
      :required => true,
      :say => say,
      :timeout => 5
    }, true)

  ring = voice.on({
      :event => "ring",
      :say => voice.say("http://openovate.com/hold-music.mp3", {} ,true)
    }, true)

  connect = voice.on({
      :event => "connect",
      :ask => ask
    }, true)

  on = voice.on([ring, connect], true)

  voice.transfer({
      :to => "9271223448",
      :ring_repeat => 2,
      :on => on
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API, please hold while you are being transferred.");

  say = voice.say("Press 1 to accept this call or any other number to reject", {}, true);

  choices = voice.choices({
      :value => 1,
      :mode => "dtmf"
    }, true)

  ask = voice.ask({
      :choices => choices,
      :name => "color",
      :say => say,
      :timeout => 60
    }, true)

  connect1 = voice.on({
      :event => "connect",
      :ask => ask
    }, true)

  connect2 = voice.on({
      :event => "connect",
      :say => voice.say("You are now being connected", {}, true)
    }, true)

  ring = voice.on({
      :event => "ring",
      :say => voice.say("http://openovate.com/hold-music.mp3", {}, true)
    }, true)

  connect = voice.on([ring, connect1, connect2], true)

  voice.transfer({
      :to => "9271223448",
      :name => "foo",
      :connect => connect,
      :required => true,
      :terminator => "*"
    })

  voice.on({
      :event => "incomplete",
      :next => "/hangup",
      :say => voice.say("You are now being disconnected", {}, true)
    })

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```ruby

require 'sinatra'
require 'connect_ruby'

get '/wait' do
  voice = Voice.new

  voice.say("Welcome to my Tropo Web API, please wait for a while.")
  voice.wait({
      :wait => 5000,
      :allowSignals => true
    })

  voice.say("Thank you for waiting!")

  content_type :json
  voice.render
end

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```ruby

require 'globe_connect'

ussd = Ussd.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA', 21584130)
response = ussd.send_ussd_request('639271223448', 'Simple USSD Message\nOption - 1\nOption - 2', false)

puts response

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```ruby

require 'globe_connect'

ussd = Ussd.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA', 21584130)
response = ussd.reply_ussd_request('639271223448', 'Simple USSD Message\nOption - 1\nOption - 2', '012345678912', false)

puts response

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```ruby

require 'globe_connect'

payment = Payment.new(
  '5ozgSgeRyeHzacXo55TR65HnqoAESbAz',
  '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e',
  'kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA'
)

response = payment.send_payment_request(0.00, 'My Application', '9271223448', '41301000116', 'Charged')

puts response

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```ruby

require 'globe_connect'

payment = Payment.new('5ozgSgeRyeHzacXo55TR65HnqoAESbAz', '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
response = payment.get_last_reference_code

puts response

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```ruby

require 'globe_connect'

amax = Amax.new('5ozgSgeRyeHzacXo55TR65HnqoAESbAz', '3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e')
response = amax.send_reward_request('9271223448', 'LOAD 50', 'token')

puts response

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```ruby

require 'globe_connect'

location = LocationQuery.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA')
response = location.get_location('09271223448', 10)

puts response

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```ruby

require 'globe_connect'

subscriber = Subscriber.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA')
response = subscriber.get_subscriber_balance('639271223448')

puts response

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```ruby

require 'globe_connect'

subscriber = Subscriber.new('kk_my8_77bTbW48zi4ap6SlE4UuybXq_XAsE79IGwhA')
response = subscriber.get_subscriber_reload_amount('639271223448')

```

##### Sample Results

TODO

## NodeJS

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js

globe = require('globe-connect');

oauth = globe.Oauth('[app_key]', '[app_secret]');

// get redirect url
url = oauth.getRedirectUrl();
console.log(url);

// get access token
oauth.getAccessToken('[code]', function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body)
});

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```js

globe = require('globe-connect');
var sms = globe.Sms('[shortcode]', '[token]');

/* SEND MESSAGE */
sms.setReceiverAddress('[address]');
sms.setMessage('[message]')
sms.sendMessage(function(resCode, body){
    // some code here
    console.log(resCode);
    console.log(body);
});

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js

globe = require('globe-connect');
var sms = globe.Sms('[shortcode]', '[token]');

sms.setUserDataHeader('06050423F423F4');
sms.setDataEncodingScheme(1)
sms.setReceiverAddress('+639065272450')
sms.setMessage('samplebinarymessage')
sms.sendBinaryMessage(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
})

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API');
var choices = voice.choices('[5 DIGITS]')
var askSay = voice.say('Please enter your 5 digit zip code.')

var ask = voice.ask(askSay);
ask.setChoices(choices);
ask.setAttempts(3);
ask.setBargein(false);
ask.setName('foo');
ask.setRequired(true);
ask.setTimeount(10);

var on = voice.on('continue');
on.setNext('http://somfakehost.com:8080/');
on.setRequired(true);

voice.addSay(askSay);
voice.addAsk(ask);
voice.addOn(on);
var obj = voice.getObject();

console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();
var say = voice.say('Welcome to my Tropo Web API')

console.log(JSON.stringify(voice.addSay(say).getObject()));

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API.');

if(url == '/ask') {
    var choices = voice.choices('[5 DIGITS]');
    var askSay = voice.say('Please enter your 5 digit zip code.');

    var ask = voice.ask(askSay);
    ask.setChoices(choices);
    ask.setAttempts(3);
    ask.setBargein(false);
    ask.setName(foo);
    ask.setRequired(true);
    ask.setTimeout(10);

    var on = voice.on('continue');
    on.setNext('/answer');
    on.setRequired(true);

    voice.addSay(say);
    voice.addAsk(ask);
    voice.addOn(on);

    var obj = voice.getObject();
} else if(url == '/answer') {
    var result = voice.result(data).getObject();
    var interpretation = result.actions.interpretation;

    var say = voice.say('Your zip is ' + interpretation + ', thank you!');
    voice.setSay(say);

    var obj = voice.getObject();
}

console.log(JSON.stringify(obj.getObject()));

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Hello World');

var call = voice.call('9065263453');
call.setFrom('sip:21584130@sip.tropo.net');

voice.addCall(call);
voice.addSay(say);

var obj = voice.getObject();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API Conference Call.');

var jPrompt = voice.joinPrompt('http://openovate.com/hold-music.mp3');
var lPrompt = voice.leavePrompt('http://openovate.com/hold-music.mp3');

var conference = voice.conference('12345');
conference.setMute(false);
conference.setName('foo');
conference.setPlayTones(true);
conference.setTerminator('#');
conference.setJoinPrompt(jPrompt);
conference.setLeavePrompt(lPrompt);

voice.addSay(say);
voice.addConference(conference);

var obj = voice.getObject();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var e1 = voice.say('sorry, I did not hear anything.');
e1.setEvent('timeout');

var e2 = voice.say('sorry, that was not a valid option.');
e2.setEvent('nomatch:1');

var e3 = voice.say('Nope, still not a valid response.');
e3.setEvent('nomatch:3');

var say = voice.say('Welcome to my tropo web API.');
var eSay = voice.say('Please enter your 5 digit zip code.');
eSay.event([e1, e2, e3]);

var choices = voice.choices('[5 DIGITS]');
var ask = voice.ask(eSay);
ask.setChoices(choices);
ask.setAttempts(3);
ask.setBargein(false);
ask.setName('foo');
ask.setRequired(true);
ask.setTimeout(10);

var on = voice.on('continue');
on.setNext('/answer');
on.setRequired(true);

voice.addSay(say);
voice.addAsk(ask);
voice.addOn(on);

var obj = voice.getObject();

console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API, thank you');
voice.addSay(say);
voice.addHangup();

var obj = voice.getObject();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API.');
var e1 = voice.say('Sorry, I did not hear anything. Please call back.');
e1.setEvent('timeout');

var say2 = voice.say('Please leave a message');
say2.setEvent([e1]);

var choices = voice.choices();
choices.setTerminator('#');

var transcription = voice.transcription('1234');
transcription.setUrl('mailto:charles.andacc@gmail.com');

var record = voice.record('foo', 'http://openovate.com/globe.php');
record.setFormat('wav');
record.setAttempts(3);
record.setBargein(false);
record.setMethod('POST');
record.setRequired(true);
record.setSay(say2);
record.setChoices(choices);
record.setTranscription(transcription);

voice.addSay(say);
voice.addRecord(record);

var obj = voice.getObject();
console.log(JSON.stringify(obj))

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

voice.addReject();
var obj = voice.getObject();

console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

if(url == '/routing') {
    var say = voice.say('Welcome to my Tropo Web API.');

    var on = voice.on('continue');
    on.setNext('/routing1');

    voice.addSay(say);
    voice.addOn(on);
} else if(url == '/routing1') {
    var say = voice.say('Hello from resource one.');

    var on = voice.on('continue');
    on.setNext('/routing2');

    voice.addSay(say);
    voice.on(on);
} else if(url == '/routing2') {
    var say = voice.say('Hello from resource two! Thank you.');
    voice.addSay(say);
}

var obj = voice.getObject();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API.');
var say2 = voice.say('I will play an audio file for you, please wait.');
var say3 = voice.say('http://openovate.com/tropo-rocks.mp3');

voice.addSay(say);
voice.addSay(say2);
voice.addSay(say3);

var obj = voice.getObject();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API, you are now being transfered.');

var e1 = voice.say('Sorry, I did not hear anything');
e1.setEvent('timeout');

var e2 = voice.say('Sorry, that was an invalid option.');
e2.setEvent('nomatch:1');

var eventSay = voice.say('Please enter your 5 digit zip code.');
eventSay.setEvent([e1, e2]);

var choices = voice.choices('[5 DIGITS]');

var ask = voice.ask(eventSay);
ask.setChoices(choices);
ask.setAttempts(3);
ask.setBargein(false);
ask.setName('foo');
ask.setRequired(true);
ask.setTimeout(10);

var ringSay = voice.say('http://openovate.com/hold-music.mp3');

var onRing = voice.on('ring');
onRing.setSay(ringSay);

var onConnect = voice.on('connect');
onConnect.setSay(ringSay);

var on = [onRing, onConnect];

var transfer = voice.transfer('9053801178');
transfer.setRingRepeat(2);
transfer.setOn(on);

voice.addSay(say);
voice.addTransfer(transfer);

var obj = voice.getObject();

console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

if(url == '/whisper') {
    var say = voice.say('Welcome to my Tropo Web API');
    var askSay = voice.say('Press 1 to continue this call or any other to reject');
    var choices = voice.choices('1');
    choices.setMode('DTMF');

    var ask = voice.ask(askSay);
    ask.setChoices(choices);
    ask.setName('color');
    ask.setTimeout(60);

    onConnect1 = voice.on('connect');
    onConnect1.setAsk(ask);

    var sayCon2 = voice.say('You are now being connected');
    var onConnect2 = voice.on('connect');
    onConnect2.setSay(sayCon2);

    sayRing = voice.say('http://openovate.com/hold-music.mp3');
    var onRing = voice.on('ring');
    onRing.setSay(say);

    on = [onRing, onConnect1, onConnect2];
    transfer = voice.transfer('9054799241');
    transfer.setName('foo');
    transfer.setOn(on);
    transfer.setRequired(true);
    transfer.terminator('*');

    var incompleteSay = voice.say('Your are now being disconnected');
    var onIncomplete = voice.on('incomplete');
    onIncomplete.setNext('/whisperIncomplete');
    onIncomplete.setSay(incompleteSay);

    voice.addSay(say);
    voice.addTransfer(transfer);
    voice.addOn(onIncomplete);

    var obj = voice.getObject();
    console.log(JSON.stringify(obj));
} else if(url == '/whisperIncomplete') {
    voice.addHangup();
    var obj = voice.getObject();

    console.log(JSON.stringify(obj));
}

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```js

var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API.');
var wait = voice.wait(5000);
wait.setAllowSignals(true);

var say2 = voice.say('Thank you for waiting.');

voice.addSay(say);
voice.addWait(wait);
voice.addSay(say2);

var obj = voice.getObjet();
console.log(JSON.stringify(obj));

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js

globe = require('globe-connect');
ussd = globe.Ussd('[token]', '[shortcode]');

ussd.setAddress('[address]');
ussd.setUssdMessage('[message]');
ussd.setFlash('[flash]');
ussd.sendUssdRequest(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js

globe = require('globe-connect');
ussd = globe.Ussd('[token]', '[shortcode]');

ussd.setAddress('[address]');
ussd.setUssdMessage('[message]');
ussd.setFlash('[flash]');
ussd.setSessionId('[session_id]')
ussd.replyUssdRequest(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js

globe = require('globe-connect');
payment = globe.Payment('[token]');
payment.setAmount('[amount]');
payment.setDescription('[desciption]');
payment.setEndUserId('[number]');
payment.setReferenceCode('[referenceCode]');
payment.setTransactionOperationStatus('[status]');
payment.sendPaymentRequest(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
})

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js


globe = require('globe-connect');
payment = globe.Payment('[token]');
payment.setAppKey('[app_key]');
payment.setAppSecret('[app_secret]');
payment.getLastReferenceCode(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
})

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js

globe = require('globe-connect');
amax = globe.Amax('[app_id]', '[app_secret]');
amax.setToken('[token]');
amax.setAddress('[address]');
amax.setPromo('[promo]');
amax.sendReward(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js

globe = require('globe-connect');
var amax = globe.Location('[token]');
amax.setAddress('[address]');
amax.setRequestedAccuracy('[accuracy]');
amax.getLocation(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js

globe = require('globe-connect');
subscriber = globe.Subscriber('[token]');
subscriber.setAddres('[address]');
subscriber.getSubscriberBalance(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js

globe = require('globe-connect');
subscriber = globe.Subscriber('[token]');
subscriber.setAddres('[address]');
subscriber.getReloadAmount(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});


```

##### Sample Results

TODO

## Java

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```java

import ph.com.globe.connect.Authentication;
import org.json.JSONObject;

String appId = "5ozgSgeRyeHzacXo55TR65HnqoAESbAz";
String appSecret = "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e";

Authentication auth = new Authentication(appId, appSecret);

System.out.println("Get dialog url:");

String dialogUrl = auth.getDialogUrl();

System.out.println(dialogUrl);

System.out.println("Sending Access Token request:");
System.out.println(auth.getAccessUrl());

JSONObject response = auth
    .getAccessToken("G4HBMexKfaM9E7SG4LpkHRBoLGf9Go6qSnBno8HRKXnes7doqEukgq4bCq59nKfR7KX6Uorknysa8EXyHoxEaRhzGo57tLn4gduLkaE7S9ke9RtpBjgauaeRKpu4RcoX6y4cRaxuGzjkKuyzedXtkra8qSbe47LueyonxtgoEorhpkEoaHLkkResXyKR4U4K996f4EqB7CRLoKGuBjXorsAxnrpH9poqrSAEo6ef7XLGXHyK9R9SLregxfaM6XxH")
    .getJsonResponse();

System.out.println("Response -->");
System.out.println("Access Token: " + response.getString("access_token"));
System.out.println("Subscriber Number: " + response.getString("subscriber_number"));

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```java

import ph.com.globe.connect.Sms;
import org.json.JSONObject;

Sms sms = new Sms("21584130", "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Sending SMS: ");

JSONObject response = sms
    .setClientCorrelator("12345")
    .setReceiverAddress("+639065272450")
    .setMessage("Hello World")
    .sendMessage()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```java

import ph.com.globe.connect.BinarySms;
import org.json.JSONObject;

BinarySms sms = new BinarySms("21584130", "JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Sending Binary SMS: ");

JSONObject response = sms
    .setUserDataHeader("0605040B8423")
    .setDataCodingScheme(1)
    .setReceiverAddress("9065272450")
    .setBinaryMessage("02056A0045C60C037777772E6465762E6D6F62692F69735F66756E2E68746D6C0")
    .sendBinaryMessage()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;

import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");

    Say say = new Say("Please enter your 5 digit zip code.");
    Choices choices = new Choices("[5 DIGITS]");

    voice.ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(10)
    );

    voice.on(
        EVENT("continue"),
        NEXT("http://somefakehost.com:8000/"),
        REQUIRED(true)
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");
    voice.hangup();

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```java

import java.io.BufferedReader;
import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;
import ph.com.globe.connect.voice.Result;

import static ph.com.globe.connect.voice.Key.*;

import org.json.JSONObject;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");

    if("/VoiceSample/AskZipTest".equals(request.getRequestURI())) {
        Say say = new Say("Please enter your 5 digit zip code.");
        Choices choices = new Choices("[5 DIGITS]");

        voice.ask(
            INSTANCE(choices),
            ATTEMPTS(3),
            BARGEIN(false),
            NAME("foo"),
            REQUIRED(true),
            INSTANCE(say),
            TIMEOUT(10)
        );

        voice.on(
            EVENT("continue"),
            NEXT("/VoiceSample/AnswerZipTest"),
            REQUIRED(true)
        );
    } else if("/VoiceSample/AnswerZipTest".equals(request.getRequestURI())) {
        StringBuilder builder = new StringBuilder();
        String line = "";

        try {
           BufferedReader reader = request.getReader();

            while ((line = reader.readLine()) != null) {
                builder.append(line);
            }

        } catch (IOException e) { }

        JSONObject json = new JSONObject(builder.toString());

        // parse result as flat data
        JSONObject result = new Result(json).getResult();

        // get interpretation
        String interpretation = (String) result.get("interpretation");

        voice = new Voice();

        voice.say("Your zip code is " + interpretation + ", thank you!");
    }

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Say;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.call(
        TO("9065263453"),
        FROM("sip:21584130@sip.tropo.net")
    );

    voice.say(ARRAY(new Say("Hello World")));

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Conference;
import ph.com.globe.connect.voice.JoinPrompt;
import ph.com.globe.connect.voice.LeavePrompt;
import ph.com.globe.connect.voice.Session;

import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API Conference Call.");

    voice.conference(
        ID("12345"),
        MUTE(false),
        NAME("foo"),
        PLAY_TONES(true),
        TERMINATOR("#"),
        INSTANCE(new JoinPrompt(
            VALUE("http://openovate.com/hold-music.mp3")
        )),
        INSTANCE(new LeavePrompt(
            VALUE("http://openovate.com/hold-music.mp3")
        ))
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;

import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");

    Say e1 = new Say(
        VALUE("Sorry, I did not hear anything."),
        EVENT("timeout")
    );

    Say e2 = new Say(
        VALUE("Sorry, that was not a valid option."),
        EVENT("nomatch:1")
    );

    Say e3 = new Say(
        VALUE("Nope, still not a valid response"),
        EVENT("nomatch:2")
    );

    Say say = new Say(
        VALUE("Please enter your 5 digit zip code."),
        ARRAY(e1, e2, e3)
    );

    Choices choices = new Choices("[5 DIGITS]");

    voice.ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(5)
    );

    voice.on(
        EVENT("continue"),
        NEXT("http://somefakehost:8000/"),
        REQUIRED(true)
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API, thank you!");
    voice.hangup();

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;
import ph.com.globe.connect.voice.Transcription;
import ph.com.globe.connect.voice.enums.*;

import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");

    Say timeout = new Say(
        VALUE("Sorry, I did not hear anything. Please call back."),
        EVENT("timeout")
    );

    Say say = new Say(VALUE("Please leave a message"), ARRAY(timeout));

    Choices choices = new Choices(TERMINATOR("#"));

    Transcription transcription = new Transcription(
        ID("1234"),
        URL("mailto:charles.andacc@gmail.com")
    );

    voice.record(
        ATTEMPTS(3),
        BARGEIN(false),
        METHOD("POST"),
        REQUIRED(true),
        INSTANCE(say),
        NAME("foo"),
        URL("http://openovate.com/globe.php"),
        FORMAT(Format.WAV),
        INSTANCE(choices),
        INSTANCE(transcription)
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.reject();

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    String path = request.getRequestURI();

    Voice voice = new Voice();

    if("/VoiceSample/RoutingTest".equals(path)) {
        voice.say("Welcome to my Tropo Web API.");
        voice.on(
            EVENT("continue"),
            NEXT("/VoiceSample/RoutingTest1")
        );
    } else if("/VoiceSample/RoutingTest1".equals(path)) {
        voice.say("Hello from resource one!");
        voice.on(
            EVENT("continue"),
            NEXT("/VoiceSample/RoutingTest2")
        );
    } else if("/VoiceSample/RoutingTest2".equals(path)) {
        voice.say("Hello from resource two! thank you.");
    }

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API.");
    voice.say("I will play an audio file for you, please wait.");
    voice.say(
        VALUE("http://openovate.com/tropo-rocks.mp3")
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Ask;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;
import ph.com.globe.connect.voice.Transfer;
import ph.com.globe.connect.voice.On;
import ph.com.globe.connect.voice.enums.*;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API, you are now being transferred.");

    Say e1 = new Say(
        VALUE("Sorry, I did not hear anything."),
        EVENT("timeout")
    );

    Say e2 = new Say(
        VALUE("Sorry, that was not a valid option."),
        EVENT("nomatch:1")
    );

    Say e3 = new Say(
        VALUE("Nope, still not a valid response"),
        EVENT("nomatch:2")
    );

    Say say = new Say(
        VALUE("Please enter your 5 digit zip code."),
        ARRAY(e1, e2, e3)
    );

    Choices choices = new Choices("[5 DIGITS]");

    Ask ask = new Ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(5)
    );

    On ring = new On(
        EVENT("ring"),
        INSTANCE(new Say("http://openovate.com/hold-music.mp3"))
    );

    On connect = new On(
       EVENT("connect"),
       INSTANCE(ask)
    );

    On on = new On(ARRAY(ring, connect));

    voice.transfer(
        TO("9053801178"),
        RING_REPEAT(2),
        INSTANCE(on)
    );

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import ph.com.globe.connect.voice.Ask;
import ph.com.globe.connect.voice.Choices;
import ph.com.globe.connect.voice.Say;
import ph.com.globe.connect.voice.Transfer;
import ph.com.globe.connect.voice.On;
import ph.com.globe.connect.voice.enums.*;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    if("/VoiceSample/TransferWhisperTest".equals(request.getRequestURI())) {
        voice.say("Welcome to my Tropo Web API, please hold while you are being transferred.");

        Say say = new Say("Press 1 to accept this call or any other number to reject");

        Choices choices = new Choices(
            VALUE("1"),
            MODE(Mode.DTMF)
        );

        Ask ask = new Ask(
            INSTANCE(choices),
            NAME("color"),
            INSTANCE(say),
            TIMEOUT(60)
        );

        On connect1 = new On(
            EVENT("connect"),
            INSTANCE(ask)
        );

        On connect2 = new On(
            EVENT("connect"),
            INSTANCE(new Say("You are now being connected."))
        );

        On ring = new On(
            EVENT("ring"),
            INSTANCE(new Say("http://openovate.com/hold-music.mp3"))
        );

        On connect = new On(ARRAY(ring, connect1, connect2));

        voice.transfer(
            TO("9054799241"),
            NAME("foo"),
            INSTANCE(connect),
            REQUIRED(true),
            TERMINATOR("*")
        );

        voice.on(
            EVENT("incomplete"),
            NEXT("/VoiceSample/TransferWhisperHangupTest"),
            INSTANCE(new Say("You are now being disconnected."))
        );
    } else if("/VoiceSample/TransferWhisperHangupTest".equals(request.getRequestURI())) {
        voice.hangup();
    }

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```java

import java.io.IOException;
import java.io.PrintWriter;

import ph.com.globe.connect.Voice;
import static ph.com.globe.connect.voice.Key.*;

...

protected void processRequest(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    response.setContentType("application/json;charset=UTF-8");

    Voice voice = new Voice();

    voice.say("Welcome to my Tropo Web API, please wait for a while.");
    voice.wait(MILLISECONDS(5000), ALLOW_SIGNALS(true));
    voice.say("Thank you for waiting!");

    try (PrintWriter out = response.getWriter()) {
        out.println(voice.render());
    }
}

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```java

import ph.com.globe.connect.Ussd;
import org.json.JSONObject;

Ussd ussd = new Ussd("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("USSD Send request: ");

JSONObject response = ussd
    .setSenderAddress("21584130")
    .setUssdMessage("Simple USSD Message\n1: Hello \n2: Hello")
    .setAddress("9065272450")
    .setFlash(false)
    .sendUssdRequest()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```java

import ph.com.globe.connect.Ussd;
import org.json.JSONObject;

Ussd ussd = new Ussd("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("USSD Reply request: ");

JSONObject reply = ussd
    .setSessionId(sessionId)
    .setAddress("9065272450")
    .setSenderAddress("21584130")
    .setUssdMessage("Simple USSD Message\n1: Foo\n2: Foo")
    .setFlash(false)
    .replyUssdRequest()
    .getJsonResponse();

System.out.println(reply.toString());

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```java

import ph.com.globe.connect.Payment;
import org.json.JSONObject;

Payment payment = new Payment("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Sending Payment Request: ");

JSONObject response = payment
    .setAmount(0.00)
    .setDescription("My Description")
    .setEndUserId("9065272450")
    .setReferenceCode("41301000200")
    .setTransactionOperationStatus("Charged")
    .sendPaymentRequest()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```java

import ph.com.globe.connect.Payment;
import org.json.JSONObject;

Payment payment = new Payment("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Get last reference request: ");

JSONObject reference = payment
    .setAppId("5ozgSgeRyeHzacXo55TR65HnqoAESbAz")
    .setAppSecret("3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e")
    .getLastReferenceCode()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(reference.toString());

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```java

import ph.com.globe.connect.Amax;
import org.json.JSONObject;

String appId = "5ozgSgeRyeHzacXo55TR65HnqoAESbAz";
String appSecret = "3dbcd598f268268e13550c87134f8de0ec4ac1100cf0a68a2936d07fc9e2459e";

Amax amax = new Amax(appId, appSecret);

System.out.println("Sending rewards request: ");

JSONObject response = amax
    .setRewardsToken("w7hYKxrE7ooHqXNBQkP9lg")
    .setAddress("9065272450")
    .setPromo("FREE10MB")
    .sendRewardRequest()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response);

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```java

import ph.com.globe.connect.Location;
import org.json.JSONObject;

Location location = new Location("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Getting Subscriber Location: ");

JSONObject response = location
    .setAddress("09065272450")
    .setRequestedAccuracy(10)
    .getLocation()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```java

import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Get subscriber balance request: ");

JSONObject response = subscriber
    .setAddress("639065272450")
    .getSubscriberBalance()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(response.toString());

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```java

import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("JO3SpcC-AFiC461wgOxUPDmsOTc5YiMayoK1GnQcduc");

System.out.println("Get subscriber reload amount request: ");

JSONObject reload = subscriber
    .setAddress("639065272450")
    .getSubscriberReloadAmount()
    .getJsonResponse();

System.out.println("Response: -->");
System.out.println(reload.toString());

```

##### Sample Results

TODO

## C Sharp

### Setting Up

TODO

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```csharp

using Globe.Connect;

Authentication auth = new Authentication(APP_ID, APP_SECRET);

Console.WriteLine("Get dialog url:");
Console.WriteLine(auth.GetDialogUrl());

string code = "G4HBMexKfaM9E7SG4LpkHRBoLGf9Go6qSnBno8HRKXnes7doqEukgq4bCq59nKfR7KX6Uorknysa8EXyHoxEaRhzGo57tLn4gduLkaE7S9ke9RtpBjgauaeRKpu4RcoX6y4cRaxuGzjkKuyzedXtkra8qSbe47LueyonxtgoEorhpkEoaHLkkResXyKR4U4K996f4EqB7CRLoKGuBjXorsAxnrpH9poqrSAEo6ef7XLGXHyK9R9SLregxfaM6XxH";

Console.WriteLine("Get access token:");
Console.WriteLine(auth.GetAccessToken(code).GetDynamicResponse());

```

#### Sample Results

TODO

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```csharp

using Globe.Connect;

Sms sms = new Sms(SHORT_CODE, ACCESS_TOKEN);

Console.WriteLine("Sending SMS:");

dynamic response = sms
    .SetReceiverAddress("+639065272450")
    .SetMessage("Hello World from C#")
    .SendMessage()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

##### Sample Results

TODO

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```csharp

using Globe.Connect;

BinarySms sms = new BinarySms(SHORT_CODE, ACCESS_TOKEN);

Console.WriteLine("Sending Binary SMS:");

dynamic response = sms
    .SetReceiverAddress("9065272450")
    .SetUserDataHeader("06050423F423F4")
    .SetDataCodingScheme(2)
    .SetBinaryMessage("samplebinarymessage")
    .SendBinaryMessage()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

##### Sample Results

TODO

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");

    Say say = new Say("Please enter your 5 digit zip code.");
    Choices choices = new Choices("[5 DIGITS]");

    voice.Ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(10)
    );

    voice.On(
        EVENT("continue"),
        NEXT("http://somefakehost.com:8000/"),
        REQUIRED(true)
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```csharp

using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");
    voice.Hangup();

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

using Newtonsoft.Json.Linq;

...

public ActionResult Ask()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");

    Say say = new Say("Please enter your 5 digit zip code.");
    Choices choices = new Choices("[5 DIGITS]");

    voice.Ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(10)
    );

    voice.On(
        EVENT("continue"),
        NEXT("/askanswer/answer"),
        REQUIRED(true)
    );

    return Content(voice.Render().ToString(), "application/json");
}

public ActionResult Answer()
{
    Voice voice = new Voice();

    String data = new System.IO.StreamReader(Request.InputStream).ReadToEnd();
    JObject result = new Result(JObject.Parse(data)).GetResult();

    voice.Say("Your zip code is " + result.GetValue("interpretation") + ", thank you!");

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Call(
        TO("9065272450"),
        FROM("sip:21584130@sip.tropo.net")
    );

    voice.Say(ARRAY(new Say("Hello World")));

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API Conference Call.");

    voice.Conference(
        ID("12345"),
        MUTE(false),
        NAME("foo"),
        PLAY_TONES(true),
        TERMINATOR("#"),
        INSTANCE(new JoinPrompt(
            VALUE("http://openovate.com/hold-music.mp3")
        )),
        INSTANCE(new LeavePrompt(
            VALUE("http://openovate.com/hold-music.mp3")
        ))
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");

    Say e1 = new Say(
        VALUE("Sorry, I did not hear anything."),
        EVENT("timeout")
    );

    Say e2 = new Say(
        VALUE("Sorry, that was not a valid option."),
        EVENT("nomatch:1")
    );

    Say e3 = new Say(
        VALUE("Nope, still not a valid response"),
        EVENT("nomatch:2")
    );

    Say say = new Say(
        VALUE("Please enter your 5 digit zip code."),
        ARRAY(e1, e2, e3)
    );

    Choices choices = new Choices("[5 DIGITS]");

    voice.Ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(5)
    );

    voice.On(
        EVENT("continue"),
        NEXT("http://somefakehost:8000/"),
        REQUIRED(true)
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```csharp

using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API, thank you!");
    voice.Hangup();

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using Globe.Connect.Voice.Enums;
using static Globe.Connect.Voice.Actions.Key;

using VoiceBase = Globe.Connect.Voice.Voice;

...

public ActionResult Index()
{
    VoiceBase voice = new VoiceBase();

    voice.Say("Welcome to my Tropo Web API.");

    Say timeout = new Say(
        VALUE("Sorry, I did not hear anything. Please call back."),
        EVENT("timeout")
    );

    Say say = new Say(VALUE("Please leave a message"), ARRAY(timeout));

    Choices choices = new Choices(TERMINATOR("#"));

    Transcription transcription = new Transcription(
        ID("1234"),
        URL("mailto:charles.andacc@gmail.com")
    );

    voice.Record(
        ATTEMPTS(3),
        BARGEIN(false),
        METHOD("POST"),
        REQUIRED(true),
        INSTANCE(say),
        NAME("foo"),
        URL("http://openovate.com/globe.php"),
        FORMAT(Format.WAV),
        INSTANCE(choices),
        INSTANCE(transcription)
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```csharp

using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Reject();

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");
    voice.On(
        EVENT("continue"),
        NEXT("/routing/route1")
    );

    return Content(voice.Render().ToString(), "application/json");
}

public ActionResult Route1()
{
    Voice voice = new Voice();

    voice.Say("Hello from resource one!");
    voice.On(
        EVENT("continue"),
        NEXT("/routing/route2")
    );

    return Content(voice.Render().ToString(), "application/json");
}

public ActionResult Route2()
{
    Voice voice = new Voice();

    voice.Say("Hello from resource two! thank you.");

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");
    voice.Say("I will play an audio file for you, please wait.");
    voice.Say(
        VALUE("http://openovate.com/tropo-rocks.mp3")
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API, you are now being transferred.");

    Say e1 = new Say(
        VALUE("Sorry, I did not hear anything."),
        EVENT("timeout")
    );

    Say e2 = new Say(
        VALUE("Sorry, that was not a valid option."),
        EVENT("nomatch:1")
    );

    Say e3 = new Say(
        VALUE("Nope, still not a valid response"),
        EVENT("nomatch:2")
    );

    Say say = new Say(
        VALUE("Please enter your 5 digit zip code."),
        ARRAY(e1, e2, e3)
    );

    Choices choices = new Choices("[5 DIGITS]");

    Ask ask = new Ask(
        INSTANCE(choices),
        ATTEMPTS(3),
        BARGEIN(false),
        NAME("foo"),
        REQUIRED(true),
        INSTANCE(say),
        TIMEOUT(5)
    );

    On ring = new On(
        EVENT("ring"),
        INSTANCE(new Say("http://openovate.com/hold-music.mp3"))
    );

    On connect = new On(
       EVENT("connect"),
       INSTANCE(ask)
    );

    On on = new On(ARRAY(ring, connect));

    voice.Transfer(
        TO("9053801178"),
        RING_REPEAT(2),
        INSTANCE(on)
    );

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Transfer Whisper

TODO

##### Sample Code

```csharp

using Globe.Connect.Voice;
using Globe.Connect.Voice.Actions;
using Globe.Connect.Voice.Enums;
using static Globe.Connect.Voice.Actions.Key;

using VoiceBase = Globe.Connect.Voice.Voice;

...

public ActionResult Index()
{
    VoiceBase voice = new VoiceBase();

    voice.Say("Welcome to my Tropo Web API, please hold while you are being transferred.");

    Say say = new Say("Press 1 to accept this call or any other number to reject");

    Choices choices = new Choices(
        VALUE("1"),
        MODE(Mode.DTMF)
    );

    Ask ask = new Ask(
        INSTANCE(choices),
        NAME("color"),
        INSTANCE(say),
        TIMEOUT(60)
    );

    On connect1 = new On(
        EVENT("connect"),
        INSTANCE(ask)
    );

    On connect2 = new On(
        EVENT("connect"),
        INSTANCE(new Say("You are now being connected."))
    );

    On ring = new On(
        EVENT("ring"),
        INSTANCE(new Say("http://openovate.com/hold-music.mp3"))
    );

    On connect = new On(ARRAY(ring, connect1, connect2));

    voice.Transfer(
        TO("9054799241"),
        NAME("foo"),
        INSTANCE(connect),
        REQUIRED(true),
        TERMINATOR("*")
    );

    voice.On(
        EVENT("incomplete"),
        NEXT("/transferwhisper/hangup"),
        INSTANCE(new Say("You are now being disconnected."))
    );

    return Content(voice.Render().ToString(), "application/json");
}

public ActionResult Hangup()
{
    VoiceBase voice = new VoiceBase();

    voice.Hangup();

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```csharp

using Globe.Connect.Voice;
using static Globe.Connect.Voice.Actions.Key;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API, please wait for a while.");
    voice.Wait(MILLISECONDS(5000), ALLOW_SIGNALS(true));
    voice.Say("Thank you for waiting!");

    return Content(voice.Render().ToString(), "application/json");
}

```

##### Sample Results

TODO

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```csharp

using Globe.Connect;

Ussd ussd = new Ussd(ACCESS_TOKEN);

Console.WriteLine("Send ussd request:");

dynamic response = ussd
    .SetAddress("9065272450")
    .SetSenderAddress(SHORT_CODE)
    .SetUssdMessage("Simple USSD \n1: Hello \n2: Hello")
    .SetFlash(false)
    .SendUssdRequest()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");

Console.WriteLine(response);

```

##### Sample Results

TODO

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```csharp

using Globe.Connect;

Ussd ussd = new Ussd(ACCESS_TOKEN);

Console.WriteLine("Reply ussd request:");

try {
    response = ussd
        .SetAddress("9065272450")
        .SetSessionId(sessionId)
        .SetSenderAddress(SHORT_CODE)
        .SetUssdMessage("Simple USSD \n1: Foo \n1: Foo")
        .SetFlash(false)
        .ReplyUssdRequest()
        .GetDynamicResponse();

    Console.WriteLine("Response: -->");
    Console.WriteLine(response);

} catch(WebException e) {
    Console.WriteLine(new System.IO.StreamReader(e.Response.GetResponseStream()).ReadToEnd());
}

```

##### Sample Results

TODO

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```csharp

using Globe.Connect;

Payment payment = new Payment(APP_ID, APP_SECRET, ACCESS_TOKEN);

Console.WriteLine("Sending payment request:");

dynamic response = payment
    .SetAmount(0.00)
    .SetDescription("my description")
    .SetEndUserId("9065272450")
    .SetReferenceCode("41301000202")
    .SetTransactionOperationStatus("Charged")
    .SendPaymentRequest()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

##### Sample Results

TODO

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```csharp

using Globe.Connect;

Payment payment = new Payment(APP_ID, APP_SECRET, ACCESS_TOKEN);

Console.WriteLine("Get last reference code request:");

response = payment
    .GetLastReferenceCode()
    .GetDynamicResponse();

Console.WriteLine("Response: --> ");
Console.WriteLine(response);

```

##### Sample Results

TODO

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```csharp

using Globe.Connect;

Amax amax = new Amax(APP_ID, APP_SECRET);

Console.WriteLine("Send reward request:");

try {
    dynamic response = amax
        .SetAddress("9065272450")
        .SetRewardsToken("token")
        .SetPromo("LOAD 50")
        .SendRewardRequest()
        .GetDynamicResponse();

    Console.WriteLine("Response: -->");
    Console.WriteLine(response);
} catch(WebException e) {
    Console.WriteLine(new System.IO.StreamReader(e.Response.GetResponseStream()).ReadToEnd());
}

```

#### Sample Results

TODO

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```csharp

using Globe.Connect;

Location location = new Location(ACCESS_TOKEN);

Console.WriteLine("Get Location request:");

dynamic response = location
    .SetAddress("+639065272450")
    .SetRequestedAccuracy(10)
    .GetLocation();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

#### Sample Results

TODO

### Subscriber

#### Overview

TODO

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```csharp

using Globe.Connect;

Subscriber subscriber = new Subscriber(ACCESS_TOKEN);

Console.WriteLine("Get subscriber balance request:");

dynamic response = subscriber
    .SetAddress("+639065272450")
    .GetSubscriberBalance()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

##### Sample Results

TODO

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```csharp

using Globe.Connect;

Subscriber subscriber = new Subscriber(ACCESS_TOKEN);

Console.WriteLine("Get subscriber reload amount request:");

response = subscriber
    .SetAddress("+9065272450")
    .GetSubscriberReloadAmount()
    .GetDynamicResponse();

Console.WriteLine("Response: -->");
Console.WriteLine(response);

```

##### Sample Results

TODO
