<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {

        $results = JobOffer::when($request->userName, function ($query, $userName) {
            return $query->where('staff_id' , $userName);
        })
        ->when($request->user_name, function ($query, $userName){
            return $query->where('kana' , 'like', "%{$userName}%");
        })
        ->when($request->team, function ($query, $team){
            return $query->where('team' , $team);
        })
        ->when($request->general == '0' || $request->athlete == '1', function ($query) use ($request){
            $in = $request->only('general', 'athlete');
            $in = array_filter($in, 'strlen');

            return $query->whereIn('activity_type' , $in);
        })
        ->when($request->update, function ($query){
            return $query->where( function( $query ) {
                $query->whereHas('chatRoom.chats' , function ($query){
                    $query->where('show_of_admin', false);
                })
                ->orWhereHas('nutritions.comments' , function ($query){
                    $query->where('show_of_admin', false);
                });
            });

        })
        ->when($request->new, function ($query){
            return $query->whereNull('start_day');
        })
        ->when($request->source_id, function ($query, $sourceId){
            return $query->where('source_id' , $sourceId);
        })
        ->get();

        return view('job_offer.index')
        ->with([
            // 'jobOffers' => $jobOffers,
            // 'clientsearch' => $clientsearch,
            // 'phonesearch' =>$phonesearch,
        ]);
    }
//   //------------------新規登録--------------------
//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('customers.create');
//     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = request()->validate([
                'company_id' => ['required'],
                'handling_office'=> ['required',],
                'client_name'=> ['required',],
                'client_name_kana'=> ['required',''],
                'postal'=> ['required',],
                'prefectures'=> ['required',],
                'municipalities'=> ['required',],
                'streetbunch'=> ['required',],
                'phone'=> ['required',],
                //'fax'=> ['required',],
                //'website'=> ['required',],
                //'industry'=> ['required',],
                //'remarks'=> ['required',],
                //'inflowroute'=> ['required',],
                'navi_no'=> ['required',],
                //'established'=> ['required',],
                //'deadline'=> ['required',],
                //'invoicemustarrivedate'=> ['required',],
                //'paymentdate'=> ['required',],
                //'company_rank'=> ['required',],

            ]);
            $customer = Customer::create($attribute);
            return redirect('/customers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *yy
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $customer = Customer::find($id);
        $customer->company_id =$request->input('company_id');
        $customer->handling_office = $request->input('handling_office');
        $customer->client_name = $request->input('client_name');
        $customer->client_name_kana = $request->input('client_name_kana');
        $customer->postal = $request->input('postal');
        $customer->prefectures = $request->input('prefectures');
        $customer->municipalities = $request->input('municipalities');
        $customer->streetbunch = $request->input('streetbunch');
        $customer->phone = $request->input('phone');
        $customer->fax = $request->input('fax');
        $customer->website = $request->input('website');
        $customer->industry = $request->input('industry');
        $customer->remarks = $request->input('remarks');
        $customer->inflowroute = $request->input('inflowroute');
        $customer->navi_no = $request->input('navi_no');
        $customer->established = $request->input('established');
        $customer->deadline = $request->input('deadline');
        $customer->invoicemustarrivedate = $request->input('invoicemustarrivedate');
        $customer->paymentdate = $request->input('paymentdate');
        $customer->company_rank = $request->input('company_rank');

        $customer->save();
      return redirect('/customers')->with('success', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer =Customer::findOrFail($id);
        $customer->delete();

        return redirect('/customers');
    }
    public function __invoke(Request $request)
    {
        $customer = auth()->user();
        $this->authorize('viewAny', $customers);  // Policy をチェック
        $customers = \App\Models\Customers::get(); // 社員一覧を取得
        return view('customers.index', compact('customers')); // users.index.bldae を呼出し、 usersを渡す

    }
}
