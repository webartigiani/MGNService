/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import Swal from 'sweetalert2';


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Swal = Swal;
window.Toast = Toast;

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/**
 * Routes imports and assigning
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

const router = new VueRouter({
    mode: 'history',
    routes
});
// Routes End


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Components
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('dashboard', require('./components/Dashboard.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/_not_found.vue').default
);

// Filter Section

Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});

Vue.filter('yesno', value => (value ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-times red"></i>'));

// end Filter

Vue.component('example-component', require('./components/ExampleComponent.vue'));
import VueMoment from 'vue-moment'
Vue.use(VueMoment)

const app = new Vue({
    el: '#app',
    router,

    // #region Properties
    data() {
        return {
            loading: true,
            url: window.location.origin,
            apkUrl: window.location.origin + '/downloads/app.apk',

            search: {
                query: ''
            },

            download: {
                saveCSV(response, filenName) {
                    /**
                     * Saves a download as CSV
                     * CSV data comes from response.data
                     * see: https://edionme.com/blogs/exportdownload-data-to-csv-with-laravel-and-vue
                     */
                    let data = response.data;
                    data = data.replace(new RegExp('<br>', 'g'), "\r\n")    // replaces <br> by CRLF

                    // Creates a dynamic download link from blob
                    const url = window.URL.createObjectURL(
                        new Blob([data], { type: "text/csv" })
                    );

                    // Creates a dynamic <a> element, sets this url and download-name, then clicks it
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", filenName + '.csv');
                    document.body.appendChild(link);
                    link.click();
                }
            },

            /**
             * Global Methods
             */
            utils: {
                generic: {
                    // Generic Methods
                    demo() {
                        console.warn('qui funzione demo')
                    },
                    functionNotAvailable() {
                        alert('Questa funzione sarà disponibile a breve.')
                        return
                    },
                    padZero(n) {
                        return (parseInt(n, 10) >= 10 ? '' : '0') + n
                    }
                },
                datetime: {
                    // dateTime Methods
                    dateAddDays(fromDate, days) {
                        if (fromDate == null) return ''
                        let ret = new Date()
                        ret.setDate(fromDate.getDate() + days)
                        return ret;
                    },
                    formatDate(date) {
                        // formats date by moment DD/MM/YYY
                        if (date==null) return ''
                        return new moment(date).format('DD/MM/YYYY')
                    },
                    formatDateISO(date) {
                        // formats date by moment
                        if (date==null) return ''
                        return new moment(date).format('YYYY-MM-DD')
                    },
                    formatDateTime(date) {
                        // formats date by moment DD/MM/YYY
                        if (date==null) return ''
                        return new moment(date).format('DD/MM/YYYY HH:mm:ss')
                    },
                }
            }
        }
    },
    // #endregion Properties

    // #region Methods
    methods: {
    },
    // #endregion Methods

    // #region App Life Cycle
    beforeCreate () {
    },
    created () {
    },
    beforeMount () {
    },
    mounted () {
        this.loading = false
    },
    beforeDestroy() {
    },
    destroyed() {
    }
    // #endregion App Life Cycle
});
