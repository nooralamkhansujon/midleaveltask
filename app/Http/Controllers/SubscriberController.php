<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\Segment;
use App\Models\Logic;
use DB;
class SubscriberController extends Controller
{
    public function index(){
        $subscribers = Subscriber::all();
        return view('SubscriberList',compact('subscribers'));
    }

    public function createSegment(){
        $data  = [];
        $columns         = LogicType::all();
        $data['columns'] = $columns;
        return view('sagments',$data);
    }

    public function getFilterdList(Request $request,Segment $segment){
        $query = Subscriber::query();
        $rules   = $segment->rules;
        DB::enableQueryLog();
        foreach($rules as $rule){
            $rule_data   = json_decode($rule->rule);
            $column = $rule_data->column;
            $index = 0;
            foreach($rule_data as $key=>$value){
                if(!is_array($value)) continue;
                //if index not exist then do nothing 
                if($index <= count($value)-1 ){
                    $val      = $rule_data->logic[$index] ?? null; // get logic id 
                    $logic    = Logic::find($val); //get logic via id ;
                    if($logic){
                        $logicVal = $logic->logic;
                        $search   = $rule_data->value[$index];
                        $option   = $rule_data->option[$index] ?? null;
                        if($option){
                            $query->{$logicVal}($column, $search,$option);
                       }else{
                           $query->{$logicVal}($column,$search);
                       }
                    }
                  
                }
               $index++;
            }
           
        }
        $filteredList = $query->get();
        // dd(DB::getQueryLog());
        $data                = array();
        $data['subscribers']     = $filteredList;
        $data['sagment_name']    =  $segment->sagment_name;

        return view('SubscriberFilteredList',$data);
    }
}
