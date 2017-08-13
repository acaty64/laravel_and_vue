<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
	
	function testExample()
    {
    	factory(User::class)->create([
    			'name'=>'Duilio'
    		]);
        $this->get('name')
        	->assertStatus(200)
        	->assertSee('Duilio');
    }
}
