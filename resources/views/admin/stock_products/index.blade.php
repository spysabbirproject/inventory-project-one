@extends('admin.layouts.admin_master')

@section('title', 'Stock Products')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="text">
                    <h4 class="card-title">Stock Products</h4>
                    <p class="card-text">List</p>
                </div>
                <div class="action_btn">

                </div>
            </div>
            <div class="card-body">
                <div class="filter">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label">Category Name</label>
                            <select class="form-control filter_data" name="category_id" id="category_id">
                                <option value="">All</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Brand Name</label>
                            <select class="form-control filter_data" name="brand_id" id="brand_id">
                                <option value="">All</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-light" id="stock_table">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>Brand Name</th>
                                <th>Unit Name</th>
                                <th>Purchase Quantity</th>
                                <th>Selling Quantity</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Read Data
        table = $('#stock_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('stock.products') }}",
                "data":function(e){
                    e.category_id = $('#category_id').val();
                    e.brand_id = $('#brand_id').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'category_name', name: 'category_name'},
                {data: 'product_name', name: 'product_name'},
                {data: 'brand_name', name: 'brand_name'},
                {data: 'unit_name', name: 'unit_name'},
                {data: 'purchase_quantity', name: 'purchase_quantity'},
                {data: 'selling_quantity', name: 'selling_quantity'},
                {data: 'stock', name: 'stock'},
            ],
        });

        // Filter Data
        $(document).on('change', '.filter_data', function(e){
            e.preventDefault();
            $('#stock_table').DataTable().ajax.reload()
        })
    });
</script>
@endsection
