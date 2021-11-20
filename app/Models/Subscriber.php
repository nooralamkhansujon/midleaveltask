<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['first_name','last_name','email','birth_day'];
    public function getLogics($column){
        if($column === 'created_at' || 
           $column === 'updated_at' ||
           $column === 'birth_day'){
             return Logic::where('logic_type','date')->get();
        }
        return Logic::where('logic_type','text')->get();
    }
    public function scopeIs($query,$key,$value,$plus='and'){
        if($plus == "and") return $query->where("{$key}",$value);
        return $query->where("{$key}",$value);
    }
    public function scopeIs_not($query,$key,$value,$plus='and'){
        if($plus == "and") return $query->where("{$key}","!=",$value);
        return $query->where("{$key}","!=",$value);
    }
    public function scopeStarts_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'like',"{$value}%");
        return $query->orwhere("{$key}",'like',"{$value}%");
    }
    public function scopeEnds_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'like',"%{$value}");
        return $query->orwhere("{$key}",'like',"${$value}");
    }
    public function scopeLikeStarts_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'like',"{$value}%");
        return $query->orwhere("{$key}",'like',"{$value}%");
    }
    public function scopeLike_does_not_starts_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'NOT LIKE',"{$value}%");
        return $query->orWhere("{$key}",'NOT LIKE',"{$value}%");
    }
    public function scopeLike_does_not_ends_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'NOT LIKE',"%{$value}");
        return $query->orWhere("{$key}",'NOT LIKE',"%{$value}");
    }
    public function scopeLike_ends_with($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'like',"%{$value}");
        return $query->orWhere("{$key}",'like',"%{$value}");
    }
    public function scopeContains($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'LIKE',"%{$value}%");
        return $query->orWhere("{$key}",'LIKE',"%{$value}%");
    }
    public function scopeDoes_not_contains($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->where("{$key}",'NOT LIKE',"%{$value}%");
        return $query->orWhere("{$key}",'NOT LIKE',"%{$value}%");
    }
    public function scopeOn($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->whereDate($key,'=',$value);
        return $query->whereDate($key,'=',$value);
    }
    public function scopeOn_or_before($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->whereDate($key,'=',$value)->orWhereDate($key,'<',$value);
        return $query->orWhereDate($key,'=',$value)->orWhereDate($key,'>',$value);
    }
    public function scopeOn_or_after($query,$key,$value,$plus="and"){
        if($plus == "and") return $query->whereDate($key,'=',$value)->orWhereDate($key,'>',$value);
        return $query->orWhereDate($key,'=',$value)->orWhereDate($key,'>',$value);
    }
    public function scopeBetween($query,$key,$value,$value2,$plus="and"){
        if($plus == "and") return $query->whereBetween($key,'=',[$value,$value2]);
        return $query->orWhereBetween($key,'=',[$value,$value2]);
    }
    public function scopeAfter($query,$key,$value,$plus="and"){
        if($plus == 'and') return $query->whereDate($key,">",$value);
        return $query->orWhereDate($key,">",$value);
    }

    public function scopeBefore($query,$key,$value,$plus="and"){
        if($plus == 'and') return $query->whereDate($key,'<',$value);
        return $query->orWhereDate($key,'<',$value);
    }
}