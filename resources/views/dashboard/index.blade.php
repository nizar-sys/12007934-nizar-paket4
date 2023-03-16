@extends('layouts.app')
@section('title', 'Dashboard')
@php
    $auth = Auth::user();
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></li>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-table-most-popular-item">
        <form action="" method="get">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Tahun Bulan Terbanyak Barang Terjual</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <select name="year" id="year" class="form-control">
                                @foreach (range(1990, date('Y')) as $year)
                                    <option value="{{ $year }}" @selected(request()->has('year') ? $year == request()->year : $year == date('Y'))>{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if (Auth::user()->role == 'masyarakat')
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
                                                    <h3 class="title"><a href="#">{{ $produk->item->item_name }}</a>
                                                    </h3>
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
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card  mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pengguna</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $data['total_pengguna'] }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                            <i class="fas fa-users text-lg opacity-10"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card  mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pelelangan</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $data['total_lelang'] }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card  mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Penawaran</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $data['total_penawaran'] }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card  mb-4">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Pelelangan Baru</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $data['lelang_baru'] }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card shadow">
                            <div class="card-header bg-transparent border-0 text-dark">
                                <h2 class="card-title h3">Barang Terbanyak Ditawar</h2>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover" id="table-most-popular">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Bid / Penawar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mostPopularItem as $item => $bid)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item }}</td>
                                                    <td>{{ $bid->count() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card shadow">
                            <div class="card-header bg-transparent border-0 text-dark">
                                <h2 class="card-title h3">Pengguna Terbanyak Menawar</h2>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover" id="table-most-popular-bidder">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pengguna</th>
                                                <th>Jumlah Bid / Menawar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mostPopularBidder as $user => $bid)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user }}</td>
                                                    <td>{{ $bid->count() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card shadow">
                            <div class="card-header bg-transparent border-0 text-dark">
                                <h2 class="card-title h3">Bulan Banyak Barang Terjual</h2>
                                <div class="table-responsive">
                                    <table class="table table-flush table-hover" id="table-most-popular-item">
                                        <thead>
                                            <tr>
                                                @foreach ($months as $month)
                                                    <th>{{ ucfirst($month) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @foreach ($mostMonth as $item)
                                                    <td>{{ $item }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        var dataTable = $('#table-most-popular').DataTable({
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Data",
                lengthMenu: "Menampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: "<i class='fa fa-angle-right'></i>",
                }
            },
            dom: 'Bflrtip',
            buttons: [{
                title: 'Data Barang Terbanyak Ditawar',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function() {
                    window.open("{{ route('generate.most-popular-item') }}", '_blank')
                }
            }, ],
        });

        var dataTable = $('#table-most-popular-bidder').DataTable({
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Data",
                lengthMenu: "Menampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: "<i class='fa fa-angle-right'></i>",
                }
            },
            dom: 'Bflrtip',
            buttons: [{
                title: 'Pengguna Terbanyak Menawar',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function() {
                    window.open("{{ route('generate.most-popular-bidder') }}", '_blank')
                }
            }, ],
        });

        var routeGenerate = "{{ route('generate.most-selling-month') }}"
        @if (request()->has('year'))
            routeGenerate = "{{ route('generate.most-selling-month', ['year' => request()->year]) }}"
        @endif

        var dataTable = $('#table-most-popular-item').DataTable({
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Data",
                lengthMenu: "Menampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: "<i class='fa fa-angle-right'></i>",
                }
            },
            dom: 'Bflrti',
            buttons: [{
                    title: 'Bulan Banyak Barang Terjual',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-sm btn-danger',
                    action: function() {
                        window.open(routeGenerate, '_blank')
                    }
                }, {
                    title: 'Bulan Banyak Barang Terjual',
                    text: '<i class="fas fa-search"></i> Filter',
                    className: 'btn btn-sm btn-default ml-1',
                    action: function(e, dt, node, config) {
                        $('#modal-table-most-popular-item').modal('show')
                    }
                },
                {
                    title: 'Reset',
                    text: '<i class="fas fa-sync-alt"></i> Reset',
                    className: 'btn btn-sm btn-danger ml-1',
                    action: function(e, dt, node, config) {
                        window.location.href = '/dashboard'
                    }
                },
            ],
        });
    </script>
@endsection
