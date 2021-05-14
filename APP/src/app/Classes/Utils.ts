/*
  UtilsService Class
  interacts with http://gestionale.mgnservice.it/ APIs

  USAGE:
    > in your "component" TS
      import {UtilsService} from "../Classes/Utils";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          UtilsService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";
import { environment } from "src/environments/environment";

// Platform
// see: https://ionicframework.com/docs/angular/platform
import { Platform } from '@ionic/angular';

// Device
// see https://ionicframework.com/docs/v3/native/device/
// NOTES: requires  npm install --save @ionic-native/device@latest
import { Device } from '@ionic-native/device/ngx';

// Network
// see  https://ionicframework.com/docs/native/network
import { Network } from '@ionic-native/network/ngx';

// ScreenOrientation
// see https://ionicframework.com/docs/native/screen-orientation
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

/* NOT USED UniqueDeviceID
// see https://ionicframework.com/docs/native/unique-device-id
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';
*/

@Injectable()
export class UtilsService {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
      private platform: Platform,
      private device: Device,
      private network: Network,
      private screenOrientation: ScreenOrientation,
      /*
      private uniqueDeviceID: UniqueDeviceID,
      private uid: Uid,
      private androidPermissions: AndroidPermissions,
      */
   ) {
      // constructor...

      // Lock screen orientation and listen for screen-orientation changes
      this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.PORTRAIT_PRIMARY)
      this.screenOrientation.onChange().subscribe(
        () => {
            console.log('Orientation Changed', this.screenOrientation.type)
        }
      );
   }
  // #endregion Constructors


   // #region Public Methods
   isDebug() {
     // returns true if App is running on local webbrowser
     return (!this.platform.is('cordova'))
   }

   platformIs(platform) {
    // returns true if the platform is the one specified
    return (this.platform.is(platform))
   }

   getDeviceData() {
    // returns a full device-data object
    // NOTE: uuid is calculated by constructor

    let ret = {}

    if (this.isDebug()) {
      // running on webbrowser: creates dummy device data
      ret = {
        'platform': 'browser',
        'version': '0.0.0',
        'model': 'model',
        'manufacturer': 'manufacturer',
        'isVirtual': false,
        'serial': 'unknown',
        'uuid': 'debug_browser',
        'connection_type': 'ethernet'
      }
    } else {
      // running on device: returns device data
      ret = {
        'platform': this.device.platform,
        'version': this.device.version,
        'model': this.device.model,
        'manufacturer': this.device.manufacturer,
        'isVirtual': this.device.isVirtual,
        'serial': this.device.serial,
        'uuid': this.device.uuid,
        'connection_type': this.network.type.toLocaleLowerCase()
      }
    }
    console.log('getDeviceData()', ret)
    return ret
   }

  isDeviceOnLine() {
      // returns true if the device is online
      if (this.isDebug())
        return true
      else
        return (this.network.type.toLocaleLowerCase() !== 'none')
  }

   deviceConnectionType() {
     if (this.isDebug())
       return 'wifi'
     else
      return this.network.type.toLocaleLowerCase()
   }
   openMapByAPP(latitude: any, longitude: any) {
     // open the Map APP (depending on the platform)
     // pointing to the specified coords

      // Android: geo:41.1954148,16.6165038
      // iOS:     maps://maps.apple.com/?q=41.1954148,16.6165038
      let url = '';

      if (this.platform.is('android')) {
        url = 'geo:' + latitude + ',' + longitude
      }
      if (this.platform.is('ios')) {
        // Note: this links also works on iOS Mobile
        url = 'maps://maps.apple.com/?q=' + latitude + ',' + longitude
      }
      if (url != '') url = 'https://www.google.it/maps/@' + latitude + ',' + longitude + ',15z'
      window.open(url)
   }
   //#endregion Public Methods
}
