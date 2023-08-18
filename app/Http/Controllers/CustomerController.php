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
        $showFilter = $request->input('show_filter');

        $query = Customer::query();
        if($showFilter == 'show' || $showFilter == null){
            $query->where('is_show', true);
        }
        if($showFilter == 'hidden'){
            $query->where('is_show', false);
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

        $customers = $query
            ->orderBy('id', 'desc')
            ->paginate();

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
            'customer_name'=> [
                'required',
                'unique:customers,customer_name'
            ],
            'customer_kana'=> [
                'regex:/^[ァ-ン　　 ]*$/u' // 全角カタカナとスペースのみ許容
            ],
        ]);

        // 顧客名：スペースがあったらスペースを無しにする
        $customerName = str_replace(
            [' ', '　'],
            '',
            $request['customer_name']
        );
        // 顧客名（全角カナ）：スペースがあったら無しにする
        $customerKana = str_replace(
            [' ', '　'],
            '',
            $request['customer_kana']
        );
        // 顧客住所：スペースがあればスペースを無しにする
        $address = str_replace(
            [' ', '　'],
            '',
            $request->input('address')
        );
        for ($i=2; $i<6; $i++) {
            ${"address_{$i}"} = str_replace(
                [' ', '　'],
                '',
                $request->input("address_{$i}")
            );
        }

        Customer::create([
            'user_id' => $request->input('user_id'),
            'handling_type' => $request->input('handling_type'),
            'handling_office' => $request->input('handling_office'),
            'corporate_type' => $request->input('corporate_type'),
            'customer_name' => $customerName,
            'customer_kana' => $customerKana,
            'industry' => $request->input('industry'),
            'company_size' => $request->input('company_size'),
            'business_development_area' => $request->input('business_development_area'),
            'business_expansion_potential' => $request->input('business_expansion_potential'),
            'company_history' => $request->input('company_history'),
            'reliability' => $request->input('reliability'),
            'branch' => $request->input('branch'),
            'department' => $request->input('department'),
            'manager_name' => $request->input('manager_name'),
            'address' => $address,
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'fax' => $request->input('fax'),
            'branch_2' => $request->input('branch_2'),
            'department_2' => $request->input('department_2'),
            'manager_name_2' => $request->input('manager_name_2'),
            'address_2' => $address_2,
            'phone_2' => $request->input('phone_2'),
            'email_2' => $request->input('email_2'),
            'fax_2' => $request->input('fax_2'),
            'branch_3' => $request->input('branch_3'),
            'department_3' => $request->input('department_3'),
            'manager_name_3' => $request->input('manager_name_3'),
            'address_3' => $address_3,
            'phone_3' => $request->input('phone_3'),
            'email_3' => $request->input('email_3'),
            'fax_3' => $request->input('fax_3'),
            'branch_4' => $request->input('branch_4'),
            'department_4' => $request->input('department_4'),
            'manager_name_4' => $request->input('manager_name_4'),
            'address_4' => $address_4,
            'phone_4' => $request->input('phone_4'),
            'email_4' => $request->input('email_4'),
            'fax_4' => $request->input('fax_4'),
            'branch_5' => $request->input('branch_5'),
            'department_5' => $request->input('department_5'),
            'manager_name_5' => $request->input('manager_name_5'),
            'address_5' => $address_5,
            'phone_5' => $request->input('phone_5'),
            'email_5' => $request->input('email_5'),
            'fax_5' => $request->input('fax_5'),
        ]);

        $request->session()->flash('SuccessMsg', '登録しました');

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
            'customer_name'=> ['required'],
            'customer_kana'=> [
                'regex:/^[ァ-ン　　 ]*$/u' // 全角カタカナとスペースのみ許容
            ],

        ]);

        // 顧客名：スペースがあったらスペースを無しにする
        $customerName = str_replace(
            [' ', '　'],
            '',
            $request['customer_name']
        );
        // 顧客名（全角カナ）：スペースがあったら無しにする
        $customerKana = str_replace(
            [' ', '　'],
            '',
            $request['customer_kana']
        );
        // 顧客住所：スペースがあればスペースを無しにする
        $address = str_replace(
            [' ', '　'],
            '',
            $request->input('address')
        );
        for ($i=2; $i<6; $i++) {
            ${"address_{$i}"} = str_replace(
                [' ', '　'],
                '',
                $request->input("address_{$i}")
            );
        }

        $customer = Customer::find($customerId);
        $customer->user_id =$request->input('user_id');
        $customer->handling_type =$request->input('handling_type');
        $customer->handling_office = $request->input('handling_office');
        $customer->corporate_type = $request->input('corporate_type');
        $customer->customer_name = $customerName;
        $customer->customer_kana = $customerKana;
        $customer->industry = $request->input('industry');
        $customer->company_size = $request->input('company_size');
        $customer->business_development_area = $request->input('business_development_area');
        $customer->business_expansion_potential = $request->input('business_expansion_potential');
        $customer->company_history = $request->input('company_history');
        $customer->reliability = $request->input('reliability');
        $customer->branch = $request->input('branch');
        $customer->department = $request->input('department');
        $customer->manager_name = $request->input('manager_name');
        $customer->address = $address;
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->fax = $request->input('fax');
        $customer->branch_2 = $request->input('branch_2');
        $customer->department_2 = $request->input('department_2');
        $customer->manager_name_2 = $request->input('manager_name_2');
        $customer->address_2 = $address_2;
        $customer->phone_2 = $request->input('phone_2');
        $customer->email_2 = $request->input('email_2');
        $customer->fax_2 = $request->input('fax_2');
        $customer->branch_3 = $request->input('branch_3');
        $customer->department_3 = $request->input('department_3');
        $customer->manager_name_3 = $request->input('manager_name_3');
        $customer->address_3 = $address_3;
        $customer->phone_3 = $request->input('phone_3');
        $customer->email_3 = $request->input('email_3');
        $customer->fax_3 = $request->input('fax_3');
        $customer->branch_4 = $request->input('branch_4');
        $customer->department_4 = $request->input('department_4');
        $customer->manager_name_4 = $request->input('manager_name_4');
        $customer->address_4 = $address_4;
        $customer->phone_4 = $request->input('phone_4');
        $customer->email_4 = $request->input('email_4');
        $customer->fax_4 = $request->input('fax_4');
        $customer->branch_5 = $request->input('branch_5');
        $customer->department_5 = $request->input('department_5');
        $customer->manager_name_5 = $request->input('manager_name_5');
        $customer->address_5 = $address_5;
        $customer->phone_5 = $request->input('phone_5');
        $customer->email_5 = $request->input('email_5');
        $customer->fax_5 = $request->input('fax_5');


        $customer->save();

        $request->session()->flash('SucccessMsg', '保存しました');

        return redirect(route('customers.detail', $customerId));
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

    public function importCsv(Request $request)
    {// 1ファイルで複数レコードを保存できる仕様
        // CSV一時保存
        $tmp = mt_rand() . "." . $request->file('csv_import')->guessExtension();
        $request->file('csv_import')->move(public_path() . "/tmp", $tmp);
        $filepath = public_path() . "/tmp/" . $tmp;

        // CSVデータ取得
        $file = new \SplFileObject($filepath);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        // バリデーション（後々実装）
        $users = User::all();

        $saveDataList = [];
        foreach ($file as $key => $line) {
            if ($key !== 0) {
                // バリデーション
                if (Customer::where('customer_name', $line[4])->exists() ) {
                    \Session::flash('AlertMsg', "顧客名:{$line[4]}は既に登録されています。");
                    return view('customers.create', ['users' => $users]);
                }
                $saveDataList[] = [
                    'user_id' => $users->where('name', $line[0])->first()->id, // 営業担当
                    'handling_type' => strval(array_search($line[1], config('options.handling_type'))), // 取扱会社種別
                    'handling_office' => strval(array_search($line[2], config('options.handling_office'))), // 取扱事業所名
                    'corporate_type' => strval(array_search($line[3], config('options.corporate_type'))), // 法人形態
                    'customer_name' => $line[4],
                    'customer_kana' => $line[5],
                    'industry' => strval(array_search($line[6], config('options.industry'))), // 業種
                    'company_size' => strval(array_search($line[7], config('options.company_size'))), // 会社規模
                    'business_development_area' => strval(array_search($line[8], config('options.business_development_area'))), // 事業展開地域
                    'business_expansion_potential' => strval(array_search($line[9], config('options.business_expansion_potential'))), // 取引拡大可能性
                    'company_history' => strval(array_search($line[10], config('options.company_history'))), // 社歴
                    'reliability' => strval(array_search($line[11], config('options.reliability'))), // 信頼性
                    'department' => $line[12], // 所属部署
                    'manager_name' => $line[13], // 顧客担当者名
                    'address' => $line[14], // 顧客住所
                    'phone' => $line[15],
                    'email' => $line[16],
                    'fax' => $line[17],
                ];
            }
        }
        // 一時ファイル削除
        unlink($filepath);

        Customer::insert($saveDataList);
        $request->session()->flash('SucccessMsg', '登録しました');
        return redirect(route('customers.index'));
    }

    public function showDetail($customerId)
    {
        $customer = Customer::find($customerId);
        $users = User::all();
        return view('customers.detail',[
            'customer' => $customer,
            'users' => $users
        ]);
    }
}
