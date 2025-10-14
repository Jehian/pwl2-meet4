<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Products</title>
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

        textarea.form-control {
            resize: none;
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
            <h2>Show Product</h2>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/images/'.$product->image) }}" class="rounded" style="width: 100%">
                    </div>
                </div>
            </div>
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <h3>{{ $product->title }}</h3>
                            <hr/>
                            <p>Category : {{ $product->product_category_name ?? '-' }}</p>
                            <hr/>
                            <p>Supplier : {{ $product->supplier_name ?? '-' }}</p>
                            <hr/>
                            <p>{{ "Rp " . number_format($product->price, 2, ',', '.') }}</p>
                            <code>
                                <p>{{ $product->description }}</p>
                            </code>
                            <hr/>
                            <p>Stock : {{ $product->stock }}</p>
                        </div>
                    </div>
                </div>
            </div>
                    <footer>
            Dashboard CRUD Project - Benny, Jason, Jonathan, Anas
        </footer>
        </div>
     
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>