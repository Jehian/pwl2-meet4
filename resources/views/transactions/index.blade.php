<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Penjualan</title>
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
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        table.table thead {
            background-color: #0d6efd;
            color: white;
            text-transform: uppercase;
        }

        table.table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.08);
        }

        table th, table td {
            vertical-align: middle;
            text-align: center;
        }

        h2 {
            color: #fff;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
            font-weight: 700;
        }

        hr {
            border-color: #ffffff66;
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
        <a href="{{ route('transactions.index') }}" class="active">Transaksi</a>
        <a href="{{ route('products.index') }}">Product</a>
        <a href="{{ route('categories.index') }}">Category Products</a>
    </div>

    <!-- ✅ MAIN CONTENT -->
    <div class="main-content">
        <h2 class="text-center my-4">Dashboard Transaksi Penjualan</h2>
        <hr>

        <div class="card border-0 shadow-sm rounded p-3">
            <div class="card-body">
                <a href="{{ route('transactions.create') }}" class="btn btn-md btn-success mb-3">+ TAMBAH TRANSAKSI</a>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">NAMA KASIR</th>
                                <th scope="col">EMAIL PEMBELI</th>
                                <th scope="col">TANGGAL TRANSAKSI</th>
                                <th scope="col">PRODUK & JUMLAH</th>
                                <th scope="col" style="width: 20%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $index => $transaction)
                            <tr>
                                <td class="text-center">{{ $index + $transactions->firstItem() }}</td>
                                <td>{{ $transaction->nama_kasir }}</td>
                                <td>{{ $transaction->email_pembeli }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d M Y') }}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach ($transaction->details as $detail)
                                            <li>
                                                {{ $detail->product->title ?? 'Produk dihapus' }} 
                                                <span class="text-muted">x{{ $detail->jumlah_pembelian }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="delete-form d-inline">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-secondary">SHOW</a>
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" id="btn-delete" data-title="Transaksi {{ $transaction->id }}">
                                            HAPUS
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger fw-bold py-3">
                                        Data Transaksi belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
                <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
    </div>

<!-- ✅ Scripts -->
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

// Konfirmasi hapus
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let title = form.querySelector('#btn-delete').getAttribute('data-title');
        Swal.fire({
            title: 'Yakin hapus ' + title + '?',
            text: "Data transaksi akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#198754',
            confirmButtonText: 'Ya, hapus!',
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
