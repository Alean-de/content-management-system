@include('partials.head')

<h2>Update Banner</h2>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('administrator.banner.update', $banner->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div>
        <label>Title</label>
        <input type="text"
               name="title"
               value="{{ $banner->title }}"
               required>
    </div>

    <div>
        <label>Subtitle</label>
        <input type="text"
               name="subtitle"
               value="{{ $banner->subtitle }}">
    </div>

    <div>
        <label>Current Image</label><br>

        @if($banner->image)
            <img src="{{ asset('storage/' . $banner->image) }}"
                 alt="{{ $banner->title }}"
                 width="150">
        @else
            <p>No Image</p>
        @endif
    </div>

    <div>
        <label>New Image</label>
        <input type="file" name="image">
    </div>

    <div>
        <label>Start Date</label>
        <input type="date"
               name="start_date"
               value="{{ $banner->start_date->format('Y-m-d') }}"
               required>
    </div>

    <div>
        <label>End Date</label>
        <input type="date"
               name="end_date"
               value="{{ $banner->end_date->format('Y-m-d') }}"
               required>
    </div>

    <div>
        <label>
            <input type="checkbox"
                   name="is_active"
                   {{ $banner->is_active ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <button type="submit">
        Update Banner
    </button>

</form>

<br>

<a href="{{ url()->previous() }}">
    Back
</a>

@include('partials.foot')