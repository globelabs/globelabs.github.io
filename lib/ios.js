var xcode = require('xcode');
var shell = require('shelljs');
var fs    = require('fs');
var path  = require('path');

var Ios = function(options) {
    if(!(this instanceof Ios)) {
        return new Ios(options);
    }

    var defaults = [
        'ConnectIOSAmax.swift',
        'ConnectIOSAuthenticate.swift',
        'ConnectIOSLocationQuery.swift',
        'ConnectIOSPayment.swift',
        'ConnectIOSSms.swift',
        'ConnectIOSSubscriber.swift',
        'ConnectIOSUssd.swift'
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

    shell.rm('-rf', path.join(target, path.basename(source), '.git'));

    console.log('Files copied to ' + target);

    var files  = options.files.split(',');

    console.log('Checking source in project ' + options.project + '\n');

    var projectRoot = path.join(target, path.basename(options.source), options.project);

    for(var i in files) {
        var file = path.join(projectRoot, files[i]);

        if(!fs.existsSync(file)) {
            console.log(file + ' does not exists, skipping...');
            continue;
        }

        for(var k in defaults) {
            var def = path.join(projectRoot, defaults[k]);

            if(def == file) {
                console.log('Including file ' + file);

                include.push(file);

                continue;
            }
        }
    }

    for(var i in defaults) {
        var def = path.join(projectRoot, defaults[i]);

        if(include.indexOf(def) == -1) {
            console.log('Excluding file ' + def);

            exclude.push(def);
        }
    }

    console.log('\nChecking xcode project and xcode project pbx file.');

    var xcodeProject = path.join(target, path.basename(options.source), [options.project, 'xcodeproj'].join('.'));
    var xcodePbx     = path.join(xcodeProject, ['project', 'pbxproj'].join('.'));

    if(!fs.existsSync(xcodeProject)
    || !fs.existsSync(xcodePbx)) {
        console.log('Either xcode project or xcode project pbx file does not exists.');
    }

    console.log('Parsing project pbx file.\n');

    var project = xcode.project(xcodePbx);

    project.parse(function(err) {
        if(err) {
            console.log('An error occured while parsing project: ' + err);
            return;
        }

        for(var i in exclude) {
            var base = path.basename(exclude[i]);

            console.log('Excluding source ' + base + ' from project.');

            project.removeSourceFile(base, null, options.project);

            console.log('Removing physical file ' + exclude[i]);

            shell.rm('-rf', exclude[i]);
        }

        console.log('');

        for(var i in exclude) {
            var file = exclude[i].substring(0, exclude[i].lastIndexOf('.')) + 'Tests';

            file = file + path.extname(exclude[i]);

            var base = path.basename(file);
            var test = options.project + 'Tests';

            console.log('Trying to exclude source ' + base + ' from project tests group.');

            try {
                project.removeSourceFile(base, null, test);

                console.log(base + ' excluded from project test group.');

                file = exclude[i].substring(0, exclude[i].lastIndexOf(path.sep)) + 'Tests/';
                file = file + base;

                console.log('Removing physical file ' + file);

                shell.rm('-rf', file);
            } catch(e) { console.log(e); };
        }

        console.log('\nWriting project pbx file.');

        fs.writeFileSync(xcodePbx, project.writeSync());

        console.log('Project pbx file written.');
        console.log('Transfering to output path ' + options.output);

        var tmp = path.join(target, path.basename(options.source));
        var out = path.join(options.output, 'ios-' + options.id);

        if(!fs.existsSync(out)) {
            shell.mkdir('-p', out);
        }

        shell.cp('-r', tmp, out);

        console.log('Modified project has been successfully transferred to ' + out);

        shell.rm('-rf', target);
    });
};

module.exports = Ios;
