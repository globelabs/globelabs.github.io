var shell = require('shelljs');
var fs    = require('fs');
var path  = require('path');

//
// Generates an SDK for Android
// based on the given parameters.
//
// This file is part of the Globe Labs SDK Builder.
//
// @author Charles Zamora <czamora@openovate.com>
var Android = function(options) {
    // short hand initialization
    if(!(this instanceof Android)) {
        return new Android(options);
    }

    // default files
    var defaults = [
        'Amax.java',
        'Authentication.java',
        'BinarySms.java',
        'Location.java',
        'Payment.java',
        'Sms.java',
        'Subscriber.java',
        'Ussd.java'
    ];

    // files to include
    var include = [];
    // files to exclude
    var exclude = [];

    // get the root
    var root    = path.normalize(__dirname + path.sep + '..');
    // get the tmp
    var tmp     = root + path.sep + 'tmp';
    // get the target
    var target  = path.join(tmp, options.id);

    // create folder if not exists
    if(!fs.existsSync(tmp)) {
        shell.mkdir(tmp);
    }

    // create folder if not exists
    if(!fs.existsSync(target)) {
        shell.mkdir(target);
    }

    // get source folder
    var source = path.normalize(options.source);

    // format source folder
    if(source.lastIndexOf(path.sep) != source.length) {
        source += path.sep;
    }

    console.log('Copying files from ' + source);

    // exit if source does not exists
    if(!fs.existsSync(source)) {
        console.log('source does not exists.');
        return;
    }

    // copy all the files
    shell.cp('-r', source, target);
    shell.cp('-r',
        path.join(source, 'instructions'),
        path.join(target, path.basename(source), 'instructions'));
    shell.cp('-r',
        path.join(source, options.project, '*'),
        path.join(target, path.basename(source), options.project));
    shell.cp('-r',
        path.join(source, options.project, 'api', '*'),
        path.join(target, path.basename(source), options.project, 'api'));


    // remove unnecessary files
    shell.rm('-rf', path.join(target, path.basename(source), '.git'));
    shell.rm('-rf', path.join(target, path.basename(source), '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), 'instructions'));
    shell.rm('-rf', path.join(target, path.basename(source), 'supported_apis.png'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, '.gradle'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'app'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'build'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'api', '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'api', 'build'));

    // customize settings.gradle
    fs.writeFileSync(
        path.join(target, path.basename(source), options.project, 'settings.gradle'),
        'include \':api\'',
        function() {
            console.log(arguments);
        }
    );

    console.log('Files copied to ' + target + '\n');

    // get sdk namespace e.g ph.com.globelabs
    var namespace   = options.namespace.split('.').join(path.sep);
    // get the files
    var files       = options.files.split(',');
    // get the api root folder
    var api         = path.join(target, path.basename(source), options.project, 'api');
    // get the api root source
    var src         = path.join(api, 'src', 'main', 'java', namespace);

    // iterate on each file
    for(var i in files) {
        // formulate file path
        var file = path.join(src, files[i]);

        // if file does not exists, skip
        if(!fs.existsSync(file)) {
            console.log(file + ' does not exists, skipping...');
            continue;
        }

        // iterate on default files
        for(var k in defaults) {
            // formulate source
            var def = path.join(src, defaults[k]);

            // if the same as target files
            if(def == file) {
                console.log('Including file ' + file);

                // include it
                include.push(file);

                continue;
            }
        }
    }

    // iterate on default files
    for(var i in defaults) {
        // formulate path
        var def = path.join(src, defaults[i]);

        // not included?
        if(include.indexOf(def) == -1) {
            console.log('Excluding file ' + def);

            // put it on excluded files
            exclude.push(def);
        }
    }

    console.log('');

    // remove phyisical files
    for(var i in exclude) {
        console.log('Removing physical file ' + exclude[i]);

        shell.rm('-rf', exclude[i]);
    }

    // get the tmp output folder
    var tmp = path.join(target, path.basename(options.source));
    // get the final output folder
    var out = path.join(options.output, 'android-' + options.id);

    console.log('\nTransfering to output path ', out);

    // if output folder does not exists
    if(!fs.existsSync(out)) {
        // create it
        shell.mkdir('-p', out);
    }

    // copy all the target files
    shell.cp('-r', tmp, out);
    shell.cp('-r',
        path.join(tmp, options.project, '*'),
        path.join(out, path.basename(source), options.project));
    shell.cp('-r',
        path.join(tmp, options.project, 'api', '*'),
        path.join(out, path.basename(source), options.project, 'api'));

    console.log('Modified project has been successfully transferred to ' + out);

    // remove tmp file
    shell.rm('-rf', target);
};

module.exports = Android;
