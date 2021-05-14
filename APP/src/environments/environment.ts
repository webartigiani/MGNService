// This file can be replaced during build by using the `fileReplacements` array.
// `ng build --prod` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

export const environment = {
  production: false,

  APP_TITLE: 'MGN Service',                                 // APP Data
  APP_VERSION: '0.0.1',

  API_TOKEN: '5be65b9c-2902-4490-9640-45f8c6ad360b',        // API token
  API_LOGGER_ENABLED: true,                                // enabled/disable API calling debug on console
  API_USE_LOCAL: false,                                      // when not on device, if true, point on API_END_POINT_LOCAL
  API_END_POINT_LOCAL: 'http://127.0.0.1:8000/api/app',     // localhost endpoint
  API_END_POINT: 'http://gestionale.mgnservice.it/api/app', // public endpoint

  LOCATION_TIMEOUT: 5,                                      // GPS location: request timout (in seconds)
  LOCATION_INERVAL: 15                                      // interval (in seconds)
};

/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/dist/zone-error';  // Included with Angular CLI.
