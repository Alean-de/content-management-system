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
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Thumbnail</label>
        <input type="file" name="thumbnail" id="thumbnail">
        <img id="thumbnail-preview" width="150">
    </div>

    <div>
        <label>Content</label>
        <textarea name="content" id="content" rows="5" required></textarea>

        <p>
            Character Count:
            <span id="counter">0</span>
        </p>
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

                    <button type="submit" class="delete-btn">
                        Delete
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/article.js') }}"></script>
@include('partials.foot')