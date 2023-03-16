@extends('layouts.app')
@section('title', 'Landing')

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('home') }}">{{ env('APP_NAME') }} | Data Barang</a></li>
@endsection

@section('c_css')
    <style>
        .product-grid {
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }

        .product-grid .product-image {
            overflow: hidden;
            position: relative;
        }

        .product-grid .product-image a.image {
            display: block;
        }

        .product-grid .product-image img {
            width: 100%;
            height: auto;
            transition: all 0.5s ease 0s;
        }

        .product-grid:hover .product-image img {
            transform: scale(1.1);
        }

        .product-grid .product-links {
            background: #fff;
            width: 150px;
            padding: 10px 20px;
            margin: 0;
            list-style: none;
            border-radius: 30px;
            box-shadow: 1px 0 30px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateX(-50%) translateY(-150%);
            position: absolute;
            top: 50%;
            left: 50%;
            transition: all .35s ease;
        }

        .product-grid:hover .product-links {
            opacity: 1;
            transform: translateX(-50%) translateY(-50%);
        }

        .product-grid .product-links li {
            width: 48%;
            margin: 10px 0;
            display: inline-block;
        }

        .product-grid .product-links li a {
            color: #788090;
            font-size: 18px;
            transition: all .3s;
        }

        .product-grid .product-links li a:hover {
            color: #341f97;
            text-shadow: 4px 4px 0 rgba(0, 0, 0, 0.2);
        }

        .product-grid .product-content {
            padding: 15px;
        }

        .product-grid .price {
            color: #333;
            font-size: 15px;
            font-weight: 500;
            margin: 0 0 10px;
        }

        .product-grid .price span {
            color: #999;
            font-weight: 400;
            margin: 0 0 0 5px;
            text-decoration: line-through;
        }

        .product-grid .title {
            font-size: 15px;
            font-weight: 500;
            text-transform: capitalize;
            margin: 0 0 12px;
        }

        .product-grid .title a {
            color: #333;
            transition: all 0.3s ease 0s;
        }

        .product-grid .title a:hover {
            color: #341f97;
            text-decoration: underline;
        }

        @media screen and (max-width: 990px) {
            .product-grid {
                margin-bottom: 30px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                @if ($items->isEmpty())
                    <div class="card-header">
                        <h3 class="card-title">
                            Tidak ada barang yang dilelang
                        </h3>
                    </div>
                @else
                    <div class="container-fluid">
                        <div class="mt-3">
                            <div class="row">
                                @foreach ($items as $produk)
                                    <div class="col-sm-6 col-md-3">
                                        <div class="product-grid">
                                            <div class="product-image">
                                                <a href="{{ route('auctions.create-auction', ['auctionId' => $produk->id]) }}"
                                                    class="image" data-tooltip="Lelang" title="Lelang barang">
                                                    <img class="pic-1"
                                                        src="{{ asset('/uploads/images/' . $produk->item->item_image) }}">
                                                </a>
                                                <ul class="product-links">
                                                    <li><a
                                                            href="{{ route('auctions.create-auction', ['auctionId' => $produk->id]) }}"><i
                                                                class="fas fa-shopping-cart"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="product-content">
                                                <div class="price">
                                                    Rp.{{ number_format($produk->item->start_price, 0, ',', '.') }}</span>
                                                </div>
                                                <h3 class="title"><a href="#">{{ $produk->item->item_name }}</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
