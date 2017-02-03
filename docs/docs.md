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
