<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Awesome store</title>
</head>
<body>
<h1>New product</h1>
<form action="{{ route('storeProduct') }}" method="post">
    @csrf()
    <label for="name">Name</label>
    <input autocomplete="off" id="name" type="text" name="name"/>

    <label for="description">Description</label>
    <textarea autocomplete="off" name="description" id="description" cols="30" rows="10"></textarea>

    <label for="price">Price</label>
    <input autocomplete="off" id="price" type="text" name="price"/>

    <button type="submit">Create</button>
</form>
<h2>
    Products
</h2>
<ul>
    @empty($products)
        <li><em>-- No products --</em></li>
    @endempty
    @foreach($products as $product)
        <li>{{ $product }}</li>
    @endforeach
</ul>
</body>
</html>
