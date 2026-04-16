<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        return view('paniers.index');
    }

    public function create()
    {
        return view('paniers.create');
    }

    public function store(Request $request)
    {
        // Validate and store the panier data
        // ...

        return redirect()->route('paniers.index')->with('success', 'Panier created successfully.');
    }

    public function show($id)
    {
        // Retrieve and display the panier details
        // ...

        return view('paniers.show', compact('panier'));
    }

    public function edit($id)
    {
        // Retrieve the panier data for editing
        // ...

        return view('paniers.edit', compact('panier'));
    }
    public function update(Request $request, $id)
    {
        // Validate and update the panier data
        // ...

        return redirect()->route('paniers.index')->with('success', 'Panier updated successfully.');
    }
    public function destroy($id)
    {        // Delete the panier
        // ...

        return redirect()->route('paniers.index')->with('success', 'Panier deleted successfully.');
    }
}
