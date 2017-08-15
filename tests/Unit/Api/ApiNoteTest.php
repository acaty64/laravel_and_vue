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

    /* NO ES NECESARIO, NO PERMITE note = ''
    function test_validation_when_creating_a_note()
    {
        $category = factory(Category::class)->create();
        
        $this->post('api/notes', [
            'note'          => '',
            'category_id'   => ''
            ])
            ->assertExactJson([
                'success' => false,
                'errors'  => [
                    'The note field is required.',
                    'The selected category is invalid.'
                ]
            ]);
        
        $this->assertDatabaseMissing('notes',[
            'note'          => ''
        ]);

    }*/

}
