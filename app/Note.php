<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //protected $visible = ['id', 'note', 'category_id'];
    protected $hidden = ['created_at', 'updated_at'];
   	protected $fillable = ['note', 'category_id'];
}
