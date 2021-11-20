<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logic;
class LogicController extends Controller
{
    public function index($logic_type){
        $logic_types = Logic::where('logic_type',$logic_type)->get();
        return response()->json(compact('logic_types'));
    }
}
