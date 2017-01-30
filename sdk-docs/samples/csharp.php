<?php

$samples = array (


'Amax' => '
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
',

'Authentication' => '
using Globe.Connect;

Authentication auth = new Authentication([app_id], [app_secret]);

Console.WriteLine(auth.GetDialogUrl());

string code = "[code]";

Console.WriteLine(auth.GetAccessToken(code).GetDynamicResponse());
',

'Location' => '
using Globe.Connect;

Location location = new Location([access_token]);

dynamic response = location
    .SetAddress("[subscriber_number]")
    .SetRequestedAccuracy([accuracy])
    .GetLocation()
    .GetDynamicResponse();

Console.WriteLine(response);
',

'Payment Send' => '
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
',

'Payment Reference' => '
using Globe.Connect;

Payment payment = new Payment([app_id], [app_secret], [access_token]);

response = payment
    .GetLastReferenceCode()
    .GetDynamicResponse();

Console.WriteLine(response);
',

'SMS Send' => '
using Globe.Connect;

Sms sms = new Sms([short_code], [acces_token]);

dynamic response = sms
    .SetReceiverAddress("[subscriber_number]")
    .SetMessage("[message]")
    .SendMessage()
    .GetDynamicResponse();

Console.WriteLine(response);
',

'SMS Binary' => '
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
',

'SMS Mobile Originating (SMS-MO)' => '',

'Subscriber Balance' => '
using Globe.Connect;

Subscriber subscriber = new Subscriber([access_token]);

dynamic response = subscriber
    .SetAddress("[subscriber_number]")
    .GetSubscriberBalance()
    .GetDynamicResponse();

Console.WriteLine(response);
',

'Subscriber Reload' => '
using Globe.Connect;

Subscriber subscriber = new Subscriber([access_token]);

response = subscriber
    .SetAddress("[subscriber_number]")
    .GetSubscriberReloadAmount()
    .GetDynamicResponse();

Console.WriteLine(response);
',

'USSD Send' => '
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
',

'USSD Reply' => '
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
',

'Voice Ask' => '
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
',

'Voice Answer' => '
using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API.");
    voice.Hangup();

    return Content(voice.Render().ToString(), "application/json");
}
',

'Voice Ask-Answer' => '
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
',

'Voice Call' => '
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
',

'Voice Conference' => '
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
',

'Voice Event' => '
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
',

'Voice Hangup' => '
using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Say("Welcome to my Tropo Web API, thank you!");
    voice.Hangup();

    return Content(voice.Render().ToString(), "application/json");
}
',

'Voice Record' => '
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
',

'Voice Reject' => '
using Globe.Connect.Voice;

...

public ActionResult Index()
{
    Voice voice = new Voice();

    voice.Reject();

    return Content(voice.Render().ToString(), "application/json");
}
',

'Voice Routing' => '
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
',

'Voice Say' => '
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
',

'Voice Transfer' => '
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
',

'Voice Transfer Whisper' => '
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
',

'Voice Wait' => '
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
'

);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
