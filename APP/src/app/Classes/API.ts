/*
  ApiService Class
  interacts with http://gestionale.mgnservice.it/ APIs

  USAGE:
    > in your "component" TS
      import {ApiService} from "../Classes/API";

    > in your "component" TS constructor, add
      private api: ApiService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          ApiService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";
import { Platform } from '@ionic/angular';

// Http Request
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import {catchError, sample} from 'rxjs/operators';
import { environment } from "src/environments/environment";

@Injectable()
export class ApiService {

    // #region Constructors
    constructor(
      private platform: Platform,
      private httpClient: HttpClient
    ) {
      // constructor...
    }
    // #endregion Constructors

    // #region Public API Methods
    /**
     * USAGE:
     *      this.api.listWorkers().then((result) => {
     *        console.log(result)
     *        }
     *      ).catch((error) => {
     *        console.error(error)
     *      })
     */
    async ping(): Promise<any> {
      return new Promise((resolve, reject) => {
        this.get('/ping/').then((result) => {
            resolve(result.data)
        }).catch((error) => {
            reject(error)
        })
      })
    }
    async listWorkers(): Promise<any> {
      /**
       * Lists Workers (enabled and not in use)
       */
      return new Promise((resolve, reject) => {
        this.get('/workers/list/').then((result) => {
            resolve(result.data)
        }).catch((error) => {
            reject(error)
        })
      })
    }
    async listVeichles(): Promise<any> {
      /**
       * Lists Veichles (enabled and not in use)
       */
      return new Promise((resolve, reject) => {
        this.get('/veichles/list/').then((result) => {
          resolve(result.data)
        }).catch((error) => {
            reject(error)
        })
      })
    }
    async deviceAdd(deviceData: any, gpsData: any): Promise<any> {
        /**
         * Add/Updates device on server
        {
            "platform": "Android",
            "version": "10.0.0",
            "manufacter": "Samsung",
            "model": "S8",
            "is_virtual": false,
            "serial": "20c8bef9-3f86-4ddc-a8c6-xxx",
            "uuid": "x1234",
            "connection_type": "wifi",
            "app_version": "1.0.0"
            "latitude": "41.19317221071111",
            "longitude": "16.599785497822222",
            "accuracy": "10"
        }
        */
        const payload = {
            "platform": deviceData.platform,
            "version": deviceData.version,
            "manufacter": deviceData.manufacter,
            "model": deviceData.model,
            "is_virtual": deviceData.isVirtual,
            "serial": deviceData.serial,
            "uuid": deviceData.uuid,
            "connection_type": deviceData.connection_type,
            'app_version': environment.APP_VERSION,
            "latitude": gpsData.latitude,
            "longitude": gpsData.longitude,
            "accuracy": gpsData.accuracy,
        }
        return new Promise((resolve, reject) => {
          this.post('/devices/add/', payload).then((result) => {
            resolve(result.data)
          }).catch((error) => {
            reject(error)
          })
        })
    }
    async startTrackingSession(deviceData: any, gpsData: any, worker: any, veichle: any, password: string) {
      /**
       * startTrackingSession
      {
        "device":{
          "platform":"browser",
          "version":"0.0.0",
          "manufacter":"manufacter",
          "model":"model",
          "isVirtual":false,
          "serial":"unknown",
          "uuid":"debug_browser",
          "connection_type":"ethernet"
        },
        "gps":{
          "latitude":44.6466223,
          "longitude":10.9308673,
          "accuracy":20,
          "timestamp":1621246509939,
          "valid":true
        },
        "worker":{
          "id":8,
          "name":"ANNA",
          "surname":"E. NACCAH"
        },
        "veichle":{
          "id":1,
          "manufacter":"Citroen",
          "model":"C3",
          "licence_plate":"XX123XX"
        },
        "password":"password"
      }
       */
      const payload = {
        "device": deviceData,
        "gps": gpsData,
        "worker": worker,
        "veichle": veichle,
        "password": password
      }
      return new Promise((resolve, reject) => {
        this.post('/workers/startTrackingSession/', payload).then((result) => {
          resolve(result)
        }).catch((error) => {
          reject(error)
        })
      })
    }
    async continueTracking(sessionID: string, gpsData: any, navigationStatus:string) {
      /**
       * Continue Tracking
        {
            "gps": {
                "latitude": 44.6466223,
                "longitude": 10.9308673,
                "accuracy": 12,
                "timestamp": 1621246509939,
                "valid": true
            },
            "session_id": "20210518140719-1-1-2"
        }
       */
      const payload = {
        "gps": gpsData,
        "session_id": sessionID,
        "navigation_status":navigationStatus
      }
      return new Promise((resolve, reject) => {
        this.post('/workers/continueTracking/', payload).then((result) => {
          resolve(result)
        }).catch((error) => {
          reject(error)
        })
      })
    }
    async stopTracking(sessionID: string) {
      /**
       * Stop Tracking
        {
            "session_id": "20210518140719-1-1-2"
        }
       */
      const payload = {
        "session_id": sessionID
      }
      return new Promise((resolve, reject) => {
        this.post('/workers/stopTrackingSession/', payload).then((result) => {
          resolve(result)
        }).catch((error) => {
          reject(error)
        })
      })
    }
    // #region Public Methods

    // #region Http Base Functions
    private async get(uri): Promise<any> {
      return new Promise((resolve, reject) => {

        const headers = new HttpHeaders()
          .set('Access-Control-Allow-Origin', '*')
          .set('Content-Type', 'application/json; charset=utf-8')
          .set('Accept', 'application/json')
          .set('Authorization', 'Bearer ' + environment.API_TOKEN);

          this.httpClient.get(this.endPoint() + uri, { 'headers': headers }).subscribe((response) => {
              if (environment.API_LOGGER_ENABLED) console.warn('API Debugger LOG', 'GET', uri, JSON.stringify(response))
              resolve(response);
          }, (err) => {
              if (environment.API_LOGGER_ENABLED) console.error('API Debug LOG', 'GET', uri, JSON.stringify(err))
              let xErr = this.envelopeError(err)
              reject(xErr);
          })
      })
    }
    private async post(uri, data): Promise<any> {
      return new Promise((resolve, reject) => {

        const headers = new HttpHeaders()
          .set('Access-Control-Allow-Origin', '*')
          .set('Content-Type', 'application/json; charset=utf-8')
          .set('Accept', 'application/json')
          .set('Authorization', 'Bearer ' + environment.API_TOKEN);

          this.httpClient.post(this.endPoint() + uri, data, { 'headers': headers }).subscribe((response) => {
              if (environment.API_LOGGER_ENABLED) console.warn('API Debugger LOG', 'POST', uri, JSON.stringify(response))
              resolve(response);
          }, (err) => {
              if (environment.API_LOGGER_ENABLED) console.error('API Debug LOG', 'POST', uri, JSON.stringify(err))
              let xErr = this.envelopeError(err)
              reject(xErr);
          })
      })
    }
    // #endregion Http Base Functions

    // #region Private Methods
    private endPoint() {
      // returns the API endpoint base url: depending on the effective environment
      // NOTE:   we could also use
      //           environment.production

      if (this.platform.is('cordova')) {
          // running on device
          return environment.API_END_POINT
      } else {
          // running on localhost or public domain, depending on API_USE_LOCAL
          if (environment.API_USE_LOCAL)
            return environment.API_END_POINT_LOCAL
          else
            return environment.API_END_POINT
      }
    }
    private envelopeError(err) {
      /* returns an error object
      {
        "http_status":{
          "code":403,
          "text":"Forbidden",
          "message":"Http failure response for http://127.0.0.1:8000/api/app/workers/list/: 403 Forbidden"
        },
        "message":"messaggio",
        "message_details":"dettaglio1, dettaglio2"
      }
      */
      let errObj = {
        "http_status": {
          'code': err.status,
          'text': err.statusText,
          'message': err.message
        },
        'message': (err.error.message == undefined) ? '': err.error.message,
        'message_details': ''
      }

      if ((typeof err.error.data) == 'object') {
        err.error.data.forEach(element => {
          if (errObj.message_details != '') errObj.message_details += ', '
          errObj.message_details += element
        });
      }
      return errObj
    }
    // #endregion Private Methods
}
