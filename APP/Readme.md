

## RUN ON BROWSER
ionic serve

## RUN ON DEVICE
# connect your Android Device via USB cable and execute
ionic cordova run android --device
ionic cordova run android --device --verbose

# CUSTOM SCRIPTS
npm run serve
# executes "ionic serve"

npm run android
# executes "ionic cordova run android --device --verbose"
# to launch APP on the connected android device

npm run serve-and-android
# to run both "ionic serve" and "ionic cordova run android --device --verbose"
