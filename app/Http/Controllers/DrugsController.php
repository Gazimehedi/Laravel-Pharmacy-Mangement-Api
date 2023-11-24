<?php

namespace App\Http\Controllers;

use App\Models\Drugs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrugsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Drugs::leftJoin('vendors', 'drugs.vendor_id', 'vendors.id')->select(['drugs.*','vendors.name as vendor'])->get();
            return response()->json([
                'status'=>'success',
                'data'=>$data
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>'internal server error',
                'data'=>null
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'vendor_id' => 'required',
            'weight' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'message'=>$validator->errors()->first()
            ], 400);
        }
        try{
            Drugs::create($request->all());
            return response()->json([
                'status'=>'success',
                'message'=>'Drugs Created Successfully'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>'internal server error',
                'data'=>null
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'vendor_id' => 'required',
            'weight' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'message'=>$validator->errors()->first()
            ], 400);
        }
        try{
            $drug = Drugs::find($id);
            if(!$drug){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Drugs Item not found!'
                ], 400);
            }
            $drug->update($request->all());
            return response()->json([
                'status'=>'success',
                'message'=>'Drugs Updated Successfully'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>'internal server error',
                'data'=>null
            ], 400);
        }
    }
    public function delete($id)
    {
        try{
            $drug = Drugs::find($id);
            if(!$drug){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Drugs Item not found!'
                ], 400);
            }
            $drug->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'Drugs Deleted Successfully'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status'=>'error',
                'message'=>'internal server error',
                'data'=>null
            ], 400);
        }
    }
}
