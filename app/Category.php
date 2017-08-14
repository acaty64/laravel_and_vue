<?php

namespace App;

use App\Note;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	
    public function notes()
    {
    	return $this->hasMany(Note::class);
    }
}
