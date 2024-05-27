<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Product Inventory</h1>
    <form id="productForm" class="mb-4">
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity in Stock</label>
            <input type="number" class="form-control" id="quantity" name="quantity_in_stock" required>
        </div>
        <div class="form-group">
            <label for="price">Price per Item</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price_per_item" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity in Stock</th>
                <th>Price per Item</th>
                <th>Datetime Submitted</th>
                <th>Total Value Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            @foreach ($products as $product)
                <tr data-id="{{ $product->id }}">
                    <td><input type="text" class="form-control" value="{{ $product->product_name }}" readonly></td>
                    <td><input type="number" class="form-control" value="{{ $product->quantity_in_stock }}" readonly></td>
                    <td><input type="number" step="0.01" class="form-control" value="{{ $product->price_per_item }}" readonly></td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ number_format($product->quantity_in_stock * $product->price_per_item, 2) }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning editBtn">Edit</button>
                        <button class="btn btn-sm btn-success saveBtn" style="display:none;">Save</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td id="sumTotalValue">{{ number_format($products->sum(function($p) { return $p->quantity_in_stock * $p->price_per_item; }), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#productForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/products',
            method: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(response) {
                alert('Error: ' + JSON.stringify(response.responseJSON.errors));
            }
        });
    });

    $('.editBtn').click(function() {
        const row = $(this).closest('tr');
        row.find('input').prop('readonly', false);
        row.find('.editBtn').hide();
        row.find('.saveBtn').show();
    });

    $('.saveBtn').click(function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const productName = row.find('input:eq(0)').val();
        const quantity = row.find('input:eq(1)').val();
        const price = row.find('input:eq(2)').val();
        $.ajax({
            url: '/products/' + id,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                product_name: productName,
                quantity_in_stock: quantity,
                price_per_item: price
            },
            success: function(data) {
                location.reload();
            },
            error: function(response) {
                alert('Error: ' + JSON.stringify(response.responseJSON.errors));
            }
        });
    });
});
</script>
</body>
</html>
