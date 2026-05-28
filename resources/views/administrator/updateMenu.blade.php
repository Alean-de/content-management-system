@include('partials.head')

<form action="{{ route('administrator.menu.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div>

        <label for="image">
            Image
        </label>

        <input
            type="file"
            id="image"
            name="image"
        >

    </div>

    @if ($menuItem->image)

        <div>

            <img
                src="{{ asset('storage/' . $menuItem->image) }}"
                alt="{{ $menuItem->name }}"
                width="120"
            >

        </div>

    @endif

    <div>

        <label for="name">
            Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ $menuItem->name }}"
            required
        >

    </div>

    <div>

        <label for="description">
            Description
        </label>

        <textarea
            id="description"
            name="description"
        >{{ $menuItem->description }}</textarea>

    </div>

    <div>

        <label for="category_id">
            Category
        </label>

        <select
            id="category_id"
            name="category_id"
            required
        >

            @foreach ($categories as $category)

                <option
                    value="{{ $category->id }}"

                    {{ $menuItem->category_id == $category->id ? 'selected' : '' }}
                >

                    {{ $category->category_name }}

                </option>

            @endforeach

        </select>

    </div>

    <div>

        <label for="price">
            Price
        </label>

        <input
            type="text"
            id="price"
            name="price"
            value="{{ $menuItem->price }}"
            required
        >

    </div>

    <div>

        <label>

            <input
                type="checkbox"
                name="is_featured"

                {{ $menuItem->is_featured ? 'checked' : '' }}
            >

            Featured Menu

        </label>

    </div>

    <button type="submit">
        Update Menu
    </button>

</form>
@include('partials.foot')