@include('partials.head')
@include('partials.navbar')


<h2>Article Management</h2>

<div id="alert-container"></div>

<form id="formTambahArticle" enctype="multipart/form-data">
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
        <p>Character Count: <span id="counter">0</span></p>
    </div>

    <button type="submit">Add Article</button>
</form>

<hr>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Thumbnail</th>
            <th>Title</th>
            <th>Author</th>
            <th>Published</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="articleTableBody">
        </tbody>
</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/article.js') }}"></script>
@include('partials.foot')