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

    <form class="frm" method="POST" action="{{route('product.destroy', $product->id)}}">

        @csrf

        <div>
            <label for="name_ar" class="form-label">أسم الصنف باللغة العربية </label>
            <input id="name_ar" class="form-control" type="text" name="name_ar" value="{{$product->name_ar}}" disabled="disabled" />
        </div>

        <div>
            <label for="name_en" class="form-label">أسم الصنف باللغة الانجليزية</label>
            <input id="name_en" class="form-control" type="text" name="name_en" value="{{$product->name_en}}" disabled="disabled" />
        </div>

        <div>
            <label for="price" class="form-label">سعر بيع الصنف </label>
            <input id="price" class="form-control" type="number" name="price" value="{{$product->price}}" disabled="disabled" min="0" step=".01" />
        </div>

        <br/>

        <input class="form-control btn btn-danger" type="submit" value="حذف"/>

        <br/>
        <br/>

        <a class="form-control btn btn-info" href="{{route("products.index")}}">عودة الي قائمة الاصناف</a>

    </form>
@endsection
