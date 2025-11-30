@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('header', 'Tambah Barang Baru')

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
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Barang</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/admin/barang') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama barang">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lokasi_id" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <select class="form-control @error('lokasi_id') is-invalid @enderror" id="lokasi_id"
                                name="lokasi_id" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok"
                                name="stok" value="{{ old('stok', 0) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                        rows="4" placeholder="Masukkan deskripsi barang">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stok_minimum" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control @error('stok_minimum') is-invalid @enderror"
                                id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', 3) }}" min="1">
                            <small class="text-muted">Sistem akan memberi peringatan ketika stok mencapai batas
                                minimum</small>
                            @error('stok_minimum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('/admin/barang') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection