@extends('layouts.admin')

@section('title', 'Admin Overview')

@section('content')
{{-- Alert untuk pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">
    <h2 class="mb-4">Insight Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow user-card-trigger" data-type="total_users" style="cursor: pointer;">
                <div class="card-body">
                    <h6 class="card-title">Pengguna Terdaftar</h6>
                    <h3>{{ number_format($stats['total_users']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow user-card-trigger" data-type="premium_users" style="cursor: pointer;">
                <div class="card-body">
                    <h6 class="card-title">User Premium</h6>
                    <h3>{{ number_format($stats['premium_users']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow user-card-trigger" data-type="active_users" style="cursor: pointer;">
                <div class="card-body">
                    <h6 class="card-title">User Aktif (7 Hari)</h6>
                    <h3>{{ number_format($stats['active_users']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h6 class="card-title">Menunggu Konfirmasi</h6>
                    <h3>{{ $stats['pending_payments'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-white font-weight-bold">Tren Pertumbuhan Pengguna</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-8 mb-3 mb-md-0">
                            <canvas id="userChart" height="130"></canvas>
                        </div>
                        
                        <div class="col-lg-3 col-md-4">
                            <div class="card border-0 bg-light p-3 text-center">
                                <h6 class="text-muted text-uppercase small font-weight-bold mb-2">Total User Baru</h6>
                                <h2 class="text-primary font-weight-bold mb-1">
                                    {{ number_format($userGrowth->sum('total')) }}
                                </h2>
                                <p class="text-muted small mb-0">Pada periode ini</p>
                            </div>
                            
                            <div class="card border-0 bg-light p-3 text-center mt-3">
                                <h6 class="text-muted text-uppercase small font-weight-bold mb-2">Rata-rata / Hari</h6>
                                <h4 class="text-dark font-weight-bold mb-0">
                                    {{ $userGrowth->count() > 0 ? number_format($userGrowth->sum('total') / $userGrowth->count(), 1) : 0 }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-white font-weight-bold">Pembayaran Terbaru</div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $tx)
                            <tr>
                                <td>{{ $tx->user->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $tx->status == 'success' ? 'success' : 'secondary' }}">
                                        {{ $tx->status }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Daftar Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="modalLoading" class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <ul class="list-group list-group-flush" id="userListContainer">
                    </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($userGrowth->pluck('date')) !!},
            datasets: [{
                label: 'User Baru',
                data: {!! json_encode($userGrowth->pluck('total')) !!},
                borderColor: '#4e73df',
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.3
            }]
        }
    });

    // --- SCRIPT BARU UNTUK MODAL USER ---
    document.querySelectorAll('.user-card-trigger').forEach(card => {
        card.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const cardTitle = this.querySelector('.card-title').innerText;
            
            // Inisialisasi & Tampilkan Modal Bootstrap
            const userModal = new bootstrap.Modal(document.getElementById('userModal'));
            document.getElementById('userModalLabel').innerText = cardTitle;
            
            const listContainer = document.getElementById('userListContainer');
            const loadingSpinner = document.getElementById('modalLoading');
            
            // Reset modal state
            listContainer.innerHTML = '';
            loadingSpinner.style.display = 'block';
            
            userModal.show();
            
            // Fetch data dari Controller
            fetch(`{{ route('admin.dashboard.users-modal') }}?type=${type}`)
                .then(response => response.json())
                .then(data => {
                    loadingSpinner.style.display = 'none';
                    
                    if(data.length === 0) {
                        listContainer.innerHTML = '<div class="p-3 text-muted text-center">Tidak ada pengguna ditemukan.</div>';
                        return;
                    }
                    
                    data.forEach(user => {
                        const listItem = `
                            <li class="list-group-item d-flex align-items-center p-3">
                                <img src="${user.photo_url}" alt="${user.name}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #ddd;">
                                <div>
                                    <h6 class="mb-0 font-weight-bold">${user.name}</h6>
                                    <small class="text-muted">${user.email}</small>
                                </div>
                            </li>
                        `;
                        listContainer.insertAdjacentHTML('beforeend', listItem);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingSpinner.style.display = 'none';
                    listContainer.innerHTML = '<div class="p-3 text-danger text-center">Gagal memuat data.</div>';
                });
        });
    });
</script>
@endsection