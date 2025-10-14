<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Category Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0a2540, #1e88e5);
            min-height: 100vh;
            color: #f8f9fa;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
            padding: 25px;
        }

        label {
            font-weight: 600;
            color: #0a2540;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-success {
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary {
            border-radius: 8px;
            font-weight: 600;
        }

        .container {
            margin-top: 70px;
        }

        /* === FOOTER === */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #0d1b2a;
            color: #f8f9fa;
            text-align: center;
            padding: 15px 0;
            font-weight: 500;
            border-top: 2px solid #205fb3;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.3);
            z-index: 1000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Tambah Kategori Produk</h2>

            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="product_category_name">Nama Kategori</label>
                            <input type="text" name="product_category_name"
                                   class="form-control @error('product_category_name') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori produk"
                                   value="{{ old('product_category_name') }}">
                            @error('product_category_name')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
                            <button type="submit" class="btn btn-success px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
            <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

</body>
</html>
