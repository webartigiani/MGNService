import { Component } from '@angular/core';
import { environment } from "src/environments/environment";

import { NavController } from '@ionic/angular';

// WebArtigiani Classes
import { AppService } from '../Classes/App';
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';

@Component({
  selector: 'app-start',
  templateUrl: './start.page.html',
  styleUrls: ['./start.page.scss'],
})
export class StartPage {

  // #region Variables
  statusDesc: string = 'caricamento...'
  statusError: boolean = false
  execDelay: number = 0.1                       // numero di secondi di attesa esecuzione
  retryDelay: number = 3                        // numero di secondi per retrial
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

      // Angular
      public navCtrl: NavController,
  ) {
    // Constructor code...
  }
  // #endregion Constructor

  // #region Component LifeCycle
  ngAfterViewInit() {
    console.log('ngAfterViewInit')

    setTimeout(() => {
      this.checkConnection()
    }, this.execDelay * 1000 * 2);

  }
  // #endregion Component LifeCycls

  // #region Public Methods
  checkConnection() {
    /**
     * step 1: checks internet connection
     */

    this.statusDesc = 'verifica connessione...'

    setTimeout(() => {
      // 0.5" before we really check connection

      if (this.utils.isDeviceOnLine()) {
        // device connected:
        this.statusDesc = 'connessione OK'
        setTimeout(() => {
          this.pingServer()
        }, this.execDelay * 1000);
      } else {
        // device not connected: retry in 1"
        this.statusDesc = 'Connessione Assente.<br><br>Attiva la connessione dati del tuo dispositivo.'
        setTimeout(() => {
          this.checkConnection()     // retry All in 3"
        }, this.retryDelay * 1000);
      }
    }, this.execDelay * 1000);
  }

  pingServer() {
    /**
     * step 2: try to ping server
     * */
    this.statusDesc = 'connessione al server MGN...'

    setTimeout(() => {
      this.api.ping().then((result) => {
        // ping OK
        this.statusDesc = 'Connessione al server MGN Ok'
        setTimeout(() => {
          this.checkGeoLocationService()
        }, this.execDelay * 1000);
      }).catch((error) => {
        // ping Error
        this.statusDesc = 'Server MGN non raggiungibile.<br><br>Nuovo tentativo in ' + this.retryDelay  + '"...'
        setTimeout(() => {
          this.checkConnection()      // retry All in 3"
        }, this.retryDelay * 1000);
      })
    }, this.execDelay * 1000);
  }

  checkGeoLocationService() {
    /**
     * step 3: checks geo-location service
     */
    this.statusDesc = 'verifica servizio GPS...'

    setTimeout(() => {
      this.geolocation.checkService().then((data) => {
        // Geo-location service OK

        this.statusDesc = 'Avvio in corso...'

        setTimeout(() => {
          this.navCtrl.navigateRoot('home')
        }, this.execDelay * 1000);

      }).catch((error) => {
        // describes the error
        let m = ''
        switch (error.code) {
          case 1:
            m= 'Devi autorizzare la localizzazione'
            break
          case 2:
            m = 'Errore di rete GPS.'
            break
          case 3:
            m = 'Timeout GPS.'
            break
          default:
            m = 'Errore GPS ' + error.code + ', ' + error.message
            break
        }
        this.statusDesc = m + '<br><br>Nuovo tentativo in ' + this.retryDelay  + '"...'
        setTimeout(() => {
          this.checkGeoLocationService()
        }, this.retryDelay * 1000)
      })
    }, this.execDelay * 1000);
  }
  // #endregion Public Methods

}
