var shell   = require('shelljs');
var fs      = require('fs');
var path    = require('path');
var xcode   = require('xcode');

var React = function(options) {
    if(!(this instanceof React)) {
        return new React(options);
    }

    var names = [
        'Amax',
        'Authentication',
        'BinarySms',
        'Location',
        'Payment',
        'Sms',
        'Subscriber',
        'Ussd'
    ];

    var androidPackage = 'ph.com.globe.connect';
    var iosPackage     = 'GlobeConnect';

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

    var files = options.files.split(',');

    for(var i in names) {
        if(files.indexOf(names[i]) === -1) {
            exclude.push(names[i]);
            continue;
        }

        include.push(names[i]);
    }

    console.log('\nModifying react native java source.\n');

    for(var i in exclude) {
        var file = path.join(
            target,
            path.basename(source),
            'android',
            'src',
            'main',
            'java',
            androidPackage.split('.').join(path.sep),
            exclude[i] + '.java');

        console.log('Removing physical file ' + file);
        shell.rm('-rf', file);
    }

    var javaPackage = path.join(
        target,
        path.basename(source),
        'android',
        'src',
        'main',
        'java',
        androidPackage.split('.').join(path.sep),
        'GlobeConnectPackage.java');

    var readline = require('readline').createInterface({
        input: fs.createReadStream(javaPackage)
    });

    var javaLines = [];

    readline.on('line', function (line) {
        javaLines.push(line);
    });

    setTimeout(function() {
        var tmp = javaLines;
        var idx = 0;
        var len = include.length;
        var sep = ',';

        for(var i in tmp) {
            if(tmp[i].indexOf('new') !== -1) {
                if(include[idx]) {
                    if(idx == len - 1) {
                        sep = '';
                    }

                    tmp[i] = '            new ' + include[idx] + '(reactContext)' + sep;

                    idx++;
                } else {
                    tmp[i] = null;
                    continue;
                }
            }
        }

        var modified = [];

        for(var i in tmp) {
            if(tmp[i] != null) {
                modified.push(tmp[i]);
            }
        }

        fs.writeFileSync(
            javaPackage,
            modified.join('\n')
        );
    }, 500);

    console.log('Modifying react native ios source. \n');

    console.log('Checking xcode project and xcode project pbx file.');

    var xcodeProject = path.join(
        target,
        path.basename(options.source),
        'ios',
        iosPackage,
        [iosPackage, 'xcodeproj'].join('.'));
    var xcodePbx     = path.join(xcodeProject, ['project', 'pbxproj'].join('.'));

    console.log(xcodeProject);

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
            var base    = path.basename(exclude[i]) + '.swift';
            var bridge  = path.basename(exclude[i]) + '-Bridge.m';

            console.log('Excluding source ' + base + ',' + bridge + ' from project.');

            project.removeSourceFile(base, null, iosPackage);
            project.removeSourceFile(bridge, null, iosPackage);

            console.log('Removing physical file ' + exclude[i]);

            base = path.join(
                target,
                path.basename(options.source),
                'ios',
                iosPackage,
                iosPackage,
                base);

            bridge = path.join(
                target,
                path.basename(options.source),
                'ios',
                iosPackage,
                iosPackage,
                bridge);

            shell.rm('-rf', base);
            shell.rm('-rf', bridge);
        }

        console.log('\nWriting project pbx file.');

        fs.writeFileSync(xcodePbx, project.writeSync());

        console.log('Project pbx file written.');
    });

    console.log('\nModifying base javascript file.');

    var lineReader = require('readline').createInterface({
        input: fs.createReadStream(path.join(target, path.basename(source), 'GlobeConnect.js'))
    });

    var lines = [];

    lineReader.on('line', function (line) {
        lines.push(line);
    });

    setTimeout(function() {
        var tmp = lines;

        tmp.shift();
        tmp.shift();

        var obj = eval(tmp.join('\n'));

        for(var i in exclude) {
            delete obj[exclude[i]];
        }

        for(var i in obj) {
            obj[i] = obj[i].toString();
        }

        var base = [];

        base.push('import { NativeModules } from \'react-native\';');
        base.push('');
        base.push('module.exports = {');

        var len = include.length;
        var idx = 0;

        for(var i in obj) {
            if(++idx != len) {
                base.push('    ' + i + ' : ' + obj[i] + ',');
            } else {
                base.push('    ' + i + ' : ' + obj[i]);
            }
        }

        base.push('};');

        fs.writeFileSync(
            path.join(target, path.basename(source), 'GlobeConnect.js'),
            base.join('\n')
        );

        console.log('Base javascript file has been successfully modified.\n');

        var tmp = path.join(target, path.basename(options.source));
        var out = path.join(options.output, 'react-' + options.id);

        console.log('\nTransfering to output path ', out);

        if(!fs.existsSync(out)) {
            shell.mkdir('-p', out);
        }

        shell.cp('-r', tmp, out);

        console.log('Modified project has been successfully transferred to ' + out);

        shell.rm('-rf', target);
    }, 500);
};

module.exports = React;
