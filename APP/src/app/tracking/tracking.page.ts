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
  counter: number = 0           // contatore tracciamenti
  sessionID: string = ''
  gpsData: any = {}
  isPaued: boolean = false
  alreadyPaused: boolean = false
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

    this.geoLocate()

    setInterval(() => {
      this.geoLocate()
    }, environment.LOCATION_INERVAL * 1000);
  }
  // #endregion Component LifeCycls

  // #region Public Methods
  pause() {
    // do a pause
    if (this.alreadyPaused) {
      // pause already used
      this.components.showAlert('Pausa', 'Pausa non disponibile', 'Hai già usufruito di una pausa lungo il tragitto.')
      return;
    }

    // ask for confirmation
    this.components.showConfirm('Pausa','Hai a disposizione una sola pausa lungo il tragitto','Confermi di voler usufruire della pausa ora?').then((result) => {
      if (!result) return;
      this.isPaued = true
      this.alreadyPaused = true

      this.components.showAlert('In Pausa', 'Sistema in pausa', 'Per riprendere il tuo tragitto, clicca sul pulsante "OK" al termine della pausa.', environment.MAX_PAUSE_TIMEOUT * 60 * 1000)
    })

  }
  dummy() {

  }
  SOS() {
    /**
     * starts a calling to the SOS number
     */
    this.components.showConfirm('SOS','Avvia chiamata SOS','Avviare una chiamata al numero di SOS ' + environment.SOS_PHONE_NUMBER + '?').then((result) => {
      if (result) this.phone.call(environment.SOS_PHONE_NUMBER)
    })
  }

  geoLocate() {
    /**
     * Geo-locate the device
     */

    this.geolocation.locate().then((data) => {
      // Geo-location OK

      if (data.valid) {
        this.gpsData = data
        this.counter++
      }
      console.log('Geo-location result', data)

      this.api.continueTracking(this.sessionID, data)
      .then((result) => {
        // tracking-data saved
        console.log('Geo-location API result', result)

      }).catch((error) => {
        // API Error
        console.error(error)
      });
    }).catch((error) => {
      // geo-location error
      console.error('Geo-location error', error)
    })
  }
  // #endregion Public Methods

  // #region Private Methods
  // #endregion Private Methods
}
