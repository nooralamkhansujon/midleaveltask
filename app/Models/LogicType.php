<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicType extends Model
{
    use HasFactory;
    protected $fillable = ['subscribers_column_name','logic_type'];
    public function logics($logic_type){
        return  Logic::where('logic_type',$logic_type)->get();
    }
}
