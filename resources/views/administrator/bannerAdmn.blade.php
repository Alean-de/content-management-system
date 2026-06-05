@include('partials.head')
@include('partials.navbar')

<h2>Banner Management</h2>

<div id="alert-container"></div>

<form id="formTambahBanner" enctype="multipart/form-data">
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
        <input type="file" name="image" id="image" required>
        <img id="preview" width="200">
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
            <input type="checkbox" name="is_active" value="1">
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

    <tbody id="bannerTableBody">
        </tbody>
</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/banner.js') }}"></script>
@include('partials.foot')