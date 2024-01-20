<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // set page setting
        $pageTitle = "إدارة الفواتير";

        // get all invoices
        $allInvoices = Invoice::all();

        // get all customers
        $allCustomers = Customer::all();

        // load view and pass data to my view
        return view('invoices.index',['pageTitle'=>$pageTitle, 'allInvoices'=>$allInvoices, 'allCustomers'=>$allCustomers]);
    }

    public function search(Request $request)
    {
        // set page setting
        $pageTitle = "البحث عن فاتورة";

        // get search result
        $results = Invoice::where('id', $request->txt_search )->get();

        // pass data and load my view
        return view('invoices.search', ['pageTitle'=>$pageTitle, 'results'=>$results, 'txt_search'=>$request->txt_search]);
    }

    public function store(Request $request)
    {
        // check data valid or no
        $request->validate([
            'id'=>'required|unique:invoices,id,'. $request->id,
            'invoice_date'=>'required|date',
            'customer_id'=>'required|numeric',
        ], [
            'id.required' => 'مطلوب إدخال حقل رقم الفاتورة',
            'id.unique' => 'رقم الفاتورة موجود موجود بالفعل',
            'invoice_date.required' => 'مطلوب إدخال حقل تاريخ الفاتورة',
            'invoice_date.date' => 'تاريخ الفاتورة غير صحيح',
            'customer_id.required' => 'برجاء اختيار اسم العميل',
            'customer_id.numeric' => 'اسم العميل غير صحيح'
        ]);

        //create new invoice
        Invoice::create($request->all());
        return redirect(route("invoice.details", $request->id));
    }

    public function update(Request $request)
    {
        // check data valid or no
        $request->validate([
            'id'=>'required|numeric',
            'invoice_date'=>'required|date',
            'customer_id'=>'required|numeric',
        ], [
            'id.required' => 'مطلوب إدخال حقل رقم الفاتورة',
            'id.numeric' => 'رقم الفاتورة خطأ',
            'invoice_date.required' => 'مطلوب إدخال حقل تاريخ الفاتورة',
            'invoice_date.date' => 'تاريخ الفاتورة غير صحيح',
            'customer_id.required' => 'برجاء اختيار اسم العميل',
            'customer_id.numeric' => 'اسم العميل غير صحيح'
        ]);

        // get invoice by id
        $invoice = Invoice::findOrFail($request->id);

        // save data to my object
        $invoice->update($request->all());
        $invoice->save();
        return redirect(route("invoice.details", $request->id))->with("message", "تم التعديل بنجاح");
    }

    public function destroy(Request $request)
    {
        // delete invoiceProducts belongs to this invoice
        $invoiceProducts = InvoiceProduct::where("invoice_id", $request->id)->get();
        if(count($invoiceProducts) > 0)
        {
            foreach ($invoiceProducts as $product)
            {
                $product->delete();
            }
        }


        // get invoice by id
        $invoice = Invoice::findOrFail($request->id);

        // Delete invoice
        $invoice->delete();

        return redirect(route("invoices.index"))->with('message','تم حذف الفاتورة بنجاح');
    }

    public function details($id)
    {
        // set page setting
        $pageTitle = "عرض وتعديل فاتورة";

        // get invoice by id
        $invoice = Invoice::findOrFail($id);

        // get invoice products
        $invoiceProducts = InvoiceProduct::where('invoice_id', $id)->get();

        // get all customers
        $allCustomers = Customer::all();

        // get all products
        $allProducts = Product::all();

        // load view and pass data to my  view
        return view('invoices.details',['pageTitle'=>$pageTitle, 'invoiceProducts'=>$invoiceProducts, 'allCustomers'=>$allCustomers, 'allProducts'=>$allProducts, 'invoice'=>$invoice]);
    }

    public function storeInvoiceProduct(Request $request)
    {
        // check data valid or no
        $request->validate([
            'product_id'=>'required|numeric',
            'quantity'=>'required|numeric',
            'total_product'=>'required',
        ], [
            'product_id.required' => 'برجاء اختيار اسم الصنف',
            'product_id.numeric' => 'اسم الصنف غير صحيح',
            'quantity.required' => 'برجاء ادخال الكمية',
            'quantity.numeric' => 'برجاء ادخال كمية صحيحة',
            'total_product.required' => 'برجاء ادخال بيانات صحيحة',
        ]);

        // create new invoiceProduct
        InvoiceProduct::create($request->all());

        // update invoice total
        $invoiceTotal = InvoiceProduct::where('invoice_id', $request->invoice_id)->sum('total_product');
        $invoice = Invoice::find($request->invoice_id);
        $invoice->total_invoice = $invoiceTotal;
        $invoice->save();

        return redirect(route("invoice.details", $request->invoice_id))->with('message','تم أضافةالصنف الي الفاتورة بنجاح');
    }

    public function destroyInvoiceProduct(Request $request)
    {
        // get invoice product by id
        $invoiceProduct = InvoiceProduct::findOrFail($request->id);

        // Delete invoice Product
        $invoiceProduct->delete();

        // update invoice total
        $invoiceTotal = InvoiceProduct::where('invoice_id', $request->invoice_id)->sum('total_product');
        $invoice = Invoice::find($request->invoice_id);
        $invoice->total_invoice = $invoiceTotal;
        $invoice->save();

        return redirect(route("invoice.details", $request->invoice_id))->with('message','تم حذف الصنف من الفاتورة بنجاح');
    }

    public function getNew_invoiceNumber()
    {
        $invoice_number = Invoice::latest()->first();
        if(!count(Invoice::all()) > 0)
        {
            $invoice_number = 1;
            return json_encode($invoice_number);
        }
        else
        {
            $invoice_number = $invoice_number->id +=1;
            return json_encode($invoice_number);
        }
    }

    public function productPrice($id)
    {
        $productPrice = Product::find($id)->price;
        return json_encode($productPrice);
    }
}
