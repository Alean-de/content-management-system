@include('partials.head')

<h2>Article Management</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form
    action="{{ route('administrator.article.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <div>
        <label>Title</label>
        <input
            type="text"
            name="title"
            required
        >
    </div>

    <div>
        <label>Thumbnail</label>
        <input
            type="file"
            name="thumbnail"
        >
    </div>

    <div>
        <label>Content</label>
        <textarea
            name="content"
            rows="5"
            required
        ></textarea>
    </div>

    <button type="submit">
        Add Article
    </button>

</form>

<hr>

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>Thumbnail</th>
        <th>Title</th>
        <th>Author</th>
        <th>Published</th>
        <th>Action</th>
    </tr>

    @foreach($articles as $index => $article)

        <tr>

            <td>{{ $index + 1 }}</td> 

            <td>

                @if($article->thumbnail)

                    <img
                        src="{{ asset('storage/' . $article->thumbnail) }}"
                        width="100"
                    >

                @endif

            </td>

            <td>{{ $article->title }}</td>

            <td>{{ $article->user->name }}</td>

            <td>{{ $article->published_at }}</td>

            <td>

                <a
                    href="{{ route('administrator.article.showUpdate', $article->id) }}"
                >
                    Edit
                </a>

                <form
                    action="{{ route('administrator.article.delete', $article->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Delete
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

</table>

@include('partials.foot')