import { Component } from '@angular/core';
import { environment } from "src/environments/environment";

import { NavController, Platform } from '@ionic/angular';
import { Input, ViewChild } from '@angular/core';
import {  IonInput } from '@ionic/angular'

// WebArtigiani Classes
import { AppService } from '../Classes/App';
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';
import { PhoneServices } from '../Classes/Phone';

@Component({
  selector: 'app-login-veichle',
  templateUrl: './login-veichle.page.html',
  styleUrls: ['./login-veichle.page.scss'],
})
export class LoginVeichlePage {

  // Referes elements
  @ViewChild('codeID', {  static: false })  codeEl: IonInput;

  // #region Variables
  workers = []                            // dipendenti
  worker = ''
  veichles = []                           // veicoli
  veichle = ''
  code = ''
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
    this.loadData()

      // #region Device Event listners
      this.platform.backButton.subscribe(() => {
        //this.components.showAlert('Attenzione', 'operazione non consentita', 'Prima di terminare l\'applicazione, completa il tuo tragitto.')
        //console.log('Another handler was called!');
        //return;
      });

      this.platform.pause.subscribe(() => {
        //console.log('pause')
      })
      this.platform.resume.subscribe(() => {
        //console.log('resume')
      })
      // #endregion Device Event listners
  }
  // #endregion Constructor

  // #region Component LifeCycle
  ngAfterViewInit() {
  }
  // #endregion Component LifeCycls

  // #region Public Methods
  start() {
    /**
     * Starts tracking worker on veichle
     */

    // #region Validations
      // checks selections: worker and veichle are both required
      if ((typeof this.worker === 'string') || (typeof this.veichle === 'string')) {
        this.components.showAlert('Attenzione', 'Operatore e veicolo richiesti', 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo')
        return
      }
      // Checks password
      if (this.code == '') {
        this.components.showAlert('Attenzione', 'Codice timbrata richiesto', 'Inserisci il codice timbrata del tuo operatore')
        this.codeEl.setFocus()
      }
    // #endregion Validations

    // shows loader then calls API to login
    this.components.getLoader('Attendi...').then((loading) => {
      loading.present()

      // checks if device is online
      if (this.utils.isDeviceOnLine()) {
        // try to ping server
        if (this.api.ping()) {

          // try to geo-locate
          this.geolocation.locate().then((data) => {

            this.api.startTrackingSession(this.utils.getDeviceData(), data, this.worker, this.veichle, this.code)
            .then((result) => {
              // tracking-session created: gets session-id, saves it, and navigate to 'tracking' page
              const sessionID = result['message'];
              this.localData.writeValue('session_id', sessionID)
              this.navCtrl.navigateRoot('tracking')
              loading.dismiss()

            }).catch((error) => {
              // API Error
              loading.dismiss()
              this.components.showAlert(error['message'], 'Si è verificato un errore', error['message_details']);
              this.loadData()
            });
          }).catch((error) => {
            // geo-location error
          })
        } else {
          // ping failed
          loading.dismiss()
          this.components.showAlert('Connessione al server assente', 'Errore di connessione al server MGN', 'Si è verificato un errore di connessione al server MSGN. Prego, riprova.')
          this.loadData()
        }
      } else {
        // device offline
        loading.dismiss()
        this.components.showAlert('Connessione Assente', 'Connessione alla rete assente', 'Prego, verifica la tua connessione quindi riprova')
      }
    })
  }

  SOS() {
    // starts a calling to the SOS number

    this.components.showConfirm('SOS','Avvia chiamata SOS','Avviare una chiamata al numero di SOS ' + environment.SOS_PHONE_NUMBER + '?').then((result) => {
      if (result) this.phone.call(environment.SOS_PHONE_NUMBER)
    })
  }
  // #endregion Public Methods

  // #region Private Methods
  private loadData() {
    // lists workers and veichles
    this.api.listWorkers().then((result) => {
      // list workers
      this.workers = result

      this.api.listVeichles().then((result) => {
        // lists veichles
        this.veichles = result
      }).catch((error) => {
        // error listing veichles
        console.error(error)
      })
    }
    ).catch((error) => {
      // error listing workers
      console.error(error)
    })
  }
  // #endregion Private Methods
}
