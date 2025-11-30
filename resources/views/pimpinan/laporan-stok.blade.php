@extends('layouts.pimpinan')

@section('title', 'Laporan Stok')

@section('header', 'Laporan Stok Barang')

@section('sidebar')
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link active" href="/pimpinan/laporan-stok">
        <i class="fas fa-boxes"></i> Laporan Stok
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/pimpinan/laporan-transaksi">
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
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-boxes"></i> Laporan Stok Barang</h5>
        <button class="btn btn-light btn-sm" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <select class="form-select" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="aman">Stok Aman</option>
                    <option value="rendah">Stok Rendah</option>
                    <option value="habis">Stok Habis</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchBarang" placeholder="Cari barang...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tableStok">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><code>{{ $barang->kode_barang }}</code></td>
                        <td>{{ $barang->nama }}</td>
                        <td>{{ $barang->kategori->nama }}</td>
                        <td>{{ $barang->lokasi->nama }}</td>
                        <td class="fw-bold {{ $barang->stok < 3 ? 'text-danger' : 'text-success' }}">
                            {{ $barang->stok }}
                        </td>
                        <td>
                            @if($barang->stok == 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($barang->stok < 3)
                                <span class="badge bg-warning">Rendah</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple filtering
    document.getElementById('filterStatus').addEventListener('change', filterTable);
    document.getElementById('filterKategori').addEventListener('change', filterTable);
    document.getElementById('searchBarang').addEventListener('input', filterTable);

    function filterTable() {
        const statusFilter = document.getElementById('filterStatus').value;
        const kategoriFilter = document.getElementById('filterKategori').value;
        const searchFilter = document.getElementById('searchBarang').value.toLowerCase();
        
        const rows = document.querySelectorAll('#tableStok tbody tr');
        
        rows.forEach(row => {
            const status = row.cells[6].textContent.toLowerCase();
            const kategori = row.cells[3].textContent;
            const namaBarang = row.cells[2].textContent.toLowerCase();
            
            let show = true;
            
            if (statusFilter && !status.includes(statusFilter)) show = false;
            if (kategoriFilter && kategori !== document.getElementById('filterKategori').options[kategoriFilter].text) show = false;
            if (searchFilter && !namaBarang.includes(searchFilter)) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }
</script>
@endsection