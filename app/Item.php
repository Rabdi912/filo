<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Item extends Model
{
    use Sortable;
    public $sortable = ['id','category','date_found','color'];
    public $fillable = ['id','category','date_found','color'];
     //Table Name
     protected $table='items';
     //Primary Key
     public $primaryKey ='id';
     //Timestamps 
     public $timestamps=true;
     public function user(){
         return $this->belongsTo('App\user');
     }
     
   
}
