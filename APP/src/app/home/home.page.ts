import { Component } from '@angular/core';
import { NavController, Platform } from '@ionic/angular';

// WebArtigiani Classes
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  // #region Constructors
    constructor(
      // WebArtigiani
      private api: ApiService,
      private utils: UtilsService,
      private components: ComponentsService,
      private geolocation: GeoLocationService,
      private localData: LocalDataService,

      public navCtrl: NavController,
      public platform: Platform
    ) {
      // Constructor

      // clears console



    }
  // #endregion Constructors


  navigate() {
    this.navCtrl.navigateRoot('check-connection')
  }

  // #region Public/Private Methods
    // #region User Functions
    async startLocating() {

      // checks operator and veichle selection
      /*
      if ((typeof this.operator === 'string') || (typeof this.veichle === 'string')) {
        this.components.showAlert('Attenzione', 'Operatore e veicolo richiesti', 'Operatore e veicolo sono entrambi richiesti per avviare il tragitto. Prego, seleziona operatore e veicolo')
        return
      }

      // shows loader then calls API
      this.components.getLoader('Verifica connessione...').then((loading) => {
        loading.present()

        loading.message = 'Verifica servizio GeoLocalizzazione...'

        this.geolocation.checkService()
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
      })
      */
    }

    // #endregion User Functions

    // #region Location Functions
    isLocating() {
      return true
    }


    // #endregion Location Functions
    // #endregion

  // #endregion Public/Private Methods
}
