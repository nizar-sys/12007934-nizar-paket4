@extends('layouts.app')
@section('title', 'Ubah Data Barang')

@section('title-header', 'Ubah Data Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Ubah Data Barang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Ubah Data Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $auction->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_id">Nama Barang</label>
                                    <select class="form-control @error('item_id') is-invalid @enderror" id="item_id"
                                        name="item_id">
                                        <option value="" selected>Pilih Barang</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('item_id', $auction->item_id) == $item->id) selected @endif>
                                                {{ $item->item_name . ' | Rp. ' . number_format( $item->start_price, 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>

                                    @error('item_id')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="user_id">Nama Pelelang (Petugas / Admin)</label>
                                    <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                        id="user_id" placeholder="Nama Pelelang (Petugas / Admin)"
                                        value="{{ Auth::user()->name ?? 'Admin' }}" name="user_id" disabled>

                                    @error('user_id')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">UBah</button>
                                <a href="{{ route('auctions.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
