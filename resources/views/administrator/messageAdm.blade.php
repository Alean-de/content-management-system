@include('partials.head')

<h2>Message Management</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        @forelse($messages as $message)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $message->name }}</td>

                <td>{{ $message->email }}</td>

                <td>{{ $message->subject }}</td>

                <td>{{ $message->created_at }}</td>

                <td>

                    <a href="{{ route('administrator.message.show', $message->id) }}">
                        View
                    </a>

                    <form action="{{ route('administrator.message.delete', $message->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Yakin hapus pesan ini?')">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6">
                    Belum ada pesan.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

@include('partials.foot')