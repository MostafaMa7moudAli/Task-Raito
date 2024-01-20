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

    <!-- Modal delete invoice -->
    <div class="modal fade" id="modal_delete_invoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{route("invoice.destroy")}}">
                    @csrf
                    @method("POST")

                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">حذف فاتورة</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row row-sm mg-b-20">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mg-b-10">رقم الفاتورة</p>
                                    <input id="invoice_number" type="text" class="form-control" name="id" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-3 -->

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mg-b-10">تاريخ الفاتورة</p>
                                    <input id="invoice_date" type="text" class="form-control" name="invoice_date" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-3 -->

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mg-b-10">اسم العميل</p>
                                    <input id="customer_name" type="text" class="form-control" name="customer_name" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-3 -->

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p class="mg-b-10">الاجمالى</p>
                                    <input id="invoice_total" type="text" class="form-control" name="invoice_total" readonly="readonly"/>
                                </div>
                            </div>
                            <!-- col-3 -->
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


    <h1 class="title_header">{{$pageTitle}}</h1>

    <div class="index_header">
        <a class="btn btn-info" href="{{route("invoices.index")}}">
            <i class="fa fa-arrow-right"></i> عودة الي قائمة الفواتير
        </a>

        <form method="POST" action="{{route('invoices.search')}}">
            @csrf
            <input class="text-center" type="text" placeholder="بحث برقم الفاتورة" name="txt_search" required="required" value="{{$txt_search}}">
            <input type="submit" value="بحث"/>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>تاريخ الفاتورة</th>
                <th>اسم العميل</th>
                <th>اجمالي الفاتورة</th>
                <th>العمليات</th>
            </tr>
            </thead>

            <tbody>
            @if(count($results) > 0)
                @foreach($results as $result)
                    <tr>
                        <td>
                            {{$result->id}}
                        </td>
                        <td>
                            {{$result->invoice_date}}
                        </td>
                        <td>
                            {{$result->customer->name_ar}}
                        </td>
                        <td>
                            {{number_format($result->total_invoice, 2)}} جنية
                        </td>

                        <td style="min-width: 200px;">
                            <a href="{{route('invoice.details', $result->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i> عرض وتعديل </a>
                            <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal_delete_invoice" invoice_number="{{$result->id}}" invoice_date="{{$result->invoice_date}}" customer_name="{{$result->customer->name_ar}}" invoice_total="{{number_format($result->total_invoice, 2)}}"><i class="fa fa-trash"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="tbl_notfound">لم يتم العثور علي نتائج</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // modal delete invoice
            $("#modal_delete_invoice").on('shown.bs.modal', function (event) {
                var button = event.relatedTarget;
                var invoice_number = $(button).attr('invoice_number');
                var invoice_date = $(button).attr('invoice_date');
                var customer_name = $(button).attr('customer_name');
                var invoice_total = $(button).attr('invoice_total');

                var modal = $(this);
                modal.find('.modal-body #invoice_number').val(invoice_number);
                modal.find('.modal-body #invoice_date').val(invoice_date);
                modal.find('.modal-body #customer_name').val(customer_name);
                modal.find('.modal-body #invoice_total').val(invoice_total);
            });

        });
    </script>
@endsection
