<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a2540, #1e88e5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h4 {
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
    </style>

</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <h4>Edit Product</h4>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        
                        <form action="{{ route('products.update', $data['product']->id) }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">IMAGE</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                <!-- error message untuk image -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror    
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_category_id">Product Category</label>
                                <select class="form-control" name="product_category_id" id="product_category_id">
                                    <option value="">-- Select Category Product --</option>
                                    @foreach ($data['categories'] as $category)
                                        <option value="{{ $category->id }}"
                                        @if(old("product_category_id", $data['product']->product_category_id) == $category->id) selected @endif >
                                            {{ $category->product_category_name }}</option>
                                    @endforeach
                                </select>
                                <!-- error message untuk product_category_id -->
                                @error('product_category_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                                <div class="form-group mb-3">
                                    <label for="id_supplier">Supplier</label>
                                    <select class="form-control" name="id_supplier" id="id_supplier">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach ($data['suppliers_'] as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                @if(old("id_supplier", $data['product']->supplier_id) == $supplier->id) selected @endif>
                                                {{ $supplier->supplier_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_supplier')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">TITLE</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ old('title', $data['product']->title) }}" placeholder="Masukkan Judul Product">
                                    
                                    <!-- error message untuk title -->
                                    @error('title')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
    
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">DESCRIPTION</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" 
                                    placeholder="Masukkan Description Product">{{ old('description', $data['product']->description) }}</textarea>
                                    
                                    <!-- error message untuk description -->
                                    @error('description')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">PRICE</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                            value="{{ old('stock', $data['product']->price) }}" placeholder="Masukkan Harga Product">
                                            
                                            <!-- error message untuk price -->
                                            @error('price')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">STOCK</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                                            value="{{ old('stock', $data['product']->stock) }}" placeholder="Masukkan Stock Product">
                                            
                                            <!-- error message untuk stock -->
                                            @error('stock')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                             
                             <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                             <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description ');
    </script>

</body>
</html>