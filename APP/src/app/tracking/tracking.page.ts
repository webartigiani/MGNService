import { Component } from '@angular/core';
import { environment } from "src/environments/environment";

import { NavController, Platform } from '@ionic/angular';

// WebArtigiani Classes
import { AppService } from '../Classes/App';
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';
import { PhoneServices } from '../Classes/Phone';

@Component({
  selector: 'app-tracking',
  templateUrl: './tracking.page.html',
  styleUrls: ['./tracking.page.scss'],
})
export class TrackingPage {

  // #region Variables
  current_worker = this.localData.readObject('current_worker', {})    // current worker and veichle
  current_veichle = this.localData.readObject('current_veichle', {})
  statusDesc = 'continua verso la tua destinazione...'
  instructions = [
    'raggiunta la tua destinazione, clicca "Stop"',
    'per fermarti lungo il tragitto, clicca "Pausa',
    'per emergenze, clicca "SOS"'
  ]
  counter: number = 0                       // contatore tracciamenti
  sessionID: string = ''
  gpsData: any = {}
  isPaued: boolean = false
  alreadyPaused: boolean = false
  iTimer: any = null                        // setInterval
  data = [];
  // #endregion Variables

  // #region Constructor
  constructor(
    // WebArtigiani
    public app: AppService,
    private api: ApiService,
    private utils: UtilsService,
    private components: ComponentsService,
    private geolocation: GeoLocationService,
    private localData: LocalDataService,
    private phone: PhoneServices,

    // Angular
    public platform: Platform,
    public navCtrl: NavController
  ) {
    // Constructor code...

    // gets current session_id from storage
    this.sessionID = this.localData.readValue('session_id');
  }
  // #endregion Constructor

  // #region Component LifeCycle
  ngAfterViewInit() {

    // keep screen awake
    this.utils.keepScreenAwake()

    // 1st geo-location, then geo-locate by 1" interval
    this.data = [];

    // 1st geo-location, then geo-locate by interval
    this.geoLocate()
    this.iTimer = setInterval(() => {
      this.geoLocate()
    }, 1 * 1000);
  }
  // #endregion Component LifeCycls

  // #region Public Methods
  pause() {
    /**
     * Do a Pause
     */
    if (this.alreadyPaused) {
      // pause already used
      this.components.showAlert('Pausa', 'Pausa non disponibile', 'Hai gi?? usufruito di una pausa lungo il tragitto.',0,'Ho capito')
      return;
    }

    // ask for confirmation
    this.components.showConfirm('Pausa','Hai a disposizione una sola pausa lungo il tragitto','Confermi di voler usufruire della tua pausa ora?', ['No', 'Si']).then((result) => {
      if (!result) return;
      this.isPaued = true
      this.alreadyPaused = true     // sets pause already used
      this.components.showAlert('In Pausa', 'Tragitto in pausa', 'Per riprendere il tuo tragitto, clicca sul pulsante "Riprendi" al termine della pausa.', environment.MAX_PAUSE_TIMEOUT * 60 * 1000, 'Riprendi').then((result) => {
        this.isPaued = false
      })
    })
  }
  stop() {
    /**
     * Stops Geo-Locate
     */

    this.components.showConfirm('Conferma', 'Hai raggiunto la destinazione?', 'Confermi di volere interrompere il tragitto?', ['No', 'Si']).then((result) => {
        if (result) {

          // shows loader then calls API to login
          this.components.getLoader('Attendi...').then((loading) => {
            loading.present()

            this.api.stopTracking(this.sessionID).then((result) => {
              // stopTracking OK
              loading.dismiss()
              this.stopTracker()
            }).catch((error) => {
              // API Error
              console.error(error)
              loading.dismiss()
            })
          })
        } else {
          // Do not stop!
        }
    })
  }
  stopTracker() {
    /**
     * Stops the tracker
     */
     clearInterval(this.iTimer)                  // stops interval
     this.iTimer = null
     this.localData.delete('session_id')
     this.localData.delete('current_worker')
     this.localData.delete('current_veichle')
     this.navCtrl.navigateRoot('login-veichle')
  }

  SOS() {
    /**
     * starts a calling to the SOS number
     */
     this.components.showConfirm('SOS','Avvia chiamata SOS','Avviare una chiamata al numero di SOS ' + environment.SOS_PHONE_NUMBER + '?', ['Annulla', 'OK']).then((result) => {
      if (result) this.phone.call(environment.SOS_PHONE_NUMBER)
    })
  }

  geoLocate(retry?: boolean) {
    /**
     * Geo-locate the device
     */

    this.geolocation.locate().then((data) => {
      /**
       * Geo-location OK
       * we call continueTracking API
       */
      if (data.valid) {
        this.gpsData = data
        this.counter++
      }

      /*
      Stores data into local array
      when we got N (environment.LOCATION_INTERVAL) points, we get the best by accuracy
      by sorting local array. Then we register the position, reset the local array,
      and redo it all
      */
      this.data.push(data);
      if (this.data.length === environment.LOCATION_INTERVAL) {
          // sorts array by accuracy, then gets the first, resets the local array
          this.data.sort((a, b) => parseInt(a.accuracy) - parseInt(b.accuracy));
          data = this.data[0]; // gets the first point by accuracy
          this.data = []; // resets local array
          const navigationStatus = this.isPaued ? 'pause' : 'running'; // status paused/running
          this.api.continueTracking(this.sessionID, data, navigationStatus)
              .then((result) => {
              // continueTracking OK
          }).catch((error) => {
              // API Error
              if (error.http_status.code === 404) {
                  // ERORR 404 returned by server
                  // tracking session stopped by admin
                  this.components.showAlert('Navigazione Interrotta', 'Navigazione interrotta da remoto', 'La navigazione di questo veicolo ?? stata interrotta da remoto dallo Staff di MGN.', 3000).then((result) => {
                      this.stopTracker();
                  });
                  return;
              }
              // other API errors
              console.error(error);
          });
      } // if (this.data.length...)
    }).catch((error) => {
      // geo-location error
      console.error('Geo-location error', error)
    })
  }
  // #endregion Public Methods

  // #region Private Methods
  // #endregion Private Methods
}
