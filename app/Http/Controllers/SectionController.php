<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $treeJSON = \App\Section::whereNull('parent_id')
        ->with('grandchildren')
        ->get();
        $all = \App\Section::all();

        $tree='<ul id="tree" class="filetree">';
        foreach ($treeJSON as $root) {
             $tree .='<li class="tree-view open"><span class="tree-name">'.$root->name.'</span>&nbsp;<a nodeId="'.$root->id.'" class="btn btn-sm btn-danger deleteNode">Delete Section <i class="fa fa-trash"></i></a>&nbsp;<a nodeId="'.$root->id.'" class="btn btn-sm btn-primary viewNode">View Test Cases <i class="fa fa-eye"></i></a>';
             if(count($root->grandchildren)) {
                $tree .=$this->childView($root);
            }
        }
        $tree .='<ul>';
        return view('index',compact('tree','all'));
    }
    public function childView($Section){                 
        $html ='<ul>';
        foreach ($Section->grandchildren as $arr) {
            if(count($arr->grandchildren)){
            $html .='<li class="tree-view open"><span class="tree-name">'.$arr->name.'</span>&nbsp;<a nodeId="'.$arr->id.'" class="btn btn-sm btn-danger deleteNode">Delete Section <i class="fa fa-trash"></i></a>&nbsp;<a nodeId="'.$arr->id.'" class="btn btn-sm btn-primary viewNode">View Test Cases <i class="fa fa-eye"></i></a>';                  
                    $html.= $this->childView($arr);
                }else{
                    $html .='<li class="tree-view"><span class="tree-name">'.$arr->name.'</span>&nbsp;<a nodeId="'.$arr->id.'"  class="btn btn-sm btn-danger deleteNode">Delete Section <i class="fa fa-trash"></i></a>&nbsp;<a nodeId="'.$arr->id.'" class="btn btn-sm btn-primary viewNode">View Test Cases <i class="fa fa-eye"></i></a>';                                 
                    $html .="</li>";
                }       
        }
        $html .="</ul>";
        return $html;
    }  

    public function destroySection(Request $request){
        $old = \App\Section::find($request->section_id);
        if($old){
            $old->delete();
            return response()->json(["status"=>"success","code"=> 200, "message"=>'Section & thier children Has been deleted'],200);
        }
        else{

            return response()->json(["status"=>"success","code"=> 404, "message"=>'Section Not found'],404);
        }
    }

    public function addSection(Request $request){
        $new  = new \App\Section();
        $new->parent_id = $request->parent_id;
        $new->name = $request->name;
        $new->save();
        return response()->json(["status"=>"success","code"=> 200, "message"=>'New Section Added'],200);
    }

    public function getTestCase($id){
        return \App\Section::where('id',$id)->with('testCases')->first();
    }

    public function destroyTestCase(Request $request){
        $old = \App\TestCase::find($request->testcase_id);
        if($old){
            if(\File::exists(public_path('uploads/'.$old->file))){
                \File::delete(public_path('uploads/'.$old->file));
            }
            $old->delete();
            return response()->json(["status"=>"success","code"=> 200, "message"=>'Test Case Has been deleted'],200);
        }
        else{

            return response()->json(["status"=>"success","code"=> 404, "message"=>'Test Case Not found'],404);
        }
    }

    public function addTestCase(Request $request){
        //return $request;
        $new  = new \App\TestCase();
        $new->section_id = $request->section_id;
        $new->summary = $request->summary;
        $new->description = $request->description;
        if($request->has('file') && $request->file){
            $file       = $request->file('file');
            $filename    = 'testcase'.time().'.'.$file->extension();
            $file->move(public_path('uploads'), $filename);
            $new->file = $filename;
        }
        $new->save();
        return response()->json(["status"=>"success","code"=> 200, "message"=>'New Test Case Added'],200);
    }

}
