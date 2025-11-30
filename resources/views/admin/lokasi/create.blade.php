@extends('layouts.admin')

@section('title', 'Tambah Lokasi')

@section('header', 'Tambah Lokasi Baru')

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
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Lokasi</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.lokasi.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lokasi">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Lokasi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                        rows="4" placeholder="Masukkan deskripsi lokasi (contoh: Gudang utama lantai 1, Ruang penyimpanan barang elektronik, dll)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Lokasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection