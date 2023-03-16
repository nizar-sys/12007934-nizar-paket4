<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\HistoryAuction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    protected $months = ['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

    public function mostSellingMonth(Request $request)
    {
        $year = $request->year ?? date('Y');

        $auctionsMonth = Auction::
            whereYear('created_at', $year)
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

        $customPaper = array(0,0,1000.00,500.80);
        $pdf = Pdf::loadView('pdf.most_selling_month', compact('mostMonth', 'year', 'months'))->setPaper($customPaper, 'potrait');
        return $pdf->stream();
    }

    public function mostPopularBidder()
    {
        $historyAuctionQuery = HistoryAuction::query();

        $mostPopularBidder = $historyAuctionQuery->whereHas('auction', function ($q) {
            return $q->where('status', 'ditutup');
        })->withCount('auction')->orderBy('auction_count', 'desc')->get()->groupBy('bidder.name');

        $customPaper = array(0,0,1000.00,500.80);
        $pdf = Pdf::loadView('pdf.most_popular_bidder', compact('mostPopularBidder'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function mostPopularItem()
    {
        $historyAuctionQuery = HistoryAuction::query();
        $mostPopularItem = $historyAuctionQuery->withCount('auction')->get()->groupBy('auction.item.item_name');

        $customPaper = array(0,0,1000.00,500.80);
        $pdf = Pdf::loadView('pdf.most_popular_item', compact('mostPopularItem'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function auctions()
    {
        $auctions = Auction::orderBy('status', 'desc')->get();

        $customPaper = array(0,0,1000.00,500.80);
        $pdf = Pdf::loadView('pdf.auctions', compact('auctions'))->setPaper($customPaper);
        return $pdf->stream();
    }

    public function historyAuction($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $historyAuction = collect($auction->auctionsHistory);

        $customPaper = array(0,0,1000.00,500.80);
        $pdf = Pdf::loadView('pdf.history_auction', compact('auction', 'historyAuction'))->setPaper($customPaper);
        return $pdf->stream();
    }
}
