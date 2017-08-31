@extends('layout')
@section('content')
  	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	      <h1>Styde.net | Curso de VueJS</h1>
			
		  <p v-show="error" class="alert alert-danger" id="error_message">@{{ error }}</p>

	      <table class="table table-striped">
	        <thead>
				<tr>
					<th>Categoría</th>
					<th>Nota</th>
					<th width="50px">&nbsp;</th>
				</tr>
	        </thead>
	        <tbody>
				<tr v-for="note in notes" is="note-row" :note.sync="note" :categories="categories"></tr>
				<tr>
					<td>
						<select-category :id.sync="new_note.category_id" :categories="categories"></select-category>
					</td>
					<td>
						<input type="text" v-model="new_note.note" class="form-control">
						<ul v-if="errors.length" class="text-danger">
							<li v-for="error in errors">@{{ error }}</li>
						</ul>
					</td>
					<td>
						<a href="#" @@click.prevent="createNote()">
							<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						</a>
					</td>					
				</tr>
	        </tbody>
	      </table>
			<pre>
				@{{ $data | json }}
			</pre>
	    </div>
			  		
  	</div>
@endsection

@section('scripts')
	@verbatim
	<template id="select_category_tpl">
		<select v-model="id" class="form-control" >
			<option value="">- Seleccione la categoria</option>
			<option :value="category.id" v-for="category in categories">
				{{ category.name }}
			</option>
		</select>		
	</template>

	<template id="note_row_tpl">
		<tr>
			<template v-if="! editing">
			  <td>{{ note.category_id | category }}</td>
			  <td>{{ note.note }}</td>
			  <td>
			    <a href="#" @click.prevent="edit()">
			    	<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			    </a>
			    <a href="#" @click="remove()">
			      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			    </a>
			  </td>
			</template>
			<template v-else>
				<td>
					<select-category :categories="categories" :id.sync="draft.category_id"></select-category>
				</td>
				<td>
					<input type="text" v-model="draft.note" class="form-control">
					<ul v-if="errors.length" class="text-danger">
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</td>
				<td>
					<a href="#" @click.prevent="update()">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
					</a>
					<a href="#" @click.prevent="cancel()">
				      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				    </a>
				</td>
			</template>
		</tr>		

	</template>

    @endverbatim
	<script src={{url("js/jquery-3.2.1.min.js")}} ></script>
    <script src={{url("js/vue.js")}} ></script>
    <script src={{url("js/vue-resource.min.js")}} ></script>
    <script src={{url("js/notes.js")}} ></script>

@endsection