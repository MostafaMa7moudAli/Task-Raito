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
        <a class="btn btn-success" href="{{route("customer.create")}}">
            <i class="fa fa-plus"></i> أضافة عميل
        </a>

        <form method="POST" action="{{route('customers.search')}}">
            @csrf
            <input class="text-center" type="text" placeholder="البحث عن عميل" name="txt_search" required="required" value="{{old('txt_search')}}">
            <input type="submit" value="بحث"/>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead>
            <tr>
                <th>اسم العميل باللغة العربية</th>
                <th>اسم العميل باللغة الانجليزية</th>
                <th>العمليات</th>
            </tr>
            </thead>

            <tbody>
            @if(count($allCustomers) > 0)
                @foreach($allCustomers as $customer)
                    <tr>
                        <td>
                            {{$customer->name_ar}}
                        </td>
                        <td>
                            {{$customer->name_en}}
                        </td>

                        <td style="min-width: 200px;">
                            <a href="{{route('customer.edit', $customer->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i> تعديل </a>
                            <a href="{{route('customer.delete', $customer->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> حذف </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="tbl_notfound">جدول العملاء فارغ</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
