var shell   = require('shelljs');
var fs      = require('fs');
var path    = require('path');
var convert = require('xml-js');

var Phonegap = function(options) {
    if(!(this instanceof Phonegap)) {
        return new Phonegap(options);
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

    shell.rm('-rf', path.join(target, path.basename(source), 'nbproject'));

    console.log('Files copied to ' + target);

    var root    = path.join(target, path.basename(source));
    var plugin  = path.join(root, 'plugin.xml');

    if(!fs.existsSync(plugin)) {
        console.log('plugin.xml does not exists.');
        return;
    }

    console.log('Reading plugin.xml');

    var xml = fs.readFileSync(plugin, 'utf8');
    var opt = { ignoreText : true, alwaysChildren: true };

    xml = convert.xml2js(xml, opt);

    var files  = options.files.split(',');

    var exclude = [];

    for(var i in names) {
        if(files.indexOf(names[i]) === -1) {
            exclude.push(names[i]);
        }
    }

    console.log('');

    for(var i in exclude) {
        for(var k in xml.elements[0].elements) {
            if(xml.elements[0].elements[k].name === 'js-module') {
                if(xml.elements[0].elements[k].attributes.name == exclude[i]) {
                    console.log('Removing js file ' + path.join(root, 'www', exclude[i] + '.js'));

                    shell.rm('-rf', path.join(root, 'www', exclude[i] + '.js'));

                    delete xml.elements[0].elements[k];
                    continue;
                }
            }

            if('name' in xml.elements[0].elements[k]
            && xml.elements[0].elements[k].name === 'platform'
            && xml.elements[0].elements[k].attributes.name === 'android') {
                var platform = xml.elements[0].elements[k].elements;

                for(var x in platform) {
                    if(platform[x].name === 'config-file') {
                        for(var y in platform[x].elements) {
                            if(platform[x].elements[y].attributes.name == exclude[i]) {
                                delete platform[x].elements[y];
                            }
                        }
                    }

                    if(platform[x].name === 'source-file') {
                        if(platform[x].attributes.src == path.join('src/android', exclude[i] + '.java')) {
                            console.log('Removing java source file ' + path.join(root, 'src/android', exclude[i] + '.java'));

                            shell.rm('-rf', path.join(root, 'src/android', exclude[i] + '.java'));

                            delete platform[x];
                        }
                    }
                }
            }

            if('name' in xml.elements[0].elements[k]
            && xml.elements[0].elements[k].name === 'platform'
            && xml.elements[0].elements[k].attributes.name === 'ios') {
                var platform = xml.elements[0].elements[k].elements;

                for(var x in platform) {
                    if(platform[x].name === 'config-file') {
                        for(var y in platform[x].elements) {
                            if(platform[x].elements[y].attributes.name == exclude[i]) {
                                delete platform[x].elements[y];
                            }
                        }
                    }

                    if(platform[x].name === 'source-file') {
                        if(platform[x].attributes.src == path.join('src/ios', exclude[i] + '.swift')) {
                            console.log('Removing ios source file ' + path.join(root, 'src/ios', exclude[i] + '.swift'));

                            shell.rm('-rf', path.join(root, 'src/ios', exclude[i] + '.swift'));

                            delete platform[x];
                        }
                    }
                }
            }
        }
    }

    var opt = { ignoreText : true, spaces : 4 };
    xml = convert.json2xml(xml, opt);

    console.log('\nWriting modified plugin.xml.');
    console.log('Modified plugin.xml successfully written.');

    fs.writeFileSync(plugin, xml);

    var tmp = path.join(target, path.basename(options.source));
    var out = path.join(options.output, 'phonegap-' + options.id);

    if(!fs.existsSync(out)) {
        shell.mkdir('-p', out);
    }

    shell.cp('-r', tmp, out);

    console.log('Modified project has been successfully transferred to ' + out);

    shell.rm('-rf', target);
};

module.exports = Phonegap;
