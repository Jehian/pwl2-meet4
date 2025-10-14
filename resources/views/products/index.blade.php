<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #001F54, #205fb3ff);
            min-height: 100vh;
            color: #f8f9fa;
            font-family: "Segoe UI", sans-serif;
        }
        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        table.table {
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 10px;
        }

        table.table thead {
            background-color: #0d6efd;
            color: white;
            text-transform: uppercase;
        }

        table.table tbody tr {
            transition: all 0.2s ease-in-out;
        }

        table.table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }

        table th, table td {
            vertical-align: middle;
            text-align: center;
        }
        .nav-buttons a {
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-buttons a:hover {
            transform: translateY(-3px);
        }

        h2 {
            color: #fff;
            font-weight: 700;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        hr {
            border-color: #ffffff66;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div>
                    <h2 class="text-center my-4">Dashboard Product</h2>
                    <hr>
                </div>

                <!-- Tombol Navigasi -->
                <div class="nav-buttons d-flex justify-content-center gap-3 mb-4">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-light px-4">Supplier</a>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-light px-4">Transaksi</a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light px-4 active">Product</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-light px-4">Category Products</a>
                </div>
                
                <div class="card border-0 shadow-sm rounded p-3">
                    <div class="card-body">
                        <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">+ ADD PRODUCT</a>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">IMAGE</th>
                                        <th scope="col">TITLE</th>
                                        <th scope="col">SUPPLIER</th>
                                        <th scope="col">CATEGORY</th>
                                        <th scope="col">PRICE</th>
                                        <th scope="col">STOCK</th>
                                        <th scope="col" style="width: 20%">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/images/'.$product->image) }}" class="rounded shadow-sm" style="width: 120px; border: 2px solid #e0e0e0;">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->supplier_name }}</td>
                                        <td>{{ $product->product_category_name }}</td>
                                        <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form d-inline">
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-secondary">SHOW</a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" id="btn-delete" data-title="{{ $product->title }}">
                                                    HAPUS
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-danger fw-bold py-3">
                                                Data Products belum Tersedia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ✅ SweetAlert pesan sukses/gagal
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>

    <script>
        // ✅ Konfirmasi hapus produk
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let title = form.querySelector('#btn-delete').getAttribute('data-title');
                Swal.fire({
                    title: 'Yakin hapus "' + title + '" ?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#198754',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>

</body>
</html>
