/*
  GeoLocationService Class
  implements geo-location functions

  USAGE:
    > in your "component" TS
      import {GeoLocationService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: GeoLocationService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          GeoLocationService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";

import { NgZone } from '@angular/core';

// GeoLocation and GeoCoder
import { Geolocation } from '@ionic-native/geolocation/ngx';
import { NativeGeocoder, NativeGeocoderResult, NativeGeocoderOptions } from '@ionic-native/native-geocoder/ngx';
import { environment } from "src/environments/environment";

@Injectable()
export class GeoLocationService {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
    private geolocation: Geolocation,
    private nativeGeocoder: NativeGeocoder,
   ) {
      // constructor...
   }
  // #endregion Constructors

    // #region Public Methods
    async checkService(): Promise<any> {
      /**
       * checks Geolocation service
       */
      return new Promise((resolve, reject) => {
        this.geolocation.getCurrentPosition(this.getOptions())
        .then((data) => {
          // result
          resolve(this.envelopeData(data))
        }).catch((error) => {
          /* error
              possible errors
                {code: 1, message: "User denied Geolocation"}       // on WebBrowser
                {code: 1, message: "Illegal Access"}                // on Android
                {code: 2, message: "Network location provider at 'https://www.googleapis.com/' : No response received."}
                {code: 3, message: "Timeout expired"}
          */
          reject(error)
        })
      })
    }

    async locate(): Promise<any> {
      /**
        * geo-locate the device
        */
      return new Promise((resolve, reject) => {
        this.geolocation.getCurrentPosition(this.getOptions())
          .then((data) => {
            // getCurrentPosition result
            // es: 41.1954148 16.6165038

            if (data.timestamp > 0) {
              resolve(this.envelopeData(data))
            } else {
              // location is empty
            }
          }).catch((error) => {
            reject(error)
          })
      })
    }
    // #endregion Public Methods

    // #region Private Methods
    private getOptions() {
      // envelope geolocation options
      let ret = {
        timeout: (environment.LOCATION_TIMEOUT * 1000),
        enableHighAccuracy: true,
        maximumAge: 0                                       // no cached position
      }
      return ret
    }
    private envelopeData(data: any) {
      // evenlope getCurrentPosition result

      let ret
      if (data.timestamp > 0) {
        ret = {
          "latitude": data.coords.latitude,
          "longitude": data.coords.longitude,
          "accuracy": data.coords.accuracy,
          "timestamp": data.timestamp,
          "valid": true
        }
      } else {
        // not valid data
        ret = {
          "latitude": 0,
          "longitude": 0,
          "accuracy": 0,
          "timestamp": 0,
          "valid": false
        }
      }
      return ret
    }
    // #region Private Methods
}
