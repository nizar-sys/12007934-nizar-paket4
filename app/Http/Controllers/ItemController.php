<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\RequestStoreOrUpdateItem;
use Illuminate\Support\Facades\Hash;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderByDesc('id');
        $items = $items->paginate(50);

        return view('dashboard.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateItem $request)
    {
        $validated = $request->validated() + [
            'created_at' => now(),
        ];

        if($request->hasFile('item_image')){
            $fileName = time() . '.' . $request->item_image->extension();
            $validated['item_image'] = $fileName;

            // move file
            $request->item_image->move(public_path('uploads/images'), $fileName);
        }

        $item = Item::create($validated);

        return redirect(route('items.index'))->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Item::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('dashboard.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreOrUpdateItem $request, $id)
    {
        $validated = $request->validated() + [
            'updated_at' => now(),
        ];

        $item = Item::findOrFail($id);

        $validated['item_image'] = $item->item_image;

        if($request->hasFile('item_image')){
            $fileName = time() . '.' . $request->item_image->extension();
            $validated['item_image'] = $fileName;

            // move file
            $request->item_image->move(public_path('uploads/images'), $fileName);

            // delete old file
            $oldPath = $item->item_image ? public_path('/uploads/images/'.$item->item_image) : '';
            if(file_exists($oldPath) && $item->item_image != 'no-image.jpg'){
                unlink($oldPath);
            }
        }

        $item->update($validated);

        return redirect(route('items.index'))->with('success', 'Item berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        // delete old file
        $oldPath = $item->item_image ? public_path('/uploads/images/'.$item->item_image) : '';
        if(file_exists($oldPath) && $item->item_image != 'no-image.jpg'){
            unlink($oldPath);
        }
        $item->delete();

        return redirect(route('items.index'))->with('success', 'Item berhasil dihapus.');
    }
}
