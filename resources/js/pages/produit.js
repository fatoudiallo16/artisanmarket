window.addToCart = function(id, name, price) {

    fetch('/cart/add', {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

        },

        body: JSON.stringify({
            id,
            name,
            price
        })

    })

    .then(res => res.json())

    .then(data => {

        console.log('Panier mis à jour', data);

        alert('Produit ajouté au panier');

    });

}