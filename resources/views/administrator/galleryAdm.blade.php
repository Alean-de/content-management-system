@include('partials.head')

<h2>Gallery Management</h2>

<div id="alert-container"></div>

<form id="formTambahGallery" enctype="multipart/form-data">
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

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody id="galleryTableBody">
        </tbody>
</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/gallery.js') }}"></script>
@include('partials.foot')