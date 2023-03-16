@extends('layouts.app')
@section('title', 'Tambah Data Barang')

@section('title-header', 'Tambah Data Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Tambah Data Barang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_name">Nama Barang</label>
                                    <input type="text" class="form-control @error('item_name') is-invalid @enderror"
                                        id="item_name" placeholder="Nama Barang" value="{{ old('item_name') }}"
                                        name="item_name">

                                    @error('item_name')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="start_price">Harga Awal Barang</label>
                                    <input type="number" class="form-control @error('start_price') is-invalid @enderror"
                                        id="start_price" placeholder="Harga Awal Barang" value="{{ old('start_price') }}"
                                        name="start_price">

                                    @error('start_price')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_status">Status Barang</label>
                                    <input type="text" class="form-control @error('item_status') is-invalid @enderror"
                                        id="item_status" placeholder="Status Barang"
                                        value="{{ old('item_status', 'Belum terjual') }}" name="item_status" disabled>

                                    @error('item_status')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_image">Gambar Barang</label>
                                    <input type="file" class="form-control @error('item_image') is-invalid @enderror"
                                        id="item_image" placeholder="Gambar Barang" name="item_image">

                                    @error('item_image')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="item_desc">Deskripsi Barang</label>
                                    <textarea class="form-control @error('item_desc') is-invalid @enderror" id="item_desc" placeholder="Deskripsi Barang"
                                        name="item_desc" cols="30" rows="10">{{ old('item_desc') }}</textarea>

                                    @error('item_desc')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{ route('items.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
