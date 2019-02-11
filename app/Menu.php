<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'mysql';
    
    protected $table = 'user_menu';
    
    public $primaryKey = 'id';
    
    public $incrimenting = true;
    
}
