<?php

namespace App\Http\Controllers;

use App\Service;
use App\ServiceDetail;
use App\ServiceName;
use Barryvdh\DomPDF\PDF;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate();
        $createRoute = route('service.create');

        return view('services.index',compact('services','createRoute'));
    }

    public function admin()
    {
        $services = Service::latest()->paginate();
        $createRoute = route('service.create');

        return view('services.indexadmin',compact('services','createRoute'));
    }

    /**s
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service_details = ServiceDetail::all();
        $service_names = ServiceName::all();
        return view('services.create',compact('service_details','service_names'));

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
            DB::beginTransaction();
            $code = 'DRWServices'.uniqid();
            $service = Service::create([
                'code'=>$code,
                'name_customer'=>$request->name_customer,
                'order_date'=>$request->order_date,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'total_amount'=>0,
                'pay'=>$request->pay,
                'returned'=>$request->pay - $request->price,
                'notes'=>$request->notes,
                'status'=>$request->status
            ]);
            $service_names =ServiceName::find($request->service_name_id);
            foreach ($service_names as $key =>$service_name)
            {
                $subtotal = $request->total_amount[$key] * $service_name->price;
                $service_detail = ServiceDetail::create([
                    'service_id'=> $service->id,
                    'service_name_id'=> $service_name->id,
                    'quantity'=> $request->total_amount[$key],
                    'subtotal'=>$subtotal
                ]);
            }
            $total = $service->ServiceDetails->sum('subtotal');
            $service->update([
                'total_amount'=>$total,
                'returned'=>$request->pay-$total
            ]);
            DB::commit();
            return redirect()->route('service.index',$service);
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('services.show',compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $service_details = ServiceDetail::all();
        $service_names = ServiceName::all();
        return view('services.edit',compact('service','service_details','service_names'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->update([
            'name_customer'=>$request->name_customer,
            'order_date'=>$request->order_date,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'total_amount'=>0,
            'pay'=>$request->pay,
            'returned'=>$request->pay - $request->price,
            'notes'=>$request->notes,
            'status'=>$request->status
        ]);

//        dd($request->all());
        $service_names =ServiceName::find($request->service_name_id);
        foreach ($service_names as $key =>$service_name)
        {
            $subtotal = $request->total_amount[$key] * $service_name->price;
            $service_detail = ServiceDetail::query()
            ->where([
                'service_id'=> $service->id,
                'service_name_id'=> $service_name->id,
                ])
            ->first();
            $service_detail->update([
                'quantity'=> $request->total_amount[$key],
                'subtotal'=>$subtotal
            ]);
        }
        $total = $service->ServiceDetails->sum('subtotal');
        $service->update([
            'total_amount'=>$total,
            'returned'=>$request->pay-$total
        ]);

        return redirect()->route('service.index',compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.admin');
    }
    public function printBarcode(Service $service, PDF $PDF)
    {

        return $PDF->loadView('services.print',compact('service'))
            ->setPaper([0, 0, 260, 600])
            ->stream('service.pdf');

    }
    public function dailyReport()
    {
        $tanggal = request()->input('tanggal');
        $services =Service::latest()->whereDate('order_date',$tanggal)->get();
        return view('services.dailyreport',compact('services','tanggal'));
    }
    public function monthlyReport()
    {
        $bulanDanTahun = request()->input('bulan');
        $services=[];
        if ($bulanDanTahun){
            $delimeter ="-";
            $resultArray=explode($delimeter,$bulanDanTahun);
            $bulan=$resultArray[1];
            $tahun=$resultArray[0];
            $services =Service::latest()->whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->get();
        }
        return view('services.monthlyreport',compact('services','bulanDanTahun'));
    }
    public function annualReport()
    {
        $tahun = request()->input('tahun');
        $services =Service::latest()->whereYear('order_date',$tahun)->get();
        return view('services.annualreport',compact('services','tahun'));
    }
    public function reportPdfDaily($tanggal,PDF $PDF)
    {
        $total= Service::where('order_date',$tanggal)->sum('total_amount');
        $services =Service::latest()->where('order_date',$tanggal)->get();
        return $PDF->loadView('services.reportpdfdaily',compact('services','tanggal','total'))
            ->setPaper('A4')
            ->stream('ServiceReportDaily.pdf');

    }
    public function reportPdfMonth($bulanDanTahun, PDF $PDF)
    {
        $services=[];
        if ($bulanDanTahun){
            $delimeter ="-";
            $resultArray=explode($delimeter,$bulanDanTahun);
            $bulan=$resultArray[1];
            $tahun=$resultArray[0];
            $services =Service::latest()->whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->get();
        }
        $total= Service::whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->sum('total_amount');
        return $PDF->loadView('services.reportpdfmonth',compact('services','bulanDanTahun','total'))
            ->setPaper('A4')
            ->stream('ServiceReportMonth.pdf');
    }
    public function reportPdfAnnual($tahun, PDF $PDF)
    {
        $services =Service::latest()->whereYear('order_date',$tahun)->get();
        $total= Service::whereYear('order_date',$tahun)->sum('total_amount');
        return $PDF->loadView('services.reportpdfannual',compact('services','total','tahun'))
            ->setPaper('A4')
            ->stream('ServiceReportAnnual.pdf');

    }
}
