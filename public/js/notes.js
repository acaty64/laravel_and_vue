function findById(items, id) {
   for (var i in items) {
      if (items[i].id == id) {
         return items[i];
      }
   }
   return null;
}

// Definimos el recurso (resource) de forma global (fuera del vm)
var resource;

Vue.filter('category', function (id) {
   var category = findById(this.categories, id);
   return category != null ? category.name : 'sin categoria';  
});

Vue.component('select-category',  {
   template: '#select_category_tpl',
   props: ['categories', 'id']
});

Vue.component('note-row',  {
   template: "#note_row_tpl",
   
   props: ['note', 'categories'],
   
   data: function () {
      return {
         editing: false,
         errors: [],
         draft: {},
      };
   },

   methods: {

      edit: function () {
         this.errors = [];

         this.draft = JSON.parse(JSON.stringify(this.note));

         this.editing = true;         
      },

      cancel: function () {
         this.editing = false;   
      },

      update: function () {
         this.errors = [];

         // declaramos una variable (component) que apunta al objeto this
         var component = this;

         resource.update({id: this.note.id}, this.draft)
            .then(function (response) {
               this.notes.$set(this.notes.indexOf(component.note), response.data.note);
               component.editing = false;
            }, function (response) {
               component.errors = response.data.errors;
            });
      },

      remove: function () {
         var component = this;

         resource.delete({id: this.note.id}).then(function (response) {
            alert('Registro eliminado: '+component.note.id);
            this.notes.$remove(component.note);
         });
      },

   },
});


var vm = new Vue({
   el: "#app",
   
   data: {
      new_note:{
         note: "",
         category_id: "",
      },

      notes: [],
      errors: [],
      categories: [],
      error: '',
   
   },

   ready: function () {
      // Declaramos el recurso
      resource = this.$resource('/api/notes{/id}');
      
      resource.get()
         .then(function (response) {
            this.notes = response.data;
         });  

      this.$http.get('/api/categories')
         .then(function (response) {
            this.categories = response.data;
         });



      Vue.http.interceptors.push({

         request: function (request) {
             return request;
         },

         response: function (response) {
             if (response.ok) {
                 return response;
             }

             $('#error_message').show();

             this.error = response.data.message;

             $('#error_message').delay(3000).fadeOut(1000, function () {
                 this.error = '';
             });

             return response;
         }.bind(this)

      });

   },

   methods: {
      createNote: function () {
         this.errors = [];

         resource.save({}, this.new_note)
            .then(function (response) {
               this.notes.push(response.data.note);
            }, function (response) {
               this.errors = response.data.errors;
         });

         this.new_note = {note:'', category_id:''};
      }
   },

   filters:{

   },

   computed: {

   },

});

