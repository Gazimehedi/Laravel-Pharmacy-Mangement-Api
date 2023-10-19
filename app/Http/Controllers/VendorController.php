<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function list()
    {
        try {
            $data = Vendor::select(['id','name','description'])->get();
            return response()->json([
                "status" => "success",
                "data" => $data
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request',
                'data' => null,
            ], 500);
        }
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:vendors,name",
            "description" => "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first(),
            ],400);
        }
        try{
            Vendor::create([
                "name" => $request->name,
                "description" => $request->description
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Vendor created successfully"
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request',
                'data' => null,
            ], 500);
        }

    }
    public function update(Request $request , $id){
        $validator = Validator::make($request->all(),[
            "name" => "required|unique:vendors,name,".$id,
            "description" => "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first(),
            ],400);
        }
        try{
            $data = Vendor::where('id',$id)->update([
                'name' => $request->name,
                "description" => $request->description
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Vendor updated successfully",
                "data" => $data
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request',
                'data' => null,
            ], 500);
        }

    }
    public function delete($id){
        try{
            Vendor::where('id',$id)->delete();
            return response()->json([
                "status" => "success",
                "message" => "Vendor deleted successfully",
            ]);
        } catch (\Throwable$th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad request',
                'data' => null,
            ], 500);
        }

    }
}
