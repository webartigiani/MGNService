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

    let geoLocationOptions = {                            // geolocation options
      timeout: (environment.LOCATION_TIMEOUT * 1000),
      enableHighAccuracy: true,
      maximumAge: 0                                       // no cached position
    };
    return new Promise((resolve, reject) => {
      this.geolocation.getCurrentPosition(geoLocationOptions)
      .then((data) => {
        // result
        resolve(data)
      }).catch((error) => {
        /* error
            possible errors
              {code: 1, message: "User denied Geolocation"}       // on WebBrowser
              {code: 1, message: "Illegal Access"}                // on Android
              {code: 2, message: "Network location provider at 'https://www.googleapis.com/' : No response received."}
        */
        reject(error)
      })
    })
  }

   async locate(): Promise<any> {
     /**
      * geo-locate the user
      */
    return new Promise((resolve, reject) => {
      let geoLocationOptions = {                        // geolocation options
        timeout: (environment.LOCATION_TIMEOUT * 1000),
        enableHighAccuracy: true,
        maximumAge: 0                                   // no cached position
      };

      this.geolocation.getCurrentPosition(geoLocationOptions)
        .then((data) => {
          // getCurrentPosition result
          // es: 41.1954148 16.6165038

          console.log('geolocation result', data.coords.latitude, data.coords.longitude, data.timestamp)

          if (data.timestamp > 0) {
            /*
            this.geoData.latitude = data.coords.latitude
            this.geoData.longitude = data.coords.longitude
            this.geoData.accuracy = Math.round(data.coords.accuracy)
            this.geoData.timestamp =  data.timestamp
            */
          } else {
            // location is empty

          }
        }).catch((error) => {
          // getCurrentPosition error
          /*
          this.error_code = error.code
          this.error_message = error.message
          this.locationErrors += 1
          */
        })
    })
  }
   // #endregion Public Methods
}
