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
import { Platform } from '@ionic/angular';

// GeoLocation and GeoCoder
import { Geolocation } from '@ionic-native/geolocation/ngx';
import { NativeGeocoder, NativeGeocoderResult, NativeGeocoderOptions } from '@ionic-native/native-geocoder/ngx';
import { environment } from "src/environments/environment";

@Injectable()
export class GeoLocationService {

  // #region Variables
  private lastLat: any = null             // last coordinates detected
  private lastLng: any = null
  // #endregion Variables

  // #region Constructors
   constructor(
    private geolocation: Geolocation,
    private nativeGeocoder: NativeGeocoder,
    private platform: Platform,
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
          resolve(this.envelopeData(data, 0))
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

              // calculates distance from the latest point
              let distance: any = 0
              if (this.lastLat !== null) {
                distance = this.getDistance(data.coords.latitude, data.coords.longitude, this.lastLat, this.lastLng, 'haversine')
                distance = Math.round(distance * 100) / 100       // rounds 2 decimals
              }
              this.lastLat = data.coords.latitude
              this.lastLng = data.coords.longitude

              resolve(this.envelopeData(data, distance))
            } else {
              // location is empty
            }
          }).catch((error) => {
            reject(error)
          })
      })
    }

    openMap(latitude: any, longitude: any) {
      // open the Map APP (depending on the platform)
      // pointing to the specified coords

      // Android:       geo:44.6318615,11.1861538
      // iOS:           maps://maps.apple.com/?q=44.6318615,11.1861538
      // GoogleMaps:    https://www.google.it/maps/place/testo+ricerca/@44.6318615,11.1861538,17z
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

    getDistance(lat1: any, lon1: any, lat2: any, lon2: any, mode: string)
    {
      let R:any = 6371      // Earth radius in km

      switch(mode)
      {
        case 'spherical':
        default:
          var dLon = this.degToRad(lon2 - lon1)
          lat1 = this.degToRad(lat1)
          lat2 = this.degToRad(lat2)
          var d = Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * R;
        break;

        case 'haversine':
          var dLat = this.degToRad(lat2 - lat1)
          var dLon = this.degToRad(lon2 - lon1)
          lat1 = this.degToRad(lat1)
          lat2 = this.degToRad(lat2)
          var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
          var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
          var d = R * c;
        break;

        case 'rectangle':
          var x = this.degToRad(lon2 - lon1) * Math.cos(this.degToRad(lat1 + lat2) / 2)
          var y = this.degToRad(lat2 - lat1)
          var d = Math.sqrt(x * x + y * y) * R;
        break;
      }

      return d;
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
    private envelopeData(data: any, distance: any) {
      // evenlope getCurrentPosition result

      let ret
      if (data.timestamp > 0) {
        ret = {
          "latitude": data.coords.latitude,
          "longitude": data.coords.longitude,
          "accuracy": data.coords.accuracy,
          "distance": distance,
          "timestamp": data.timestamp,
          "valid": true
        }
      } else {
        // not valid data
        ret = {
          "latitude": 0,
          "longitude": 0,
          "accuracy": 0,
          "distance": 0,
          "timestamp": 0,
          "valid": false
        }
      }
      return ret
    }
    private degToRad(n: any)
    {
      return n * Math.PI / 180
    }
    private radToDeg(n: any)
    {
      return n * 180 / Math.PI
    }
    // #region Private Methods
}
