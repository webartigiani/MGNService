import { Component } from '@angular/core';
import { environment } from "src/environments/environment";

import { NavController } from '@ionic/angular';

// WebArtigiani Classes
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

  // #region Constructor
  constructor(
      // WebArtigiani Classes
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

  // #region App Data
  appName() {
    return environment.APP_TITLE
  }
  appVersion() {
    return environment.APP_VERSION
  }
  // #endregion App Data

}
