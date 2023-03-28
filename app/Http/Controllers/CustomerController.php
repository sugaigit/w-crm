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
        $customers = Customer::paginate();
        $users = User::all();
        /**検索ワード */
        $clientsearch = $request->input('clientsearch');
        $phonesearch = $request->input('phonesearch');
        $usersearch = $request->input('usersearch');
        $hasShowAll = $request->has('show_all');

        $query = Customer::query();
        if(!$hasShowAll){
            $query->where('is_show', true);
        }
        if(!empty($clientsearch)){
            $query->where('customer_name', 'like',"%{$clientsearch}%");
        }
        if(!empty($phonesearch)){
            $query->where('phone', 'like', "%{$phonesearch}%");
        }

        if(!empty($usersearch)){
            $query->where('user_id', 'like', "%{$usersearch}%");
        }

        $customers = $query->paginate();

        return view('customers.index')
        ->with([
            'customers' => $customers,
            'clientsearch' => $clientsearch,
            'phonesearch' =>$phonesearch,
            'users' => $users
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
        $request->validate([
            'user_id' => ['required'],
            'handling_type' => ['required'],
            'handling_office'=> ['required'],
            // 'corporate_type'=> ['required'],
            'customer_name'=> ['required','unique:customers,customer_name'],
            // 'address'=> ['required'],
            // 'phone'=> ['required'],
        ]);

        Customer::create($request->all());

        $request->session()->flash('SucccessMsg', '登録しました');

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
        $users = User::all();
        return view('customers.edit',[
            'customer' => $customer,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *yy
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customerId)
    {
        $request->validate([
            'user_id' => ['required'],
            'handling_type' => ['required'],
            'handling_office'=> ['required'],
            // 'corporate_type'=> ['required'],
            'customer_name'=> ['required'],
            // 'address'=> ['required'],
            // 'phone'=> ['required'],

        ]);

        $customer = Customer::find($customerId);
        $customer->user_id =$request->input('user_id');
        $customer->handling_type =$request->input('handling_type');
        $customer->handling_office = $request->input('handling_office');
        $customer->corporate_type = $request->input('corporate_type');
        $customer->customer_name = $request->input('customer_name');
        $customer->customer_kana = $request->input('customer_kana');
        $customer->department = $request->input('department');
        $customer->manager_name = $request->input('manager_name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->fax = $request->input('fax');

        $customer->save();

        $request->session()->flash('SucccessMsg', '保存しました');

        return redirect('/customers');
    }

    /**
     * 顧客一覧への表示/非表示を切り替える
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $id
     * @return \Illuminate\Http\Response
     */
    public function hide(Request $request, $customerId)
    {
        $customer = Customer::find($customerId);

        if ($request->hidden_flag === '1') {
            $customer->is_show = false;
            $text = '非表示';
        } else {
            $customer->is_show = true;
            $text = '表示';
        }
        
        $customer->save();

        $request->session()->flash('SucccessMsg', "{$customer->customer_name}を{$text}にしました");

        return redirect('/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $customer =Customer::findOrFail($id);
    //     $customer->delete();

    //     \Session::flash('SucccessMsg', '削除しました');

    //     return redirect('/customers');
    // }
    public function __invoke(Request $request)
    {
        $customer = auth()->user();
        $this->authorize('viewAny', $customer);  // Policy をチェック
        $customers = \App\Models\Customers::get(); // 社員一覧を取得
        return view('customers.index', compact('customers')); // users.index.bldae を呼出し、 usersを渡す

    }
}
