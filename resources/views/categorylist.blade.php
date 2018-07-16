@extends('layouts.master')
@section('content')


    <div class="container">
    <div class="col-md-12">
        <h3 class="headline centered margin-top-75">
            Start with Finding the right Category
        </h3>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="categories-boxes-container margin-top-5 margin-bottom-30 categories1">
                    
                    @foreach($categories as $category)
                    <a href="{{url('/category/search?catid='.$category->id)}}" class="category-small-box">
                        <i class="fa {{$category->category_photo}}"></i>
                        <h4>{{$category->categoryname}}</h4>
                    </a>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


@endsection