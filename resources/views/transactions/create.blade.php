<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Transaction</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a2540, #1e88e5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h3 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
        }

        label {
            font-weight: 600;
            color: #0a2540;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 0.2rem rgba(30, 136, 229, 0.25);
        }

        .btn-primary {
            background-color: #1e88e5;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1565c0;
        }

        .btn-warning {
            border-radius: 8px;
            color: #fff;
            background-color: #fbc02d;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #f9a825;
        }

        .product-group {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
        }
    </style>

</head>
<body>
    
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h3>Add New Transaction</h3>

                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form id="transactionForm" action="{{ route('transactions.store') }}" method="POST">
                            @csrf

                            <!-- Nama Kasir -->
                            <div class="form-group mb-3">
                                <label for="nama_kasir">Nama Kasir</label>
                                <input type="text" class="form-control @error('nama_kasir') is-invalid @enderror" name="nama_kasir" placeholder="Masukkan Nama Kasir">
                            </div>

                            <!-- Email Pembeli -->
                            <div class="form-group mb-3">
                                <label for="email_pembeli">Email Pembeli</label>
                                <input type="email" class="form-control @error('email_pembeli') is-invalid @enderror" name="email_pembeli" placeholder="Masukkan Email Pembeli">
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div class="form-group mb-4">
                                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" name="tanggal_transaksi">
                            </div>

                            <hr>

                            <h5 class="mb-3 text-primary">Daftar Produk Dibeli</h5>
                            <div id="product-container">
                                <div class="product-group">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-8">
                                            <label for="product_id[]">Pilih Produk</label>
                                            <select name="product_id[]" class="form-select">
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->title }} - Rp {{ number_format($product->price, 0, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="jumlah_pembelian[]">Jumlah</label>
                                            <input type="number" class="form-control" name="jumlah_pembelian[]" placeholder="Jumlah" min="1">
                                        </div>

                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-product">&times;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="addProduct" class="btn btn-sm btn-outline-primary">+ Tambah Produk</button>
                            </div>

                            <hr class="mt-4 mb-4">

                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="button" id="resetBtn" class="btn btn-md btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 🔁 Tambah produk baru
        document.getElementById('addProduct').addEventListener('click', function() {
            const container = document.getElementById('product-container');
            const newProduct = container.firstElementChild.cloneNode(true);

            // Reset nilai dalam clone
            newProduct.querySelectorAll('select, input').forEach(el => el.value = '');
            container.appendChild(newProduct);

            attachRemoveHandlers();
        });

        // 🗑️ Hapus baris produk
        function attachRemoveHandlers() {
            document.querySelectorAll('.remove-product').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (document.querySelectorAll('.product-group').length > 1) {
                        btn.closest('.product-group').remove();
                    } else {
                        Swal.fire('Minimal satu produk harus dipilih');
                    }
                });
            });
        }
        attachRemoveHandlers();

        // ♻️ Reset form
        document.getElementById('resetBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Reset Form?',
                text: "Semua input akan dikosongkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("transactionForm").reset();
                    const container = document.getElementById('product-container');
                    container.innerHTML = '';
                    container.appendChild(container.firstElementChild.cloneNode(true));
                    attachRemoveHandlers();
                }
            });
        });
    </script>
</body>
</html>
