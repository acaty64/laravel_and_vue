<?php

namespace Tests\Feature;

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiNote2Test extends TestCase
{
    use DatabaseTransactions;
	

    function test_can_update_a_note()
    {
        $category = factory(Category::class)->create();
        $anotherCategory = factory(Category::class)->create();
    	
        $note = factory(Note::class)->create();
        
        $this->put('api/notes/'.$note->id, [
                'note'          => 'Updated note',
                'category_id'   => $anotherCategory->id])
            ->assertStatus(200) 
            ->assertExactJson([
                'success'   => true,
                'note'      => [
                        'id'    => $note->id,
                        'category_id' => $anotherCategory->id,
                        'note'  => 'Updated note'
                    ],
            ]);
        

        $this->assertDatabaseHas('notes',[
            'note'          =>'Updated note',
            'category_id'   => $anotherCategory->id,
        ]);

    }

    function test_validation_when_updating_a_note()
    {
        $category = factory(Category::class)->create();
        $note = factory(Note::class)->create();

        $this->put('api/notes/'.$note->id, [
                    'note'          => '',
                    'category_id'   => 100
                ],['Accept'=>'application/json'])
            ->assertExactJson([
                'success' => false,
                'errors'  => [
                    'The note field is required.',
                    'The selected category id is invalid.'
                ]
            ]);

        $this->assertDatabaseMissing('notes',[
            'note'          => ''
        ]);

    }


}
