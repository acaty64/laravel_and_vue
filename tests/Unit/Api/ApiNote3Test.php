<?php

namespace Tests\Feature;

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiNote3Test extends TestCase
{
    use DatabaseTransactions;
	

    function test_can_delete_a_note()
    {
    	
        $note = factory(Note::class)->create();
        
        $this->delete('api/notes/'.$note->id)
            ->assertStatus(200) 
            ->assertExactJson([
                'success'   => true
            ]);
        

        $this->assertDatabaseMissing('notes',[
            'note'          => $note->note,
            'category_id'   => $note->category_id,
        ]);

    }


}
