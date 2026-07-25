<x-guest-layout>
    <div class="mb-3 small text-secondary">
        {{ __('Akun Anda saat ini sedang dalam masa penangguhan penutupan akun.') }}
    </div>

    <div class="mb-3 small text-danger fw-bold">
        {{ __('Perhatian: Akun Anda akan dihapus permanen dalam beberapa hari jika tidak dipulihkan.') }}
    </div>

    <div class="mb-3">
        <!-- Tombol Ajukan Pemulihan -->
        <form method="POST" action="{{ route('account.restore') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Batalkan Penghapusan & Pulihkan Akun Saya') }}
            </button>
        </form>
    </div>

    <div class="mb-3">
        <!-- Tombol Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="btn btn-link p-0 m-0 text-secondary text-decoration-underline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>