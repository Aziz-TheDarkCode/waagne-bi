<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('burgers.index', compact('burgers'));
    }

    public function show(Burger $burger)
    {
        return view('burgers.show', compact('burger'));
    }

    public function create()
    {
        return view('burgers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('burgers', 'public');
            $validated['image_path'] = $path;
        }

        Burger::create($validated);

        return redirect()->route('burgers.index')
            ->with('success', 'Burger créé avec succès.');
    }

    public function update(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($burger->image_path) {
                Storage::disk('public')->delete($burger->image_path);
            }
            $path = $request->file('image')->store('burgers', 'public');
            $validated['image_path'] = $path;
        }

        $burger->update($validated);

        return redirect()->route('burgers.index')
            ->with('success', 'Burger mis à jour avec succès.');
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }
}