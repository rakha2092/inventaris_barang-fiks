@extends('layouts.petugas')

@section('title', 'Barang Keluar')
@section('header', 'Barang Keluar')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link" href="/petugas/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/petugas/barang-masuk"><i class="fas fa-arrow-down"></i> Masuk</a>
</li>
<li class="nav-item">
    <a class="nav-link active" href="/petugas/barang-keluar"><i class="fas fa-arrow-up"></i> Keluar</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/petugas/daftar-barang"><i class="fas fa-list"></i> Barang</a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-arrow-up"></i> Input Barang Keluar</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/petugas/barang-keluar') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Barang <span class="text-danger">*</span></label>
                                <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach(\App\Models\Barang::all() as $b)
                                    <option value="{{ $b->id }}" data-stok="{{ $b->stok }}" {{ old('barang_id') == $b->id ? 'selected' : '' }}>
                                        {{ $b->kode_barang }} - {{ $b->nama }} ({{ $b->stok }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('barang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                       id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                                <small>Stok: <span id="stok-info">-</span></small>
                                @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                       name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                       name="keterangan" value="{{ old('keterangan') }}" placeholder="Tujuan pengambilan">
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/petugas/dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Fitur Barang Keluar:</strong></p>
                <ul class="mb-0">
                    <li>Catat barang keluar gudang</li>
                    <li>Stok otomatis berkurang</li>
                    <li>Pastikan stok cukup</li>
                    <li>Isi keterangan tujuan</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Peringatan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i>
                    <strong>Perhatian!</strong><br>
                    Pastikan stok mencukupi sebelum ambil barang.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('barang_id').addEventListener('change', function() {
    var opt = this.options[this.selectedIndex];
    var stok = opt.getAttribute('data-stok');
    document.getElementById('stok-info').textContent = stok || '0';

    var jml = document.getElementById('jumlah');
    jml.max = stok || 0;

    if (stok == 0) {
        jml.disabled = true;
        jml.placeholder = 'Stok habis';
    } else {
        jml.disabled = false;
        jml.placeholder = 'Masukkan jumlah';
    }
});

document.getElementById('barang_id').dispatchEvent(new Event('change'));
</script>
@endsection
