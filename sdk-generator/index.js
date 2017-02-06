var yargs = require('yargs');

// initial argument helper
yargs.usage('Usage: $0 <command> [args]')
    .command('ios', 'send an sms to the given subscriber / MSISDN number.')
    .command('android', 'send a binary sms to the given subscruber / MSISDN number.')
    .command('react', 'get the subscribers location.')
    .command('phonegap', 'charge the given subscriber with the given amount.')
    .option('verbose', {
        describe : 'enable verbose logging.'
    })
    .option('help', {
        alias : 'h',
        describe : 'show list of available commands.'
    })
    .epilog('Globe Labs - Copyright 2016 - https://developer.globelabs.com.ph');

// parse arguments
var argv = yargs.argv;

// do we have arguments?
if(argv._.length == 0) {
    // show help
    yargs.showHelp();

    return;
}

// show help argument?
if(argv.h || argv.help) {
    // show help
    yargs.showHelp();

    return;
}

// get the command
var command = argv._.shift();
// command options
var options = null;

// switch between commands
switch(command) {
    // ios?
    case 'ios' :
        // set ios options
        options = require('yargs')
        .usage('Usage: $0 ios [args]')
        .option('i', {
            alias       : 'id',
            type        : 'string',
            demand      : true,
            describe    : 'unique identifier for the build output.'
        })
        .option('f', {
            alias       : 'files',
            type        : 'string',
            demand      : true,
            describe    : 'files to be included in the sdk separated by comma.'
        })
        .option('s', {
            alias       : 'source',
            type        : 'string',
            demand      : true,
            describe    : 'sdk source root source folder.'
        })
        .option('p', {
            alias       : 'project',
            type        : 'string',
            demand      : true,
            describe    : 'sdk project name.'
        })
        .option('o', {
            alias       : 'output',
            type        : 'string',
            demand      : true,
            describe    : 'sdk output path.'
        })
        .help('h', 'show list of available options.')
        .alias('h', 'help')
        .argv;

        break;

    // android?
    case 'android' :
        // set android options
        options = require('yargs')
        .usage('Usage: $0 android [args]')
        .option('i', {
            alias       : 'id',
            type        : 'string',
            demand      : true,
            describe    : 'unique identifier for the build output.'
        })
        .option('f', {
            alias       : 'files',
            type        : 'string',
            demand      : true,
            describe    : 'files to be included in the sdk separated by comma.'
        })
        .option('s', {
            alias       : 'source',
            type        : 'string',
            demand      : true,
            describe    : 'sdk source root source folder.'
        })
        .option('p', {
            alias       : 'project',
            type        : 'string',
            demand      : true,
            describe    : 'sdk project name.'
        })
        .option('n', {
            alias       : 'namespace',
            type        : 'string',
            demand      : true,
            describe    : 'sdk project namespace / package.'
        })
        .option('o', {
            alias       : 'output',
            type        : 'string',
            demand      : true,
            describe    : 'sdk output path.'
        })
        .help('h', 'show list of available options.')
        .alias('h', 'help')
        .argv;

        break;

    // phonegap?
    case 'phonegap' :
        // set phonegap options
        options = require('yargs')
        .usage('Usage: $0 phonegap [args]')
        .option('i', {
            alias       : 'id',
            type        : 'string',
            demand      : true,
            describe    : 'unique identifier for the build output.'
        })
        .option('f', {
            alias       : 'files',
            type        : 'string',
            demand      : true,
            describe    : 'files to be included in the sdk separated by comma.'
        })
        .option('s', {
            alias       : 'source',
            type        : 'string',
            demand      : true,
            describe    : 'sdk source root source folder.'
        })
        .option('o', {
            alias       : 'output',
            type        : 'string',
            demand      : true,
            describe    : 'sdk output path.'
        })
        .help('h', 'show list of available options.')
        .alias('h', 'help')
        .argv;

        break;

    // react?
    case 'react' :
        // set react options
        options = require('yargs')
        .usage('Usage: $0 react [args]')
        .option('i', {
            alias       : 'id',
            type        : 'string',
            demand      : true,
            describe    : 'unique identifier for the build output.'
        })
        .option('f', {
            alias       : 'files',
            type        : 'string',
            demand      : true,
            describe    : 'files to be included in the sdk separated by comma.'
        })
        .option('s', {
            alias       : 'source',
            type        : 'string',
            demand      : true,
            describe    : 'sdk source root source folder.'
        })
        .option('o', {
            alias       : 'output',
            type        : 'string',
            demand      : true,
            describe    : 'sdk output path.'
        })
        .help('h', 'show list of available options.')
        .alias('h', 'help')
        .argv;

        break;
    default :
        yargs.showHelp();

        return;
}

// build the path
var action = require('./lib/' + command);

// execute action
action(options);
