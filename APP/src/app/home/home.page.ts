import { Component } from '@angular/core';

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

  // #region Variables
    baseURL = 'https://jsonplaceholder.typicode.com'          // API End-point base url

    operators = []                          // operatori
    operator = ''
    veichles = []                           // targhe veicoli
    veichle = ''
  // #endregion Variables

  // #region Constructors
    constructor(
      // WebArtigiani
      private api: ApiService,
      private utils: UtilsService,
      private components: ComponentsService,
      private geolocation: GeoLocationService,
      private localData: LocalDataService
    ) {
      // Constructor

      // clears console
      console.clear()

      // lists workers and veichles
      this.api.listWorkers().then((result) => {
          // list workers
          this.operators = result

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

      this.geolocation.checkService().then((data) => {
      }).catch((err) => {
      })
    }
  // #endregion Constructors

  // #region View LifeCycle Events
  // see: https://angular.io/guide/lifecycle-hooks
  ngOnInit() {
    /*
    Initialize the directive or component
    after Angular first displays the data-bound properties and sets the directive or component's input properties.
    Called once
    */
    console.log('ngOnInit')
  }
  ngAfterContentInit() {
    /*
    Respond after Angular projects external content into the component's view, or into the view that a directive is in.
    Called once
    */
    console.log('ngAfterContentInit')
  }
  ngAfterContentChecked() {
    // Respond after Angular checks the content projected into the directive or component.
  }
  ngAfterViewInit() {
      /*
      Respond after Angular initializes the component's views and child views, or the view that contains the directive.
      Called once
      */
      console.log('ngAfterViewInit')
  }

  ngAfterViewChecked() {
    // Respond after Angular checks the component's views and child views, or the view that contains the directive.
  }
  ngOnDestroy() {
    /*
    Cleanup just before Angular destroys the directive or component.
    Unsubscribe Observables and detach event handlers to avoid memory leaks.
    */
   console.log('ngOnDestroy')
  }

  // #endregion View LifeCycle Events

  // #region Public/Private Methods

  writeValue() {
    let d = [
      {
        'name': 'paolo',
        'surname': 'fox'
      },
      {
        'name': 'marta',
        'surname': 'stiuart'
      },
    ]
    this.localData.writeValue('nome', 'andrea')
  }
  writeObject() {
    let obj = [
      {
        'name': 'paolo',
        'surname': 'fox'
      },
      {
        'name': 'marta',
        'surname': 'stiuart'
      },
    ]
    this.localData.writeArray('lista', obj)
  }
  readValue() {
    return this.localData.readValue('nome', 'predefinito')
  }
  readObject() {
    return JSON.stringify(this.localData.readArray('lista', []))
  }
  delete() {
    this.localData.delete('nome')
  }

    // #region User Functions
    async startLocating() {

      // checks operator and veichle selection
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

          /* start locating
          this.locate()
          this.tmr = setInterval( ()=>{
            this.locate()
          }, (this.locationInterval * 1000))
          */
        }).catch((error) => {
          // GeoLocation Error {code:%, message:$}
          loading.dismiss()
          alert(error.message)
        })
      })
    }

    dummy() {

    }
    // #endregion User Functions

    // #region Location Functions
    isLocating() {
      return true
    }


    // #endregion Location Functions
    // #endregion


    // #region Utils Functions
    timestampToDateTime(ts) {
      return new Date(ts) //.toLocaleDateString("it-IT")
    }
    // #endregion Utils Functions

  // #endregion Public/Private Methods
}
