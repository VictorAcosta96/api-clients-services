<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $clients = Client::all();
            if (count($clients) == 0) {
                return response()->json([
                    "message"=>"Client not fount"
                ],404);
            }
            $array = [];
            foreach($clients as $client){
                $array[] = [
                    "name"=>$client->id,
                    "email"=>$client->email,
                    "phone"=>$client->phone,
                    "address"=>$client->address,
                    "services"=>$client->services
                ];
            }
            return response()->json($array, 200);
            // return response()->json($clients, 200);
        } catch (\Exception $e) {
            return response()->json([
                "error"=> $e->getMessage()
            ],400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                "name"=> "required|string",
                "email"=>"required|string",
                "phone"=>"required|string",
                "address"=>"required|string"
            ]);
    
            $client = new Client();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->save();
    
            $data = [
                "message"=>"Client created successfully",
                "client"=>$client
            ];
    
            return response()->json($data,201);
        } catch (\Exception $e) {
            return response()->json([
                "error"=>$e->getMessage()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $client = Client::find($id);
            if (!$client) {
                return response()->json([
                    "message"=>"Client not fount"
                ],404);
            }

            $data = [
                "Client datails",
                "client"=> $client,
                "services"=>$client->services
            ];

            return response()->json($data,200);
            // return response()->json($client,200);
        } catch (\Exception $e) {
            return response()->json([
                "error"=>$e->getMessage()
            ],400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        try {
            $request->validate([
                "name"=> "required|string",
                "email"=>"required|string",
                "phone"=>"required|string",
                "address"=>"required|string"
            ]);
    
            $client->name = $request->name;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->address = $request->address;
            $client->save();
    
            $data = [
                "message"=>"Client updated successfully",
                "client"=>$client
            ];
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "error"=>$e->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $client = Client::find($id);
            if (!$client) {
                return response()->json([
                    "message"=>"Client not fount"
                ],404);
            }
            $client->delete();
            $data = [
                "message"=>"Client deleted successfully",
                "client"=> $client
            ];
            return response()->json($data,200);
        } catch (\Exception $e) {
            return response()->json([
                "error"=>$e->getMessage()
            ],400);
        }
    }

    public function attach(Request $request){

        $client = Client::find($request->client_id);
        $client->services()->attach($request->service_id);
        $data = [
            "message"=>"Service attached successfully",
            "client"=> $client
        ];
        return response()->json($data);
    }

    public function detach(Request $request){

        $client = Client::find($request->client_id);
        $client->services()->detach($request->service_id);
        $data = [
            "message"=>"Service deached successfully",
            "client"=> $client
        ];
        return response()->json($data);
    }
}
