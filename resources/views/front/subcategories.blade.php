<ul class="dropdown" id="headdrop">

    @foreach ($subcat as $c)


        <li style="position:relative"><a href="{{ route('9gem_allblogs', $cat['id']) }}">{{ $c['name'] }}</a>

            @includeWhen($c->category_rel()->count() > 0,'front.subcategories',['subcat'=>$c->category_rel])
            
        </li>
    @endforeach

</ul>
