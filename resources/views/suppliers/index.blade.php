<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Suppliers</title>
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
        table.table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }
        table th, table td {
            text-align: center;
            vertical-align: middle;
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
            <div class="col-md-10">

                <h2 class="text-center my-4">Dashboard Supplier</h2>
                <hr>

                <!-- ✅ Navigasi Utama -->
                <div class="nav-buttons d-flex justify-content-center gap-3 mb-4">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-light px-4 active">Supplier</a>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-light px-4">Transaksi</a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light px-4">Product</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-light px-4">Category Products</a>
                </div>

                <div class="card border-0 shadow-sm rounded p-3">
                    <div class="card-body">
                        <a href="{{ route('suppliers.create') }}" class="btn btn-md btn-success mb-3">+ ADD SUPPLIER</a>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Supplier Name</th>
                                        <th>PIC Supplier</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->pic_supplier }}</td>
                                        <td>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline delete-form">
                                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-secondary">SHOW</a>
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" id="btn-delete" data-name="{{ $supplier->supplier_name }}">
                                                    HAPUS
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger fw-bold py-3">
                                            Data Supplier belum tersedia.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
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

        // ✅ Konfirmasi hapus supplier
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let name = form.querySelector('#btn-delete').getAttribute('data-name');
                Swal.fire({
                    title: 'Yakin hapus "' + name + '" ?',
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
