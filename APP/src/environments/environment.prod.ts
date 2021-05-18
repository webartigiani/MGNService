export const environment = {
  production: true,

  APP_TITLE: 'MGN Service',                            // APP Data
  APP_VERSION: '0.0.1',

  API_TOKEN: '5be65b9c-2902-4490-9640-45f8c6ad360b',        // API token
  API_LOGGER_ENABLED: false,                                // enabled/disable API calling debug on console
  API_USE_LOCAL: true,                                      // when not on device, if true, point on API_END_POINT_LOCAL
  API_END_POINT_LOCAL: 'http://127.0.0.1:8000/api/app',     // localhost endpoint
  API_END_POINT: 'http://gestionale.mgnservice.it/api/app', // public endpoint

  LOCATION_TIMEOUT: 5,                                      // GPS location: request timout (in seconds)
  LOCATION_INERVAL: 15                                      // interval (in seconds)
};
