@extends('layouts.app')
@section('title', 'Data Lelang Barang')

@section('title-header', 'Data Lelang Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Lelang Barang</li>
@endsection

@if (Auth::user()->role != 'masyarakat')
    @section('action_btn')
        <a href="{{ route('auctions.create') }}" class="btn btn-default">Tambah Data Lelang Barang</a>
    @endsection
@endif

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Data Lelang Barang</h2>
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
                                    <th>Status Lelang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auctions as $auction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $auction->item->item_name }}</td>
                                        <td>Rp. {{ number_format($auction->item->start_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($auction->item->item_image)
                                                <img src="{{ asset('/uploads/images/' . $auction->item->item_image) }}"
                                                    alt="{{ $auction->item->name }}" width="100">
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                        @php
                                            $lastAuction = $auction
                                                ->auctionsHistory()
                                                ->where('status', 'diterima')
                                                ->first();
                                        @endphp
                                        @if ($lastAuction)
                                            <td>Rp. {{ number_format($lastAuction->price_quote, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($lastAuction->bidder->name) }}</td>
                                        @else
                                            <td>Rp. {{ number_format(0, 0, ',', '.') }}</td>
                                            <td>Belum ada penawar akhir</td>
                                        @endif
                                        <td>{{ ucfirst($auction->status) }}</td>
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{ route('auctions.show', $auction->id) }}"
                                                class="btn btn-sm btn-primary">Lihat lelang</a>

                                            @if (Auth::user()->role != 'masyarakat')
                                            <form id="delete-form-{{ $auction->id }}"
                                                action="{{ route('auctions.destroy', $auction->id) }}" class="d-none"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{ $auction->id }}')"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        {{ $auctions->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id) {
            Swal.fire({
                title: 'Hapus data',
                text: "Anda akan menghapus data!",
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
                title: 'Data Lelang',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function() {
                    window.open("{{ route('generate.auctions') }}", '_blank')
                }
            }, ],
        });
    </script>
@endsection
