<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use App\Models\LogicType;
use App\Models\Rule;
use DB;
use Illuminate\Validation\Rule as ValidateRule;
class SagmentController extends Controller
{
    public function index(){
        $segments = Segment::all();
        return view('segment.Segments',compact('segments'));
    }
    public function create(){
        $data  = [];
        $columns         = LogicType::all();
        $data['columns'] = $columns;
        return view('segment.create',$data);
    }
    public function store(Request $request){
        $columns         = LogicType::all();
        $validRule  = array( 
            'segment_name' => 'required|unique:segments,sagment_name'
        );
        foreach($columns as $column){
            $columnName                      = $column->subscribers_column_name;
            $validRule[$columnName.'.value'] = 'array';
            $validRule[$columnName.'.logic.*'] = [ ValidateRule::requiredIf(function () use ($request,$columnName) {
                foreach($request->{$columnName} as $key=>$value){
                    if(isset($request->{$columnName}['value'][$key])){
                        return $request->{$columnName}['value'][$key] != null;
                    }
                }
            })];
           
            $validRule[$columnName.'.option'] = 'array';
        }
        $request->validate($validRule);
        //array:8 [▼
        //   "segment_name" => null
        //   "first_name" => array:3 [▼
        //     "logic" => array:2 [▼
        //       0 => "29"
        //       1 => "31"
        //     ]
        //     "value" => array:2 [▼
        //       0 => "dfgsdg"
        //       1 => "asdfasdf"
        //     ]
        //     "option" => array:2 [▼
        //       0 => "or"
        //       1 => null
        //     ]
        //   ]
        //       
        //   "last_name" => array:3 [▼
        //     "logic" => array:1 [▶]
        //     "value" => array:1 [▶]
        //     "option" => array:1 [▶]
        //   ]
        //   "email" => array:3 [▶]
        //   "birth_day" => array:3 [▶]
        //   "created_at" => array:3 [▶]
        //   "updated_at" => array:3 [▶]
        try{
            DB::beginTransaction();
            $segment = Segment::create(['sagment_name'=>$request->segment_name]);
            foreach($request->all() as $key=>$column){
                
                if(is_array($column)){
                    $data = [
                       'column' => $key,
                       'logic'  => $column['logic'] ?? null,
                       'value'  => $column['value'] ?? null,
                       'option' => $column['option'] ?? null
     
                    ];
                    $rule = Rule::create([
                        'rule'       => json_encode($data),
                        'segment_id' => $segment->id
                    ]);
                }
            }
            DB::commit();
            $request->session()->flash('flash_success_message',"Your segment has been added successfully");
            return redirect()->route('segment.logic.index');
        }catch(\Exception $e){

            DB::rollBack();
            dd($e->getMessage());
            $request->session()->flash('flash_error_message', $e->getMessage());
            return redirect()->back();
        }
        return view('Sagments',compact('sagments'));
    }
    public function edit(){
        $sagments = Segment::all();
        return view('Sagments',compact('sagments'));
    }
}