export const environment = {
  production: true,

  APP_TITLE: 'MGN Service',                            // APP Data
  APP_VERSION: '1.0.6',

  WEB_SITE_LOCAL: 'http://127.0.0.1:8000/',                 // localhost website
  WEB_SITE: 'https://gestionale.mgnservice.it/',             // public website url

  API_TOKEN: '5be65b9c-2902-4490-9640-45f8c6ad360b',        // API token
  API_LOGGER_ENABLED: true,                                 // enabled/disable API calling debug on console
  API_USE_LOCAL: true,                                     // when not on device, if true, point on API_END_POINT_LOCAL
  API_END_POINT_LOCAL: 'http://127.0.0.1:8000/api/app',     // localhost endpoint
  API_END_POINT: 'https://gestionale.mgnservice.it/api/app', // public endpoint

  LOCATION_TIMEOUT: 10,                                     // GPS location: request timout (in seconds)
  LOCATION_INERVAL: 10,                                     // interval (in seconds)
  MAX_PAUSE_TIMEOUT: 15,                                    // tempo massimo di pausa in minuti

  DEBUG_GPS: false,                                         // true to debug GPS data
  SOS_PHONE_NUMBER: '112',                                  // SOS Phone Number
};
