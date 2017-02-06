#!/bin/sh

# get host
HOST="https://github.com/globelabs"
# get repo path
REPO="$(pwd)/repo"

# update android
git --work-tree="$REPO/globe-connect-android" --git-dir="$REPO/globe-connect-android/.git" pull origin master
# update ios
git --work-tree="$REPO/globe-connect-ios" --git-dir="$REPO/globe-connect-ios/.git" pull origin master
# update phonegap
git --work-tree="$REPO/globe-connect-phonegap" --git-dir="$REPO/globe-connect-phonegap/.git" pull origin master
# update react native
git --work-tree="$REPO/globe-connect-react-native" --git-dir="$REPO/globe-connect-react-native/.git" pull origin master
