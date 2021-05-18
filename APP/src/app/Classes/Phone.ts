/*
  PhoneServices Class
  provides methods to store and read values, objects, array from/to localStorage

  USAGE:
    > in your "component" TS
      import {PhoneServices} from "../Classes/Phone";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          PhoneServices
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";
import { CallNumber } from '@ionic-native/call-number/ngx'

@Injectable()
export class PhoneServices {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
    private callNumber: CallNumber
   ) {
      // constructor...
   }
  // #endregion Constructors


   // #region Public Methods
   call(number: string) {
     /**
      * call a phone number
      * see: https://ionicframework.com/docs/native/call-number
        requires
          ionic cordova plugin add call-number
          npm install @ionic-native/call-number
      */
   }
   //#endregion Public Methods
}
