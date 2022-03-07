# MGNService - APP

## Installation
  '''
  npm install
  '''

## Add Android
  ionic cordova platform add android

## Remove Android
  ionic cordova platform rm android

## Build
  '''
  ionic cordova build android
  '''

## Run
  ### on Browser
  '''
  ionic serve
  or
  npm run serve
  '''


  ### on phisycal Device
  > connect your Android Device via USB cable and execute
  '''
  ionic cordova run android --device --verbose
  or
  npm run android
  '''

  npm run serve-and-android
  > to run both "ionic serve" and "ionic cordova run android --device --verbose"

## Automating Icons and Splash Screens
  > see https://ionicframework.com/blog/automating-icons-and-splash-screens/
  With the new CLI, all you need is a resource directory and two images. These images must be .png files named icon.png and splash.png. With the images in a resources directory, ./resources, the ionic cordova resources command will generate the icons and splash screen images locally for each platform setup in the project by using the cordova-res tool.

    npm install -g cordova-res
    or
    ionic cordova resources

  > Then run
    ionic cordova resources --icon
    ionic cordova resources --splash
