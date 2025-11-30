@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header', 'Kelola Kategori')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/admin/kategori"><i class="fas fa-tags"></i> Kelola Kategori</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/lokasi"><i class="fas fa-map-marker-alt"></i> Kelola Lokasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/barang"><i class="fas fa-boxes"></i> Kelola Barang</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/stok"><i class="fas fa-chart-bar"></i> Laporan Stok</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/admin/laporan/hampir-habis"><i class="fas fa-exclamation-triangle"></i> Barang Hampir
            Habis</a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Kategori</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.kategori.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Kategori</h5>
                    <span class="badge bg-light text-dark">{{ $kategoris->count() }}</span>
                </div>
                <div class="card-body">
                    @if($kategoris->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Barang</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kategoris as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->deskripsi ?? '-' }}</td>
                                            <td><span class="badge bg-primary">{{ $item->barangs_count }}</span></td>
                                            <td>
                                                <!-- Tombol Hapus -->
                                                <form action="{{ url('/admin/kategori/' . $item->id) }}" method="POST"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Hapus kategori {{ $item->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                        title="Hapus Kategori" {{ $item->barangs_count > 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p>Belum ada kategori</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltips.map(function (el) {
                return new bootstrap.Tooltip(el)
            });
        });
    </script>
@endsection