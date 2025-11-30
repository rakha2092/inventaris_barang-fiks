@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('header', 'Detail Barang')

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
                                    {{ $barang->stok }} unit
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Stok Minimum</th>
                            <td>{{ $barang->stok_minimum }} unit</td>
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