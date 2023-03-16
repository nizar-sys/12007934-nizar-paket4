<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\HistoryAuction;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    protected $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

    public function dashboard(Request $request)
    {
        $items = Auction::orderByDesc('id')->whereStatus('dibuka')->get();

        $auctionQuery = Auction::query();
        $historyAuctionQuery = HistoryAuction::query();
        $userQuery = User::query();

        $data = [
            'total_pengguna' => $userQuery->count(),
            'total_lelang' => $auctionQuery->count(),
            'total_penawaran' => $historyAuctionQuery->count(),
            'lelang_baru' => $auctionQuery->whereStatus('dibuka')->count(),
        ];

        $mostPopularItem = $historyAuctionQuery->withCount('auction')->get()->groupBy('auction.item.item_name');

        $mostPopularBidder = $historyAuctionQuery->whereHas('auction', function ($q) {
            return $q->where('status', 'ditutup');
        })->withCount('auction')->orderBy('auction_count', 'desc')->get()->groupBy('bidder.name');

        $auctionsMonth = Auction::
            whereYear('created_at', $request->year ?? date('Y'))
            ->where('status', 'ditutup')
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $itemsMonth = [];
        $itemsArr = [];

        foreach ($auctionsMonth as $key => $value) {
            $itemsMonth[(int)$key] = count($value);
        }

        for ($i = 1; $i <= 12; $i++) {
            if (!empty($itemsMonth[$i])) {
                $itemsArr[$i] = $itemsMonth[$i];
            } else {
                $itemsArr[$i] = 0;
            }
        }

        $mostMonth = $itemsArr;
        $months = $this->months;

        return view('dashboard.index', compact('items', 'data', 'mostPopularItem', 'mostPopularBidder', 'mostMonth', 'months'));
    }

    public function landing()
    {
        $items = Auction::orderByDesc('id')->whereStatus('dibuka')->get();

        return view('dashboard.landing', compact('items'));
    }
}
