<?php

$samples = array (

'Amax' => '
use Globe\Connect\Amax;

$amax = new Amax("[app_id]", "[app_secret]");
$amax->setToken("[token]");
$amax->setAddress("[address]");
$amax->setPromo("[promo]");
echo $amax->sendReward();
',

'Authentication' => '
use Globe\Connect\Oauth;

$oauth = new Oauth("[key]", "[secret]");

// get redirect url
echo $oauth->getRedirectUrl();

// redirect to dialog and process the code then ...

// get access token
$oauth->setCode("[code]");
echo $oauth->getAccessToken();
',


'Location' => '
use Globe\Connect\Location;

$location = new Location("[token]");
$location->setAddress("[address]");
$location->setRequestedAccuracy("[accuracy]");
echo $location->getLocation();
',

'Payment Send' => '
use Globe\Connect\Payment;

$payment = new Payment("[token]");

// payment request
$payment->setEndUserId("[user_id]");
$payment->setAmount("[amount]");
$payment->setDescription("[description]");
$payment->setReferenceCode("[reference_code]");
$payment->setTransactionOperationStatus("[status]");
print $payment->sendPaymentRequest();
',

'Payment Reference' => '
use Globe\Connect\Payment;

// get last reference code request
$payment->setAppKey("[key]");
$payment->setAppSecret("[secret]");
print $payment->getLastReferenceCode();
',

'SMS Send' => '
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");

$sms->setReceiverAddress("[address]");
$sms->setMessage("[message]");
$sms->setClientCorrelator("[correlator]");
echo $sms->sendMessage();
',

'SMS Binary' => '
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");
$sms->setReceiverAddress("[address]");
$sms->setUserDataHeader("[header]");
$sms->setDataEncodingScheme("[scheme]");
$sms->setMessage("[message]");
echo $sms->sendBinaryMessage();
',

'Subscriber Balance' => '
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getSubscriberBalance();
',

'Subscriber Reload' => '
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getReloadAmount();
',

'USSD Send' => '
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

// send ussd request
$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");

print $ussd->sendUssdRequest();
',

'USSD Reply' => '
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");
$ussd->setSessionId("[session_id]");

print $ussd->replyUssdRequest();
',

'Voice Ask' => '
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
',

'Voice Answer' => '
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web Api.");
echo $voice->addSay($say);
',

'Voice Ask-Answer' => '
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
',

'Voice Call' => '
use Globe\Connect\Voice;

$voice = new Voice();
$call = $voice->call("9065263453")
    ->setFrom("sip:21584130@sip.tropo.net");

$say = $voice->say("Hello World");

echo $voice->addCall($call)
    ->addSay($say);
',

'Voice Conference' => '
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
',

'Voice Event' => '
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
',

'Voice Hangup' => '
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web Api, Thank you");
echo $say->addSay($say)
    ->addHangup("");
',

'Voice Record' => '
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
',

'Voice Reject' => '
use Globe\Connect\Voice

$voice = new Voice();

echo $voice->addreject("");
',

'Voice Routing' => '
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
',

'Voice Say' => '
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo web API");
$say2 = $voice->say("I will play an audio file for you, please wait.");
$say3 = $voice->say("http://openovate.com/tropo-rocks.mp3");

echo $voice->addSay($say)
    ->addSay($say2)
    ->addSay($say3);
',

'Voice Transfer' => '
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
',

'Voice Transfer Whisper' => '
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
',

'Voice Wait' => '
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web API.");
$wait = $voice->wait(5000)
    ->setAllowSignals(true);

$say2 = $voice->say("Thank you for waiting.");

echo $voice->addSay($say)
    ->addWait($wait)
    ->addSay($say2);
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
