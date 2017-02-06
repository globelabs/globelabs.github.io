var xcode = require('xcode');
var shell = require('shelljs');
var fs    = require('fs');
var path  = require('path');

//
// Generates an SDK for iOS
// based on the given parameters.
//
// This file is part of the Globe Labs SDK Builder.
//
// @author Charles Zamora <czamora@openovate.com>
//
var Ios = function(options) {
    // short hand initialization
    if(!(this instanceof Ios)) {
        return new Ios(options);
    }

    // default files
    var defaults = [
        'ConnectIOSAmax.swift',
        'ConnectIOSAuthenticate.swift',
        'ConnectIOSLocationQuery.swift',
        'ConnectIOSPayment.swift',
        'ConnectIOSSms.swift',
        'ConnectIOSSubscriber.swift',
        'ConnectIOSUssd.swift'
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

    // if folder does not exists, create it
    if(!fs.existsSync(tmp)) {
        shell.mkdir(tmp);
    }

    // if folder does not exists, create it
    if(!fs.existsSync(target)) {
        shell.mkdir(target);
    }

    // get the source folder
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

    // copy all the files
    shell.cp('-r', source, target);

    // remove unnecessary files
    shell.rm('-rf', path.join(target, path.basename(source), '.git'));

    console.log('Files copied to ' + target);

    // get the target files
    var files  = options.files.split(',');

    console.log('Checking source in project ' + options.project + '\n');

    // get the project root
    var projectRoot = path.join(target, path.basename(options.source), options.project);

    // iterate on each files
    for(var i in files) {
        // formulate file path
        var file = path.join(projectRoot, files[i]);

        // if file does not exists, skip it
        if(!fs.existsSync(file)) {
            console.log(file + ' does not exists, skipping...');
            continue;
        }

        // iterate on each default files
        for(var k in defaults) {
            // formulate file path
            var def = path.join(projectRoot, defaults[k]);

            // if file exists
            if(def == file) {
                console.log('Including file ' + file);

                // include it
                include.push(file);

                continue;
            }
        }
    }

    // iterate on each default files
    for(var i in defaults) {
        // formulate file path
        var def = path.join(projectRoot, defaults[i]);

        // if it's not included
        if(include.indexOf(def) == -1) {
            console.log('Excluding file ' + def);

            // add it to exluded files
            exclude.push(def);
        }
    }

    console.log('\nChecking xcode project and xcode project pbx file.');

    // get xcode project folder
    var xcodeProject = path.join(target, path.basename(options.source), [options.project, 'xcodeproj'].join('.'));
    // get xcode project pbx file
    var xcodePbx     = path.join(xcodeProject, ['project', 'pbxproj'].join('.'));

    // if any of the files does not exists, exit
    if(!fs.existsSync(xcodeProject)
    || !fs.existsSync(xcodePbx)) {
        console.log('Either xcode project or xcode project pbx file does not exists.');

        return;
    }

    console.log('Parsing project pbx file.\n');

    // load xcode project
    var project = xcode.project(xcodePbx);

    project.parse(function(err) {
        if(err) {
            console.log('An error occured while parsing project: ' + JSON.stringify(err));
            return;
        }

        // iterate on each excluded files
        for(var i in exclude) {
            // formulate base name
            var base = path.basename(exclude[i]);

            console.log('Excluding source ' + base + ' from project.');

            // remove that on source files
            project.removeSourceFile(base, null, options.project);

            console.log('Removing physical file ' + exclude[i]);

            // remove physical file
            shell.rm('-rf', exclude[i]);
        }

        console.log('');

        // iterate on each exluded files
        for(var i in exclude) {
            // formulate file path
            var file = exclude[i].substring(0, exclude[i].lastIndexOf('.')) + 'Tests';

            // get the file + extension
            file = file + path.extname(exclude[i]);

            // get base file
            var base = path.basename(file);
            // formulate test path
            var test = options.project + 'Tests';

            console.log('Trying to exclude source ' + base + ' from project tests group.');

            // try
            try {
                // exclude test files
                project.removeSourceFile(base, null, test);

                console.log(base + ' excluded from project test group.');

                // formulate path
                file = exclude[i].substring(0, exclude[i].lastIndexOf(path.sep)) + 'Tests/';
                file = file + base;

                console.log('Removing physical file ' + file);

                // remove physical file
                shell.rm('-rf', file);
            } catch(e) { console.log(e); };
        }

        console.log('\nWriting project pbx file.');

        // update xcode pbx file
        fs.writeFileSync(xcodePbx, project.writeSync());

        console.log('Project pbx file written.');
        console.log('Transfering to output path ' + options.output);

        // get tmp folder
        var tmp = path.join(target, path.basename(options.source));
        // get output folder
        var out = path.join(options.output, 'ios-' + options.id);

        // if output folder does not exists
        if(!fs.existsSync(out)) {
            // make it
            shell.mkdir('-p', out);
        }

        // copy from tmp to out
        shell.cp('-r', tmp, out);

        console.log('Modified project has been successfully transferred to ' + out);

        // remove tmp target
        shell.rm('-rf', target);
    });
};

module.exports = Ios;
