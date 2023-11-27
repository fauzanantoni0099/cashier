<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\OrderDetail;
use App\Product;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->paginate();
        $createRoute = route('order.create');

        return view('orders.index',compact('orders','createRoute'));
    }
    public function admin()
    {
        $orders = Order::latest()->paginate();
        $createRoute = route('order.create');

        return view('orders.indexadmin',compact('orders','createRoute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $order_details = OrderDetail::all();

        return view('orders.create',compact('products','categories','order_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = 'DRWOrder'.uniqid(); //iko pr ADEK, misal ORDER001 / DRW-ORDER-01 / 17-08-2023-001
        $order = Order::create([
            'code'=> $code,
            'name_customer'=>$request->name_customer,
            'notes'=>$request->notes,
            'order_date'=>$request->order_date,
            'pay'=>$request->pay,
            'total_amount'=>0,
            'returned'=>0,
            'status'=>$request->status
        ]);
        $products = Product::find($request->product_id);
        foreach ($products as $key => $product)
        {
            $subTotal = $request->total_amount[$key] * $product->selling_price;

            $order_detail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->total_amount[$key],
                'subtotal' => $subTotal
            ]);
            if ($order->status == 'Sudah Dibayar'){
                $product->decrement('stock', $order_detail->quantity);
            }
        }
        $total = $order->OrderDetails->sum('subtotal');

        $order->update([
            'total_amount' => $total,
            'returned' =>$request->pay - $total
        ]);


        return redirect()->route('order.index', $order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        $categories = Category::all();
        $order_details = OrderDetail::all();

        return view ('orders.edit',compact('order','products','categories','order_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'name_customer'=>$request->name_customer,
            'notes'=>$request->notes,
            'order_date'=>$request->order_date,
            'pay'=>$request->pay,
            'total_amount'=>0,
            'returned'=>0,
            'status'=>$request->status
        ]);
        $products = Product::find($request->product_id);
        foreach ($products as $key => $product)
        {
            $subTotal = $request->total_amount[$key] * $product->selling_price;
            $order_detail = OrderDetail::query()
                ->where([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                ])
                ->first();
            $oldQuantity = $order_detail->quantity;
            $newQuantity = $request->total_amount[$key];
            $order_detail->update([
                    'quantity' => $newQuantity,
                    'subtotal' => $subTotal
                ]);

            if ($order->status == 'Belum Dibayar'){
                $product->increment('stock', $order_detail->quantity);
            }
            elseif ($order->status == 'Sudah Dibayar'){
                if ($oldQuantity > $newQuantity){
                    $selisih = $oldQuantity - $newQuantity;
                    $product->increment('stock', $selisih);
                }
                elseif ($oldQuantity < $newQuantity){
                    $selisih = $newQuantity - $oldQuantity;
                    $product->decrement('stock', $selisih);
                }
                elseif ($oldQuantity == $newQuantity){
                    $product->decrement('stock',$order_detail->quantity);
                }
            }



        }
        $total = $order->OrderDetails->sum('subtotal');
        $order->update([
            'total_amount' => $total,
            'returned' =>$request->pay - $total
        ]);

        return redirect()->route('order.index',compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('order.admin');
    }

    public function printBarcode(Order $order, PDF $PDF)
    {

        return $PDF->loadView('orders.print',compact('order'))
            ->setPaper([0, 0, 260, 600])
            ->stream('order.pdf');

    }
    public function dailyReport()
    {
        $tanggal = request()->input('tanggal');
        $orders =Order::latest()->whereDate('order_date',$tanggal)->get();
        return view('orders.dailyreport',compact('orders','tanggal'));
    }
    public function monthlyReport()
    {
        $bulanDanTahun = request()->input('bulan');
        $orders=[];
        if ($bulanDanTahun){
            $delimeter ="-";
            $resultArray=explode($delimeter,$bulanDanTahun);
            $bulan=$resultArray[1];
            $tahun=$resultArray[0];
            $orders =Order::latest()->whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->get();
        }
        return view('orders.monthlyreport',compact('orders','bulanDanTahun'));
    }
    public function annualReport()
    {
        $tahun = request()->input('tahun');
        $orders =Order::latest()->whereYear('order_date',$tahun)->get();
        return view('orders.annualreport',compact('orders','tahun'));
    }
    public function reportPdfDaily($tanggal,PDF $PDF)
    {
        $total= Order::where('order_date',$tanggal)->sum('total_amount');
        $orders =Order::latest()->where('order_date',$tanggal)->get();
        return $PDF->loadView('orders.reportpdfdaily',compact('orders','tanggal','total'))
            ->setPaper('A4')
            ->stream('OrderReportDaily.pdf');

    }
    public function reportPdfMonth($bulanDanTahun, PDF $PDF)
    {
        $orders=[];
        if ($bulanDanTahun){
            $delimeter ="-";
            $resultArray=explode($delimeter,$bulanDanTahun);
            $bulan=$resultArray[1];
            $tahun=$resultArray[0];
            $orders =Order::latest()->whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->get();
        }
        $total= Order::whereMonth('order_date', $bulan)->whereYear('order_date',$tahun)->sum('total_amount');
        return $PDF->loadView('orders.reportpdfmonth',compact('orders','bulanDanTahun','total'))
            ->setPaper('A4')
            ->stream('OrderReportMonth.pdf');
    }
    public function reportPdfAnnual($tahun, PDF $PDF)
    {
        $orders =Order::latest()->whereYear('order_date',$tahun)->get();
        $total= Order::whereYear('order_date',$tahun)->sum('total_amount');
        return $PDF->loadView('orders.reportpdfannual',compact('orders','total','tahun'))
            ->setPaper('A4')
            ->stream('OrderReportAnnual.pdf');

    }
}
