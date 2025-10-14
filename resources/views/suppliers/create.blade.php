<!DOCTYPE html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Supplier</title>
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
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row">
            <h2>Show Supplier</h2>
            <div class="col-md-8 offset-md-2">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="mb-3">{{ $supplier->supplier_name }}</h3>
                        <hr/>
                        <p><strong>PIC Supplier :</strong> {{ $supplier->pic_supplier }}</p>
                        <hr/>
                        @if(isset($supplier->address))
                            <p><strong>Alamat :</strong> {{ $supplier->address }}</p>
                            <hr/>
                        @endif
                        @if(isset($supplier->phone))
                            <p><strong>Nomor Telepon :</strong> {{ $supplier->phone }}</p>
                            <hr/>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-primary">Kembali</a>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">Edit Supplier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
