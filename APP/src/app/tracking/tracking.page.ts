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


@Component({
  selector: 'app-tracking',
  templateUrl: './tracking.page.html',
  styleUrls: ['./tracking.page.scss'],
})
export class TrackingPage {

  // #region Variables
  counter: number = 0
  sessionID: string = ''
  gpsData:any = {}
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
  dummy() {

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
