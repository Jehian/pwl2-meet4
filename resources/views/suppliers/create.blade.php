<!DOCTYPE html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Supplier</title>
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

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
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
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h3>Add New Supplier</h3>

                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('suppliers.store') }}" method="POST" id="supplierForm">
                            @csrf

                            <!-- Supplier Name -->
                            <div class="form-group mb-3">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" 
                                       name="supplier_name" 
                                       class="form-control @error('supplier_name') is-invalid @enderror" 
                                       placeholder="Masukkan Nama Supplier"
                                       value="{{ old('supplier_name') }}">
                                @error('supplier_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PIC Supplier -->
                            <div class="form-group mb-3">
                                <label for="pic_supplier">PIC Supplier</label>
                                <input type="text" 
                                       name="pic_supplier" 
                                       class="form-control @error('pic_supplier') is-invalid @enderror" 
                                       placeholder="Masukkan Nama PIC Supplier"
                                       value="{{ old('pic_supplier') }}">
                                @error('pic_supplier')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <!-- Tombol Aksi -->
                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="button" id="resetBtn" class="btn btn-md btn-warning">RESET</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-md btn-secondary ms-2">BACK</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Reset form dengan konfirmasi SweetAlert
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
                    document.getElementById("supplierForm").reset();
                }
            });
        });
    </script>

</body>
</html>
