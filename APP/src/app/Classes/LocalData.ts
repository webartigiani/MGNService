/*
  LocalDataService Class
  provides methods to store and read values, objects, array from/to localStorage

  USAGE:
    > in your "component" TS
      import {LocalDataService} from "../Classes/LocalData";

    > in your "component" TS constructor, add
      private api: UtilsService

    > in src/app.module.ts, add your provider
        providers: [
          ...,
          ScreenOrientation,
          LocalDataService
        ],

  see a sample: https://stackoverflow.com/questions/35665903/how-to-write-helper-class-in-typescript
*/

import {Injectable} from "@angular/core";

@Injectable()
export class LocalDataService {

  // #region Variables
  // #endregion Variables

  // #region Constructors
   constructor(
   ) {
      // constructor...
   }
  // #endregion Constructors


   // #region Public Methods
  writeValue(name: string, value: any) {
    localStorage.setItem(name, value)
  }
  readValue(name: string, defaultValue?: any) {
    if (defaultValue === undefined) defaultValue = ''
    let value: any = localStorage.getItem(name)
    if (value === null) value = defaultValue
    return value
  }
  writeObject(name: string, value: any) {
    if (value === null) value = {}
    localStorage.setItem(name, JSON.stringify(value))
  }
  readObject(name: string, defaultObject?: any) {
    if (defaultObject === undefined) defaultObject = '{}'
    let value: any = localStorage.getItem(name)
    if (value === null) value = defaultObject
    value = JSON.parse(value)
    return value
  }
  writeArray(name: string, value: any) {
    if (value === null) value = []
    localStorage.setItem(name, JSON.stringify(value))
  }
  readArray(name: string, defaultArray?: any) {
    if (defaultArray === undefined) defaultArray = []
    let value: any = localStorage.getItem(name)
    if (value === null)
      return defaultArray
    else
      return JSON.parse(value)
  }
  delete(name: string) {
    localStorage.removeItem(name)
  }
  clear() {
    localStorage.clear()
  }
   //#endregion Public Methods
}
