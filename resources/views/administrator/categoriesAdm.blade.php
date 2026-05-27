@include('partials.head')

@foreach($category as $c)

    <p>{{ $c->category_name }}</p>

@endforeach

@include('partials.foot')