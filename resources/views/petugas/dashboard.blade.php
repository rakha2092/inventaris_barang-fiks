@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('header', 'Dashboard Petugas Gudang')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link active" href="/petugas/dashboard">
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
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-info">
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
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Barang Stok Rendah</h5>
                        <h2 class="mb-0">{{ \App\Models\Barang::hampirHabis()->count() }}</h2>
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
            <div class="card-header">
                <h5>Menu Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/petugas/barang-masuk') }}" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-arrow-down fa-2x mb-2"></i><br>
                            Barang Masuk
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/petugas/barang-keluar') }}" class="btn btn-outline-danger btn-lg w-100">
                            <i class="fas fa-arrow-up fa-2x mb-2"></i><br>
                            Barang Keluar
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('/petugas/daftar-barang') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-list fa-2x mb-2"></i><br>
                            Daftar Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Barang Hampir Habis -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Barang dengan Stok Rendah</h5>
            </div>
            <div class="card-body">
                @php
                    $barangHampirHabis = \App\Models\Barang::hampirHabis()->with('kategori', 'lokasi')->get();
                @endphp

                @if($barangHampirHabis->count() > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i>
                    Terdapat {{ $barangHampirHabis->count() }} barang dengan stok rendah.
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangHampirHabis as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->kategori->nama }}</td>
                                <td>{{ $barang->lokasi->nama }}</td>
                                <td class="fw-bold text-danger">{{ $barang->stok }}</td>
                                <td>
                                    @if($barang->stok == 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @else
                                        <span class="badge bg-warning">Hampir Habis</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <p class="text-muted mb-0">Semua stok barang dalam kondisi aman</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
