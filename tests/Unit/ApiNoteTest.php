<?php

namespace Tests\Feature;

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiNoteTest extends TestCase
{
    use DatabaseTransactions;
	
	function test_list_notes()
    {
    	$category = factory(Category::class)->create();

    	$notes = factory(Note::class)->times(2)->create([
    			'category_id' => $category->category_id
    		]);
    	
    	$this->get('api/v1/notes')
    		->assertStatus(200)
    		->assertExactJson($notes->toArray());
    }
}
