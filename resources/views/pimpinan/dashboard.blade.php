@extends('layouts.pimpinan')

@section('title', 'Dashboard Pimpinan')

@section('header', 'Dashboard Pimpinan')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link active" href="/pimpinan/dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/laporan-stok">
        <i class="fas fa-boxes"></i> Laporan Stok
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/laporan-transaksi">
        <i class="fas fa-exchange-alt"></i> Laporan Transaksi
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/barang-hampir-habis">
        <i class="fas fa-exclamation-triangle"></i> Stok Rendah
    </a>
</li>
@endsection

@section('content')
<!-- Statistik Utama -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Barang</h5>
                        <h2 class="mb-0">{{ \App\Models\Barang::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Stok Aman</h5>
                        <h2 class="mb-0">{{ \App\Models\Barang::where('stok', '>=', 3)->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Stok Rendah</h5>
                        <h2 class="mb-0">{{ \App\Models\Barang::hampirHabis()->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Stok Habis</h5>
                        <h2 class="mb-0">{{ \App\Models\Barang::where('stok', 0)->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Barang dengan Stok Terendah -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Barang Stok Rendah</h5>
            </div>
            <div class="card-body">
                @php
                    $barangRendah = \App\Models\Barang::hampirHabis()->with('kategori')->limit(5)->get();
                @endphp
                
                @if($barangRendah->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barangRendah as $barang)
                                <tr>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $barang->kategori->nama }}</td>
                                    <td class="fw-bold text-danger">{{ $barang->stok }}</td>
                                    <td>
                                        @if($barang->stok == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @else
                                            <span class="badge bg-warning">Rendah</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="/pimpinan/barang-hampir-habis" class="btn btn-outline-warning btn-sm">Lihat Semua</a>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-muted mb-0">Tidak ada barang dengan stok rendah</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                @php
                    $transaksiTerbaru = \App\Models\BarangMasuk::with('barang')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($transaksiTerbaru->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($transaksiTerbaru as $transaksi)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-success">
                                    <i class="fas fa-arrow-down"></i> Masuk
                                </small>
                                <div class="fw-bold">{{ $transaksi->barang->nama }}</div>
                                <small class="text-muted">
                                    {{ $transaksi->jumlah }} unit • {{ $transaksi->tanggal }}
                                </small>
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $transaksi->jumlah }}</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="/pimpinan/laporan-transaksi" class="btn btn-outline-info btn-sm mt-2">Lihat Semua</a>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Kategori -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Ringkasan per Kategori</h5>
            </div>
            <div class="card-body">
                @php
                    $kategories = \App\Models\Kategori::withCount('barangs')->get();
                @endphp
                <div class="row">
                    @foreach($kategories as $kategori)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $kategori->nama }}</h6>
                                <h3 class="text-primary">{{ $kategori->barangs_count }}</h3>
                                <small class="text-muted">Jenis Barang</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection