<?php

$samples = array (

'Amax' => "
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
",

'Authentication' => "
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
",

'Location' => "
var globe = require('globe-connect');

var location = globe.Location('[access_token]');

location.setAddress('[subscriber_number]]');
location.setRequestedAccuracy('[accuracy]');
location.getLocation(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
",

'Payment Send' => "
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
",

'Payment Reference' => "
var globe = require('globe-connect');

var payment = globe.Payment('[access_token]');

payment.setAppKey('[app_key]');
payment.setAppSecret('[app_secret]');
payment.getLastReferenceCode(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
",

'SMS Send' => "
var globe = require('globe-connect');

var sms = globe.Sms('[short_code]', '[access_token]');

sms.setReceiverAddress('[subscriber_number]]');
sms.setMessage('[message]')
sms.sendMessage(function(resCode, body){
    // some code here
    console.log(resCode);
    console.log(body);
});
",

'SMS Binary' => "
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
",

'Subscriber Balance' => "
var globe = require('globe-connect');

var subscriber = globe.Subscriber('[access_token]');

subscriber.setAddres('[subscriber_number]]');
subscriber.getSubscriberBalance(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
",

'Subscriber Reload' => "
var globe = require('globe-connect');

var subscriber = globe.Subscriber('[access_token]');

subscriber.setAddres('[subscriber_number]]');
subscriber.getReloadAmount(function(resCode, body) {
    // some code here
    console.log(resCode);
    console.log(body);
});
",

'USSD Send' => "
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
",

'USSD Reply' => "
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
",

'Voice Ask' => "
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
",

'Voice Answer' => "
var globe = require ('globe-connect');
var voice = globe.Voice();
var say = voice.say('Welcome to my Tropo Web API')

console.log(JSON.stringify(voice.addSay(say).getObject()));
",

'Voice Ask-Answer' => "
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
",

'Voice Call' => "
var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Hello World');

var call = voice.call('9065263453');
call.setFrom('sip:21584130@sip.tropo.net');

voice.addCall(call);
voice.addSay(say);

var obj = voice.getObject();

console.log(JSON.stringify(obj));
",

'Voice Conference' => "
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
",

'Voice Event' => "
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
",

'Voice Hangup' => "
var globe = require ('globe-connect');
var voice = globe.Voice();

var say = voice.say('Welcome to my Tropo Web API, thank you');
voice.addSay(say);
voice.addHangup();

var obj = voice.getObject();

console.log(JSON.stringify(obj));
",

'Voice Record' => "
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
",

'Voice Reject' => "
var globe = require ('globe-connect');
var voice = globe.Voice();

voice.addReject();
var obj = voice.getObject();

console.log(JSON.stringify(obj));
",

'Voice Routing' => "
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
",

'Voice Say' => "
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
",

'Voice Transfer' => "
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
",

'Voice Transfer Whisper' => "
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
",

'Voice Wait' => "
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
"

);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
