(function() {
    // Handles the sdk builder actions.
    var Sdk = function() {
        // short hand initialization
        if(!(this instanceof Sdk)) {
            return new Sdk();
        }

        // initialize, start drivers
        this.initialize();
    }, sdk = Sdk.prototype;

    // selected sdk type
    sdk.type  = null;

    // selected sdk files
    sdk.files = {
        'rewards'    : 0, // or amax
        'auth'       : 0,
        'binary'     : 0,
        'location'   : 0,
        'charging'   : 0, // or payment
        'sms'        : 0,
        'subscriber' : 0,
        'ussd'       : 0
    };

    // redirect flag
    sdk.redirect = false;

    // initialize, drivers
    sdk.initialize = function() {
        // on platform select
        $('input[name="platform"]').on('click', this.update.bind(this));
        // on api files change
        $('input[name="api[]"]').on('change', this.update.bind(this));
        // on download button click
        $('.panel-footer .btn').on('click', this.download.bind(this));
    };

    // on platform and api files change
    sdk.update = function(e) {
        // get the current target
        var target  = $(e.currentTarget);
        // get the target name
        var name    = target.attr('name');
        // get the target value
        var value   = target.val();
        // get the current starte
        var checked = target.is(':checked');

        // update platform?
        if(name == 'platform') {
            this.type = value;
        }

        // update api?
        if(name == 'api[]' && value in this.files) {
            // checked? flip.
            if(checked) {
                // always include binary in sms
                if(value == 'sms') {
                    this.files['binary'] = 1;
                }

                this.files[value] = 1;
            } else {
                // remove binary if sms is not selected
                if(value == 'sms') {
                    this.files['binary'] = 0;
                }

                this.files[value] = 0;
            }
        }

        // reset images
        $('.panel-footer .choices').html('');

        // iterate on each choices
        $('input[name="platform"]').each(function(i, el) {
            // if is checked
            if($(el).is(':checked')) {
                // get source
                var src = $(el).next().attr('src');

                // create image
                $('.panel-footer .choices').append($('<img>').attr('src', src));
            }
        });

        // iterate on each choices
        $('input[name="api[]"]').each(function(i, el) {
            // if is checked
            if($(el).is(':checked')) {
                // get source
                var src = $(el).next().attr('src');

                // create image
                $('.panel-footer .choices').append($('<img>').attr('src', src));
            }
        });

        // get selection string
        var selection = this.getSelectionString();

        // no selection?
        if(this.type == null || selection == '00000000') {
            // remove size
            $('.panel-footer .text-info').css('display', 'none').html('');
            // disable button
            $('.panel-footer .btn').attr('disabled', true);

            // don't redirect
            this.redirect = false;

            return;
        }

        // get sdk size
        var size = window.sdkSize[this.type][selection];

        // update size
        $('.panel-footer .text-info').css('display', 'inline').html(size);
        // enable button
        $('.panel-footer .btn').attr('disabled', false);

        // allow redirect
        this.redirect = true;
    };

    // process download and success template
    sdk.download = function() {
        // redirect?
        if(!this.redirect) {
            return;
        }

        // target url
        var url  = window.location.origin;
        // formulate download url
        var path = '/sdk-generator/download.php?type=' + this.type;

        // always include auth
        this.files['auth'] = 1;
        // always include subscriber
        this.files['subscriber'] = 1;

        // get selection
        var selection = this.getSelectionString();

        // set selection
        path += '&files=' + selection;

        // set url path
        url += path;

        // if from github.io
        if(window.location.host === 'globelabs.github.io') {
            url = 'http://sdk.globelabs.com.ph' + path;
        }

        window.open(url, '_blank');

        // swap template
        var template = $('#success-template').html();
        $('div.sdk-builder-ui div.panel').html(template);
    };

    // convert selection to string
    sdk.getSelectionString = function() {
        var selection = '';

        for(var i in this.files) {
            selection += this.files[i].toString();
        }

        return selection;
    };

    return Sdk();
})();
