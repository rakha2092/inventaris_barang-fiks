@extends('layouts.petugas')

@section('title', 'Daftar Barang')

@section('header', 'Daftar Barang')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="/petugas/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/petugas/barang-masuk">
            <i class="fas fa-arrow-down"></i> Input Barang Masuk
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/petugas/barang-keluar">
            <i class="fas fa-arrow-up"></i> Input Barang Keluar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/petugas/daftar-barang">
            <i class="fas fa-list"></i> Daftar Barang
        </a>
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-boxes"></i> Daftar Semua Barang</h5>
            <div class="btn-group">
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="card-body">

            @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
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
                                        <a href="{{ url('/petugas/detail-barang/' . $barang->id) }}" class="btn btn-sm btn-info"
                                            data-bs-toggle="tooltip" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
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
                    <p class="text-muted">Tidak ada data barang yang tersedia</p>
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
