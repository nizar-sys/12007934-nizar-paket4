<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\HistoryAuction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class HistoryAuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        return view('dashboard.auctions.bid.create', compact("auction"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        $validatedPayloadHistory = [
            'auction_id' => $auctionId,
            'bidder_id' => Auth::id(),
            'price_quote' => $request->price_quote,
            'created_at' => now(),
        ];

        if((int)$validatedPayloadHistory['price_quote'] < (int) $auction->item->start_price){
            return back()->with('error', 'Terjadi kesalahan')->withErrors(['price_quote' => "Harga yang diajukan harus lebih besar dari harga awal"])->withInput(['price_quote']);
        }

        $auction->auctionsHistory()->create($validatedPayloadHistory);

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil mengajukan pelelangan barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HistoryAuction  $historyAuction
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryAuction $historyAuction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HistoryAuction  $historyAuction
     * @return \Illuminate\Http\Response
     */
    public function edit(HistoryAuction $historyAuction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HistoryAuction  $historyAuction
     * @return \Illuminate\Http\Response
     */
    public function update($auctionId, $historyAuctionId)
    {
        $historyAuction = HistoryAuction::findOrFail($historyAuctionId);

        $historyAuction->update([
            'status' => 'diterima',
            'updated_at' => now(),
        ]);

        $historyAuction->auction()->update([
            'status' => 'ditutup',
            'final_price' => (int) $historyAuction->price_quote,
            'updated_at' => now()
        ]);

        $historyAuction->auction->item()->update([
            'item_status' => '1',
            'created_at' => now()
        ]);

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil menerima tawaran lelang.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HistoryAuction  $historyAuction
     * @return \Illuminate\Http\Response
     */
    public function destroy($auctionId, $historyAuctionId)
    {
        $historyAuction = HistoryAuction::findOrFail($historyAuctionId);

        $historyAuction->update([
            'status' => 'ditolak',
            'updated_at' => now(),
        ]);

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil menolak penawaran lelang.');
    }

    public function validateAuction($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        // get history bid yang harganya paling tinggi
        $highBid = $auction->auctionsHistory()->orderByDesc('price_quote');

        $highgestBid = $highBid->get()->first();

        if(is_null($highgestBid)){
            return back()->with('error', 'Terjadi kesalahan saat memvalidasi data.');
        }

        $highgestBid->update([
            'status' => 'diterima',
            'updated_at' => now(),
        ]);

        $idPending = $highBid->where('status', 'pending')->get()->pluck('id')->toArray();

        $highBid->whereIn('id', $idPending)->update([
            'status' => 'ditolak',
            'updated_at' => now()
        ]);

        $highgestBid->auction()->update([
            'status' => 'ditutup',
            'final_price' => (int) $highgestBid->price_quote,
            'updated_at' => now()
        ]);

        $highgestBid->auction->item()->update([
            'item_status' => '1',
            'created_at' => now()
        ]);

        return redirect(route('auctions.show', $auctionId))->with('success', 'Berhasil memvalidasi tawaran lelang.');
    }
}
