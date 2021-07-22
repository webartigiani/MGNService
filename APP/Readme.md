
### GETTING STARTED
  > Execute
    npm install

### ADD/REMOVE PLATFORMS
  > To add Android
    ionic cordova platform add android

  > To remove Android
    ionic cordova platform rm android

### EXECUTE APP ON BROWSER
ionic serve

### BUILD FOR PLATFORM
  ionic cordova build android
  
### EXECUTE APP ON DEVICE
  > connect your Android Device via USB cable and execute
  ionic cordova run android --device
  ionic cordova run android --device --verbose

### CUSTOM SCRIPTS
  npm run serve
  > executes "ionic serve"

  npm run android
  > executes "ionic cordova run android --device --verbose"
  > to launch APP on the connected android device

  npm run serve-and-android
  > to run both "ionic serve" and "ionic cordova run android --device --verbose"

### Automating Icons and Splash Screens
  > see https://ionicframework.com/blog/automating-icons-and-splash-screens/
  With the new CLI, all you need is a resource directory and two images. These images must be .png files named icon.png and splash.png. With the images in a resources directory, ./resources, the ionic cordova resources command will generate the icons and splash screen images locally for each platform setup in the project by using the cordova-res tool.

    npm install -g cordova-res
    or
    ionic cordova resources

  > Then run
    ionic cordova resources --icon
    ionic cordova resources --splash
