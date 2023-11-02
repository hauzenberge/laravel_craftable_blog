@extends('blog.layouts.app')


@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>--}}

    <link rel="stylesheet" href="{{asset('blog/css/main.css')}}">

    @include('blog.layouts.header')

    <div class="sidebar col-lg-2">
    </div>

    <br><br>

    <div class="main col-lg-7">
        <h2>{{$title}}</h2>
        @foreach($posts as $post)
            <a href="{{url("/post/" . $post["id"])}}" class="item col-lg-6">
{{--
                <img class="col-lg-4 " src="{{asset('images/' . $post['path_image'])}}" alt="" width="150px">
--}}                
                <div class="description col-lg-8">
                    <b>{{$post['title']}}</b>
                    <br>
                    <b>Categories:</b> {{-- $post["category"]["name"] --}}
                    {{-- dd($post["categories"]) --}}
                    @foreach($post["categories"] as $category)
                    {{ $category["name"] }}
                    @endforeach
                    <div class="text">
                        {!! $post["text_preview"] !!}
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @include("blog.layouts/sidebar")

    <div class="outher-paginate">
        {{ $posts->render() }}
    </div>

    @include("blog.layouts/footer")

@endsection
