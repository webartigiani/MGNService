export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/user/Profile.vue').default },

    { path: '/workers', component: require('./components/worker/Workers.vue').default },
    { path: '/timbrate', component: require('./components/timbrata/Timbrate.vue').default },
    { path: '/tracking', component: require('./components/tracking/Tracking.vue').default },

    { path: '/veichles', component: require('./components/veichle/Veichles.vue').default },
    { path: '/devices', component: require('./components/device/Devices.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },


    { path: '*', component: require('./components/_not_found.vue').default }
];
