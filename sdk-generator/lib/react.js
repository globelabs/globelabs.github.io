var shell   = require('shelljs');
var fs      = require('fs');
var path    = require('path');
var xcode   = require('xcode');

//
// Generates an SDK for React
// based on the given parameters.
//
// This file is part of the Globe Labs SDK Builder.
//
// @author Charles Zamora <czamora@openovate.com>
//
var React = function(options) {
    // short hand initialization
    if(!(this instanceof React)) {
        return new React(options);
    }

    // default file names
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

    // android package
    var androidPackage = 'ph.com.globe.connect';
    // ios package
    var iosPackage     = 'GlobeConnect';

    // included files
    var include = [];
    // excluded files
    var exclude = [];

    // get root path
    var root    = path.normalize(__dirname + path.sep + '..');
    // get tmp path
    var tmp     = root + path.sep + 'tmp';
    // get target path
    var target  = path.join(tmp, options.id);

    // if folder does not exists, make it
    if(!fs.existsSync(tmp)) {
        shell.mkdir(tmp);
    }

    // if folder does not exists, make it
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

    // if source does not exists, exit
    if(!fs.existsSync(source)) {
        console.log('source does not exists.');
        return;
    }

    // copy required files
    shell.cp('-r', source, target);

    // remove unecessary files
    shell.rm('-rf', path.join(target, path.basename(source), '.git'));
    shell.rm('-rf', path.join(target, path.basename(source), 'instructions'));

    console.log('Files copied to ' + target);

    // get target files
    var files = options.files.split(',');

    // iterate on each target files
    for(var i in names) {
        // exclude file if not exists on target files
        if(files.indexOf(names[i]) === -1) {
            exclude.push(names[i]);
            continue;
        }

        // include files
        include.push(names[i]);
    }

    console.log('\nModifying react native java source.\n');

    // iterate on each excluded files
    for(var i in exclude) {
        // formulate path
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

        // remove it
        shell.rm('-rf', file);
    }

    // formulate java package
    var javaPackage = path.join(
        target,
        path.basename(source),
        'android',
        'src',
        'main',
        'java',
        androidPackage.split('.').join(path.sep),
        'GlobeConnectPackage.java');

    // read package file
    var readline = require('readline').createInterface({
        input: fs.createReadStream(javaPackage)
    });

    // collect lines
    var javaLines = [];

    // read each line
    readline.on('line', function (line) {
        // push each lines
        javaLines.push(line);
    });

    // set a slight timeout
    setTimeout(function() {
        // copy temp lines
        var tmp = javaLines;
        // set index
        var idx = 0;
        // get length
        var len = include.length;
        // separator
        var sep = ',';

        // iterate on each lines
        for(var i in tmp) {
            // initialization?
            if(tmp[i].indexOf('new') !== -1) {
                // if it's included
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

        // set modified package file
        var modified = [];

        // iterate on each lines
        for(var i in tmp) {
            // if it's not null
            if(tmp[i] != null) {
                // push modified line
                modified.push(tmp[i]);
            }
        }

        // write updated package file
        fs.writeFileSync(
            javaPackage,
            modified.join('\n')
        );
    }, 500);

    console.log('Modifying react native ios source. \n');

    console.log('Checking xcode project and xcode project pbx file.');

    // get xcode project path
    var xcodeProject = path.join(
        target,
        path.basename(options.source),
        'ios',
        iosPackage,
        [iosPackage, 'xcodeproj'].join('.'));

    // get xcode project pbx file
    var xcodePbx     = path.join(xcodeProject, ['project', 'pbxproj'].join('.'));

    console.log(xcodeProject);

    // if project or pbx does not exists
    if(!fs.existsSync(xcodeProject)
    || !fs.existsSync(xcodePbx)) {
        console.log('Either xcode project or xcode project pbx file does not exists.');
        return;
    }

    console.log('Parsing project pbx file.\n');

    // load project file
    var project = xcode.project(xcodePbx);

    // parse project file
    project.parse(function(err) {
        if(err) {
            console.log('An error occured while parsing project: ' + err);
            return;
        }

        // iterate on each excluded files
        for(var i in exclude) {
            // get basename
            var base    = path.basename(exclude[i]) + '.swift';
            // get bridge file
            var bridge  = path.basename(exclude[i]) + '-Bridge.m';

            console.log('Excluding source ' + base + ',' + bridge + ' from project.');

            // remove file
            project.removeSourceFile(base, null, iosPackage);
            // remove base file
            project.removeSourceFile(bridge, null, iosPackage);

            console.log('Removing physical file ' + exclude[i]);

            // get base file path
            base = path.join(
                target,
                path.basename(options.source),
                'ios',
                iosPackage,
                iosPackage,
                base);

            // get bridge file path
            bridge = path.join(
                target,
                path.basename(options.source),
                'ios',
                iosPackage,
                iosPackage,
                bridge);

            // remove base file
            shell.rm('-rf', base);
            // remove bridge file
            shell.rm('-rf', bridge);
        }

        console.log('\nWriting project pbx file.');

        // write updated pbx file
        fs.writeFileSync(xcodePbx, project.writeSync());

        console.log('Project pbx file written.');
    });

    console.log('\nModifying base javascript file.');

    // read index plugin file
    var lineReader = require('readline').createInterface({
        input: fs.createReadStream(path.join(target, path.basename(source), 'GlobeConnect.js'))
    });

    // file lines
    var lines = [];

    // read on each line
    lineReader.on('line', function (line) {
        // and push it
        lines.push(line);
    });

    // add slight timeout
    setTimeout(function() {
        // copy lines
        var tmp = lines;

        // remove first two lines
        tmp.shift();
        tmp.shift();

        // evaluate string
        var obj = eval(tmp.join('\n'));

        // delete each excluded files
        for(var i in exclude) {
            delete obj[exclude[i]];
        }

        // format each object
        for(var i in obj) {
            obj[i] = obj[i].toString();
        }

        // set base file
        var base = [];

        // push header
        base.push('import { NativeModules } from \'react-native\';');
        base.push('');
        base.push('module.exports = {');

        // get included files length
        var len = include.length;
        // set index
        var idx = 0;

        // iterate on each object
        for(var i in obj) {
            // if we still have to push
            if(++idx != len) {
                // push line
                base.push('    ' + i + ' : ' + obj[i] + ',');
            } else {
                // push line
                base.push('    ' + i + ' : ' + obj[i]);
            }
        }

        // set terminator
        base.push('};');

        // write updated index file
        fs.writeFileSync(
            path.join(target, path.basename(source), 'GlobeConnect.js'),
            base.join('\n')
        );

        console.log('Base javascript file has been successfully modified.\n');

        // get tmp path
        var tmp = path.join(target, path.basename(options.source));
        // get output path
        var out = path.join(options.output, 'react-' + options.id);

        console.log('\nTransfering to output path ', out);

        // if output path does not exists
        if(!fs.existsSync(out)) {
            // make it
            shell.mkdir('-p', out);
        }

        // copy tmp to output
        shell.cp('-r', tmp, out);

        console.log('Modified project has been successfully transferred to ' + out);

        // remove tmp target
        shell.rm('-rf', target);
    }, 500);
};

module.exports = React;
