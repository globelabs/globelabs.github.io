<?php

$samples = array (

'Amax' => '
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
',

'Authentication' => '
import ph.com.globe.connect.Authentication;
import org.json.JSONObject;

Authentication auth = new Authentication([app_id], [app_secret]);

String dialogUrl = auth.getDialogUrl();

// redirect the user, process the code then ...

JSONObject response = auth
    .getAccessToken("[code]")
    .getJsonResponse();

System.out.println(response);
',

'Location' => '
import ph.com.globe.connect.Location;
import org.json.JSONObject;

Location location = new Location("[access_token]");

JSONObject response = location
    .setAddress("[subscriber_number]")
    .setRequestedAccuracy([accuracy])
    .getLocation()
    .getJsonResponse();

System.out.println(response);
',

'Payment Send' => '
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
',

'Payment Reference' => '
import ph.com.globe.connect.Payment;
import org.json.JSONObject;

Payment payment = new Payment("[access_token]");

JSONObject response = payment
    .setAppId("[app_id]")
    .setAppSecret("[app_secret]")
    .getLastReferenceCode()
    .getJsonResponse();

System.out.println(response);
',

'SMS Send' => '
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
',

'SMS Binary' => '
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
',

'Subscriber Balance' => '
import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("[access_token]");

JSONObject response = subscriber
    .setAddress("[subscriber_number]")
    .getSubscriberBalance()
    .getJsonResponse();

System.out.println(response);
',

'Subscriber Reload' => '
import ph.com.globe.connect.Subscriber;
import org.json.JSONObject;

Subscriber subscriber = new Subscriber("[access_token]");

JSONObject response = subscriber
    .setAddress("[subscriber_number]")
    .getSubscriberReloadAmount()
    .getJsonResponse();

System.out.println(response);
',

'USSD Send' => '
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
',

'USSD Reply' => '
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
',

'Voice Ask' => '
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
',

'Voice Answer' => '
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
',

'Voice Ask-Answer' => '
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
',

'Voice Call' => '
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
',

'Voice Conference' => '
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
',

'Voice Event' => '
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
',

'Voice Hangup' => '
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
',

'Voice Record' => '
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
',

'Voice Reject' => '
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
',

'Voice Routing' => '
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
',

'Voice Say' => '
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
',

'Voice Transfer' => '
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
',

'Voice Transfer Whisper' => '
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
',

'Voice Wait' => '
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
'
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
