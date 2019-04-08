
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
  el: '#app',
  data: {
  	currentUser: { id: null, name: '', notes: [], },
  	newNote: '',
  	disableSubmit: true,
  },
  watch: {
  	newNote: function(newVal, oldVal){
  		this.disableSubmit = newVal.length > 1 ? false : true;
  	},
  },
  methods: {
    // open the model to add note, set the currentUser and get the notes
    openModal: function(userName, userId){
    	this.currentUser.name = userName;
    	this.currentUser.id = userId;
    	this.getNotes(userId);
    },
    // get the notes
    getNotes: function(userId){
      axios.get('/user_notes/' + userId, {
      }).then(function(resp){
        app.currentUser.notes = resp.data.notes;
      }).catch(function(err){
        console.log(err);
        app.currentUser.notes = [];
      });
    },
    //add a new note
    addUserNote: function(note, userId){
    	axios.post('/save_usernote', {
        note: note,
        user_id: userId,
      }).then(function(resp){
        app.newNote = '';
        app.currentUser.notes.splice(0,0,{id: resp.data.note_id, body: note, created_at: resp.data.created_at});
      }).catch(function(err){
        console.log(err);
      });
    },
  },
});
