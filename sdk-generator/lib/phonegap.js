var shell   = require('shelljs');
var fs      = require('fs');
var path    = require('path');
var convert = require('xml-js');

//
// Generates an SDK for Phonegap
// based on the given parameters.
//
// This file is part of the Globe Labs SDK Builder.
//
// @author Charles Zamora <czamora@openovate.com>
//
var Phonegap = function(options) {
    // short hand initialization
    if(!(this instanceof Phonegap)) {
        return new Phonegap(options);
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

    // files to include
    var include = [];
    // files to exclude
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

    // get source path
    var source = path.normalize(options.source);

    // format source path
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

    // remove unnecessary files
    shell.rm('-rf', path.join(target, path.basename(source), '.git'));
    shell.rm('-rf', path.join(target, path.basename(source), 'nbproject'));
    shell.rm('-rf', path.join(target, path.basename(source), 'instructions'));

    console.log('Files copied to ' + target);

    // get root path
    var root    = path.join(target, path.basename(source));
    // get plugin file path
    var plugin  = path.join(root, 'plugin.xml');

    // if plugin file does not exists, exit
    if(!fs.existsSync(plugin)) {
        console.log('plugin.xml does not exists.');
        return;
    }

    console.log('Reading plugin.xml');

    // read xml data
    var xml = fs.readFileSync(plugin, 'utf8');
    // convert options
    var opt = { ignoreText : true, alwaysChildren: true };

    // convert xml to json
    xml = convert.xml2js(xml, opt);

    // get the target files
    var files  = options.files.split(',');

    // iterate on each names
    for(var i in names) {
        // if files does not exists
        if(files.indexOf(names[i]) === -1) {
            // exclude it
            exclude.push(names[i]);
        }
    }

    console.log('');

    // iterate on each excluded files
    for(var i in exclude) {
        // iterate on each elements
        for(var k in xml.elements[0].elements) {
            // js module element?
            if(xml.elements[0].elements[k].name === 'js-module') {
                // exclude file?
                if(xml.elements[0].elements[k].attributes.name == exclude[i]) {
                    console.log('Removing js file ' + path.join(root, 'www', exclude[i] + '.js'));

                    // remove it physically
                    shell.rm('-rf', path.join(root, 'www', exclude[i] + '.js'));

                    // remove from js modules
                    delete xml.elements[0].elements[k];
                    continue;
                }
            }

            // platform element?
            if('name' in xml.elements[0].elements[k]
            && xml.elements[0].elements[k].name === 'platform'
            && xml.elements[0].elements[k].attributes.name === 'android') {
                // get platform elements
                var platform = xml.elements[0].elements[k].elements;

                // iterate on each platform
                for(var x in platform) {
                    // config file element?
                    if(platform[x].name === 'config-file') {
                        // iterate on each config file elements
                        for(var y in platform[x].elements) {
                            // if it's excluded
                            if(platform[x].elements[y].attributes.name == exclude[i]) {
                                // remove that element
                                delete platform[x].elements[y];
                            }
                        }
                    }

                    // is it a source file attribute?
                    if(platform[x].name === 'source-file') {
                        // is it excluded?
                        if(platform[x].attributes.src == path.join('src/android', exclude[i] + '.java')) {
                            console.log('Removing java source file ' + path.join(root, 'src/android', exclude[i] + '.java'));

                            // remove physical file
                            shell.rm('-rf', path.join(root, 'src/android', exclude[i] + '.java'));

                            // delete element
                            delete platform[x];
                        }
                    }
                }
            }

            // platform element?
            if('name' in xml.elements[0].elements[k]
            && xml.elements[0].elements[k].name === 'platform'
            && xml.elements[0].elements[k].attributes.name === 'ios') {
                // get platform elements
                var platform = xml.elements[0].elements[k].elements;

                // iterate on each platform elements
                for(var x in platform) {
                    // is it a config file?
                    if(platform[x].name === 'config-file') {
                        // iterate on each config file
                        for(var y in platform[x].elements) {
                            // is it excluded?
                            if(platform[x].elements[y].attributes.name == exclude[i]) {
                                // remove element
                                delete platform[x].elements[y];
                            }
                        }
                    }

                    // is it a source file?
                    if(platform[x].name === 'source-file') {
                        // is it excluded?
                        if(platform[x].attributes.src == path.join('src/ios', exclude[i] + '.swift')) {
                            console.log('Removing ios source file ' + path.join(root, 'src/ios', exclude[i] + '.swift'));

                            // remove physical file
                            shell.rm('-rf', path.join(root, 'src/ios', exclude[i] + '.swift'));

                            // remove element
                            delete platform[x];
                        }
                    }
                }
            }
        }
    }

    // convert options
    var opt = { ignoreText : true, spaces : 4 };
    // convert json to xml
    xml = convert.json2xml(xml, opt);

    console.log('\nWriting modified plugin.xml.');
    console.log('Modified plugin.xml successfully written.');

    // update plugin.xml
    fs.writeFileSync(plugin, xml);

    // get tmp folder
    var tmp = path.join(target, path.basename(options.source));
    // get output folder
    var out = path.join(options.output, 'phonegap-' + options.id);

    // if output folder does not exists
    if(!fs.existsSync(out)) {
        // make it
        shell.mkdir('-p', out);
    }

    // copy tmp to output
    shell.cp('-r', tmp, out);

    console.log('Modified project has been successfully transferred to ' + out);

    // remove temp target
    shell.rm('-rf', target);
};

module.exports = Phonegap;
