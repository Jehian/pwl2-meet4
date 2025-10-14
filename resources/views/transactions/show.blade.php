<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Transaction Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a2540, #1e88e5);
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
        label {
            font-weight: 600;
            color: #0a2540;
        }
        table {
            width: 100%;
            margin-top: 15px;
        }
        th {
            background-color: #1e88e5;
            color: #fff;
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

<div class="container mt-5 mb-5">
    <h2>Detail Transaksi Penjualan</h2>

    {{-- Informasi Utama Transaksi --}}
    <div class="card mb-4">
        <div class="card-body">
            <h4>Informasi Transaksi</h4>
            <hr>
            <p><strong>Nama Kasir:</strong> {{ $transaction->nama_kasir }}</p>
            <p><strong>Email Pembeli:</strong> {{ $transaction->email_pembeli }}</p>
            <p><strong>Tanggal Transaksi:</strong> 
    {{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d M Y') }}</p>
            <p><strong>Dibuat:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    {{-- Detail Produk yang Dibeli --}}
    <div class="card">
        <div class="card-body">
            <h4>Produk yang Dibeli</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Beli</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($transaction->details as $index => $detail)
                        @php
                            $subtotal = $detail->product->price * $detail->jumlah_pembelian;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->product->title }}</td>
                            <td>{{ "Rp " . number_format($detail->product->price, 2, ',', '.') }}</td>
                            <td>{{ $detail->jumlah_pembelian }}</td>
                            <td>{{ "Rp " . number_format($subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>{{ "Rp " . number_format($total, 2, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
            <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
