// Makes the sdk and libraries section
// of the documentation collabsilble
//
// For example: Turn the links from ...
//
// Android
//      SMS
//      USSD
//      ...
//
// To ..
//
// + Android
// + PHP
var Collapse = function() {
    //
    // Window on load collapse target sections
    //
    var onload = function() {
        // get the parent links
        $('a[id^="sdks-libraries-"].level-2').each(function(index, el) {
            // customize text
            $(el)
                .removeAttr('href')
                .css('cursor', 'pointer')
                .html('+ ' + $(el).html());

            // hide the list
            $(el).next().toggle();

            // on link click
            $(el).on('click', function(e) {
                if($(el).hasClass('collapsed')) {
                    // update text
                    $(el)
                        .removeClass('collapsed')
                        .html($(el).html().replace('-', '+'));
                } else {
                    // update the text
                    $(el)
                        .addClass('collapsed')
                        .html($(el).html().replace('+', '-'));

                    // scroll to target
                    $(el).next().find('li a:first').click();
                }

                // toggle the list
                $(el).next().toggle();
            });
        });

        // re-try checking checking the dom, maybe it's not yet loaded
        if(!$('a[id^="sdks-libraries-"].level-2').length) {
            setTimeout(onload, 1000);
        }
    };

    // on load make target links collapsible
    $(window).on('load', onload);
}();
