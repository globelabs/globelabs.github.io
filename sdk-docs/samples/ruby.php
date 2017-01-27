<?php

$samples = array (

'Amax' => "
require 'globe_connect'

amax = Amax.new('[app_id]', '[app_secret]')
response = amax.send_reward_request('[subscriber_number]', '[promo]', '[rewards_token]')

puts response
",

'Authentication' => "
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
",

'Location' => "
require 'globe_connect'

location = LocationQuery.new('[access_token]')
response = location.get_location('[subscriber_number]', [accuracy])

puts response
",

'Payment Send' => "
require 'globe_connect'

payment = Payment.new(
  '[app_id]',
  '[app_secret]',
  '[access_token]'
)

response = payment.send_payment_request([amount], '[description]', '[subscriber_number]', '[reference]', '[status]')

puts response
",

'Payment Reference' => "
require 'globe_connect'

payment = Payment.new('[app_id]', '[app_secret]')
response = payment.get_last_reference_code

puts response
",

'SMS Send' => "
require 'globe_connect'

sms = Sms.new('[access_token]', [short_code])
response = sms.send_message('[subscriber_number]', '[message]')

puts response
",

'SMS Binary' => "
require 'globe_connect'

binary = Sms.new('[access_token]', [short_code])
response = binary.send_binary_message('[subscriber_number]', '[message]', '[data_header]')

puts response
",

'Subscriber Balance' => "
require 'globe_connect'

subscriber = Subscriber.new('[access_token]')
response = subscriber.get_subscriber_balance('[subscriber_number]')

puts response
",

'Subscriber Reload' => "
require 'globe_connect'

subscriber = Subscriber.new('[access_token]')
response = subscriber.get_subscriber_reload_amount('[subscriber_number]')
",

'USSD Send' => "
require 'globe_connect'

ussd = Ussd.new('[access_token]', [short_code])
response = ussd.send_ussd_request('[subscriber_number]', '[message]', [flash])

puts response
",

'USSD Reply' => "
require 'globe_connect'

ussd = Ussd.new('[access_token]', [short_code])
response = ussd.reply_ussd_request('[subscriber_number]', '[message]', '[session_id]', [flash])

puts response
",

'Voice Ask' => "
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
",

'Voice Answer' => "
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API.')
  voice.hangup

  content_type :json
  voice.render
end
",

'Voice Ask-Answer' => "
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
",

'Voice Call' => "
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
",

'Voice Conference' => "
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
",

'Voice Event' => "
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
",

'Voice Hangup' => "
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.say('Welcome to my Tropo Web API, thank you!')
  voice.hangup

  content_type :json
  voice.render
end
",

'Voice Record' => "
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
",

'Voice Reject' => "
require 'sinatra'
require 'connect_ruby'

get '/' do
  voice = Voice.new

  voice.reject

  content_type :json
  voice.render
end
",

'Voice Routing' => "
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
",

'Voice Say' => "
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
",

'Voice Transfer' => "
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
",

'Voice Transfer Whisper' => "
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
",

'Voice Wait' => "
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
"
);

foreach($samples as $key => $value) {
    $samples[$key] = trim($value);
}

return $samples;
