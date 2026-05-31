@include('partials.head')

<form action="{{ route('administrator.gallery.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Image</label>
        <input type="file" name="image" id="gallery-image" required>
        <img id="gallery-preview" width="150">
    </div>

    <button type="submit">
        Upload
    </button>

</form>

<hr>

<table border="1">

    <tr>
        <th>No</th>
        <th>Image</th>
        <th>Title</th>
        <th>Action</th>
    </tr>

    @foreach($galleries as $gallery)
    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>
            <img src="{{ asset('storage/' . $gallery->image) }}"
                 width="100">
        </td>

        <td>{{ $gallery->title }}</td>

        <td>

            <form action="{{ route('administrator.gallery.delete', $gallery->id) }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <button type="submit" class="delete-btn">
                    Delete
                </button>

            </form>

        </td>

    </tr>
    @endforeach

</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/gallery.js') }}"></script>
@include('partials.foot')