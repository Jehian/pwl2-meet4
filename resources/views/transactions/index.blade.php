<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Penjualan</title>
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
            background-color: rgba(13, 110, 253, 0.08);
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
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
            font-weight: 700;
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
            <h2 class="text-center my-4">Dashboard Transaksi Penjualan</h2>
            <hr>
        </div>

            <!-- Navigasi -->
            <div class="nav-buttons d-flex justify-content-center gap-3 mb-4">
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-light px-4">Supplier</a>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-light px-4 active">Transaksi</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light px-4">Product</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-light px-4">Category Products</a>
            </div>

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

        </div>
    </div>
</div>

<!-- Scripts -->
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
