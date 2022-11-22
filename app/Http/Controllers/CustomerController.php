<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // if (auth()->user()->isSuperVisor()) {
                $customers = Customer::paginate();
            /**以下検索ワード */
                $clientsearch = $request->input('clientsearch');
                $phonesearch = $request->input('phonesearch');

                $query = Customer::query();
            if(!empty($clientsearch)){
                $query->where('client_name', 'like',"%{$clientsearch}%");
            }
            if(!empty($phonesearch)){
                $query->where('phone', 'like', "%{$phonesearch}%");
            }

                    $customers = $query->paginate();

        // } else {
        //     //スーパーじゃない
        //     $customers = Customer::paginate();
        //     /**以下クライアント名検索ワード */
        //         $clientsearch = $request->input('clientsearch');
        //         $phonesearch = $request->input('phonesearch');

        //         $query = Customer::query();
        //     if(!empty($clientsearch)){
        //         $query->where('client_name', 'like', "%{$clientsearch}%");
        //     }
        //     if(!empty($phonesearch)){
        //         $query->where('phone', 'like', "%{$phonesearch}%");
        //     }

        //             $customers = $query->paginate();
        // }
        return view('customers.index')
        ->with([
            'customers' => $customers,
            'clientsearch' => $clientsearch,
            'phonesearch' =>$phonesearch,
        ]);
    }
  //------------------新規登録--------------------
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('customers.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = request()->validate([
            'user_id' => ['required'],
            'company_type' => ['required'],
            'handling_office'=> ['required'],
            'name'=> ['required'],
            'kana'=> ['required'],
            'address'=> ['required'],
            'phone'=> ['required'],
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
