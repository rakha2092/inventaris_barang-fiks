@extends('layouts.pimpinan')

@section('title', 'Barang Stok Rendah')

@section('header', 'Barang dengan Stok Rendah')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/laporan-stok">
        <i class="fas fa-boxes"></i> Laporan Stok
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/laporan-transaksi">
        <i class="fas fa-exchange-alt"></i> Laporan Transaksi
    </a>
</li>
<li class="nav-item">
    <a class="nav-link active" href="/pimpinan/barang-hampir-habis">
        <i class="fas fa-exclamation-triangle"></i> Stok Rendah
    </a>
</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Daftar Barang dengan Stok Rendah</h5>
        <button class="btn btn-dark btn-sm" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
    <div class="card-body">
        @if($barangRendah->count() > 0)
        <div class="alert alert-warning">
            <i class="fas fa-info-circle"></i>
            Terdapat <strong>{{ $barangRendah->count() }}</strong> barang dengan stok rendah yang perlu perhatian.
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Stok Saat Ini</th>
                        <th>Stok Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangRendah as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><code>{{ $barang->kode_barang }}</code></td>
                        <td>
                            <strong>{{ $barang->nama }}</strong>
                            @if($barang->deskripsi)
                                <br><small class="text-muted">{{ $barang->deskripsi }}</small>
                            @endif
                        </td>
                        <td>{{ $barang->kategori->nama }}</td>
                        <td>{{ $barang->lokasi->nama }}</td>
                        <td class="fw-bold text-danger">{{ $barang->stok }}</td>
                        <td>{{ $barang->stok_minimum }}</td>
                        <td>
                            @if($barang->stok == 0)
                                <span class="badge bg-danger">Habis</span>
                            @else
                                <span class="badge bg-warning">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Total Stok Rendah</h6>
                        <h4 class="mb-0">{{ $barangRendah->where('stok', '>', 0)->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Stok Habis</h6>
                        <h4 class="mb-0">{{ $barangRendah->where('stok', 0)->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Perlu Restock</h6>
                        <h4 class="mb-0">{{ $barangRendah->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
            <h4 class="text-success">Semua Stok Aman</h4>
            <p class="text-muted">Tidak ada barang dengan stok rendah saat ini</p>
        </div>
        @endif
    </div>
</div>
@endsection