@extends('layouts.admin')

@section('title', 'Restock Barang')

@section('header', 'Restock Barang')

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
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Form Restock Barang</h5>
        </div>
        <div class="card-body">
            <!-- Informasi Barang -->
            <div class="alert alert-info">
                <h6><i class="fas fa-info-circle"></i> Informasi Barang</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Kode Barang:</strong> {{ $barang->kode_barang }}<br>
                        <strong>Nama Barang:</strong> {{ $barang->nama }}<br>
                        <strong>Kategori:</strong> {{ $barang->kategori->nama }}
                    </div>
                    <div class="col-md-6">
                        <strong>Stok Saat Ini:</strong> 
                        <span class="fw-bold text-danger">{{ $barang->stok }} unit</span><br>
                        <strong>Stok Minimum:</strong> {{ $barang->stok_minimum }} unit<br>
                        <strong>Kekurangan:</strong> 
                        <span class="badge bg-danger">{{ $barang->stok_minimum - $barang->stok }} unit</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.barang.process-restock', $barang->id) }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Restock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                                   min="1" required placeholder="Masukkan jumlah barang">
                            <small class="text-muted">Stok saat ini: {{ $barang->stok }} unit</small>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Restock <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                              id="keterangan" name="keterangan" rows="3" 
                              placeholder="Masukkan keterangan restock (contoh: Pembelian dari supplier, Transfer dari gudang lain, dll)"
                              required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Preview Stok Setelah Restock -->
                <div class="alert alert-warning">
                    <h6><i class="fas fa-calculator"></i> Preview Setelah Restock</h6>
                    <div id="preview-stok">
                        Stok saat ini: <strong>{{ $barang->stok }}</strong> unit + 
                        Jumlah restock: <strong id="preview-jumlah">0</strong> unit = 
                        Total stok: <strong id="preview-total">{{ $barang->stok }}</strong> unit
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url('/admin/laporan/hampir-habis') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Restock
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jumlahInput = document.getElementById('jumlah');
        const previewJumlah = document.getElementById('preview-jumlah');
        const previewTotal = document.getElementById('preview-total');
        const stokAwal = {{ $barang->stok }};

        jumlahInput.addEventListener('input', function() {
            const jumlah = parseInt(this.value) || 0;
            previewJumlah.textContent = jumlah;
            previewTotal.textContent = stokAwal + jumlah;
        });
    });
</script>
@endsection