<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lenses extends Model
{
    use HasFactory;
    protected $guarded=[];
    const IMAGE_PATH = 'lenses/';
    public $timestamps = false;

    public function lens_type(){
        return $this->belongsTo(LensTypes::class, 'type_id');
    }
}
