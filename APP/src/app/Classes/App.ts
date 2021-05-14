/*
  AppService Class
  implements various components, such as loading, alert

  USAGE:
    > in your "component" TS
      import {AppService} from "../Classes/Components";

    > in your "component" TS constructor, add
      private components: AppService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          AppService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";
import { environment } from "src/environments/environment";

@Injectable()
export class AppService {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
   ) {
      // constructor...
   }
  // #endregion Constructors

   // #region Public Methods
  appName() {
    return environment.APP_TITLE
  }
  appVersion() {
    return environment.APP_VERSION
  }
   // #endregion Public Methods
}
