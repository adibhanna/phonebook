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
        notes: '',
        nameIsValid: true,
        phoneIsValid: true,
        updating: false,
        updateId: null,
        searchQuery: null,

        pagination: {
            page: 1,
            previous: false,
            next: false
        },

    },

    ready() {
        this.$http({url: '/api/contacts', method: 'GET'}, {page: this.pagination.page}).then(function (response) {
            this.$set('contacts', response.data.data);
            this.pagination.previous = response.data.prev_page_url;
            this.pagination.next = response.data.next_page_url;
        }, function (response) {
            console.log('Something wrong happened while fetching the contacts.');
        });
    },

    methods: {
        paginate(direction) {
            if (direction === 'previous') {
                --this.pagination.page;
            }
            else if (direction === 'next') {
                ++this.pagination.page;
            }
            this.$http({url: '/api/contacts?page='+this.pagination.page, method: 'GET'}).then(function (response) {
                this.$set('contacts', response.data.data);
                this.pagination.previous = response.data.prev_page_url;
                this.pagination.next = response.data.next_page_url;
            }, function (response) {
                console.log('Something wrong happened while fetching the contacts.');
            });

        },

        addContact() {
            if(this.validateName() && !this.validatePhone()) {
                this.nameIsValid = true; this.phoneIsValid = false;
            } else if(!this.validateName() && this.validatePhone()) {
                this.nameIsValid = false; this.phoneIsValid = true;
            } else if(!this.validateName() && !this.validatePhone()) {
                this.nameIsValid = false; this.phoneIsValid = false;
            } else if(this.validateName() && this.validatePhone()) {

                var data = {
                    name: this.name,
                    phone: this.phone,
                    notes: this.notes,
                };

                this.$http.post('/api/contacts', data, function (data) {
                    this.contacts.push(data);
                    this.clearFields();
                    this.hideValidationMessages();
                }).catch(function (data) {
                    console.log('Something wrong happened while adding the contacts.');
                });
            }
        },

        editContact(contact) {
            this.updating = true;
            this.updateId = contact.id;
            this.name = contact.name;
            this.phone = contact.phone;
            this.notes = contact.notes;

            this.contacts.$remove(contact);
        },

        updateContact() {
            if(this.validateName() && !this.validatePhone()) {
                this.nameIsValid = true; this.phoneIsValid = false;
            } else if(!this.validateName() && this.validatePhone()) {
                this.nameIsValid = false; this.phoneIsValid = true;
            } else if(!this.validateName() && !this.validatePhone()) {
                this.nameIsValid = false; this.phoneIsValid = false;
            } else if(this.validateName() && this.validatePhone()) {

                var data = {
                    name: this.name,
                    phone: this.phone,
                    notes: this.notes,
                };

                this.$http.put('/api/contacts/'+this.updateId+'/update', data, function (data) {
                    this.contacts.push(data);
                    this.clearFields();
                    this.hideValidationMessages();
                }).catch(function (data) {
                    console.log('Something wrong happened while fetching the contacts.');
                });
            }        },

        removeContact(contact) {
            this.$http({url: '/api/contacts/'+contact.id, method: 'DELETE'}).then(function (response) {
                this.contacts.$remove(contact);
            }, function (response) {
                console.log('Something wrong happened while deleting the contact.');
            });
        },

        search() {
            this.searchQuery = (this.searchQuery == null) ? '' : this.searchQuery.trim();
            if(this.searchQuery) {
                this.$http({
                    url: '/api/contacts/search?q=' + this.searchQuery,
                    method: 'GET'
                }).then(function (response) {
                    this.$set('contacts', response.data.data);
                }, function (response) {
                    console.log('Something wrong happened while fetching the contacts.');
                });
            } else {
                this.$http({url: '/api/contacts', method: 'GET'}).then(function (response) {
                    this.$set('contacts', response.data.data);
                }, function (response) {
                    console.log('Something wrong happened while fetching the contacts.');
                });
            }
        },

        validateName() {
            if(this.name == '') {
                return false;
            }

            return true;
        },

        validatePhone() {
            if(this.phone == '') {
                return false;
            }

            return true;
        },

        clearFields() {
            this.name = '';
            this.phone = '';
            this.notes = '';
        },

        hideValidationMessages() {
            this.nameIsValid = true;
            this.phoneIsValid = true;
        }
    }
});
