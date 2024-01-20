<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // set page setting
        $pageTitle = "إدارة العملاء";

        // get all Customers
        $allCustomers = Customer::all();

        // load view and pass data to my view
        return view('customers.index',['pageTitle'=>$pageTitle, 'allCustomers'=>$allCustomers]);
    }

    public function search(Request $request)
    {
        // set page setting
        $pageTitle = "بحث فى العملاء";

        // get search result
        $results = Customer::where('name_ar', 'like', '%' . $request->txt_search . '%')
            ->orWhere('name_en', 'like', '%' . $request->txt_search . '%')
            ->get();

        // pass data and load my view
        return view('customers.search', ['pageTitle'=>$pageTitle, 'results'=>$results, 'txt_search'=>$request->txt_search]);
    }

    public function create()
    {
        // set page setting
        $pageTitle = "أضافة عميل";

        // load view and pass data to my  view
        return view('customers.create',['pageTitle'=>$pageTitle]);
    }

    public function store(Request $request)
    {
        // check data valid or no
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',
        ], [
            'name_ar.required' => 'مطلوب إدخال حقل اسم العميل باللغة العربية',
            'name_ar.required' => 'مطلوب إدخال حقل اسم العميل باللغة الانجليزية'
        ]);

        //create new customer
        Customer::create($request->all());
        return redirect(route("customers.index"))->with('message','تمت أضافة العميل بنجاح');
    }

    public function edit($id)
    {
        // set page setting
        $pageTitle = "تعديل بيانات عميل";

        // get Product by id
        $customer = Customer::find($id);

        // load view and pass data to my view
        return view('customers.edit', ['pageTitle'=>$pageTitle, 'customer'=>$customer]);
    }

    public function update($id, Request $request)
    {
        // check data valid or no
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',
        ], [
            'name_ar.required' => 'مطلوب إدخال حقل اسم العميل باللغة العربية',
            'name_ar.required' => 'مطلوب إدخال حقل اسم العميل باللغة الانجليزية',
        ]);

        // get customer by id
        $customer = Customer::find($id);

        // update customer data
        $customer->update($request->all());
        return redirect(route('customers.index'))->with('message','تم تعديل بيانات العميل بنجاح');
    }

    public function delete($id)
    {
        // set page setting
        $pageTitle = "حذف عميل";

        // get customer by id
        $customer = Customer::find($id);

        // load view and pass data to my view
        return view('customers.delete', ['pageTitle'=>$pageTitle, 'customer'=>$customer]);
    }

    public function destroy($id)
    {
        // find customer by id
        $customer = Customer::find($id);

        //delete product object
        $customer->delete();
        return redirect(route("customers.index"))->with('message','تم حذف العميل بنجاح');
    }
}
