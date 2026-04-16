<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validate and store the user data
        // ...

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        // Retrieve and display the user details
        // ...

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        // Retrieve the user data for editing
        // ...

        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        // Validate and update the user data
        // ...

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {        // Delete the user
        // ...

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }   
}
