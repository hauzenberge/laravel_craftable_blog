<div class="header__bottom">
    <div class="non_container" style="margin-left: 15%; margin-right: 5%;">
        <nav>
            <ul>
                {{--
                <li><a href="/category/it">IT</a></li>
                <li><a href="/category/books">Книги</a></li>
                <li><a href="/category/travel">Путешествия</a></li>
                <li><a href="/category/space">Космос</a></li>
                <li><a href="/category/politic">Политика</a></li>
                <li><a href="/category/auto">Авто</a></li>
                --}}

                @foreach(App\Models\Category::all() as $category)
                <li><a href="{{url('/category/' . $category->name)}}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
