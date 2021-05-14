import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

// WebArtigiani Classes
import { ApiService } from '../Classes/API';
import { UtilsService } from '../Classes/Utils';
import { ComponentsService } from '../Classes/Components';
import { GeoLocationService } from '../Classes/GeoLocation';
import { LocalDataService } from '../Classes/LocalData';

@Component({
  selector: 'app-check-connection',
  templateUrl: './check-connection.page.html',
  styleUrls: ['./check-connection.page.scss'],
})
export class CheckConnectionPage {

  // #region Constructors
  constructor(
    // WebArtigiani
    private api: ApiService,
    private utils: UtilsService,
    private components: ComponentsService,
    private geolocation: GeoLocationService,
    private localData: LocalDataService,

    public navCtrl: NavController
  ) {
    // Constructor

    // clears console
    console.clear()
  }
// #endregion Constructors

  // #region View LifeCycle Events
  // see: https://angular.io/guide/lifecycle-hooks
  ngAfterViewChecked() {
      console.log('ngAfterViewInit')

      setTimeout(() => {
        this.navCtrl.navigateRoot('home')
      }, 3000);
  }
  // #endregion View LifeCycle Events
}
