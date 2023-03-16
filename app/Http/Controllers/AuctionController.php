<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use App\Http\Requests\RequestStoreOrUpdateAuction;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['roles:admin,petugas'])->except(['index', 'show', 'userDataTable']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::orderBy('status', 'desc');
        $auctions = $auctions->paginate(50);

        return view('dashboard.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::whereItemStatus('0')->orderByDesc('id')->get(['id', 'item_name', 'start_price']);
        return view('dashboard.auctions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateAuction $request)
    {
        $validated = $request->validated() + [
            'user_id' => Auth::id(),
            'created_at' => now(),
        ];

        $auction = Auction::create($validated);

        return redirect(route('auctions.index'))->with('success', 'Auction berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        $historyAuction = collect($auction->auctionsHistory);

        return view('dashboard.auctions.show', compact('auction', 'historyAuction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        $items = Item::orderByDesc('id')->get(['id', 'item_name', 'start_price']);

        return view('dashboard.auctions.edit', compact('auction', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreOrUpdateAuction $request, $id)
    {
        $validated = $request->validated() + [
            'updated_at' => now(),
        ];

        $auction = Auction::findOrFail($id);

        $auction->update($validated);

        return redirect(route('auctions.index'))->with('success', 'Auction berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();

        return redirect(route('auctions.index'))->with('success', 'Auction berhasil dihapus.');
    }
}
