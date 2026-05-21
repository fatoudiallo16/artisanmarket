

@php $total = 0; @endphp

@foreach($cart as $id => $item)

    @php
        $total += $item['price'] * $item['quantity'];
    @endphp

    <div>

        <h4>{{ $item['name'] }}</h4>

        <p>{{ $item['price'] }} FCFA</p>

        <p>Quantité : {{ $item['quantity'] }}</p>

    </div>

@endforeach

<hr>

<h3>Total : {{ $total }} FCFA</h3>