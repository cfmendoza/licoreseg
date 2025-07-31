<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Stock</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
