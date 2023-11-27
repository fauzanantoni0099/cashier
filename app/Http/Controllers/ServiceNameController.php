<?php

namespace App\Http\Controllers;

use App\ServiceName;
use Illuminate\Http\Request;

class ServiceNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_names = ServiceName::latest()->paginate();
        $createRoute = route('service_name.create');

        return view('serviceNames.index',compact('service_names','createRoute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('serviceNames.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service_names = ServiceName::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price
        ]);

        return redirect()->route('service_name.index',compact('service_names'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceName  $serviceName
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceName $serviceName)
    {
        return view('serviceNames.show',compact('serviceName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceName  $serviceName
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceName $serviceName)
    {
        return view('serviceNames.edit',compact('serviceName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceName  $serviceName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceName $serviceName)
    {
        $serviceName->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price
        ]);
        return redirect()->route('service_name.index',compact('serviceName'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceName  $serviceName
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceName $serviceName)
    {
        $serviceName->delete();

        return redirect()->route('service_name.index');
    }
}
