(function() {
    var redirect = false;

    var store = JSON.parse(document.getElementById('data-store').innerText);

    var update = function() {
        document.querySelectorAll('footer.panel-footer img').forEach(function(image) {
            image.parentElement.removeChild(image);
        });

        var size = 0, choices = {}, platform = null;
        document.querySelectorAll('input.choice').forEach(function(input) {
            if(input.checked) {
                var src = input.parentElement.querySelector('img').src;
                var image = document.createElement('img');
                image.src = src;

                document.querySelector('footer.panel-footer span.choices').appendChild(image);

                if(typeof store[input.value] !== 'undefined') {
                    platform = input.value;
                    choices.platform = platform;
                    choices.api = [];
                }

                if(!platform || typeof store[platform][input.value] === 'undefined') {
                    return;
                }

                choices.api.push(input.value);
                size += store[platform][input.value];
            }
        });

        if(!size) {
            redirect = false;
            document.querySelector('footer.panel-footer button').disabled = true;
            document.querySelector('footer.panel-footer em').style.display = 'none';
            return;
        }

        document.querySelector('footer.panel-footer em').innerHTML = size + 'KB';
        document.querySelector('footer.panel-footer em').style.display = 'inline-block';

        //determine the link
        var download = '/download/globe-sdk-build-';
        switch(choices.platform) {
            case 'android':
                download += '1';
                break;
            case 'ios':
                download += '2';
                break;
            case 'react':
                download += '3';
                break;
            case 'phonegap':
                download += '4';
                break;
        }

        download += choices.api.indexOf('sms') !== -1 ? '1': '0';
        download += choices.api.indexOf('voice') !== -1 ? '1': '0';
        download += choices.api.indexOf('location') !== -1 ? '1': '0';
        download += choices.api.indexOf('charging') !== -1 ? '1': '0';
        download += choices.api.indexOf('ussd') !== -1 ? '1': '0';
        download += choices.api.indexOf('rewards') !== -1 ? '1': '0';

        redirect = window.location.origin + download + '.zip';

        document.querySelector('footer.panel-footer button').disabled = false;
    };

    var success = function() {
        if(!redirect) {
            return;
        }

        window.open(redirect, '_blank');

        //be responsible
        document.querySelectorAll('input.choice').forEach(function(input) {
            input.removeEventListener('change', update);
        });

        document.querySelector('footer.panel-footer button').removeEventListener('click', success);

        //now we can swap out the form
        var template = document.getElementById('success-template').innerHTML;
        document.querySelector('div.sdk-builder div.panel').innerHTML = template;
    };

    //drivers
    document.querySelectorAll('input.choice').forEach(function(input) {
        input.addEventListener('change', update);
    });

    document.querySelector('footer.panel-footer button').addEventListener('click', success);
})();
