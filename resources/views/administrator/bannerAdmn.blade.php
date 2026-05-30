@include('partials.head')

<h2>Banner Management</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('administrator.banner.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div>
        <label>Title</label>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Subtitle</label>
        <input type="text" name="subtitle">
    </div>

    <div>
        <label>Image</label>
        <input type="file" name="image" required>
    </div>

    <div>
        <label>Start Date</label>
        <input type="date" name="start_date" required>
    </div>

    <div>
        <label>End Date</label>
        <input type="date" name="end_date" required>
    </div>

    <div>
        <label>
            <input type="checkbox" name="is_active">
            Active
        </label>
    </div>

    <button type="submit">Save</button>

</form>

<hr>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Status</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        @forelse($banners as $index => $banner)
            <tr>

                <td>{{ $index + 1 }}</td>

                <td>
                    @if($banner->image)
                        <img
                            src="{{ asset('storage/' . $banner->image) }}"
                            alt="{{ $banner->title }}"
                            width="120">
                    @else
                        No Image
                    @endif
                </td>

                <td>{{ $banner->title }}</td>

                <td>{{ $banner->subtitle }}</td>

                <td>
                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                </td>

                <td>{{ $banner->start_date }}</td>

                <td>{{ $banner->end_date }}</td>

                <td>

                    <a href="{{ route('administrator.banner.showUpdate', $banner->id) }}">
                        Edit
                    </a>

                    <form action="{{ route('administrator.banner.delete', $banner->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Yakin hapus banner?')">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8">
                    Belum ada banner
                </td>
            </tr>

        @endforelse

    </tbody>
</table>

@include('partials.foot')