import { Component, NgZone } from '@angular/core';
import { LoadingController, Platform, AlertController } from '@ionic/angular';

import { Device } from '@ionic-native/device/ngx';

// UniqueDeviceID (see https://ionicframework.com/docs/native/unique-device-id)
// see also https://www.freakyjolly.com/ionic-4-get-unique-device-id-other-uids-of-uuid-imei-imsi-iccid-and-mac-using-native-cordova-plugins/
import { UniqueDeviceID } from '@ionic-native/unique-device-id/ngx';
import { Uid } from '@ionic-native/uid/ngx';
import { AndroidPermissions } from '@ionic-native/android-permissions/ngx';

// ScreenOrientation (see https://ionicframework.com/docs/native/screen-orientation)
import { ScreenOrientation } from '@ionic-native/screen-orientation/ngx';

// GeoLocation and GeoCoder
import { Geolocation } from '@ionic-native/geolocation/ngx';
import { NativeGeocoder, NativeGeocoderResult, NativeGeocoderOptions } from '@ionic-native/native-geocoder/ngx';

// Http Request
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import {catchError} from 'rxjs/operators';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  // #region Variables
    baseURL = 'https://jsonplaceholder.typicode.com'          // API End-point base url

    operators = []                          // operatori
    operator = ''
    veichles = []                           // targhe veicoli
    veichle = ''

    // device
    UUID: string = ''

    // Location and Map Settings
    locationInterval: number = 10           // interval to acquire GPS data
    locationTimeout: number = 5            // location timeout seconds
    tmr = null                              // location timer

    // Location Data and results
    locationProgress: any = 0             // location progress: 0=stopped;
    locationErrors: any = 0               // location errors counter
    locationEmpty: any = 0                // location empty (coords 0,0)

    error_code: number = 0
    error_message: string = ''

    geoData = {                         // geoLocation result
      latitude:  0,                     // latitude
      longitude:  0,                    // longitude
      accuracy:  0,                     // accuracy
      timestamp:  0                     // timestamp
    }
  // #endregion Variables

  // #region Constructors
    constructor(
      private platform: Platform,
      private uniqueDeviceID: UniqueDeviceID,
      private uid: Uid,
      private device: Device,
      private androidPermissions: AndroidPermissions,
      private screenOrientation: ScreenOrientation,
      private alertController: AlertController,
      private loadingController: LoadingController,
      private geolocation: Geolocation,
      private nativeGeocoder: NativeGeocoder,
      private httpClient: HttpClient
    ) {
      // Constructor

      // Lock screen orientation
      this.screenOrientation.lock(this.screenOrientation.ORIENTATIONS.LANDSCAPE_PRIMARY)

      console.log('platform', this.device.platform)
      console.log('version', this.device.version)
      console.log('model', this.device.model)
      console.log('manufacturer', this.device.manufacturer)
      console.log('isVirtual', this.device.isVirtual)
      console.log('serial', this.device.serial)

      // detect orientation changes
      this.screenOrientation.onChange().subscribe(
        () => {
            console.log("Orientation Changed", this.screenOrientation.type);
        }
      );

      // gets operators list
      this.apiGet('/users/').then((result) => {
        if (result != undefined) {

          // overwrites operatori
          result = [
            {
              name: 'BRANCHINI GIOVANNI MARIA'
            },
            {
              name: 'ALBERTI LIDIA'
            },
            {
              name: 'BICOCCHI STEFANIA'
            }
          ]
          this.operators = result

          // gets veichles list
          this.apiGet('/todos/').then((result) => {
            if (result != undefined) {

              // overwrites veichles
              result = [
                {
                  title: 'CITROEN C3 (XX123XX)'
                },
                {
                  title: 'Fiat Punto (YY000YY)'
                }
              ]

              this.veichles = result
            } else {
              // API Error
              alert('errore API veichles')
            }
          })
        } else {
          // API Error
          alert('errore API operatori')
        }
      })

      // on Android, detects device UUID
      if (this.platform.is('android')) {
        this.uniqueDeviceID.get()
        .then((uuid: any) => this.UUID = uuid)
        .catch((error: any) => alert(JSON.stringify(error)));
      }
    }
  // #endregion Constructors

  // #region Public/Private Methods

    // #region User Functions
    async startLocating() {

      // checks operator and veichle selection
      if ((typeof this.operator === 'string') || (typeof this.veichle === 'string')) {
        const alert = await this.alertController.create({
          animated: true,
          backdropDismiss: false,
          header: 'Attenzione',
          subHeader: 'Operatore e veicolo richiesti',
          message: 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo',
          buttons: ['OK']
        });
        await alert.present();
        return
      }

      // start locating veichle
      this.locationErrors = 0

      // shows loader then calls API
      this.getLoading('Verifica connessione...').then((loading) => {
        loading.present(),

        this.apiGet('/todos/1')
          .then((result) => {
            if (result != undefined) {
              // API OK: checks GeoLocation service

              loading.message = 'Verifica servizio GeoLocalizzazione...'

              this.checkGeoLocationService()
              .then((result) => {
                // GeoLocation Service running
                loading.dismiss()

                // start locating
                this.locate()
                this.tmr = setInterval( ()=>{
                  this.locate()
                }, (this.locationInterval * 1000))

              }).catch((error) => {
                // GeoLocation Error {code:%, message:$}
                loading.dismiss()
                alert(error.message)
              })
            } else {
              // API Error
              loading.dismiss()     // closes loader
            }
          })
      })
    }
    stopLocating() {
      // stop locating veichle
      this.locationProgress = 0
      clearInterval(this.tmr)
      this.tmr = 0
    }
    // #endregion User Functions

    // #region Location Functions
    isLocating() {
      return (this.tmr > 0)
    }
    locationStatus() {
      return this.locationProgress
    }

    async checkGeoLocationService(): Promise<any> {
      // checks Geolocation service
      let geoLocationOptions = {                        // geolocation options
        timeout: (this.locationTimeout * 1000),
        enableHighAccuracy: true,
        maximumAge: 0               // no cached position
      };
      return new Promise((resolve, reject) => {
        this.geolocation.getCurrentPosition(geoLocationOptions)
        .then((data) => {
          // getCurrentPosition result
          resolve(data)
        }).catch((error) => {
          // getCurrentPosition error
          reject(error)
        })
      })
    }
    locate() {
      // locates the veichle
      this.resetLocationData()

      let geoLocationOptions = {                        // geolocation options
        timeout: (this.locationTimeout * 1000),
        enableHighAccuracy: true,
        maximumAge: 0               // no cached position
      };

      this.geolocation.getCurrentPosition(geoLocationOptions)
        .then((data) => {
          // getCurrentPosition result
          // es: 41.1954148 16.6165038

          console.log('geolocation result', data.coords.latitude, data.coords.longitude, data.timestamp)

          if (data.timestamp > 0) {
            this.geoData.latitude = data.coords.latitude
            this.geoData.longitude = data.coords.longitude
            this.geoData.accuracy = Math.round(data.coords.accuracy)
            this.geoData.timestamp =  data.timestamp

            this.locationErrors = 0
            this.locationEmpty = 0
            this.locationProgress += 1
          } else {
            // location is empty
            this.error_code = 0
            this.error_message = 'location empty'
          }
        }).catch((error) => {
          // getCurrentPosition error
          this.error_code = error.code
          this.error_message = error.message
          this.locationErrors += 1
        })
    }
    resetLocationData() {
      // resets error
      this.error_code = 0
      this.error_message = ''

      // resets data
      /*
      this.geoData.latitude = 0
      this.geoData.longitude = 0
      this.geoData.accuracy = 0
      this.geoData.timestamp = 0
      */
    }
    // #endregion Location Functions

    // #region Map Functions
    /*
    initMap(lat?: number, lng?:number) {
      // initializes map
      if (lat == undefined) lat = 0
      if (lng == undefined) lng = 0

      const map = new Map('geoLocator').setView([lat, lng], this.mapZoomLevel);

      this.mapInit = true
    }
    refreshMap(lat: number, lng:number) {
      // refresh map
      if (lat == undefined) lat = 0
      if (lng == undefined) lng = 0

      const map = Map('geoLocator')
      map.setView([lat, lng], 23)

      const m = new marker([lat, lng])
      m.addTo(map)
      console.log('refreshMap')
    }
    */
    openMapAPP() {
      // opens map APP
      // Android: geo:41.1954148,16.6165038
      // iOS:     maps://maps.apple.com/?q=41.1954148,16.6165038
      let url = '';

      if (this.platform.is('android')) {
        url = 'geo:' + this.geoData.latitude + ',' + this.geoData.longitude
      }
      if (this.platform.is('desktop')) {
        url = 'maps://maps.apple.com/?q=' + this.geoData.latitude + ',' + this.geoData.longitude
      }
      if (url != '')
        window.open(url)
      else
        alert('cannot open maps')
    }
    // #endregion

    // #region Http Functions
    async apiGet(uri): Promise<any> {
      return new Promise((resolve, reject) => {
        this.httpClient.get(this.baseURL + uri).subscribe((response) => {
          resolve(response);
        }, (err) => {
          reject(err);
        })
      })
      .catch((err) => {
      });
    }
    // #endregion Http Functions

    // #region Utils Functions
    async getLoading(message?: string, duration?: number) {
      // returns a loading object
      if (message == undefined) message = 'Please wait...'
      if (duration == undefined) duration = 10000

      const loading = await this.loadingController.create({
        message: message,
        duration: duration,
        showBackdrop: true
      });
      return loading
    }

    timestampToDateTime(ts) {
      return new Date(ts) //.toLocaleDateString("it-IT")
    }
    // #endregion Utils Functions

  // #endregion Public/Private Methods
}
