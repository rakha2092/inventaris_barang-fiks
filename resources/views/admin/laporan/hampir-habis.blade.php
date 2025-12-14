@extends('layouts.admin')

@section('title', 'Barang Hampir Habis')
@section('header', 'Barang Hampir Habis')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
        <a class="nav-link active" href="/admin/laporan/hampir-habis"><i class="fas fa-exclamation-triangle"></i> Stok
            Rendah</a>
    </li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Stok Rendah</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($barangs->count() > 0)
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Peringatan!</strong> {{ $barangs->count() }} barang perlu restock.
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-warning">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Stok</th>
                                <th>Min</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $item)
                                <tr class="{{ $item->stok == 0 ? 'table-danger' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->kode_barang }}</span></td>
                                    <td>
                                        <strong>{{ $item->nama }}</strong>
                                        @if($item->deskripsi)<br><small
                                        class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>@endif
                                    </td>
                                    <td>{{ $item->kategori->nama }}</td>
                                    <td>{{ $item->lokasi->nama }}</td>
                                    <td><span
                                            class="fw-bold {{ $item->stok == 0 ? 'text-danger' : 'text-warning' }}">{{ $item->stok }}</span>
                                    </td>
                                    <td>{{ $item->stok_minimum }}</td>
                                    <td>
                                        @php $kurang = $item->stok_minimum - $item->stok; @endphp
                                        @if($item->stok == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @elseif($kurang > 0)
                                            <span class="badge bg-warning">Kurang {{ $kurang }}</span>
                                        @else
                                            <span class="badge bg-success">Cukup</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ url('/admin/barang/' . $item->id) }}" class="btn btn-info" title="Detail" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('/admin/barang/' . $item->id . '/restock') }}" class="btn btn-success"
                                                title="Restock" data-bs-toggle="tooltip">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a href="{{ url('/admin/barang/' . $item->id . '/edit') }}" class="btn btn-warning"
                                                title="Edit" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-card bg-danger">
                            <h6 class="mb-2"><i class="fas fa-times-circle"></i> Habis</h6>
                            <h4 class="mb-0">{{ $barangs->where('stok', 0)->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-card bg-warning">
                            <h6 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Rendah</h6>
                            <h4 class="mb-0">{{ $barangs->where('stok', '>', 0)->where('stok', '<', 3)->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-card bg-info">
                            <h6 class="mb-2"><i class="fas fa-boxes"></i> Total</h6>
                            <h4 class="mb-0">{{ $barangs->count() }}</h4>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-card bg-primary">
                            <h6 class="mb-2"><i class="fas fa-sync-alt"></i> Restock</h6>
                            <h4 class="mb-0">{{ $barangs->count() }}</h4>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-light rounded">
                    <h6><i class="fas fa-lightbulb me-2"></i> Saran:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Prioritaskan barang habis terlebih dahulu</li>
                        <li>Gunakan fitur restock untuk menambah stok</li>
                        <li>Buat rencana pembelian untuk barang yang sering habis</li>
                        <li>Periksa stok minimum secara berkala</li>
                    </ul>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-4"></i>
                    <h4 class="mb-3">Stok aman semua!</h4>
                    <p class="text-muted mb-4">Tidak ada barang yang perlu direstock saat ini.</p>
                    <a href="{{ url('/admin/laporan/stok') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar me-2"></i> Lihat Laporan Stok Lengkap
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Print functionality
            document.getElementById('printBtn')?.addEventListener('click', function() {
                window.print();
            });
        });
    </script>
@endsection