<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi Penjualan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" 
        style="border-collapse: collapse; background-color: #ffffff; margin-top: 30px; border-radius: 8px; overflow: hidden;">
        <tr>
            <td align="center" bgcolor="#1e88e5" style="padding: 20px 0;">
                <h2 style="color: #ffffff; margin: 0;">Detail Transaksi Penjualan</h2>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px;">
                <h3 style="color: #0a2540; margin-bottom: 10px;">Informasi Transaksi</h3>
                <p><strong>Nama Kasir:</strong> {{ $transaction->nama_kasir }}</p>
                <p><strong>Email Pembeli:</strong> {{ $transaction->email_pembeli }}</p>
                <p><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaction->tanggal_transaksi)->format('d M Y') }}</p>
                <p><strong>Dibuat:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px;">
                <h3 style="color: #0a2540; margin-bottom: 10px;">Produk yang Dibeli</h3>
                <table width="100%" border="1" cellpadding="6" cellspacing="0" 
                    style="border-collapse: collapse; border-color: #dddddd;">
                    <thead style="background-color: #1e88e5; color: white;">
                        <tr>
                            <th align="left">No</th>
                            <th align="left">Nama Produk</th>
                            <th align="right">Harga Satuan</th>
                            <th align="right">Jumlah Beli</th>
                            <th align="right">Subtotal</th>
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
                                <td align="right">{{ 'Rp ' . number_format($detail->product->price, 2, ',', '.') }}</td>
                                <td align="right">{{ $detail->jumlah_pembelian }}</td>
                                <td align="right">{{ 'Rp ' . number_format($subtotal, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background-color: #f8f9fa;">
                        <tr>
                            <td colspan="4" align="right" style="font-weight: bold;">Total:</td>
                            <td align="right" style="font-weight: bold; color: #1e88e5;">
                                {{ 'Rp ' . number_format($total, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>

        <tr>
            <td align="center" bgcolor="#0d1b2a" style="padding: 15px; color: #ffffff; font-size: 14px;">
                Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
            </td>
        </tr>
    </table>
</body>
</html>
