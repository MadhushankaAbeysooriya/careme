<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\DataTables\PaymentMethodDataTable;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaymentMethodDataTable $dataTable)
    {
        return $dataTable->render('payment_methods.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        PaymentMethod::create($request->all());
        return redirect()->route('payment_methods.index')->with('success','Payment Method Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        return view('payment_methods.show',compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        return view('payment_methods.edit',compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->toArray());
        return redirect()->route('payment_methods.index')->with('message', 'Payment Method Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }

    public function inactive($id){
        PaymentMethod::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('payment_methods.index')->with( 'success','Payment Method De-Activated');
    }

    public function activate($id){
        PaymentMethod::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('payment_methods.index')->with( 'success','Payment Method Activated');
    }
}
