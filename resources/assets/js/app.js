// Twitter bootstrap expects jQuery to be global that's why
// we are including jQuery and assigning it to the window.
window.$ = window.jQuery = require('jquery')

require('bootstrap-sass');
var Vue = require('vue');
Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $("meta[name=token]").attr("value");

new Vue({
    el: "#spaApp",
    data: {
        contacts: [],
        name: '',
        phone: '',
        notes: ''
    },
    ready() {
        this.$http({url: '/api/contacts', method: 'GET'}).then(function (response) {
            this.$set('contacts', response.data.data);
        }, function (response) {
            console.log('Something wrong happened while fetching the contacts.');
        });
    },

    methods: {
        addContact() {
            var data = {
                name: this.name,
                phone: this.phone,
                notes: this.notes,
            };

            this.$http({url: '/api/contacts', method: 'POST'}, data).then(function (response) {
                console.log(response);
                // this.contacts.push(response.data.data);
            }, function (response) {
                console.log('Something wrong happened while fetching the contacts.');
            });
        }
    }
});
