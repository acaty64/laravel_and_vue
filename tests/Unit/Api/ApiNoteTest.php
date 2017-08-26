<?php

namespace Tests\Feature;

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;
	
    protected $note = 'This is a note';

	function test_list_notes()
    {
        $category = factory(Category::class)->create();

        $notes = factory(Note::class)->times(2)->create([
                'category_id' => $category->category_id
            ]);
        
        $this->get('api/notes')
            ->assertStatus(200)
            ->assertExactJson($notes->toArray());
    }

    function test_can_create_a_note()
    {
    	$category = factory(Category::class)->create();
        
        $this->post('api/notes', [
            'note'          => $this->note,
            'category_id'   => $category->id])
            ->assertStatus(200) 
            ->assertExactJson([
                'success'   => true,
                'note'      => Note::first()->toArray(),
            ]);
        

        $this->assertDatabaseHas('notes',[
            'note'          => $this->note,
            'category_id'   => $category->id,
        ]);

    }

    function test_validation_when_creating_a_note()
    {
        //$category = factory(Category::class)->create();
        
        $this->post('api/notes', [
            'note'          => '',
            'category_id'   => 100
            ], ['Accept'=>'application/json'])
            ->assertExactJson([
                'success' => false,
                'errors'  => [
                    'The note field is required.',
                    'The selected category id is invalid.'
                ]
            ]);
//{"category_id":["The selected category id is invalid."],"note":["The note field is required."]}
        $this->assertDatabaseMissing('notes',[
            'note'          => ''
        ]);

    }

    function test_list_categories()
    {
        $categories = factory(Category::class)->times(3)->create();

        $this->get('api/categories')
            ->assertStatus(200)
            ->assertExactJson($categories->toArray());
    }

}
