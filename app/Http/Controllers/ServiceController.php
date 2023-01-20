<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try {
        $services = Service::all();
        if (count($services) == 0) {
            return response()->json([
                "error" => "Service not found"
            ],404);
        }
        return response()->json($services,200);
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
                "name"=>"required|string",
                "description"=>"required|string",
                "price"=>"required|integer"
            ]);
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->save();

            $data = [
                "message"=>"Service created successfully",
                "service"=>$service
            ];
            return response()->json($data,201);
        } catch (\Exception $e) {
            return response()->json([
                "error"=> $e->getMessage()
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
            $service = Service::find($id);
            if(!$service){
                return response()->json([
                    "error"=>"Service not found"
                ],404);
            }
            return response()->json($service,200);
        } catch (\Exception $e) {
            return response()->json([
                "error"=> $e->getMessage()
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
    public function update(Request $request, Service $service)
    {
        try {
            $request->validate([
                "name"=>"required|string",
                "description"=>"required|string",
                "price"=>"required|integer"
            ]);
           
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->save();

            $data = [
                "message"=>"Service updated successfully",
                "service"=>$service
            ];
            return response()->json($data,200);
        } catch (\Exception $e) {
            return response()->json([
                "error"=> $e->getMessage()
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
            $service = Service::find($id);
            if(!$service){
                return response()->json([
                    "error"=>"Service not found"
                ],404);
            }
            $service->delete();
            $data = [
                "message"=>"Service deleted successfully"
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "error"=>$e->getMessage()
            ],400);
        }
    }

    public function clients(Request $request){
        $service = Service::find($request->service_id);
        $clients = $service->clients;
        $data = [
            "message"=>"Clients fetched successfully",
            "clients"=>$clients
        ];
        return response()->json($data);
    }
}
