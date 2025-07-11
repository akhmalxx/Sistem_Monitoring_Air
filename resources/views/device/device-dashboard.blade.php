@extends('layouts.app')

@section('title', 'Daftar Device')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Device</h1>
            </div>
            <div class="section-body">
                {{-- <div class="col"> --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <a href="{{ route('device-list.create') }}" class="btn btn-primary">+ Tambah Device</a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="userTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">NAMA PENGGUNA</th>
                                            <th class="text-center">API KEY</th>
                                            <th class="text-center">FIREBASE URL</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($devices as $device)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}.</td>
                                                <td class="text-center">{{ $device->user->username }}</td>
                                                <td class="text-center">{{ $device->apikey }}</td>
                                                <td class="text-center">{{ $device->firebase_url }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('device-list.edit', $device->id) }}"
                                                        class="btn btn-action btn-primary" data-toggle="tooltip"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('device-list.destroy', $device->id) }}"
                                                        class="d-inline-block" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-action btn-danger"
                                                            data-toggle="tooltip" title="Hapus"
                                                            onclick="return confirm('Anda yakin ingin menghapus data?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    {{-- <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "info": "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script> --}}
@endpush
