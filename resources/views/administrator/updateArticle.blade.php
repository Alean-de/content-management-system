@include('partials.head')

<h2>Update Article</h2>

<form action="{{ route('administrator.article.update', $article->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div>
        <label>Title</label>
        <input type="text"
               name="title"
               value="{{ old('title', $article->title) }}"
               required>
    </div>

    <br>

    <div>
        <label>Content</label>
        <textarea name="content"
                  rows="10"
                  cols="80"
                  required>{{ old('content', $article->content) }}</textarea>
    </div>

    <br>

    <div>
        <label>Thumbnail Saat Ini</label><br>

        @if($article->thumbnail)
            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 width="150">
        @else
            <p>Tidak ada thumbnail</p>
        @endif
    </div>

    <br>

    <div>
        <label>Ganti Thumbnail</label>
        <input type="file" name="thumbnail">
    </div>

    <br>

    <div>
        <label>Published At</label>
        <input type="datetime-local"
               name="published_at"
               value="{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d\TH:i') : '' }}">
    </div>

    <br>

    <button type="submit">
        Update Article
    </button>

</form>

@include('partials.foot')