@extends('layouts.app')
@section('title', 'Data History Barang')

@section('title-header', 'Data History Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Data Lelang Barang</a></li>
    <li class="breadcrumb-item active">Data History Lelang {{ $auction->item->item_name }}</li>
@endsection

@section('action_btn')
    @if ($auction->status == 'dibuka')
        @if (Auth::user()->role == 'masyarakat')
            <a href="{{ route('auctions.create-auction', ['auctionId' => $auction->id]) }}" class="btn btn-default">Buat
                Penawaran</a>
        @else
            @if ($historyAuction->count() > 1)
                <form id="validate-form-{{ $auction->id }}"
                    action="{{ route('auctions.validate-auction', ['auctionId' => $auction->id]) }}" class="d-none"
                    method="post">
                    @csrf
                </form>
                <button onclick="validateAuction('{{ $auction->id }}')" class="btn btn-sm btn-success"><i
                        class="fas fa-check"></i> Validasi Penawaran</button>
            @endif
        @endif
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Data History Lelang Barang</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover" id="table-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal Barang</th>
                                    <th>Gambar Barang</th>
                                    <th>Harga Akhir Barang</th>
                                    <th>Penawar Akhir Lelang Barang</th>
                                    <th>Status Penawaran Lelang</th>
                                    @if ($auction->status == 'dibuka' && Auth::user()->role != 'masyarakat')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($historyAuction as $history)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $history->auction->item?->item_name ?? 'Data tidak ditemukan' }}</td>
                                        <td>Rp. {{ number_format($history->auction->item?->start_price ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @if ($history->auction->item?->item_image ?? null)
                                                <img src="{{ asset('/uploads/images/' . $history->auction->item->item_image) }}"
                                                    alt="{{ $history->auction->item->name }}" width="100">
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                        <td>Rp. {{ number_format($history->price_quote, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($history->bidder->name) }}</td>
                                        <td>{{ ucfirst($history->status) }}</td>
                                        @if ($auction->status == 'dibuka' && Auth::user()->role != 'masyarakat')
                                            <td class="d-flex jutify-content-center">
                                                @if ($history->status == 'pending')
                                                    <form id="approve-form-{{ $history->id }}"
                                                        action="{{ route('auctions.update-auction', ['auctionId' => $auction->id, 'historyId' => $history->id]) }}"
                                                        class="d-none" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    <button onclick="approveAuction('{{ $history->id }}')"
                                                        class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>

                                                    <form id="delete-form-{{ $history->id }}"
                                                        action="{{ route('auctions.destroy-auction', ['auctionId' => $auction->id, 'historyId' => $history->id]) }}"
                                                        class="d-none" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button onclick="rejectAuction('{{ $history->id }}')"
                                                        class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function rejectAuction(id) {
            Swal.fire({
                title: 'Tolak Penawaran',
                text: "Anda akan menolak penawaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit()
                }
            })
        }

        function approveAuction(id) {
            Swal.fire({
                title: 'Terima Penawaran',
                text: "Anda akan menerima penawaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#approve-form-${id}`).submit()
                }
            })
        }

        function validateAuction(id) {
            Swal.fire({
                title: 'Validasi Penawaran',
                text: "Anda akan memvalidasi penawaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#validate-form-${id}`).submit()
                }
            })
        }

        var dataTable = $('#table-data').DataTable({
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
                title: 'Data History Lelang ' + "{{ $auction->item->item_name }}",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function() {
                    window.open("{{ route('generate.history-auction', ['auctionId' => $auction->id]) }}", '_blank')
                }
            }, ],
        });
    </script>
@endsection
