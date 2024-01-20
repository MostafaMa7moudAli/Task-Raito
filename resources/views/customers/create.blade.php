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

    <form class="frm" method="POST" action="{{route('customer.store')}}">
        @csrf

        <div>
            <label for="name_ar" class="form-label">أسم العميل باللغة العربية </label>
            <input id="name_ar" class="form-control" type="text" name="name_ar" value="{{old('name_ar')}}" required="required" autofocus="autofocus" />
        </div>

        <div>
            <label for="name_en" class="form-label">أسم العميل باللغة الانجليزية</label>
            <input id="name_en" class="form-control" type="text" name="name_en" value="{{old('name_en')}}" required="required" autofocus="autofocus" />
        </div>

        <br/>

        <input class="form-control btn btn-success" type="submit" value="أضافة"/>

        <br/>
        <br/>

        <a class="form-control btn btn-info" href="{{route("customers.index")}}">عودة الي قائمة العملاء</a>

    </form>
@endsection
