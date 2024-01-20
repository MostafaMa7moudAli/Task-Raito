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
        <a class="btn btn-info" href="{{route("customers.index")}}">
            <i class="fa fa-arrow-right"></i> عودة الي قائمة العملاء
        </a>

        <form method="POST" action="{{route('customers.search')}}">
            @csrf
            <input class="text-center" type="text" placeholder="البحث عن عميل" name="txt_search" required="required" value="{{$txt_search}}">
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
            @if(count($results) > 0)
                @foreach($results as $result)
                    <tr>
                        <td>
                            {{$result->name_ar}}
                        </td>
                        <td>
                            {{$result->name_en}}
                        </td>

                        <td style="min-width: 200px;">
                            <a href="{{route('customer.edit', $result->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i> تعديل </a>
                            <a href="{{route('customer.delete', $result->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> حذف </a>
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
