<?php

use Illuminate\Database\Seeder;

class NoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        $notes = factory(App\Note::class)->times(20)->make();

        foreach ($notes as $note) {
        	$category = $categories->random();

        	$category->notes()->save($note);
        }
    }
}
