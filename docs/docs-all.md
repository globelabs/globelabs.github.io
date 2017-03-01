Getting Started
========================

**Subscriber Consent Workflow**

Access Tokens are required in order to transact (SMS, Voice or Charging API) with a subscriber.
To get the access token, the subscribers need to grant the developer app in either two ways:

- via SMS
- via Web Form (OAuth 2.0)

### Create An App

After successful registration and login, create an app at http://www.globelabs.com.ph/apps/new or by clicking the **Create App** button.  

In order to create an app, user must fill out a minimum of required fields which are the following:

- Name - Application name, this will be included in the 'welcome message' sent to the subcriber.

- Short Description -  A short description that will also be included in the 'welcome message' sent to the subscriber.

- Email Support - Valid Email address for contact that will also be included in the 'welcome message' sent to the subscriber.

- Category - Select a category for this app.

- Redirect URI - This link will receive the **Code** parameter if via web form, or **Access Token** if via SMS.

  **Code** parameter: required to get your subscriber's Access Token. This is sent to your Redirect URI, and **access it via GET**.

  **Access Token**: required to use the API.

  **Note**: The Redirect URI must be on a domain or on a web server, for example; **http://www.example.com/your_code.php** .


- API Type - Upon selection of the API type, there are certain API's that may require new fields:

  **SMS**

  - Notify URI - Everytime your short code receives a message; this link will receive the data in JSON format.

  **Voice**

  - Voice URI - Either in Scripting or WEB API; this contains your code/commands to be accessed.

After creation, your app will have its own **Short Code**.

### Opt-in via SMS

1.  Subscribers need to text **INFO** to your **Short Code**.

    **Short Code** provided to your app after creation, see your app's details.

2.  Upon receipt of the **‘welcome message’**, the subscriber needs to reply **YES**.

    **Welcome Message** - welcome message mentioned in the Create App Section.

3.  After the subscriber replies (Yes), the **Access Token** and the **Subscriber’s mobile number** will be posted (POST) to your **Redirect URI**, you can get these parameters via GET method.

###### Sample POST to Redirect URI

```javascript
{
  "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
  "subscriber_number":"9171234567"
}
```

### Opt-in via Webform

1.  Platform redirects your subscribers to this url:
    - https://developer.globelabs.com.ph/dialog/oauth?app_id=APP_ID_HERE

2.  The page will ask to key-in the subscriber’s mobile number and subscriber clicks the Grant button.

3.  The page will be redirected, and an SMS with confirmation code will be sent to the subscriber.

4.  The subscriber needs to key-in on the page the received confirmation code and click the button Confirm to authorize the subscriber.

5.  The page will then be redirected to the redirect uri of the application, and a **Code** parameter will be passed to it.

6.  To get the access token, you need to do a POST request via https://developer.globelabs.com.ph/oauth/access_token with your ‘**app_id**’, ‘**app_secret**’ and ‘**code**’ as the parameters. The parameters ‘**access_token**’ and ‘**subscriber_number**’ will then be returned to your **Redirect URI** as a response.

###### Sample POST to Redirect URI

```javascript
{
  "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
  "subscriber_number":"9171234567"
}
```

### Stop Subscription

If ever a subscriber chooses to opt-out or unsubscribe to your application. They will need to text in STOP to your shortcode ('STOPSVC' for cross-telco). After stopping the subscription, a json data will be passed to your redirect_uri informing you that a subscriber had just unsubscribed to your service.

json format:

```javascript
{
   "unsubscribed":{
          "subscriber_number":"9171234567",
          "access_token":"abcdefghijklmnopqrstuvwxyz",
          "time_stamp": "2014-10-19T12:00:00"
   }
}
```

SMS
========================

**Overview**

Short Message Service (SMS) enables your application or service to send and
receive secure, targeted text messages and alerts to your Globe / TM and other telco subscribers.

Note: All API calls must include the access_token as one of the
Universal Resource Identifier (URI) parameters.

### Resources and URIs

A RESTful API utilises HTTP commands POST, GET, PUT, and DELETE in order to
perform an operation on a resource at the server. This resource is addressed by a URI;
and what is returned by the server is a representation of that resource depending on its current state.

HTTP POST and GET commonly used  in our services. The URIs of the resources are:


### Sending SMS (SMS-MT)

Send an SMS message to one or more mobile terminals:

(Mobile Terminating - Application to Subscriber)

Use <span class="method">POST</span> method on this URI:
```
https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}
```

###### Representation Formats

For the Globe Labs API SMS (beta), it is implemented
using application/json.

###### Resource Parameters

| Parameter | Usage |
| ----------|-------|
| _string_ **senderAddress** refers to the application short code suffix (last 4 digits) | Required |
| _string_ **access_token** which contains security information for transacting with a subscriber. Subscriber needs to grant an app first via SMS or Web Form Subscriber Consent Workflow. | Required |

###### Request Body or Payload Parameters

| Parameter        | Usage |
| -----------------|-------|
| _string_ **address** is the subscriber MSISDN (mobile number), including the ‘tel:’ identifier. Parameter format can include the ‘+’ followed by country code  +639xxxxxxxxx or 09xxxxxxxxx | Required |
| _string_ **message** must be provided within the ```outboundSMSTextMessage``` element. Currently, the API implementation is limited a maximum of 160 characters. Also make sure that your language or framework's editor is encoding the HTTP parameters as UTF-8 | Required |
| _string_ **clientCorrelator** uniquely identifies this create SMS request. If there is a communication failure during the request, using the same clientCorrelator when retrying the request allows the operator to avoid sending the same SMS twice. | Optional |

###### Sample POST Request

```
curl -X POST
"https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/1234/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g" -H "Content-Type: application/json" -d
{"outboundSMSMessageRequest": {
   "clientCorrelator": "123456",
   "senderAddress": "1234",
   "outboundSMSTextMessage": {"message": "Hello World"},
   "address": "9171234567"
 }
}
```

###### Sample Successful POST Response

```javascript
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
```

###### Response Parameters


| Parameter 			 | Usage    |
| -----------------------|----------|
| **outboundSMSResponse** Specifies the body of the response. | Required |
| **address** Subscriber MSISDN (mobile number) whom the SMS was sent to. | |
| **senderAddress** Refers to the application short code suffix (last 4 digits). | |
| **outboundSMSTextMessage** The string message sent to the subscriber’s number (address). | |
| **resourceURL** Specifies the URI that provides network delivery status of the sent message. The API Endpoint. | Required |
| **notifyURL** App call back URL defined at the App Info. | Optional |

__Note:__ Response parameters deliveryInfo, callbackData, senderName are optional parameters that are not currently supported by the Globe Labs SMS (beta) API.


### Receiving SMS (SMS-MO)

In receiving SMS, globe will send a data(POST) to your Notify URL (that you provided when you created your app) when the subscriber sends an SMS or replied to your short code number.

(Mobile Originating - Subscriber to Application)


```javascript
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

In your Notify URL, create a script that will catch and save these data to a file or to the database.

###Binary SMS

Binary Short Messaging interface allows an application to send any generic binary object attachments to the network using SMS.

Use <span class="method">POST</span> method on this URI:
```
https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}
```
#### Parameters

Parameter | Description | Required
----------|-------------|----------
`userDataHeader` | UDH of the message | true
`dataCodingScheme` | data coding of the message | true
`address` | MSISDN of the recipient | true
`outboundBinaryMessage.message` | message to be sent | true
`senderAddress` | shortcode of the app | true
`access_token` | access token of the subscriber | true

Data Coding Value | Description
------------------|------------
0                 | SMSC Default
1                 | IA5/ASCII
3                 | Latin 1 (ISO-8859-1)
4                 | Binary (8-bit)
8                 | UCS2 (Unicode)

```json
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
  "resourceURL": "https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}",
  }
}
```

###Multi-Part SMS

**Sending Multi-Part SMS**

You can send multi-part sms like you would in sending a normal sms, just keep in mind that you will be charged per 160 characters.


###### Sample POST Request

```
curl -X POST
"https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/1234/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g" -H "Content-Type: application/json" -d
{"outboundSMSMessageRequest": {
   "clientCorrelator": "123456",
   "senderAddress": "1234",
   "outboundSMSTextMessage": {"message": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis commodo posuere dui vitae feugiat. Cras vehicula, elit eget commodo tristique, mi magna placerat turpis, quis ultrices massa odio vitae sapien. Proin elit diam, malesuada sit amet blandit id, fermentum eu orci."},
   "address": "9171234567"]
 }
}
```

**Receiving Multi-Part SMS**

There will be additional parameters whenever you receive an sms content exceeding 160 characters, this would be:

Parameter | Description |
----------|-------------|
`multipartRefId` | ID of multi-part message
`multipartSeqNum` | Sequence of multi-part message

sample of expected format of multi-part content below:

```json
{
   "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":"57cd07d61a28d80100a26bc7",
            "message":"AlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrigh",
            "resourceURL":null,
            "senderAddress":"tel:+639171234567",
            "multipartRefId":"5476ddbba4e7d20c527c0f83422bf938",
            "multipartSeqNum":"1"
         }
      ],
      "numberOfMessagesInThisBatch":"2",
      "resourceURL":null,
      "totalNumberOfPendingMessages":0
   }
}

{
   "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":"57cd07dab9d3660100cee8d2",
            "message":"tAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightAlrightu",
            "resourceURL":null,
            "senderAddress":"tel:+639171234567",
            "multipartRefId":"5476ddbba4e7d20c527c0f83422bf938",
            "multipartSeqNum":"2"
         }
      ],
      "numberOfMessagesInThisBatch":"2",
      "resourceURL":null,
      "totalNumberOfPendingMessages":0
   }
}
```

Batch of messages could be identified if they have the same `multipartRefId`.

###SMS API HTTP Response

|Code|Description|
|----|-----------|
|201|Request has been successful|
|400/401|Request failed. Wrong or missing parameters, invalid subscriber_number format, wrong access_token. |
|502/503|Platform Error. API Service is busy or down|

API requests with a response code of 201, 400 or 401 will be chargeable against your developer wallet. Standard SMS API rates apply, unless otherwise stated.


Location Based Services
========================

**Overview**

This API allows a web application to query the location of one or more mobile devices that are connected to a mobile operator network.
The Globe Labs LBS is a RESTful interface.

Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters. This can be requested beforehand via the Subscriber Consent Workflow.

Read more about the Subscriber Consent Workflow (http://goo.gl/EEEBO8) .

###Resources and URIs

A RESTful API utilises HTTP commands GET in order to perform an operation on a resource at the server. This resource is addressed by a URI; and what is returned by the server is a representation of that resource depending on its current state.

HTTP GET commnand is used in these resources below:

### LBS Query

Locate a subscriber’s location:

Use <span class="method">GET</span> method on this URI:
```
https://devapi.globelabs.com.ph/location/v1/queries/location?access_token={access_token}&address={address}&requestedAccuracy={metres}
```

###### Representation Formats

For the Globe Labs API LBS (beta), it is implemented using application/json.

###### Resource Parameters

| Parameter | Usage |
| ----------|-------|
| _string_ **access_token** (string) which contains security information for transacting with a subscriber.This can be requested beforehand via the Subscriber Consent Workflow. Read more about the Subscriber Consent Workflow (http://goo.gl/EEEBO8). | Required |

###### Request Body or Payload Parameters

| Parameter        | Usage |
| -----------------|-------|
| _int_ **address** is the subscriber MSISDN (mobile number), including the ‘tel:’ identifier. Parameter format can include the ‘+’ followed by country code  +639xxxxxxxxx or 09xxxxxxxxx | Required |
| _int_ **requestedAccuracy** The preferred accuracy of the result, in metres. Typically, when you request an accurate location it will take longer to retrieve than a coarse location. So requestedAccuracy=10 will take longer than requestedAccuracy=100 . | Required |

###### Sample GET Request

```
curl "https://devapi.globelabs.com.ph/location/v1/queries/location?access_token=ux5MvYjg7V_9aNljXBewrLVHHo70kOyKF7Vbgupm5IY&address=09171234567&requestedAccuracy=100" -H "Content-Type: application/json"
```

###### Sample Successful POST Response

```javascript
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
201
```

###### Response Parameters


| Parameter        | Usage    |
| -----------------------|----------|
| **terminalLocationList** Specifies the body of the response. |  |
| **address** Subscriber MSISDN (mobile number) whom the SMS was sent to. | |
| **accuracy** The preferred accuracy of the result, in metres. | |
| **outboundSMSTextMessage** The string message sent to the subscriber’s number (address). | |
| **latitude** geographic coordinate of the subscriber that specifies the north-south. | |
| **longitude** geographic coordinate of the subscriber that specifies the north-south. ||
| **timestamp** time of event response. | |
| **locationRetrievalStatus** status of location request. | |


###LBS API HTTP Response

|Code|Description|
|----|-----------|
|201|Request has been successful|
|400/401|Request failed. Wrong or missing parameters.|
|502/503|Platform Error. API Service is busy or down|

API requests with a response code of 201, 400 or 401 will be chargeable against your developer wallet. Standard LBS API rates apply, unless otherwise stated.


Charging
========================

**Overview**

The Charging API directly charges for digital services to the bill of an Globe or TM subscriber. A developer creates new transactions or subscriptions, requests the status of the transaction or subscription, and authorizes refunds.


######CHARGING v2.1

The API Payment interface allows you to charge mobile subscribers for use of your Web application or content. The API allows you to directly charge a user based on their consent (see ‘User consent and operator policies’ below).

### Charge Subscriber

Charge/bill a subscriber:

Use <span class="method">POST</span> method on this URI:
```
https://devapi.globelabs.com.ph/payment/v1/transactions/amount?access_token={access_token}
```
###### Sample POST Request

```
curl -X POST "https://devapi.globelabs.com.ph/payment/v1/transactions/amount?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPcQDdTESLUDI4s4g" \
 -F "amount=0.00" \
 -F "description=my application" \
 -F "endUserId=9171234567" \
 -F "referenceCode=12341000022" \
 -F "transactionOperationStatus=Charged"
 ```

###### Resource Parameters

| Parameter | Usage |
| ----------|-------|
|**amount** (decimal) amount to be charged. Must be in decimal format. eg. 1.00, 2.50, 10.00 | Required |
|**description**(string) is the human-readable text to appear on the bill, so the user can easily see what they bought| Required |
| **endUserId** URL-escaped end user ID; in this case their MSISDN including the ‘tel:’ protocol identifier and the country code preceded by ‘+’. i.e., tel:+16309700001. The API also supports the Anonymous Customer Reference (ACR) if provided by the operator. | Required |
| **referenceCode** (string, unique alphanumeric) is your reference for reconciliation purposes. The operator should include it in reports so that you can match their view of what has been sold with yours by matching the referenceCodes. Required format: Unique combination of 7 alphanumeric string. or you can also do Increments of 1 from 1000000 e.g. [1234]1,000,001 to [1234]9,999,999]| Required |
|**transactionOperationStatus** (enumeration). This indicates the desired resource state, in this case ‘Charged’. See ‘resource states’ section below for further explanation| Required |

###### Sample Response

```javascript
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
```



###### Error Codes:

|Code|Description|
|----|-----------|
|400 | Authentication Error/Missing parameters in request body.|
|401 | App Is deactivated (due to inactivity).|
|402 | Subscriber Not found (invalid number). |
|405 | Failure to update the TM subscriber’s balance or failure to check the TM subscriber’s balance.|
|407 | Failure since postpaid charging is not permitted.|
|411 | GHP Subscriber has insufficient balance.|
|412 | TM Subscriber has insufficient balance.|
|416 |Failure to check the subscriber's balance.|
|503 | System is busy, please try again later.|


### Get Last Reference Code
In case you lost of track of your reference code,
you can make a <span class="method">GET</span> request to this uri below:

```
https://devapi.globelabs.com.ph/payment/v1/transactions/getLastRefCode
```

|Parameter|Usage|
|---------|-----|
|app_id|required|
|app_secret|required|

###### Sample Response

```
{
  "referenceCode": "12341000005",
  "status": "SUCCESS",
  "shortcode": "21581234"
}
```


###Charging API HTTP Response

|Code|Description|
|----|-----------|
|201|Request has been successful|
|400/401|Request failed. Wrong or missing parameters|
|502/503|Platform Error. API Service is busy or down|

Voice
========================

**Overview**

Build nearly any voice application you can imagine, including speech-driven IVR, VoIP solutions and voice mashups with the Globe Labs Voice APIs (powered by Tropo).
With the Globe Labs Voice APIs, one can easily:

- Make a Call (Incoming and Outgoing) : Have your application dial a sip address or better yet an actual phone number. You can call even more than one number or sip address with just 2 lines of code.

- Call Control : With the API you can transfer or route a call to another phone number or sip address, reject a call without even answering or even have other callers to join in for a conference call.

- Speech Recognition: Not just the tone touch input. The API gives your caller the capability to talk back to your application, and by simply tell the API what are the expected words as the valid answer.

- Recording : Going beyond speech recognition, the API has the capability to transcribe the caller's responses to text and you can easily save it to your database, or perhaps record their responses in part or whole as audio files.

- and more…

###### You can select the App Type can either be a Scripting or Web API .

### Scripting

Scripting : A simple yet powerful synchronous API that lets you build communications applications, hosted on servers in our platform, using the languages you already know - JavaScript, PHP, Ruby, Python, and Groovy. Best to use for quick apps or short code snippets.

You can even use Gist Github or Dropbox to use your code.

Upon successfully creating an app you will get following information: Voice App ID, Voice App Token

**Change Voice URI**

Change Voice URI to where your Script is located.

To configure, read the full documentation at:

http://bit.ly/VoiceAPIDocs_v2

https://www.tropo.com/docs

### Web API

Web API :  A web-service API that lets you build communications applications that run on your servers and drive the Tropo cloud using JSON over HTTP. It uses the same request-response model many web developers are already comfortable using, communicating with applications running on your own server, feeding requests and processing responses back and forth as needed. Requires to import or include code library.

Best to use for apps that requires database and other system integration.

Upon successfully creating an app you will get following information: Voice App ID, Voice App Token

**Change Voice URI**

Change Voice URI to where your Web API is located.

To configure, read the full documentation at:

http://bit.ly/VoiceAPIDocs_v2

https://www.tropo.com/docs

Subscriber Data Query (Alpha)
========================

**Overview**

Globe Labs Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator. Currently the information epxosed is subscriber balance and reload amount.

Note: This API is still in alpha. For inquiries and concern, kindly email api@globelasbeta.com.

HTTP GET command is used in Subscriber Data Query API. The URIs of the resources are:

### Subscriber Balance

Use <span class="method">GET</span> method on this URI:
```
https://devapi.globelabs.com.ph/location/v1/queries/balance?access_token={access_token}&address={address}
```

###### Sample GET Request (Balance)
```
curl
https://devapi.globelabs.com.ph/location/v1/queries/balance?address=639065755831 "Content-Type: application/json"
```

###### Sample Successful GET Response (Balance)

```javascript
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
```

###### Sample Response Parameters (Balance)

|Parameter name|Description|
|--------------|-----------|
|terminalLocationList|Specifies the body of the response.|
|address|Subscriber MSISDN (mobile number)|
|subBalance|Current balance of subscriber. Note: this is in cents (the last two digits are the decimal digits).|

### Reload Amount

Use <span class="method">GET</span> method on this URI:
```
https://devapi.globelabs.com.ph/location/v1/queries/reload_amount?address={address}
```

###### Sample GET Request (Reload Amount)

```
curl
https://devapi.globelabs.com.ph/location/v1/queries/reload_amount?address=639065755831 "Content-Type: application/json"
 ```

 ###### Sample Successful GET Response (Reload Amount)

```javascript
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
```

###### Sample Response Parameters (Reload Amount)

|Parameter name | Description |
|---------------|-------------|
|terminalLocationList|Specifies the body of the response.|
|address|Subscriber MSISDN (mobile number)|
|reloadAmount|Last amount loaded by subscriber (in cents)|

SDK's & Libraries
===================

## Android

### Setting Up

Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-android/blob/master/instructions/manual-installation.md">link</a> for manual installation of the Globe Connect Android SDK.
        <br />Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-android/blob/master/instructions/installation-via-maven.md">link</a> to install the Globe Connect Android SDK via Maven Central.

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```java
Please go to `https://github.com/globelabs/globe-connect-android/blob/master/instructions/authentication-activity.md`
for more detailed explanation on how to do the android sdk authentication flow process.
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```java
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
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```java
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
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```java
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```java
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```java
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
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```java
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
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```java
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
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```java
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
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```java
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
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```java
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
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## iOS 10

### Setting Up

Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-ios/blob/feature/documentation-installation/installation/manual.md">link</a> for manual installation of Globe Connect iOS SDK.
        <br/>Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-ios/blob/feature/documentation-installation/installation/cocoapods.md">link</a> for Globe Connect iOS SDK installtion via CocoaPods.

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```swift
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
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

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
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```swift
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
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```swift
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```swift
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```swift
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
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```swift
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
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```swift
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
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```swift
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
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```swift
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
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```swift
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
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## React Native

### Setting Up

Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-react-native/blob/master/react-native-globeconnect/instructions/installation.md">link</a> for the detailed installation of Globe Connect React Native SDK.

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js
var auth = GlobeConnect.Authentication(
  '[app_id]',
  '[app_secret]');

auth.startAuthActivity(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

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
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js
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
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js
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
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js
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
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js
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
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js
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
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js
import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('[access_token]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js
import GlobeConnect from 'react-native-globeapi';

var subscriber = GlobeConnect.Subscriber('[access_token]');

subscriber
    .setAddress('[subscriber_address]')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## PhoneGap

### Setting Up

Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-phonegap/blob/master/instructions/installation.md">link</a> for detailed installation instructions of Globe Connect Phonegap SDK.

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js
var auth = globeconnect.Authentication(
    '[app_id]',
    '[app_secret]');

auth.startAuthActivity(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```js
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
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js
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
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js
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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js
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
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js
var payment = globeconnect.Payment('[app_secret]');

payment
    .setAppId('[app_id]')
    .setAppSecret('[app_secret]')
    .getLastReferenceCode(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js
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
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js
var location = globeconnect.Location('[app_secret]');

location
    .setAddress('[subscriber_number]')
    .setRequestedAccuracy([accuracy]);

location.getLocation(function() {
    console.log(arguments);
}, function() {
    console.log(arguments);
});
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js
var subscriber = globeconnect.Subscriber('[app_secret]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberBalance(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js
var subscriber = globeconnect.Subscriber('[app_secret]');

subscriber
    .setAddress('[subscriber_number]')
    .getSubscriberReloadAmount(function() {
        console.log(arguments);
    }, function() {
        console.log(arguments);
    });
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## CLI

### Setting Up

```npm install -g globe-connect-cli```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```bash
Authentication is not available in Globe Connect CLI.
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```bash
globe-connect sms -a [subscriber_number] -m "[message]" -s [short_code] -c [client_correlator] -t "[access_token]"
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```bash
globe-connect binarysms -c "[short_code]" -t "[access_token]" -u "[data_header]" -d [coding_scheme] -a "[subscriber_number]" -m "[message]" --verbose
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```bash
globe-connect ussd-send -m [message] -a [address] -s [short_code] -f [flash] -t [access_token]
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```bash
globe-connect ussd-send -m [message] -a [address] -s [short_code] -f [flash] -t [access_token] -i [session_id]
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```bash
globe-connect payment -a [amount] -d "[description]" -e [subscriber_number] -r [reference] -s [status] -t "[access_token]" --verbose
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```bash
globe-connect get-last-reference -ai "[app_id]" -as "[app_secret]" --verbose
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```bash
globe-cli.js amax -i "[app_id]" -s "[app_secret]" -t "[rewards_token]" -p "[promo]" -a [subscriber_number] --verbose
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```bash
globe-connect location -a [subscriber_number] -c [accuracy] -t "[access_token]" --verbose
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```bash
globe-connect subscr-bal -a [subscriber_number] -t "[access_token]" --verbose
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```bash
globe-connect subscr-reload-amt -a [subscriber_number] -t "[access_token]" --verbose
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## PHP

### Setting Up

```composer install globe-connect-php```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```php
use Globe\Connect\Oauth;

$oauth = new Oauth("[key]", "[secret]");

// get redirect url
echo $oauth->getRedirectUrl();

// redirect to dialog and process the code then ...

// get access token
$oauth->setCode("[code]");
echo $oauth->getAccessToken();
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```php
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");

$sms->setReceiverAddress("[address]");
$sms->setMessage("[message]");
$sms->setClientCorrelator("[correlator]");
echo $sms->sendMessage();
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```php
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");
$sms->setReceiverAddress("[address]");
$sms->setUserDataHeader("[header]");
$sms->setDataEncodingScheme("[scheme]");
$sms->setMessage("[message]");
echo $sms->sendBinaryMessage();
```

##### Sample Results

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```php
// print post data from your callback url
print_r(json_encode($_POST));
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web Api");
$choices = $voice->choices("[5 DIGITS]");
$askSay = $voice->say("Please enter yout 5 digit zip code.");

$ask = $voice->ask($askSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on("continue")
    ->setNext("http://somefakehost.com:8000/")
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);
```

##### Sample Results

```json
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
```

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web Api.");
echo $voice->addSay($say);
```

##### Sample Results

```json
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
```

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API");

$voice->addSay($say);

if($url == "/ask") {
    $choices = $voice->choices("[5 DIGITS]");
    $askSay = $voice->say("Please enter yout 5 digit zip code.");

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setAttempts(3)
        ->setBargein(false)
        ->setName("foo")
        ->setRequired(true)
        ->setTimeout(10);

    $on = $voice->on("continue")
        ->setNext("/answer")
        ->setRequired(true);

    $voice->addSay($say)
        ->addAsk($ask)
        ->addOn($on);
} elseif($url == "/answer") {
    $result = $voice->result($data)
        ->getObject();

    $interprertation = $result["actions"]["ineterpretation"];
    $say = $voice->say("Your zip is " . $interpretation . ", thank you!");

    $voice->addSay($say);
}

echo $voice;
```

##### Sample Results

```json
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
```

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$call = $voice->call("9065263453")
    ->setFrom("sip:21584130@sip.tropo.net");

$say = $voice->say("Hello World");

echo $voice->addCall($call)
    ->addSay($say);
```

##### Sample Results

```json
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
```

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web API Conference Call.");

$jPrompt = $voice->joinPrompt("http://openovate.com/hold-music.mp3");
$lPrompt = $voice->leavePrompt("http://openovate.com/hold-music.mp3");

$conference = $voice->conference("12345")
    ->setMute(false)
    ->setName("foo")
    ->setPlayTones(true)
    ->setTerminator("#")
    ->setJoinPrompt($jPrompt)
    ->setLeavePrompt($lPrompt);

echo $voice->addSay($say)
    ->addConference($conference);
```

##### Sample Results

```json
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
```

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$e1 = $voice->say("Sorry, I did not hear anything.")
    ->setEvent("timeout");

$e2 = $voice->say("Sorry, that was not a valid option.")
    ->setEvent("nomatch:1");

$e3 = $voice->say("Nope, still not a valid response.")
    ->setEvent("nomatch:2");

$say = $voice->say("Welcome to my Tropo Web API");
$eventSay = $voice->say("Please enter your 5 digit zip code.")
    ->setEvent(array($e1, $e2, $e3));

$choices = $voice->choices("[5 DIGITS]");
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on("continue")
    ->setNext("/answer")
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);
```

##### Sample Results

```json
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
```

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web Api, Thank you");
echo $say->addSay($say)
    ->addHangup("");
```

##### Sample Results

```json
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
```

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API.");
$sayTimeout = $voice->say("Sorry, I did not here anything. Please call back.")
    ->setEvent("timeout");

$say2 = $voice->say("Please leave a message")
    ->setEvent(array($sayTimeout));

$choices = $voice->choices()
    ->setTerminator("#");

$transcription = $voice->transcription("1234")
    ->setUrl("mailto:charles.andacc@gmail.com");

$record = $voice->record("foo", "http://openovate.com/globe.php")
    ->setFormat("wav")
    ->setAttempts(3)
    ->setBargein(false)
    ->setMethod("POST")
    ->setRequired(true)
    ->setSay($say2)
    ->setChoices($choices)
    ->setTranscription($transcription);

echo $voice->addSay($say)
    ->addRecord($record);
```

##### Sample Results

```json
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
```

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```php
use Globe\Connect\Voice

$voice = new Voice();

echo $voice->addreject("");
```

##### Sample Results

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```php
use Globe\Connect\Voice

$voice = new Voice();

if($url == "/routing") {
    $say = $voice->say("Welcome to my Tropo Web API.");
    $on = $voice->on("continue")
        ->setNext("/routing1");

    $voice->addSay($say)
        ->addOn($on);
} else if($url == "/routing1") {
    $say = $voice->say("Hello from resource one.");
    $on = $voice->on("continue")
        ->setNext("/routing2");

    $voice->addSay($say)
        ->addOn($on);
} else if($url == "/routing2") {
    $say = $voice->say("Hello from resource two! Thank you.");
    $voice->addSay($say);
}

echo $voice;
```

##### Sample Results

```json
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
```

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo web API");
$say2 = $voice->say("I will play an audio file for you, please wait.");
$say3 = $voice->say("http://openovate.com/tropo-rocks.mp3");

echo $voice->addSay($say)
    ->addSay($say2)
    ->addSay($say3);
```

##### Sample Results

```json
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
```

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API, you are now being transfered.");

$e1 = $voice->say("Sorry I did not hear anything")
    ->setEvent("timeout");

$e2 = $voice->say("Sorry, that was an invalid option")
    ->setEvent("nomatch:1");

$eventSay = $voice->say("Please enter your 5 digit zip code")
    ->setEvent(array($e1, $e2));

$choices = $voice->choices("[5 DIGITS]");
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(5);

$ringSay = $voice->say("http://openovate.com/hold-music.mp3");
$onRing = $voice->on("ring")
    ->setSay($ringSay);

$onConnect = $voice->on("connect")
    ->setAsk($ask);

$on = array($onRing, $onConnect);
$transfer = $voice->transfer("9053801178")
    ->setRingRepeat(2)
    ->setOn($on);

echo $voice->addSay($say)
    ->addTransfer($transfer);
```

##### Sample Results

```json
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
```

#### Voice Transfer Whisper

TODO

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

if($url == "/whisper") {
    $say = $voice->say("Welcome to my Tropo Web API");
    $askSay = $voice->say("Press 1 to continue this call or any other to reject");
    $choices = $voice->choices("1")
        ->setMode("DTMF");

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setName("color")
        ->setTimeout(60);

    $onConnect1 = $voice->on("connect")
        ->setAsk($ask);

    $sayCon2 = $voice->say("You are now being connected");
    $onConnect2 = $voice->on("connect")
        ->setSay($sayCon2);

    $sayRing = $voice->say("http://openovate.com/hold-music.mp3");
    $onRing = $voice->on("ring")
        ->setSay($say);

    $on = array($onRing, $onConnect1, $onConnect2);
    $transfer = $voice->transfer("9054799241")
        ->setName("foo")
        ->setOn($on)
        ->setRequired(true)
        ->terminator("*")

    $incompleteSay = $voice->say("Your are now being disconnected");
    $onIncomplete = $voice->on("incomplete")
        ->setNext("/whisperIncomplete")
        ->setSay($incompleteSay);

    echo $voice->addSay($say)
        ->addTransfer($transfer)
        ->addOn($onIncomplete);
} else if($url == "/whisperIncomplete") {
    echo $voice->addHangup("");
}
```

##### Sample Results

```json
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
```

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web API.");
$wait = $voice->wait(5000)
    ->setAllowSignals(true);

$say2 = $voice->say("Thank you for waiting.");

echo $voice->addSay($say)
    ->addWait($wait)
    ->addSay($say2);
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```php
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

// send ussd request
$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");

print $ussd->sendUssdRequest();
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```php
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");
$ussd->setSessionId("[session_id]");

print $ussd->replyUssdRequest();
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```php
use Globe\Connect\Payment;

$payment = new Payment("[token]");

// payment request
$payment->setEndUserId("[user_id]");
$payment->setAmount("[amount]");
$payment->setDescription("[description]");
$payment->setReferenceCode("[reference_code]");
$payment->setTransactionOperationStatus("[status]");
print $payment->sendPaymentRequest();
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```php
use Globe\Connect\Payment;

// get last reference code request
$payment->setAppKey("[key]");
$payment->setAppSecret("[secret]");
print $payment->getLastReferenceCode();
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```php
use Globe\Connect\Amax;

$amax = new Amax("[app_id]", "[app_secret]");
$amax->setToken("[token]");
$amax->setAddress("[address]");
$amax->setPromo("[promo]");
echo $amax->sendReward();
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```php
use Globe\Connect\Location;

$location = new Location("[token]");
$location->setAddress("[address]");
$location->setRequestedAccuracy("[accuracy]");
echo $location->getLocation();
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```php
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getSubscriberBalance();
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```php
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getReloadAmount();
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## Python

### Setting Up

```pip install globe```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```python
from globe.connect import oauth

oauth = oauth.Oauth("[app_id]", "[app_secret]")

# get redirect url
print oauth.getRedirectUrl()

# get access token
print oauth.getAccessToken("[code]")
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

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
sms.sendMessage()

print sms.getResponse()
```

##### Sample Results

```json
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
```

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

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```python
from BaseHTTPServer import BaseHTTPRequestHandler, HTTPServer
import SocketServer
import json

...

def _set_headers(self):
    # set response code as 200
    self.send_response(200)
    # set content-type to text/html,
    # we can also set it as application/json ;)
    self.send_header("Content-type", "text/html")
    # end header
    self.end_headers()

def do_POST(self):
    # set http header
    self._set_headers()
    # store post data
    self.data_string = self.rfile.read(int(self.headers["Content-Length"]))
    # load post data as json
    data = json.loads(self.data_string)
    # write data to response
    self.wfile.write(data)

...
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

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

```json
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
```

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```python
from globe.connect import voice

voice = voice.Voice()
say = voice.say("Welcome to my Tropo Web API")

print voice.addSay(say).getObject())
```

##### Sample Results

```json
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
```

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
elif url == "/answer":
    result = voice.result(data).getObject()
    interpretation = result.actions.interpretation

    say = ("Your zip is %s, thank you!" % (interpretation))
    say = voice.say(say)
    voice.setSay(say)

    obj = voice.getObject()

print obj
```

##### Sample Results

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

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

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

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
payment.setReferenceCode("[reference]")
payment.setTransactionOperationStatus("[status]")
payment.sendPaymentRequest()

print payment.getResponse()
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```python
from globe.connect import payment

payment = payment.Payment("[token]")
payment.setAppKey("[app_id]")
payment.setAppSecret("[app_secret]")
payment.getLastReferenceCode()

print payment.getResponse()
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

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

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

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

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

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

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

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

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## Ruby

### Setting Up

```gem install globe_connect```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```ruby
require 'globe_connect'

authenticate = Authentication.new
url = authenticate.get_access_url('[app_id]')

print url

response = authenticate
  .get_access_token(
    '[app_id]',
    '[app_secret]',
    '[code]'
  )

puts response
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```ruby
require 'globe_connect'

sms = Sms.new('[access_token]', [short_code])
response = sms.send_message('[subscriber_number]', '[message]')

puts response
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```ruby
require 'globe_connect'

binary = Sms.new('[access_token]', [short_code])
response = binary.send_binary_message('[subscriber_number]', '[message]', '[data_header]')

puts response
```

##### Sample Results

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```ruby
require 'sinatra'
require 'globe_connect'

post '/inbound-sms' do
  payload = JSON.parse(request.body.read)

  print(payload)

  # do things here...
end
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

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

  voice.say('Welcome to my Tropo Web API.');

  say = voice.say('Please enter your 5 digit zip code.', {}, true)
  choices = voice.choices({ :value => '[5 DIGITS]' }, true)

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => 'foo',
      :required => true,
      :say => say,
      :timeout => 10
    })

  voice.on({
      :name => 'continue',
      :next => 'http://somefakehost.com:8000',
      :required => true
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.')
  voice.hangup

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'
require 'json'

get '/ask-test' do
  voice = Voice.new

  say = voice.say('Please enter your 5 digit zip code.', {}, true)
  choices = voice.choices({:value => '[5 DIGITS]'})

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => 'foo',
      :required => true,
      :say => say,
      :timeout => 10
    })

  voice.on({
      :name => 'continue',
      :next => 'http://somefakehost.com:8000',
      :required => true
    })

  content_type :json
  voice.render
end

post '/ask-answer' do
  # get data from post
  payload = JSON.parse(request.body.read)

  voice = Voice.new
  voice.say('Your zip code is ' + payload[:result][:actions][:disposition] + ', thank you!')

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.call({
      :to => '9065263453',
      :from => 'sip:21584130@sip.tropo.net'
    })

  say = Array.new
  say << voice.say('Hello world', {}, true)
  voice.say(say)

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API Conference Call.');

  voice.conference({
      :id => '12345',
      :mute => false,
      :name => 'foo',
      :play_tones => true,
      :terminator => '#',
      :join_prompt => voice.join_prompt({:value => 'http://openovate.com/hold-music.mp3'}, true),
      :leave_prompt => voice.join_prompt({:value => 'http://openovate.com/hold-music.mp3'}, true),
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.')

  say1 = voice.say('Sorry, I did not hear anything', {:event => 'timeout'}, true)

  say2 = voice.say({
      :value => 'Sorry, that was not a valid option.',
      :event => 'nomatch:1'
    }, {}, true)

  say3 = voice.say({
      :value => 'Nope, still not a valid response',
      :event => 'nomatch:2'
    }, {}, true)

  say4 = voice.say({
      :value => 'Please enter your 5 digit zip code.',
      :array => [say1, say2, say3]
    }, {}, true)

  choices = voice.choices({ :value => '[5 DIGITS]' }, true)

  voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :required => true,
      :say => say4,
      :timeout => 5
    })

  voice.on({
      :event => 'continue',
      :next => 'http://somefakehost:8000/',
      :required => true
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API, thank you!')
  voice.hangup

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.');

  timeout = voice.say(
    'Sorry, I did not hear anything. Please call back.',
    { :event => 'timeout'},
    true)

  say = voice.say('Please leave a message', {:array => timeout}, true);

  choices = voice.choices({:terminator => '#'}, true)

  transcription = voice.transcription({
      :id => '1234',
      :url => 'mailto:address@email.com'
    }, true)

  voice.record({
      :attempts => 3,
      :bargein => false,
      :method => 'POST',
      :required => true,
      :say => say,
      :name => 'foo',
      :url => 'http://openovate.com/globe.php',
      :format => 'audio/wav',
      :choices => choices,
      :transcription => transcription
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

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

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/routing' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.');
  voice.on({
    :event => 'continue',
    :next => '/routing-1'
  });

  content_type :json
  voice.render
end

get '/routing-1' do
  voice = Voice.new

  voice.say('Hello from resource one!');
  voice.on({
    :event => 'continue',
    :next => '/routing-2'
  });

  content_type :json
  voice.render
end

get '/routing-2' do
  voice = Voice.new

  voice.say('Hello from resource two! thank you.');

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.');
  voice.say('I will play an audio file for you, please wait.');
  voice.say({
      :value => 'http://openovate.com/tropo-rocks.mp3'
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/transfer' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API, you are now being transferred.');

  e1 = voice.say({
    :value => 'Sorry, I did not hear anything.',
    :event => 'timeout'
  }, {} ,true)

  e2 = voice.say({
    :value => 'Sorry, that was not a valid option.',
    :event => 'nomatch:1'
  }, {} ,true)

  e3 = voice.say({
    :value => 'Nope, still not a valid response',
    :event => 'nomatch:2'
  }, {} ,true)

  # TODO: [e1, e2, e3]
  say = voice.say('Please enter your 5 digit zip code', {}, true)

  choices = voice.choices({:value => '[5 DIGITs]'}, true)

  ask = voice.ask({
      :choices => choices,
      :attempts => 3,
      :bargein => false,
      :name => 'foo',
      :required => true,
      :say => [e1, e2, e3, say],
      :timeout => 5
    }, true)

  ring = voice.on({
      :event => 'ring',
      :say => voice.say('http://openovate.com/hold-music.mp3', {} ,true)
    }, true)

  connect = voice.on({
      :event => 'connect',
      :ask => ask
    }, true)

  on = voice.on([ring, connect], true)

  voice.transfer({
      :to => '9271223448',
      :ring_repeat => 2,
      :on => on
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Transfer Whisper

TODO

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API, please hold while you are being transferred.');

  say = voice.say('Press 1 to accept this call or any other number to reject', {}, true);

  choices = voice.choices({
      :value => 1,
      :mode => 'dtmf'
    }, true)

  ask = voice.ask({
      :choices => choices,
      :name => 'color',
      :say => say,
      :timeout => 60
    }, true)

  connect1 = voice.on({
      :event => 'connect',
      :ask => ask
    }, true)

  connect2 = voice.on({
      :event => 'connect',
      :say => voice.say('You are now being connected', {}, true)
    }, true)

  ring = voice.on({
      :event => 'ring',
      :say => voice.say('http://openovate.com/hold-music.mp3', {}, true)
    }, true)

  connect = voice.on([ring, connect1, connect2], true)

  voice.transfer({
      :to => '9271223448',
      :name => 'foo',
      :connect => connect,
      :required => true,
      :terminator => '*'
    })

  voice.on({
      :event => 'incomplete',
      :next => '/hangup',
      :say => voice.say('You are now being disconnected', {}, true)
    })

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```ruby
require 'sinatra'
require 'connect_ruby'

get '/wait' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API, please wait for a while.')
  voice.wait({
      :wait => 5000,
      :allowSignals => true
    })

  voice.say('Thank you for waiting!')

  content_type :json
  voice.render
end
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```ruby
require 'globe_connect'

ussd = Ussd.new('[access_token]', [short_code])
response = ussd.send_ussd_request('[subscriber_number]', '[message]', [flash])

puts response
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```ruby
require 'globe_connect'

ussd = Ussd.new('[access_token]', [short_code])
response = ussd.reply_ussd_request('[subscriber_number]', '[message]', '[session_id]', [flash])

puts response
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```ruby
require 'globe_connect'

payment = Payment.new(
  '[app_id]',
  '[app_secret]',
  '[access_token]'
)

response = payment.send_payment_request([amount], '[description]', '[subscriber_number]', '[reference]', '[status]')

puts response
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```ruby
require 'globe_connect'

payment = Payment.new('[app_id]', '[app_secret]')
response = payment.get_last_reference_code

puts response
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```ruby
require 'globe_connect'

amax = Amax.new('[app_id]', '[app_secret]')
response = amax.send_reward_request('[subscriber_number]', '[promo]', '[rewards_token]')

puts response
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```ruby
require 'globe_connect'

location = LocationQuery.new('[access_token]')
response = location.get_location('[subscriber_number]', [accuracy])

puts response
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```ruby
require 'globe_connect'

subscriber = Subscriber.new('[access_token]')
response = subscriber.get_subscriber_balance('[subscriber_number]')

puts response
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```ruby
require 'globe_connect'

subscriber = Subscriber.new('[access_token]')
response = subscriber.get_subscriber_reload_amount('[subscriber_number]')
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## NodeJS

### Setting Up

```npm install globe-connect```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```js
var globe = require('globe-connect');

var oauth = globe.Oauth('[app_key]', '[app_secret]');

// get redirect url
var url = oauth.getRedirectUrl();

console.log(url);

// get access access_token
oauth.getAccessToken('[code]', function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body)
});
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```js
var globe = require('globe-connect');

var sms = globe.Sms('[short_code]', '[access_token]');

sms.setReceiverAddress('[subscriber_number]]');
sms.setMessage('[message]')
sms.sendMessage(function(resCode, body){
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```js
var globe = require('globe-connect');

var sms = globe.Sms('[short_code]', '[access_token]');

sms.setUserDataHeader('[data_header]');
sms.setDataEncodingScheme([coding_scheme])
sms.setReceiverAddress('[subscriber_number]')
sms.setMessage('[message]')
sms.sendBinaryMessage(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```js
var http = require('http');

var server = http.createServer(function(request, response) {
    if(request.method === 'POST') {
        var body = '';

        request.on('data', function(chunks) {
            body += chunks;
        });

        request.on('end', function() {
            response.statusCode = 200;
            response.setHeader('Content-Type', 'application/json');
            response.end(body);
        });
    }
});

server.listen(8080, '127.0.0.1', function() {
    console.log('Server running at http://127.0.0.1:8080');
});
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

console.log(JSON.stringify(obj));
```

##### Sample Results

```json
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
```

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

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```js
var globe = require('globe-connect');

var ussd = globe.Ussd('[access_token]', '[short_code]');

ussd.setAddress('[subscriber_number]]');
ussd.setUssdMessage('[message]');
ussd.setFlash('[flash]');
ussd.sendUssdRequest(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```js
var globe = require('globe-connect');

var ussd = globe.Ussd('[access_token]', '[short_code]');

ussd.setAddress('[subscriber_number]]');
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

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```js
var globe = require('globe-connect');

var payment = globe.Payment('[access_token]');

payment.setAmount('[amount]');
payment.setDescription('[desciption]');
payment.setEndUserId('[subscriber_number]');
payment.setReferenceCode('[reference]');
payment.setTransactionOperationStatus('[status]');
payment.sendPaymentRequest(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```js
var globe = require('globe-connect');

var payment = globe.Payment('[access_token]');

payment.setAppKey('[app_key]');
payment.setAppSecret('[app_secret]');
payment.getLastReferenceCode(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```js
var globe = require('globe-connect');

var amax = globe.Amax('[app_id]', '[app_secret]');

amax.setToken('[rewards_token]');
amax.setAddress('[subscriber_number]]');
amax.setPromo('[promo]');
amax.sendReward(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```js
var globe = require('globe-connect');

var location = globe.Location('[access_token]');

location.setAddress('[subscriber_number]]');
location.setRequestedAccuracy('[accuracy]');
location.getLocation(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```js
var globe = require('globe-connect');

var subscriber = globe.Subscriber('[access_token]');

subscriber.setAddres('[subscriber_number]]');
subscriber.getSubscriberBalance(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```js
var globe = require('globe-connect');

var subscriber = globe.Subscriber('[access_token]');

subscriber.setAddres('[subscriber_number]]');
subscriber.getReloadAmount(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## Java

### Setting Up


        Install via Maven:
        <!-- https://mvnrepository.com/artifact/ph.com.globe.connect/globe-connect-java -->
        <dependency>
            <groupId>ph.com.globe.connect</groupId>
            <artifactId>globe-connect-java</artifactId>
            <version>0.0.5</version>
        </dependency>

        Install via Gradle:
        // https://mvnrepository.com/artifact/ph.com.globe.connect/globe-connect-java
        compile group: 'ph.com.globe.connect', name: 'globe-connect-java', version: '0.0.5'

        Install via Ivy:
        <!-- https://mvnrepository.com/artifact/ph.com.globe.connect/globe-connect-java -->
        <dependency org="ph.com.globe.connect" name="globe-connect-java" rev="0.0.5"/>
        

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```java
import ph.com.globe.connect.Authentication;
import org.json.JSONObject;

Authentication auth = new Authentication([app_id], [app_secret]);

String dialogUrl = auth.getDialogUrl();

// redirect the user, process the code then ...

JSONObject response = auth
    .getAccessToken("[code]")
    .getJsonResponse();

System.out.println(response);
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

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

Sms sms = new Sms("[short_code]", "[access_token]");

JSONObject response = sms
    .setClientCorrelator("[client_correlator]")
    .setReceiverAddress("[receiver_address]")
    .setMessage("[message]")
    .sendMessage()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```java
import ph.com.globe.connect.BinarySms;
import org.json.JSONObject;

BinarySms sms = new BinarySms("[short_code]", "[access_token]");

JSONObject response = sms
    .setUserDataHeader("[data_header]")
    .setDataCodingScheme([coding_scheme])
    .setReceiverAddress("[receiver_address]")
    .setBinaryMessage("[message]")
    .sendBinaryMessage()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```java
import java.io.BufferedReader;
import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.json.JSONObject;
import org.json.JSONException;

...

/**
 * Handles the HTTP <code>POST</code> method.
 *
 * @param request servlet request
 * @param response servlet response
 * @throws ServletException if a servlet-specific error occurs
 * @throws IOException if an I/O error occurs
 */
@Override
protected void doPost(HttpServletRequest request, HttpServletResponse response)
        throws ServletException, IOException {

    StringBuilder raw = new StringBuilder();

    try {
      BufferedReader reader = request.getReader();
      String line = null;

      while ((line = reader.readLine()) != null) {
        raw.append(line);
      }
    } catch (IOException e) {
        throw new IOException(e.getMessage());
    }

    try {
      JSONObject json =  new JSONObject(raw.toString());

      System.out.println(json.toString(5));
    } catch (JSONException e) {
      throw new IOException("An error occured while parsing json string.");
    }

    processRequest(request, response);
}
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```java
import ph.com.globe.connect.Ussd;
import org.json.JSONObject;

Ussd ussd = new Ussd("[access_token]");

JSONObject response = ussd
    .setSenderAddress("[short_code]")
    .setUssdMessage("[message]")
    .setAddress("[subscriber_number]")
    .setFlash([flash])
    .sendUssdRequest()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```java
import ph.com.globe.connect.Ussd;
import org.json.JSONObject;

Ussd ussd = new Ussd("[access_token]");

JSONObject response = ussd
    .setSessionId([session_id])
    .setAddress("[subscriber_number]")
    .setSenderAddress("[short_code]")
    .setUssdMessage("[message]")
    .setFlash([flash])
    .replyUssdRequest()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```java
import ph.com.globe.connect.Payment;
import org.json.JSONObject;

Payment payment = new Payment("[access_token]");

JSONObject response = payment
    .setAmount([amount])
    .setDescription("[description]")
    .setEndUserId("[subscriber_number]")
    .setReferenceCode("[reference]")
    .setTransactionOperationStatus("[status]")
    .sendPaymentRequest()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```java
import ph.com.globe.connect.Payment;
import org.json.JSONObject;

Payment payment = new Payment("[access_token]");

JSONObject response = payment
    .setAppId("[app_id]")
    .setAppSecret("[app_secret]")
    .getLastReferenceCode()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```java
import ph.com.globe.connect.Amax;
import org.json.JSONObject;

Amax amax = new Amax([app_id], [app_secret]);

JSONObject response = amax
    .setRewardsToken("[rewards_token]")
    .setAddress("[subscriber_number]")
    .setPromo("[promo]")
    .sendRewardRequest()
    .getJsonResponse();

System.out.println(response);
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```java
import ph.com.globe.connect.Location;
import org.json.JSONObject;

Location location = new Location("[access_token]");

JSONObject response = location
    .setAddress("[subscriber_number]")
    .setRequestedAccuracy([accuracy])
    .getLocation()
    .getJsonResponse();

System.out.println(response);
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```java
import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("[access_token]");

JSONObject response = subscriber
    .setAddress("[subscriber_number]")
    .getSubscriberBalance()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```java
import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("[access_token]");

JSONObject response = subscriber
    .setAddress("[subscriber_number]")
    .getSubscriberReloadAmount()
    .getJsonResponse();

System.out.println(response);
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## C Sharp

### Setting Up

```PM> Install-Package Globe.Connect```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```csharp
using Globe.Connect;

Authentication auth = new Authentication([app_id], [app_secret]);

Console.WriteLine(auth.GetDialogUrl());

string code = "[code]";

Console.WriteLine(auth.GetAccessToken(code).GetDynamicResponse());
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```csharp
using Globe.Connect;

Sms sms = new Sms([short_code], [acces_token]);

dynamic response = sms
    .SetReceiverAddress("[subscriber_number]")
    .SetMessage("[message]")
    .SendMessage()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```csharp
using Globe.Connect;

BinarySms sms = new BinarySms([short_code], [access_token]);

dynamic response = sms
    .SetReceiverAddress("[subscriber_number]")
    .SetUserDataHeader("[data_header]")
    .SetDataCodingScheme([coding_scheme])
    .SetBinaryMessage("[message]")
    .SendBinaryMessage()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
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
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```csharp
using Newtonsoft.Json.Linq;

...

public ActionResult Index()
{
	String data = new System.IO.StreamReader(Request.InputStream).ReadToEnd();
	JObject result = JObject.Parse(data);

	Console.WriteLine(result);

	return Content(result.ToString(), "application/json");
}
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

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

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```csharp
using Globe.Connect;

Ussd ussd = new Ussd([access_token]);

dynamic response = ussd
    .SetAddress("[subscriber_number]")
    .SetSenderAddress([short_code])
    .SetUssdMessage("[message]")
    .SetFlash([flash])
    .SendUssdRequest()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```csharp
using Globe.Connect;

Ussd ussd = new Ussd([access_token]);

try {
    response = ussd
        .SetAddress("[subscriber_number]")
        .SetSessionId([session_id])
        .SetSenderAddress([short_code])
        .SetUssdMessage("[message]")
        .SetFlash([flash])
        .ReplyUssdRequest()
        .GetDynamicResponse();

    Console.WriteLine(response);
} catch(WebException e) {
    Console.WriteLine(new System.IO.StreamReader(e.Response.GetResponseStream()).ReadToEnd());
}
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```csharp
using Globe.Connect;

Payment payment = new Payment([app_id], [app_secret], [access_token]);

dynamic response = payment
    .SetAmount([amount])
    .SetDescription("[description]")
    .SetEndUserId("[subscriber_number]")
    .SetReferenceCode("[reference]")
    .SetTransactionOperationStatus("[status]")
    .SendPaymentRequest()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```csharp
using Globe.Connect;

Payment payment = new Payment([app_id], [app_secret], [access_token]);

response = payment
    .GetLastReferenceCode()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```csharp
using Globe.Connect;

Amax amax = new Amax([app_id], [app_secret]);

try {
    dynamic response = amax
        .SetAddress("[subscriber_number]")
        .SetRewardsToken("[rewards_token]")
        .SetPromo("[promo]")
        .SendRewardRequest()
        .GetDynamicResponse();

    Console.WriteLine(response);
} catch(WebException e) {
    Console.WriteLine(new System.IO.StreamReader(e.Response.GetResponseStream()).ReadToEnd());
}
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```csharp
using Globe.Connect;

Location location = new Location([access_token]);

dynamic response = location
    .SetAddress("[subscriber_number]")
    .SetRequestedAccuracy([accuracy])
    .GetLocation()
    .GetDynamicResponse();

Console.WriteLine(response);
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```csharp
using Globe.Connect;

Subscriber subscriber = new Subscriber([access_token]);

dynamic response = subscriber
    .SetAddress("[subscriber_number]")
    .GetSubscriberBalance()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```csharp
using Globe.Connect;

Subscriber subscriber = new Subscriber([access_token]);

response = subscriber
    .SetAddress("[subscriber_number]")
    .GetSubscriberReloadAmount()
    .GetDynamicResponse();

Console.WriteLine(response);
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```

## Swift

### Setting Up

Please refer to this <a target="_blank" href="https://github.com/globelabs/globe-connect-swift/blob/master/instructions/cocoapods.md">link</a>
        for the installation of Globe Connect Swift via CocoaPods.

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```
import GlobeConnectSwift

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
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```
import GlobeConnectSwift

let sms = Sms(
    accessToken: "[access_token]",
    shortCode: "[short_code]"
)

sms.sendMessage(
    address: "[subscriber_number]",
    message: "[message]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
```

##### Sample Results

```json
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
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
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
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
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
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```
import GlobeConnectSwift

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
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```
import GlobeConnectSwift

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
```

#### Sample Results

```json
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
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```
import GlobeConnectSwift

let subscriber = Subscriber(accessToken: "[access_token]")

subscriber.getSubscriberBalance(
    address: "[subscriber_number]",
    success: { json in
        dump(json)
    },
    failure: { error in
        print(error)
    })
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```
import GlobeConnectSwift

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
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```
