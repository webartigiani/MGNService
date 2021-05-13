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
        if (result != undefined) {
          resolve(result.data)
        } else {
          // API Error
        }
      })
    })
  }
  async listWorkers(): Promise<any> {
    return new Promise((resolve, reject) => {

      this.get('/workers/list/').then((result) => {
        if (result != undefined) {
          resolve(result.data)
        } else {
          // API Error
          alert('errore API operatori')
        }
      })
    })
  }
  async listVeichles(): Promise<any> {
    return new Promise((resolve, reject) => {

      this.get('/veichles/list/').then((result) => {
        if (result != undefined) {
          resolve(result.data)
        } else {
          // API Error
          alert('errore API veicoli')
        }
      })
    })
  }
  // #region Public Methods

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
  // //#endregion Private Methods

  // #region Http Base Functions
    async get(uri): Promise<any> {
      return new Promise((resolve, reject) => {

        const headers = new HttpHeaders()
          .set('Access-Control-Allow-Origin', '*')
          .set('Content-Type', 'application/json; charset=utf-8')
          .set('Accept', 'application/json')
          .set('Authorization', 'Bearer ' + environment.API_TOKEN);

          this.httpClient.get(this.endPoint() + uri, { 'headers': headers }).subscribe((response) => {
              if (environment.API_LOGGER_ENABLED) console.warn('API Debugger LOG', uri, JSON.stringify(response))
              resolve(response);
          }, (err) => {
              if (environment.API_LOGGER_ENABLED) console.error('API Debug LOG', uri, JSON.stringify(err))
              let xErr = this.envelopeError(err)
              reject(xErr);
          })
      })
    }

    envelopeError(err) {
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
  // #endregion Http Base Functions
}
