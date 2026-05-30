@include('partials.head')

<h2>Message Detail</h2>

<hr>

<div>
    <strong>Name</strong>
    <p>{{ $message->name }}</p>
</div>

<div>
    <strong>Email</strong>
    <p>{{ $message->email }}</p>
</div>

<div>
    <strong>Subject</strong>
    <p>{{ $message->subject }}</p>
</div>

<div>
    <strong>Message</strong>
    <p>{{ $message->message }}</p>
</div>

<div>
    <strong>Created At</strong>
    <p>{{ $message->created_at }}</p>
</div>

<hr>

<a href="{{ url()->previous() }}">
    Back
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

@include('partials.foot')