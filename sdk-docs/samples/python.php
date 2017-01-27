<?php

$samples = array (

'Amax' => '
from globe.connect import amax

amax = amax.Amax("[app_id]", "[app_secret]")
amax.setAddress("[address]")
amax.setToken("[token]")
amax.setPromo("[promo]")
amax.sendReward()

print amax.getResponse()
',

'Authentication' => '
from globe.connect import oauth

oauth = oauth.Oauth("[key]", "[secret]")

# get redirect url
print oauth.getRedirectUrl()

# get access token
print oauth.getAccessToken("[code]")
',

'Location' => '
from globe.connect import location

loc = location.Location("[token]")
loc.setAddress("[address]")
loc.setRequestedAccuracy("[accuracy]")
loc.getLocation()

print loc.getResponse()
',

'Payment Send' => '
from globe.connect import payment

payment = payment.Payment("[token]")
payment.setAmount("[amount]")
payment.setDescription("[description]")
payment.setEndUserId("[number]")
payment.setReferenceCode("[referenceCode]")
payment.setTransactionOperationStatus("[status]")
payment.sendPaymentRequest()

print payment.getResponse()
',

'Payment Reference' => '
from globe.connect import payment

payment = payment.Payment("[token]")
payment.setAppKey("[app_key]")
payment.setAppSecret("[app_secret]")
payment.getLastReferenceCode()

print payment.getResponse()
',

'SMS Send' => '
from globe.connect import sms

sms = sms.Sms("[shortcode]","[token]")
sms.setReceiverAddress("[receiver_address]")
sms.setMessage("[message]")
sms.setClientCorrelator("[correlator]")

print sms.getResponse()
',

'SMS Binary' => '
from globe.connect import sms

sms = sms.setUserDataHeader("[header]")
sms.setDataEncodingScheme("[encoding]")
sms.setReceiverAddress("[address]")
sms.setMessage("[msg]")
sms.sendBinaryMessage()

print sms.getResponse()
',

'Subscriber Balance' => '
from globe.connect import subscriber

subscriber = subscriber.Subscriber("[token]")
subscriber.setAddress("[address]")
subscriber.getSubscriberBalance()

print subscriber.getResponse()
',

'Subscriber Reload' => '
from globe.connect import subscriber

subscriber = subscriber.Subscriber("[token]")
subscriber.setAddress("[address]")
subscriber.getReloadAmount()

print subscriber.getResponse()
',

'USSD Send' => '
from globe.connect import ussd

ussd = ussd.Ussd("[token]", "[shortcode]")
ussd.setAddress("[address]")
ussd.setMessage("[message]")
ussd.setFlash("[flash]")
ussd.sendUsssdRequest()

print ussd.getResponse()
',

'USSD Reply' => '
from globe.connect import ussd

ussd = ussd.Ussd("[token]", "[shortcode]")
ussd.setAddress("[address]")
ussd.setMessage("[message]")
ussd.setFlash("[flash]")
ussd.setSessionId("[session_id]")
ussd.replyUssdRequest()

print ussd.getResponse()
',

'Voice Ask' => '
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
',

'Voice Answer' => '
from globe.connect import voice

voice = voice.Voice()
say = voice.say("Welcome to my Tropo Web API")

print voice.addSay(say).getObject())
',

'Voice Ask-Answer' => '
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
',

'Voice Call' => '
from globe.connect import voice

voice = voice.Voice()

say = voice.say("Hello World")

call = voice.call("9065263453")
call.setFrom("sip:21584130@sip.tropo.net")

voice.addCall(call)
voice.addSay(say)

print voice.getObject()
',

'Voice Conference' => '
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
',

'Voice Event' => '
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
',

'Voice Hangup' => '
from globe.connect import voice

voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API, thank you")
voice.addSay(say)
voice.addHangup()

print voice.getObject()
',

'Voice Record' => '
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
',

'Voice Reject' => '
from globe.connect import voice

voice = voice.Voice()

voice.addReject()

print voice.getObject()
',

'Voice Routing' => '
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
',

'Voice Say' => '
from globe.connect import voice

voice = voice.Voice()

say = voice.say("Welcome to my Tropo Web API.")
say2 = voice.say("I will play an audio file for you, please wait.")
say3 = voice.say("http://openovate.com/tropo-rocks.mp3")

voice.addSay(say)
voice.addSay(say2)
voice.addSay(say3)

print voice.getObject()
',

'Voice Transfer' => '
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
',

'Voice Transfer Whisper' => '
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
',

'Voice Wait' => '
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
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
