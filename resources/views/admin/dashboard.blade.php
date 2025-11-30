@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/kategori"><i class="fas fa-tags"></i> Kategori</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/lokasi"><i class="fas fa-map-marker-alt"></i> Lokasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/barang"><i class="fas fa-boxes"></i> Barang</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/stok"><i class="fas fa-chart-bar"></i> Stok</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/hampir-habis"><i class="fas fa-exclamation-triangle"></i> Stok Rendah</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Barang</h5>
                            <h2 class="mb-0">{{ $totalBarang }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Stok Rendah</h5>
                            <h2 class="mb-0">{{ $barangHampirHabis }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-th"></i> Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <a href="{{ url('/admin/barang') }}" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-boxes fa-2x mb-2"></i><br>
                                Kelola Barang
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ url('/admin/kategori') }}" class="btn btn-outline-success btn-lg w-100">
                                <i class="fas fa-tags fa-2x mb-2"></i><br>
                                Kelola Kategori
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ url('/admin/lokasi') }}" class="btn btn-outline-warning btn-lg w-100">
                                <i class="fas fa-map-marker-alt fa-2x mb-2"></i><br>
                                Kelola Lokasi
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
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Sistem</h5>
                </div>
                <div class="card-body">
                    <p>Sistem Manajemen Gudang membantu Anda mengelola:</p>
                    <ul>
                        <li>Data barang dan stok</li>
                        <li>Kategori dan lokasi barang</li>
                        <li>Laporan stok dan transaksi</li>
                        <li>Monitoring barang hampir habis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection