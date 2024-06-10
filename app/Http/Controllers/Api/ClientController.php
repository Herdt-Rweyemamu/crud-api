<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;

class ClientController extends Controller
{


 public function index(){

    $clients = Client::all();

    if($clients->isEmpty()){
        return response()->json(['message'=>'No data Founds'], 404);
    }

    return response()->json($clients,200);
 }

     public function store(Request $request){

        $validator = Validator::make($request->all(),
        [
            'name'=>'required|string|max:191',
            'address'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'tin'=>'required|digits:4',
            'vrn'=>'required|digits:4',
        ]
        );
        if($validator->fails()){
            return response()->json([
                'status'=> 422,
                'errors'=> $validator->messages()
            ], 422);
        }
        
        else{

            $client = Client::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'email'=>$request->email,
                'tin'=>$request->tin,
                'vrn'=>$request->vrn,
            ]);


            if($client){
                return response()->json([
                    'status'=> 200,
                    'message'=> "Client Created Successfully "
                ],200);
            }else{

                return response()->json([
                    'status'=> 500,
                    'message'=>"Something Went Wrong!"
                ],500); 
            }
        }
     }

     public function edit(Request $request, $id){
        $client = Client::find($id);

        return response()->json($client,200);
     }

     public function update(Request $request, int $id){

        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'address'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'tin'=>'required|digits:4',
            'vrn'=>'required|digits:4',
        ]);

        if($validator->fails()){

            return response()->json([
                'staus'=>422,
                'errors'=> $validator->messages()
            ],422);
        }
        else{

            $client = Client::find($id);
            if($client){
                $client->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'email'=>$request->email,
                'tin'=>$request->tin,
                'vrn'=>$request->vrn,
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>"Client Updated Successfully"
                ],200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>"Client Updated Successfully"
                ],404);
            }
        }
     }

     public function destroy($id){
         $client = Client::find($id);
         if($client){
            $client->delete();

            return response()->json([
                'status'=>200,
                'message'=>"Client Deleted Successfully"
            ],200);
         }else
         {

            return response()->json([
                'status'=>404,
                'message'=>"No such Client Found"
            ],404);
         }
     }
}
