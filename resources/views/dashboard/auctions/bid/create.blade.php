@extends('layouts.app')
@section('title', 'Data History Barang')

@section('title-header', 'Data History Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Data Lelang Barang</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.show', $auction->id) }}">Data History Lelang
            {{ $auction->item->item_name }}</a></li>
    <li class="breadcrumb-item active">Buat Penawaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Penawaran Data Barang Lelang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('auctions.store-auction', ['auctionId' => $auction->id]) }}" method="POST" role="form"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    @if ($auction->item->item_image)
                                    <img src="{{ asset('/uploads/images/' . $auction->item->item_image) }}" alt="{{ $auction->item->item_name }}" width="300">
                                    @else
                                    <h6>Tidak ada gambar</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_id">Nama Barang Lelang: </label>
                                    <h5>{{ $auction->item->item_name }}</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="bidder_id">Nama Penawar: </label>
                                    <h5>{{ ucfirst(Auth::user()->name) }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="deskripsi">Deskripsi Barang: </label>
                                <h5>{{ $auction->item->item_desc }}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="start_price">Harga Awal Barang Lelang: </label>
                                    <h5>Rp. {{ number_format($auction->item->start_price, 0, '0', '.') }}</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="price_quote">Harga yang diajukan: </label>
                                    <input type="number" class="form-control @error('price_quote') is-invalid @enderror"
                                        id="price_quote" placeholder="Harga yang diajukan" value="{{ old('price_quote') }}"
                                        name="price_quote" required>

                                    @error('price_quote')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{ route('auctions.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
