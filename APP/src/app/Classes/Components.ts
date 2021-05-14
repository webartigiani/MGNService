/*
  ComponentsService Class
  implements various components, such as loading, alert

  USAGE:
    > in your "component" TS
      import {UtilsService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: ComponentsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          ComponentsService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";
import { Component, NgZone } from '@angular/core';
import { LoadingController, AlertController } from '@ionic/angular';

@Injectable()
export class ComponentsService {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
    private alertController: AlertController,
    private loadingController: LoadingController,
   ) {
      // constructor...
   }
  // #endregion Constructors

   // #region Public Methods
   async showAlert(title: string, subtitle: string, message: string) {
      // shows device native alert by alertController
      const alert = await this.alertController.create({
        animated: true,
        backdropDismiss: false,
        header: title,
        subHeader: subtitle,
        message: message,
        buttons: ['OK']
      });
      await alert.present();
   }

   async getLoader(message?: string, duration?: number) {
    // returns a loading object
    if (message == undefined) message = 'Please wait...'
    if (duration == undefined) duration = 10000

    const loading = await this.loadingController.create({
      message: message,
      duration: duration,
      showBackdrop: true
    });
    return loading
  }
   // #endregion Public Methods
}
