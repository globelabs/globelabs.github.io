#!/bin/sh

HOST="https://github.com/globelabs"
REPO="$(pwd)/repo"
ANDROID="$HOST/globe-connect-android"
IOS="$HOST/globe-connect-ios"
PHONEGAP="$HOST/globe-connect-phonegap"
REACT="$HOST/globe-connect-react-native"

if [ ! -d "$REPO" ]; then
    mkdir $REPO
fi

git clone $ANDROID "$REPO/globe-connect-android"
git clone $IOS "$REPO/globe-connect-ios"
git clone $PHONEGAP "$REPO/globe-connect-phonegap"
git clone $REACT "$REPO/globe-connect-react-native"
