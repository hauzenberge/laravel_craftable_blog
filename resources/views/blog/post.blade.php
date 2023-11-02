@extends('blog.layouts.app')
@section('content')

@include('blog.layouts.header')


<div class="page">
    <div class="sidebar col-lg-3"></div>

    <div class="main col-lg-6">

        <h1 style="text-align: center;">{{$post['title']}}</h1>
        
        <img class="leftimg" src="{{ $post['img'] }}" width="400px" alt="">

        {!! $post['description'] !!}


        <h3>{{$post['count_comments']}}</h3>
        <div id="comments">
            @foreach($post['comments'] as $value)
            <div class="comment">
                <h4 class='comment_name'>{{$value['user']}}</h4>
                <p class='comment_text'>
                <p class='comment_text'>{{$value['comment']}}</p>
                <p class='comment_date'>{{$value['created_at']}}</p>
            </div>
            @endforeach
        </div>
        <div class="form">
            <textarea name="comment" id="comment_area" type="text" placeholder="Enter You Comment"></textarea><br>

            <input type="hidden" id="post_id" name="post_id" value="{{$post['id']}}">
            <input id="comment_submit" type="button" value="Отправить">
        </div>
    </div>



    @include("blog.layouts/sidebar")
    @include("blog.layouts/footer")
</div>

@endsection