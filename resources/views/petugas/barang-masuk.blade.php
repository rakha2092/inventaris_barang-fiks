@extends('layouts.petugas')

@section('title', 'Barang Masuk')

@section('header', 'Input Barang Masuk')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link" href="/petugas/dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link active" href="/petugas/barang-masuk">
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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-arrow-down"></i> Form Input Barang Masuk</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/petugas/barang-masuk') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="barang_id" class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach(\App\Models\Barang::all() as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->kode_barang }} - {{ $barang->nama }} (Stok: {{ $barang->stok }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                       id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required
                                       placeholder="Masukkan jumlah barang">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                       id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                       id="keterangan" name="keterangan" value="{{ old('keterangan') }}"
                                       placeholder="Contoh: Pembelian dari supplier">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/petugas/dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Barang Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <p><strong>Fitur Barang Masuk:</strong></p>
                <ul class="mb-0">
                    <li>Digunakan untuk mencatat barang yang masuk ke gudang</li>
                    <li>Stok barang akan otomatis bertambah</li>
                    <li>Pastikan data yang dimasukkan sudah benar</li>
                    <li>Keterangan membantu melacak sumber barang</li>
                </ul>
            </div>
        </div>

        <!-- Barang Stok Rendah -->
        <div class="card mt-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Barang Stok Rendah</h5>
            </div>
            <div class="card-body">
                @php
                    $barangRendah = \App\Models\Barang::hampirHabis()->limit(5)->get();
                @endphp
                @if($barangRendah->count() > 0)
                    @foreach($barangRendah as $barang)
                    <div class="alert alert-warning py-2 mb-2">
                        <small>
                            <strong>{{ $barang->nama }}</strong><br>
                            Stok: {{ $barang->stok }} | Min: {{ $barang->stok_minimum }}
                        </small>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Tidak ada barang dengan stok rendah</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
