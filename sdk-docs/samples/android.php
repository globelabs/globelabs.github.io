<?php
$samples = array (

'Amax' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Amax amax = new Amax([app_id], [app_secret]);

try {
    amax
        .setRewardsToken("[rewards_token]")
        .setAddress("[subscriber_number]")
        .setPromo("[promo]")
        .sendRewardRequest(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'Authentication' => '
Please go to `https://github.com/globelabs/globe-connect-android/blob/master/instructions/authentication-flow.md`
for more detailed explanation on how to do the android sdk authentication flow process.
',

'Location' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Location location = new Location("[access_token]");

try {
    location
        .setAddress("[subscriber_number]")
        .setRequestedAccuracy([accuracy])
        .getLocation(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'Payment Send' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Payment payment = new Payment("[access_token]");

try {
    payment
        .setAmount([amount])
        .setDescription("[description]")
        .setEndUserId("[subscriber_number]")
        .setReferenceCode("[reference]")
        .setTransactionOperationStatus("[status]")
        .sendPaymentRequest(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'Payment Reference' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Payment payment = new Payment("[access_token]");

try {
    payment
        .setAppId("[app_id]")
        .setAppSecret("[app_secret]")
        .getLastReferenceCode(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'SMS Send' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Sms sms = new Sms("[short_code]", "[access_token]");

try {
    sms
        .setClientCorrelator("[client_correlator]")
        .setReceiverAddress("[receiver_address]")
        .setMessage("[message]")
        .sendMessage(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch(JSONException e) {
                    e.printStackTrace();
                }
            }
        });

} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'SMS Binary' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

BinarySms sms = new BinarySms("[short_code]", "[access_token]");

try {
    sms
        .setUserDataHeader("[data_header]")
        .setDataCodingScheme([coding_scheme])
        .setReceiverAddress("[receiver_address]")
        .setBinaryMessage("[message]")
        .sendBinaryMessage(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch(JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'Subscriber Balance' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Subscriber subscriber = new Subscriber("[access_token]");

try {
    subscriber
        .setAddress("[subscriber_number]")
        .getSubscriberBalance(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'Subscriber Reload' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Subscriber subscriber = new Subscriber("[access_token]");

try {
    subscriber
        .setAddress("[subscriber_number]")
        .getSubscriberReloadAmount(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'USSD Send' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Ussd ussd = new Ussd("[access_token]");

try {
    ussd
        .setSenderAddress("[short_code]")
        .setUssdMessage("[message]")
        .setAddress("[subscriber_number]")
        .setFlash([flash])
        .sendUssdRequest(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
',

'USSD Reply' => '
import ph.com.globe.connect.*;
import org.json.JSONObject;
import org.json.JSONException;

Ussd ussd = new Ussd("[access_token]");

try {
    ussd
        .setSessionId("[session_id]")
        .setAddress("[subscriber_number]")
        .setSenderAddress("[short_code]")
        .setUssdMessage("[message]")
        .setFlash([flash])
        .replyUssdRequest(new AsyncHandler() {
            @Override
            public void response(HttpResponse response) throws HttpResponseException {
                try {
                    JSONObject json = new JSONObject(response.getJsonResponse().toString());

                    System.out.println(json.toString());
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        });
} catch(ApiException | HttpRequestException | HttpResponseException e) {
    e.printStackTrace();
}
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
