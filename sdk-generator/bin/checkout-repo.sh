#!/bin/sh

# root hosts
HOST="https://github.com/globelabs"
# repo path
REPO="$(pwd)/repo"
# android url
ANDROID="$HOST/globe-connect-android"
# ios url
IOS="$HOST/globe-connect-ios"
# phonegap url
PHONEGAP="$HOST/globe-connect-phonegap"
# react url
REACT="$HOST/globe-connect-react-native"

# if repo folder does not exists
if [ ! -d "$REPO" ]; then
    # make it
    mkdir $REPO
fi

# clone android to the given path
git clone $ANDROID "$REPO/globe-connect-android"
# clone ios to the given path
git clone $IOS "$REPO/globe-connect-ios"
# clone phonegap to the given path
git clone $PHONEGAP "$REPO/globe-connect-phonegap"
# clone react to the given path
git clone $REACT "$REPO/globe-connect-react-native"
