@extends('layouts.admin')

@section('title', 'Laporan Stok')

@section('header', 'Laporan Stok Barang')

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
        <a class="nav-link" href="/admin/barang">
            <i class="fas fa-boxes"></i> Kelola Barang
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/admin/laporan/stok">
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
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Laporan Stok Barang</h5>
            <div>
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Barang</h6>
                                    <h3 class="mb-0">{{ $barangs->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-boxes fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stok Aman</h6>
                                    <h3 class="mb-0">{{ $barangs->where('stok', '>=', 3)->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Hampir Habis</h6>
                                    <h3 class="mb-0">{{ $barangs->where('stok', '<', 3)->where('stok', '>', 0)->count() }}
                                    </h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Stok Habis</h6>
                                    <h3 class="mb-0">{{ $barangs->where('stok', 0)->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-times-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                <th width="10%">Stok Min</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $barang)
                                <tr class="{{ $barang->stok == 0 ? 'table-danger' : ($barang->stok < 3 ? 'table-warning' : '') }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $barang->kode_barang }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $barang->nama }}</strong>
                                    </td>
                                    <td>{{ $barang->kategori->nama }}</td>
                                    <td>{{ $barang->lokasi->nama }}</td>
                                    <td>
                                        <span class="fw-bold {{ $barang->stok < 3 ? 'text-danger' : 'text-success' }}">
                                            {{ $barang->stok }}
                                        </span>
                                    </td>
                                    <td>{{ $barang->stok_minimum }}</td>
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
                                        <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                    <h5>Belum ada data barang</h5>
                    <p class="text-muted">Silakan tambah barang terlebih dahulu</p>
                    <a href="{{ url('/admin/barang/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection