<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        return view('commandes.index');
    }

    public function create()
    {
        return view('commandes.create');
    }

    public function store(Request $request)
    {
        // Validate and store the commande data
        // ...

        return redirect()->route('commandes.index')->with('success', 'Commande created successfully.');
    }

    public function show($id)
    {
        // Retrieve and display the commande details
        // ...

        return view('commandes.show', compact('commande'));
    }

    public function edit($id)
    {
        // Retrieve the commande data for editing
        // ...

        return view('commandes.edit', compact('commande'));
    }
    public function update(Request $request, $id)
    {
        // Validate and update the commande data
        // ...

        return redirect()->route('commandes.index')->with('success', 'Commande updated successfully.');
    }
    public function destroy($id)
    {        // Delete the commande
        // ...

        return redirect()->route('commandes.index')->with('success', 'Commande deleted successfully.');
    }
}
