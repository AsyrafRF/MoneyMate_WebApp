{{-- Modal Pengaturan Akun (static) --}}
<div class="modal fade" id="pengaturanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="pengaturanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-gradient text-white">
                <h5 class="modal-title" id="pengaturanModalLabel"><i class="bi bi-gear"></i> Pengaturan Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Google Connect --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-1">Koneksi Google</h6>
                        @if(!$user->google_id)
                        <small class="text-muted">Hubungkan akun MoneyMate dengan Google untuk login cepat.</small>
                        @else
                        <small class="text-success">Akun ini sudah terhubung dengan Google.</small>
                        @endif
                    </div>

                    @if(!$user->google_id)
                    <a href="{{ route('login.google') }}" class="btn btn-outline-success">
                        <i class="bi bi-google"></i> Sambungkan
                    </a>
                    @else
                    <form action="{{ route('auth.google.disconnect') }}" method="POST"
                        onsubmit="return confirm('Yakin ingin memutuskan sambungan akun Google?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Putuskan
                        </button>
                    </form>
                    @endif
                </div>

                <hr>

                {{-- Tombol Logout --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-1">Keluar Akun</h6>
                        <small class="text-muted d-block" style="max-width: 450px;">
                            Keluar dari aplikasi untuk menjaga keamanan akun Anda. 
                            Anda bisa masuk kembali kapan saja.
                        </small>
                    </div>

                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                        </button>
                    </form>
                </div>
                
                <hr>

                {{-- Hapus Akun --}}
                <div class="text-center">
                    <h6 class="text-danger mb-2"><i class="bi bi-exclamation-triangle"></i> Hapus Akun</h6>
                    <p class="text-muted small">
                        Menghapus akun akan menghapus semua data keuangan Anda secara permanen.
                    </p>
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusAkunModal">
                        <i class="bi bi-trash"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
