#!/bin/sh

HOST="https://github.com/globelabs"
REPO="$(pwd)/repo"

git --work-tree="$REPO/globe-connect-android" --git-dir="$REPO/globe-connect-android/.git" pull origin master
git --work-tree="$REPO/globe-connect-ios" --git-dir="$REPO/globe-connect-ios/.git" pull origin master
git --work-tree="$REPO/globe-connect-phonegap" --git-dir="$REPO/globe-connect-phonegap/.git" pull origin master
git --work-tree="$REPO/globe-connect-react-native" --git-dir="$REPO/globe-connect-react-native/.git" pull origin master
