@extends('layouts.petugas')

@section('title', 'Detail Barang')

@section('header', 'Detail Barang')

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
    <a class="nav-link" href="/petugas/daftar-barang">
        <i class="fas fa-list"></i> Daftar Barang
    </a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Barang</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Kode Barang</th>
                        <td>{{ $barang->kode_barang }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $barang->kategori->nama }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $barang->lokasi->nama }}</td>
                    </tr>
                    <tr>
                        <th>Stok Saat Ini</th>
                        <td>
                            <span class="fw-bold {{ $barang->stok < 3 ? 'text-danger' : 'text-success' }}">
                                {{ $barang->stok }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Stok Minimum</th>
                        <td>{{ $barang->stok_minimum }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($barang->stok == 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($barang->stok < 3)
                                <span class="badge bg-warning">Hampir Habis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $barang->deskripsi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Statistik</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    @if($barang->stok == 0)
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <h5>Stok Habis!</h5>
                            <p class="mb-0">Segera lakukan restock</p>
                        </div>
                    @elseif($barang->stok < 3)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                            <h5>Stok Rendah!</h5>
                            <p class="mb-0">Stok hampir habis, perlu restock</p>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h5>Stok Aman</h5>
                            <p class="mb-0">Stok dalam kondisi baik</p>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <h6>Quick Actions:</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ url('/petugas/barang-masuk') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-arrow-down"></i> Input Barang Masuk
                        </a>
                        <a href="{{ url('/petugas/barang-keluar') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-up"></i> Input Barang Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Transaksi</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Fitur riwayat transaksi akan tersedia dalam pengembangan selanjutnya.</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Riwayat transaksi akan menampilkan data barang masuk dan keluar untuk barang ini.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ url('/petugas/daftar-barang') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>
@endsection
