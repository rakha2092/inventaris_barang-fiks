@extends('layouts.admin')

@section('title', 'Kelola Barang')

@section('header', 'Kelola Data Barang')

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
        <a class="nav-link" href="/admin/lokasi">
            <i class="fas fa-map-marker-alt"></i> Kelola Lokasi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/admin/barang">
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
            <h5 class="mb-0"><i class="fas fa-boxes"></i> Daftar Barang</h5>
            <a href="{{ url('/admin/barang/create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Barang
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

            @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Kode Barang</th>
                                <th width="20%">Nama Barang</th>
                                <th width="15%">Kategori</th>
                                <th width="15%">Lokasi</th>
                                <th width="10%">Stok</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $barang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $barang->kode_barang }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $barang->nama }}</strong>
                                        @if($barang->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($barang->deskripsi, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $barang->kategori->nama }}</td>
                                    <td>{{ $barang->lokasi->nama }}</td>
                                    <td>
                                        <span class="fw-bold {{ $barang->stok < 3 ? 'text-danger' : 'text-success' }}">
                                            {{ $barang->stok }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($barang->stok == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif($barang->stok < 3)
                                            <span class="badge bg-warning">Hampir Habis</span>
                                        @else
                                            <span class="badge bg-success">Aman</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- PERBAIKAN DI SINI: tambahkan /detail di akhir URL -->
                                            <a href="{{ url('/admin/barang/' . $barang->id . '/detail') }}" 
                                               class="btn btn-info" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('/admin/barang/' . $barang->id . '/edit') }}" 
                                               class="btn btn-warning" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#hapusModal{{ $barang->id }}"
                                                    data-bs-tooltip="tooltip" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="hapusModal{{ $barang->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                                                        <div class="alert alert-warning">
                                                            <strong>{{ $barang->nama }}</strong><br>
                                                            <small>Kode: {{ $barang->kode_barang }}</small><br>
                                                            <small>Stok: {{ $barang->stok }} unit</small><br>
                                                            <small>Kategori: {{ $barang->kategori->nama }}</small>
                                                        </div>
                                                        <p class="text-danger">
                                                            <small>
                                                                <i class="fas fa-info-circle"></i>
                                                                Data yang dihapus tidak dapat dikembalikan!
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times"></i> Batal
                                                        </button>
                                                        <form action="{{ url('/admin/barang/' . $barang->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i> Ya, Hapus
                                                            </button>
                                                        </form>
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

                <!-- Summary Cards -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Total Barang</h6>
                                <h4 class="mb-0">{{ $barangs->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Stok Aman</h6>
                                <h4 class="mb-0">{{ $barangs->where('stok', '>=', 3)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Hampir Habis</h6>
                                <h4 class="mb-0">{{ $barangs->where('stok', '<', 3)->where('stok', '>', 0)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center py-2">
                                <h6 class="mb-0">Stok Habis</h6>
                                <h4 class="mb-0">{{ $barangs->where('stok', 0)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                    <h5>Belum ada barang</h5>
                    <p class="text-muted">Silakan tambah barang baru untuk memulai</p>
                    <a href="{{ url('/admin/barang/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Barang Pertama
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