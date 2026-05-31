@include('partials.head')

<form method="POST" id="formTambahMenu" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="image">Image</label>
        <input type="file" id="image" name="image" required>
        <img id="preview" width="150">
    </div>
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="category">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="price">Price</label>
        <input type="number" id="price" name="price" required>
    </div>
    <div>
        <label>
            <input type="checkbox" name="is_featured">
            Featured Menu
        </label>
    </div>
    <button type="submit">
        Add
    </button>
</form>

<table class="table" border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Nama Menu</th>
            <th>Description</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="menuTableBody">
       
    </tbody>
</table>

<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
@include('partials.foot')