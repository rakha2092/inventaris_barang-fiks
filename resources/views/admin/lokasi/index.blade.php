@extends('layouts.admin')

@section('title', 'Kelola Lokasi')

@section('header', 'Kelola Data Lokasi')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/kategori">
            <i class="fas fa-tags"></i> Kelola Kategori
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/admin/lokasi">
            <i class="fas fa-map-marker-alt"></i> Kelola Lokasi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/barang">
            <i class="fas fa-boxes"></i> Kelola Barang
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/stok">
            <i class="fas fa-chart-bar"></i> Laporan Stok
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/hampir-habis">
            <i class="fas fa-exclamation-triangle"></i> Barang Hampir Habis
        </a>
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Daftar Lokasi</h5>
            <a href="{{ route('admin.lokasi.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Lokasi
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($lokasis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Nama Lokasi</th>
                                <th width="40%">Deskripsi</th>
                                <th width="15%">Jumlah Barang</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lokasis as $lokasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $lokasi->nama }}</strong>
                                    </td>
                                    <td>
                                        {{ $lokasi->deskripsi ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $lokasi->barangs_count }} barang</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.lokasi.edit', $lokasi->id) }}" 
                                               class="btn btn-warning" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#hapusModal{{ $lokasi->id }}"
                                                    data-bs-tooltip="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="hapusModal{{ $lokasi->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus lokasi ini?</p>
                                                        <div class="alert alert-warning">
                                                            <strong>{{ $lokasi->nama }}</strong><br>
                                                            <small>Deskripsi: {{ $lokasi->deskripsi ?? '-' }}</small><br>
                                                            <small>Jumlah Barang: {{ $lokasi->barangs_count }} barang</small>
                                                        </div>
                                                        @if($lokasi->barangs_count > 0)
                                                            <div class="alert alert-danger">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                Lokasi ini masih digunakan oleh {{ $lokasi->barangs_count }} barang. 
                                                                Tidak dapat dihapus!
                                                            </div>
                                                        @else
                                                            <p class="text-danger">
                                                                <small>
                                                                    <i class="fas fa-info-circle"></i>
                                                                    Data yang dihapus tidak dapat dikembalikan!
                                                                </small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times"></i> Batal
                                                        </button>
                                                        @if($lokasi->barangs_count == 0)
                                                            <form action="{{ route('admin.lokasi.destroy', $lokasi->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i> Ya, Hapus
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Total Lokasi</h6>
                                <h4 class="mb-0">{{ $lokasis->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Lokasi Terisi</h6>
                                <h4 class="mb-0">{{ $lokasis->where('barangs_count', '>', 0)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Lokasi Kosong</h6>
                                <h4 class="mb-0">{{ $lokasis->where('barangs_count', 0)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                    <h5>Belum ada lokasi</h5>
                    <p class="text-muted">Silakan tambah lokasi baru untuk memulai</p>
                    <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Lokasi Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection