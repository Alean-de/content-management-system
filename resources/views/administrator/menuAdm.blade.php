@include('partials.head')

<form action="{{ route('administrator.menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="image">Image</label>
        <input type="file" id="image" name="image" required>
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

<table class="table">
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
    <tbody>
        @forelse ($menuItems as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td> 

                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                            alt="{{ $item->name }}" 
                            style="width: 100px; height: auto; object-fit: cover;" 
                            class="img-thumbnail">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                            alt="No Image" 
                            style="width: 100px; height: auto;" 
                            class="img-thumbnail">
                    @endif
                </td>

                
                <td>{{ $item->name }}</td> 

                <td>{{ $item->description }}</td>
                
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td> 
                
                <td>
                    {{ $item->category ? $item->category->category_name : 'Tanpa Kategori' }}
                </td>
                
                <td>{{ $item->created_at->format('d M Y') }}</td>

                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        
                        <a href="{{ route('administrator.menu.showUpdate', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('administrator.menu.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data menu.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@include('partials.foot')