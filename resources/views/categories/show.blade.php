<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #001F54, #205fb3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h2 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-back {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 500;
        }
        .btn-back:hover {
            background-color: #0b5ed7;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <h2 class="text-center">Detail Kategori Produk</h2>

    {{-- Informasi Utama Kategori --}}
    <div class="card mb-4">
        <div class="card-body">
            <h4>Informasi Kategori</h4>
            <hr>
            <p><strong>Nama Kategori:</strong> {{ $category->product_category_name }}</p>
            <p><strong>Dibuat Pada:</strong> {{ \Carbon\Carbon::parse($category->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
            <p><strong>Diperbarui Terakhir:</strong> {{ \Carbon\Carbon::parse($category->updated_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- Daftar Produk dalam Kategori --}}
    <div class="card">
        <div class="card-body">
            <h4>Produk dalam Kategori Ini</h4>
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ "Rp " . number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->supplier->supplier_name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold py-3">
                                Tidak ada produk dalam kategori ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('categories.index') }}" class="btn btn-back">← Kembali ke Daftar Kategori</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
