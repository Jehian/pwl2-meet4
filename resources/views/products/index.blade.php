<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body { 
            background: linear-gradient(135deg, #0a2540, #1e88e5);
            min-height: 100vh;
            color: #f8f9fa;
            font-family: "Segoe UI", sans-serif;
            display: flex;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 250px;
            background-color: #0d1b2a;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar h3 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            width: 100%;
            padding: 12px 15px;
            color: #f8f9fa;
            text-decoration: none;
            font-weight: 600;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #205fb3;
            transform: translateX(5px);
        }

        /* === MAIN CONTENT === */
        .main-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #fff;
            font-weight: 700;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
            margin-bottom: 25px;
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

    <!-- ✅ SIDEBAR -->
    <div class="sidebar">
        <h3>Dashboard</h3>
        <a href="{{ route('suppliers.index') }}">Supplier</a>
        <a href="{{ route('transactions.index') }}">Transaksi</a>
        <a href="{{ route('products.index') }}" class="active">Product</a>
        <a href="{{ route('categories.index') }}">Category Products</a>
    </div>

    <!-- ✅ MAIN CONTENT -->
    <div class="main-content">
        <div>
            <h2 class="text-center my-4">Dashboard Product</h2>
            <hr>

            <div class="card border-0 shadow-sm rounded p-3">
                <div class="card-body">
                    <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">+ ADD PRODUCT</a>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>IMAGE</th>
                                    <th>TITLE</th>
                                    <th>SUPPLIER</th>
                                    <th>CATEGORY</th>
                                    <th>PRICE</th>
                                    <th>STOCK</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    <td><img src="{{ asset('/storage/images/'.$product->image) }}" class="rounded shadow-sm" style="width: 100px;"></td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->supplier_name }}</td>
                                    <td>{{ $product->product_category_name }}</td>
                                    <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-secondary">SHOW</a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" id="btn-delete" data-title="{{ $product->title }}">HAPUS</button>
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

        <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
</body>
</html>
