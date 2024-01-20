@extends('template.template')
@section('pageTitle', $pageTitle)
@section('content')

    @if (session('message'))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger text-center">
            {{$errors->first()}}
        </div>
    @endif

    <h1 class="title_header">{{$pageTitle}}</h1>

    <div class="index_header">
        <a class="btn btn-info" href="{{route("invoices.index")}}">
            <i class="fa fa-arrow-right"></i> عودة الي قائمة الفواتير
        </a>
    </div>

    <!-- sweet alert -->
    <div class="modal fade" id="error_alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="text-danger text-center"><i class="far fa-times-circle"></i></h1>
                    <h4 class="alert_text text-danger tx-danger text-center mg-b-20"></h4>
                </div>
                <div class="modal-footer align-items-center justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">حسنا فهمت</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete invoice product -->
    <div class="modal fade" id="modal_delete_invoiceProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{route("invoice.destroyInvoiceProduct")}}">
                    @csrf
                    @method("POST")

                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">حذف صنف من الفاتورة</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm mg-b-20">
                            <input type="hidden" id="productInvoice_id" name="id"/>
                            <input type="hidden" id="invoice_id" name="invoice_id"/>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p class="mg-b-10">اسم الصنف</p>
                                    <input id="product_name" type="text" class="form-control bg-light" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <p class="mg-b-10">الكمية</p>
                                    <input id="product_quantity" type="text" class="form-control bg-light" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-6 -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حذف</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- invoice main header -->
    <div class="row text-center invoice-details">
        <form method="POST" action="{{route('invoice.update')}}">
            @csrf
            @method("POST")

            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">رقم الفاتورة : </span>
                                    <input type="text" class="form-control text-center text-primary bg-light input-group-control" name="id" value="{{$invoice->id}}" required readonly="readonly">
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">اجمالي الفاتورة : </span>
                                    <input type="text" class="form-control text-center text-primary bg-light input-group-control" name="total_invoice" value="{{number_format($invoice->total_invoice, 2)}}" required readonly="readonly">
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">تاريخ الفاتورة : </span>
                                    <input type="date" id="invoice_date" class="form-control input-group-control" placeholder="سنة / يوم / شهر" name="invoice_date" value="{{$invoice->invoice_date}}" required>
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">اسم العميل : </span>
                                    <select class="form-control input-group-control" name="customer_id" required="required">
                                        <option value="" selected disabled> -- اسم العميل -- </option>
                                        @foreach($allCustomers as $customer)
                                            <option value="{{$customer->id}}" <?php if($invoice->customer->id == $customer->id) {echo "selected";}?>>{{$customer->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-12">
                                <button type="submit" class="form-control btn btn-primary">حفظ التعديلات</button>
                            </div>
                            <!-- col-12 -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- invoice add product -->
    <div class="row text-center invoice-details">
        <form method="POST" action="{{route('invoice.storeInvoiceProduct')}}">
            @csrf
            @method("POST")

            <input name="invoice_id" type="hidden" value="{{$invoice->id}}"/>

            <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">اسم الصنف : </span>
                                    <select id="invoiceDetails-product_id" class="form-control input-group-control" name="product_id" required="required">
                                        <option value="" selected disabled> -- اسم الصنف -- </option>
                                        @foreach($allProducts as $product)
                                            <option value="{{$product->id}}">{{$product->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">الكمية : </span>
                                    <input id="invoiceDetails-product_quantity" type="number" min="1" step="1" class="form-control input-group-control" placeholder="الكمية" name="quantity" value="{{old('quantity')}}" required>
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">سعر بيع الصنف : </span>
                                    <input id="invoiceDetails-product_price" type="text" class="form-control text-center text-primary bg-light input-group-control" required readonly="readonly">
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text">اجمالي الفاتورة : </span>
                                    <input id="invoiceDetails-product_total" type="text" class="form-control text-center text-primary bg-light input-group-control" name="total_product" required readonly="readonly">
                                </div>
                            </div>
                            <!-- col-6 -->

                            <div class="col-lg-12">
                                <button type="submit" class="form-control btn btn-success">أضافة الى الفاتورة</button>
                            </div>
                            <!-- col-12 -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- invoice products -->
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th>اسم الصنف</th>
                <th>سعر بيع الصنف</th>
                <th>الكمية</th>
                <th>اجمالي السعر</th>
                <th>حذف الصنف</th>
            </tr>
            </thead>

            <tbody>
            @if(count($invoiceProducts) > 0)
                @foreach($invoiceProducts as $product)
                    <tr>
                        <td>
                            {{$product->product->name_ar}}
                        </td>
                        <td>
                            {{number_format($product->product->price, 2)}} جنية
                        </td>
                        <td>
                            {{$product->quantity}}
                        </td>
                        <td>
                            {{$product->total_product}}
                        </td>

                        <td style="min-width: 200px;">
                            <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal_delete_invoiceProduct" productInvoice_id="{{$product->id}}" invoice_id ="{{$product->invoice_id}}" product_name="{{$product->product->name_ar}}" product_quantity="{{$product->quantity}}"><i class="fa fa-trash"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="tbl_notfound">لا توجد اصناف في هذة الفاتورة</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>













@endsection


@section('js')
    <script>
        $(document).ready(function () {

            // get product price
            $('#invoiceDetails-product_id').on('change', function () {
                var product_id = $(this).val();
                if(product_id)
                {
                    $.ajax({
                        url: "{{url('productPrice')}}/" + product_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#invoiceDetails-product_price').val(data);
                            $('#invoiceDetails-product_quantity').val("");
                            $('#invoiceDetails-product_total').val("");
                        },
                    });
                }
                else
                {
                    console.log("Ajax Load Did Not Work");
                }
            })

            // set total price
            function getTotal()
            {
                var product_id = document.getElementById("invoiceDetails-product_id").value;
                var product_price = document.getElementById("invoiceDetails-product_price").value;
                var product_quantity = parseInt(document.getElementById("invoiceDetails-product_quantity").value);

                if (!product_id)
                {
                    $("#error_alert .alert_text").text("من فضلك اختار اسم الصنف !");
                    $("#invoiceDetails-product_quantity").val("");
                    $("#invoiceDetails-product_total").val("");
                    $("#error_alert").modal("show");
                }
                else if (!product_price)
                {
                    $("#error_alert .alert_text").text("من فضلك اختار اسم الصنف !");
                    $("#invoiceDetails-product_quantity").val("");
                    $("#invoiceDetails-product_total").val("");
                    $("#error_alert").modal("show");
                }
                else if (!product_quantity || typeof (product_quantity) != "number")
                {
                    $("#error_alert .alert_text").text("من فضلك ادخل الكمية !");
                    $("#invoiceDetails-product_quantity").val("");
                    $("#invoiceDetails-product_total").val("");
                    $("#error_alert").modal("show");
                }
                else
                {
                    var product_total = product_price * product_quantity;

                    $("#invoiceDetails-product_total").val(product_total.toFixed(2));
                }
            }

            $('#invoiceDetails-product_quantity').on('keyup', getTotal);


            // modal delete invoice product
            $("#modal_delete_invoiceProduct").on('shown.bs.modal', function (event) {
                var button = event.relatedTarget;
                var productInvoice_id = $(button).attr('productInvoice_id');
                var invoice_id = $(button).attr('invoice_id');
                var product_name = $(button).attr('product_name');
                var product_quantity = $(button).attr('product_quantity');

                var modal = $(this);
                modal.find('.modal-body #productInvoice_id').val(productInvoice_id);
                modal.find('.modal-body #invoice_id').val(invoice_id);
                modal.find('.modal-body #product_name').val(product_name);
                modal.find('.modal-body #product_quantity').val(product_quantity);
            });
        });
    </script>
@endsection
