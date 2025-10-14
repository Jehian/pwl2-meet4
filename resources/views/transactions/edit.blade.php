<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0a2540, #1e88e5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        h4 {
            color: #fff;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        label {
            font-weight: 600;
        }
        .btn-primary {
            background-color: #1e88e5;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1565c0;
        }
        .btn-warning {
            color: #fff;
            background-color: #fbc02d;
            border: none;
        }
        .btn-warning:hover {
            background-color: #f9a825;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <h4>Edit Transaksi</h4>
            <div class="card p-4">
                <div class="card-body">
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label>Nama Kasir</label>
                            <input type="text" name="nama_kasir" class="form-control" 
                                   value="{{ old('nama_kasir', $transaction->nama_kasir) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label>Email Pembeli</label>
                            <input type="email" name="email_pembeli" class="form-control" 
                                   value="{{ old('email_pembeli', $transaction->email_pembeli) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label>Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" class="form-control" 
                            value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('Y-m-d')) }}">

                        </div>

                        <hr>
                        <h5>Daftar Produk</h5>

                        <div id="produk-container">
                            @foreach ($transaction->details as $index => $detail)
                                <div class="row mb-3 align-items-end produk-row">
                                    <div class="col-md-6">
                                        <label>Produk</label>
                                        <select name="product_id[]" class="form-select">
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $product->id == $detail->id_product ? 'selected' : '' }}>
                                                    {{ $product->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Jumlah Pembelian</label>
                                        <input type="number" name="jumlah_pembelian[]" class="form-control"
                                               value="{{ $detail->jumlah_pembelian }}">
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-success mb-3" id="btn-tambah-produk">+ Tambah Produk</button>

                        <div>
                            <button type="submit" class="btn btn-md btn-primary me-2">UPDATE</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-md btn-warning">KEMBALI</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-tambah-produk').addEventListener('click', function () {
    const container = document.getElementById('produk-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-3', 'align-items-end', 'produk-row');

    row.innerHTML = `
        <div class="col-md-6">
            <label>Produk</label>
            <select name="product_id[]" class="form-select">
                <option value="">-- Pilih Produk --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Jumlah Pembelian</label>
            <input type="number" name="jumlah_pembelian[]" class="form-control" placeholder="Masukkan jumlah">
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-danger btn-remove">Hapus</button>
        </div>
    `;

    container.appendChild(row);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remove')) {
        e.target.closest('.produk-row').remove();
    }
});
</script>

</body>
</html>
