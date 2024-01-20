<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // set page setting
        $pageTitle = "إدارة الأصناف";

        // get all Products
        $allProducts = Product::all();

        // load view and pass data to my view
        return view('products.index',['pageTitle'=>$pageTitle, 'allProducts'=>$allProducts]);
    }

    public function search(Request $request)
    {
        // set page setting
        $pageTitle = "بحث فى الاصناف";

        // get search result
        $results = Product::where('name_ar', 'like', '%' . $request->txt_search . '%')
            ->orWhere('name_en', 'like', '%' . $request->txt_search . '%')
            ->orWhere('price', 'like', '%' . $request->txt_search . '%')
            ->get();

        // pass data and load my view
        return view('products.search', ['pageTitle'=>$pageTitle, 'results'=>$results, 'txt_search'=>$request->txt_search]);
    }

    public function create()
    {
        // set page setting
        $pageTitle = "أضافة صنف";

        // load view and pass data to my  view
        return view('products.create',['pageTitle'=>$pageTitle]);
    }

    public function store(Request $request)
    {
        // check data valid or no
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',
            'price'=>'required|numeric',
        ], [
            'name_ar.required' => 'مطلوب إدخال حقل اسم الصنف باللغة العربية',
            'name_ar.required' => 'مطلوب إدخال حقل اسم الصنف باللغة الانجليزية',
            'price.required' => 'مطلوب إدخال حقل سعر بيع الصنف',
            'price.numeric' => 'حقل سعر بيع الصنف لابد ان يكون رقما',
        ]);

        //create new product
        Product::create($request->all());
        return redirect(route("products.index"))->with('message','تمت أضافة الصنف بنجاح');
    }

    public function edit($id)
    {
        // set page setting
        $pageTitle = "تعديل صنف";

        // get Product by id
        $product = product::find($id);

        // load view and pass data to my view
        return view('products.edit', ['pageTitle'=>$pageTitle, 'product'=>$product]);
    }

    public function update($id, Request $request)
    {
        // check data valid or no
        $request->validate([
            'name_ar'=>'required',
            'name_en'=>'required',
            'price'=>'required|numeric',
        ], [
            'name_ar.required' => 'مطلوب إدخال حقل اسم الصنف باللغة العربية',
            'name_ar.required' => 'مطلوب إدخال حقل اسم الصنف باللغة الانجليزية',
            'price.required' => 'مطلوب إدخال حقل سعر بيع الصنف',
            'price.numeric' => 'حقل سعر بيع الصنف لابد ان يكون رقما',
        ]);

        // get product by id
        $product = Product::find($id);

        // update product
        $product->update($request->all());
        return redirect(route('products.index'))->with('message','تم تعديل الصنف بنجاح');
    }

    public function delete($id)
    {
        // set page setting
        $pageTitle = "حذف صنف";

        // get product by id
        $product = Product::find($id);

        // load view and pass data to my view
        return view('products.delete', ['pageTitle'=>$pageTitle, 'product'=>$product]);
    }

    public function destroy($id)
    {
        // find product by id
        $product = Product::find($id);

        //delete product object
        $product->delete();
        return redirect(route("products.index"))->with('message','تم حذف الصنف بنجاح');
    }
}
