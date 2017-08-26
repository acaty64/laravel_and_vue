function findById(items, id) {
   for (var i in items) {
      if (items[i].id == id) {
         return items[i];
      }
   }
   return null;
}

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

         $.ajax({
            url: '/api/notes/'+this.note.id,
            method: 'PUT',
            data: this.draft,
            dataType: 'json',
            success: function (data) {
               this.$parent.notes.$set(this.$parent.notes.indexOf(this.note), data.note);
               this.editing = false;
            }.bind(this),
            error: function (jqXHR) {
               this.errors = jqXHR.responseJSON.errors;
            }.bind(this),
         });

      },

      remove: function () {
         this.$http.delete('/api/notes/'+this.note.id).then(function (response) {
            alert('Registro eliminado: '+this.note.id);
            this.$parent.notes.$remove(this.note);
         }, function (response) {
            this.errors = response.data.errors;
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
   
   },

   ready: function () {

      $.getJSON('/api/notes', [], function (notes) {
             vm.notes = notes;
         });

      $.getJSON('/api/categories', [], function (categories) {
             vm.categories = categories;
         });

   },

   methods: {
      createNote: function () {
         this.errors = [];

         this.$http.post('/api/notes', this.new_note).then(function (response) {
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

