var shell = require('shelljs');
var fs    = require('fs');
var path  = require('path');

var Android = function(options) {
    if(!(this instanceof Android)) {
        return new Android(options);
    }

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

    var include = [];
    var exclude = [];

    var root    = path.normalize(__dirname + path.sep + '..');
    var tmp     = root + path.sep + 'tmp';
    var target  = path.join(tmp, options.id);

    if(!fs.existsSync(tmp)) {
        shell.mkdir(tmp);
    }

    if(!fs.existsSync(target)) {
        shell.mkdir(target);
    }

    var source = path.normalize(options.source);

    if(source.lastIndexOf(path.sep) != source.length) {
        source += path.sep;
    }

    console.log('Copying files from ' + source);

    if(!fs.existsSync(source)) {
        console.log('source does not exists.');
        return;
    }

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


    shell.rm('-rf', path.join(target, path.basename(source), '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), 'instructions'));
    shell.rm('-rf', path.join(target, path.basename(source), 'supported_apis.png'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, '.gradle'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'app'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'build'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'api', '.idea'));
    shell.rm('-rf', path.join(target, path.basename(source), options.project, 'api', 'build'));

    fs.writeFileSync(
        path.join(target, path.basename(source), options.project, 'settings.gradle'),
        'include \':api\'',
        function() {
            console.log(arguments);
        }
    );

    console.log('Files copied to ' + target + '\n');

    var namespace   = options.namespace.split('.').join(path.sep);
    var files       = options.files.split(',');
    var api         = path.join(target, path.basename(source), options.project, 'api');
    var src         = path.join(api, 'src', 'main', 'java', namespace);

    for(var i in files) {
        var file = path.join(src, files[i]);

        if(!fs.existsSync(file)) {
            console.log(file + ' does not exists, skipping...');
            continue;
        }

        for(var k in defaults) {
            var def = path.join(src, defaults[k]);

            if(def == file) {
                console.log('Including file ' + file);

                include.push(file);

                continue;
            }
        }
    }

    for(var i in defaults) {
        var def = path.join(src, defaults[i]);

        if(include.indexOf(def) == -1) {
            console.log('Excluding file ' + def);

            exclude.push(def);
        }
    }

    console.log('');

    for(var i in exclude) {
        console.log('Removing physical file ' + exclude[i]);
        shell.rm('-rf', exclude[i]);
    }

    var tmp = path.join(target, path.basename(options.source));
    var out = path.join(options.output, 'android-' + options.id);

    console.log('\nTransfering to output path ', out);

    if(!fs.existsSync(out)) {
        shell.mkdir('-p', out);
    }

    shell.cp('-r', tmp, out);
    shell.cp('-r',
        path.join(tmp, options.project, '*'),
        path.join(out, path.basename(source), options.project));
    shell.cp('-r',
        path.join(tmp, options.project, 'api', '*'),
        path.join(out, path.basename(source), options.project, 'api'));

    console.log('Modified project has been successfully transferred to ' + out);

    shell.rm('-rf', target);
};

module.exports = Android;
