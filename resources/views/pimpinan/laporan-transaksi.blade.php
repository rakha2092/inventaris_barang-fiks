@extends('layouts.pimpinan')

@section('title', 'Laporan Transaksi')

@section('header', 'Laporan Transaksi Barang')

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
    <a class="nav-link active" href="/pimpinan/laporan-transaksi">
        <i class="fas fa-exchange-alt"></i> Laporan Transaksi
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/barang-hampir-habis">
        <i class="fas fa-exclamation-triangle"></i> Stok Rendah
    </a>
</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Laporan Transaksi Barang</h5>
        <button class="btn btn-light btn-sm" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
    <div class="card-body">
        <!-- Filter Tanggal -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filterTanggal" class="form-label">Filter Tanggal</label>
                <input type="date" class="form-control" id="filterTanggal">
            </div>
            <div class="col-md-4">
                <label for="filterJenis" class="form-label">Jenis Transaksi</label>
                <select class="form-select" id="filterJenis">
                    <option value="">Semua Transaksi</option>
                    <option value="masuk">Barang Masuk</option>
                    <option value="keluar">Barang Keluar</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="searchTransaksi" class="form-label">Cari Barang</label>
                <input type="text" class="form-control" id="searchTransaksi" placeholder="Nama barang...">
            </div>
        </div>

        <!-- Tabs untuk Masuk dan Keluar -->
        <ul class="nav nav-tabs mb-3" id="transaksiTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk" type="button" role="tab">
                    <i class="fas fa-arrow-down text-success"></i> Barang Masuk
                    <span class="badge bg-success ms-1">{{ $barangMasuk->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="keluar-tab" data-bs-toggle="tab" data-bs-target="#keluar" type="button" role="tab">
                    <i class="fas fa-arrow-up text-danger"></i> Barang Keluar
                    <span class="badge bg-danger ms-1">{{ $barangKeluar->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="transaksiTabsContent">
            <!-- Tab Barang Masuk -->
            <div class="tab-pane fade show active" id="masuk" role="tabpanel">
                @if($barangMasuk->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangMasuk as $masuk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($masuk->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $masuk->barang->nama }}</strong>
                                    <br><small class="text-muted">{{ $masuk->barang->kode_barang }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $masuk->jumlah }} unit</span>
                                </td>
                                <td>{{ $masuk->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5>Belum ada barang masuk</h5>
                    <p class="text-muted">Tidak ada data transaksi barang masuk</p>
                </div>
                @endif
            </div>

            <!-- Tab Barang Keluar -->
            <div class="tab-pane fade" id="keluar" role="tabpanel">
                @if($barangKeluar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-danger">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangKeluar as $keluar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($keluar->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $keluar->barang->nama }}</strong>
                                    <br><small class="text-muted">{{ $keluar->barang->kode_barang }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $keluar->jumlah }} unit</span>
                                </td>
                                <td>{{ $keluar->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <h5>Belum ada barang keluar</h5>
                    <p class="text-muted">Tidak ada data transaksi barang keluar</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Summary -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Total Barang Masuk</h6>
                        <h4 class="mb-0">{{ $barangMasuk->count() }}</h4>
                        <small>Transaksi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Total Barang Keluar</h6>
                        <h4 class="mb-0">{{ $barangKeluar->count() }}</h4>
                        <small>Transaksi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center py-3">
                        <h6 class="mb-0">Total Transaksi</h6>
                        <h4 class="mb-0">{{ $barangMasuk->count() + $barangKeluar->count() }}</h4>
                        <small>Semua Transaksi</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple filtering
    document.getElementById('filterJenis').addEventListener('change', function() {
        const jenis = this.value;
        
        if (jenis === 'masuk') {
            document.getElementById('masuk-tab').click();
        } else if (jenis === 'keluar') {
            document.getElementById('keluar-tab').click();
        }
    });

    document.getElementById('filterTanggal').addEventListener('change', filterTransaksi);
    document.getElementById('searchTransaksi').addEventListener('input', filterTransaksi);

    function filterTransaksi() {
        const tanggalFilter = document.getElementById('filterTanggal').value;
        const searchFilter = document.getElementById('searchTransaksi').value.toLowerCase();
        
        // Filter untuk tab aktif
        const activeTab = document.querySelector('.tab-pane.active');
        const rows = activeTab.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const tanggal = row.cells[1].textContent;
            const namaBarang = row.cells[2].textContent.toLowerCase();
            
            let show = true;
            
            if (tanggalFilter) {
                const rowDate = tanggal.split('/').reverse().join('-');
                if (rowDate !== tanggalFilter) show = false;
            }
            
            if (searchFilter && !namaBarang.includes(searchFilter)) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }
</script>
@endsection