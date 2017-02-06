(function() {
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
        // on load make target links collapsible
        $(window).on('load', function() {
            setTimeout(function() {
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

                            // hide the list
                            $(el).next().toggle();
                        } else {
                            // update the text
                            $(el)
                                .addClass('collapsed')
                                .html($(el).html().replace('+', '-'));

                            // show the list
                            $(el).next().toggle();
                            // scroll to target
                            $(el).next().find('li a:first').click();
                        }
                    });
                });
            }, 500);
        });
    }();
})();
