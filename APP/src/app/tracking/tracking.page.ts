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
  gpsData = {}
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
  }
  // #endregion Constructor


  // #region Component LifeCycle
  ngAfterViewInit() {

    setInterval(() => {
      this.geolocation.locate().then((data) => {
        if (data.valid) this.gpsData = data
        console.log(data)
      }).catch((error) => {
        console.error(error)
      })
    }, environment.LOCATION_INERVAL * 1000);
  }
  // #endregion Component LifeCycls

  // #region Public Methods
  dummy() {

  }
  // #endregion Public Methods

  // #region Private Methods
  // #endregion Private Methods
}
