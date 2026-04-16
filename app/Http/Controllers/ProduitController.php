<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        return view('produits.index');
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        // Validate and store the product data
        // ...

        return redirect()->route('produits.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        // Retrieve and display the product details
        // ...

        return view('produits.show', compact('produit'));
    }

    public function edit($id)
    {
        // Retrieve the product data for editing
        // ...

        return view('produits.edit', compact('produit'));
    }
    public function update(Request $request, $id)
    {
        // Validate and update the product data
        // ...

        return redirect()->route('produits.index')->with('success', 'Product updated successfully.');
    }
    public function destroy($id)
    {        // Delete the product
        // ...

        return redirect()->route('produits.index')->with('success', 'Product deleted successfully.');
    }
}
