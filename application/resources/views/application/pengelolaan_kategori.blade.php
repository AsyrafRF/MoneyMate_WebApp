@extends('layouts.app')

@section('title', 'Kelola Kategori')

@push('styles')
<link href="{{ asset('css/app/kategori-style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="kat-page" id="katPage">

    {{-- ===== HEADER ===== --}}
    <header class="kat-header">
        <div class="kat-header__inner">
            <div class="kat-header__text">
                <h1 class="kat-header__title">Pengelolaan Kategori</h1>
                <p class="kat-header__desc">Kelola kategori kustom untuk pencatatan keuangan yang lebih terstruktur.</p>
            </div>
            @if(Auth::user()->is_premium)
            <button type="button" class="kat-btn kat-btn--primary" onclick="openAddModal()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Kategori
            </button>
            @endif
        </div>
    </header>

    {{-- ===== PAYWALL (Non-Premium) ===== --}}
    @if(!Auth::user()->is_premium)
    <section class="kat-paywall">
        <div class="kat-paywall__card">
            <div class="kat-paywall__icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    <circle cx="12" cy="16" r="1"/>
                </svg>
            </div>
            <h2 class="kat-paywall__title">Fitur Premium</h2>
            <p class="kat-paywall__desc">Buat dan kelola kategori kustom sesuai kebutuhan finansialmu. Fitur ini eksklusif untuk pengguna premium.</p>
            <ul class="kat-paywall__features">
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Buat kategori tanpa batas
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Kelola pemasukan &amp; pengeluaran terpisah
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Edit dan hapus kapan saja
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Analisis anggaran per kategori
                </li>
            </ul>
            <a href="{{ route('premium.upgrade') }}" class="kat-btn kat-btn--gold">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Upgrade ke Premium
            </a>
        </div>

        {{-- Preview bergelombang (dekoratif) --}}
        <div class="kat-paywall__preview" aria-hidden="true">
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--1"></div>
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--2"></div>
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--3"></div>
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--4"></div>
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--5"></div>
            <div class="kat-paywall__ghost-card kat-paywall__ghost-card--6"></div>
        </div>
    </section>
    @endif

    {{-- ===== KONTEN PREMIUM ===== --}}
    @if(Auth::user()->is_premium)

    {{-- Statistik Ringkas --}}
    <div class="kat-stats">
        <div class="kat-stat" data-stat="total">
            <span class="kat-stat__number">{{ $stats['total'] }}</span>
            <span class="kat-stat__label">Total Kategori</span>
        </div>
        <div class="kat-stat kat-stat--pemasukan" data-stat="pemasukan">
            <span class="kat-stat__number">{{ $stats['pemasukan'] }}</span>
            <span class="kat-stat__label">Pemasukan</span>
        </div>
        <div class="kat-stat kat-stat--pengeluaran" data-stat="pengeluaran">
            <span class="kat-stat__number">{{ $stats['pengeluaran'] }}</span>
            <span class="kat-stat__label">Pengeluaran</span>
        </div>
    </div>

    {{-- Toolbar: Pencarian + Filter --}}
    <div class="kat-toolbar">
        <form method="GET" action="{{ route('kategori.index') }}" class="kat-search" id="searchForm">
            <svg class="kat-search__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama kategori..." class="kat-search__input" id="searchInput">
            @if($search !== '')
            <button type="button" class="kat-search__clear" onclick="clearSearch()" aria-label="Hapus pencarian">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            @endif
            <input type="hidden" name="jenis" value="{{ $currentJenis }}" id="searchJenisInput">
        </form>

        <div class="kat-filter" role="tablist">
            <a href="{{ route('kategori.index', ['jenis' => 'semua'] + ($search ? ['search' => $search] : [])) }}"
               class="kat-filter__pill {{ $currentJenis === 'semua' ? 'kat-filter__pill--active' : '' }}"
               role="tab" aria-selected="{{ $currentJenis === 'semua' }}">
                Semua
            </a>
            <a href="{{ route('kategori.index', ['jenis' => 'pemasukan'] + ($search ? ['search' => $search] : [])) }}"
               class="kat-filter__pill {{ $currentJenis === 'pemasukan' ? 'kat-filter__pill--active kat-filter__pill--pm' : '' }}"
               role="tab" aria-selected="{{ $currentJenis === 'pemasukan' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                Pemasukan
            </a>
            <a href="{{ route('kategori.index', ['jenis' => 'pengeluaran'] + ($search ? ['search' => $search] : [])) }}"
               class="kat-filter__pill {{ $currentJenis === 'pengeluaran' ? 'kat-filter__pill--active kat-filter__pill--pr' : '' }}"
               role="tab" aria-selected="{{ $currentJenis === 'pengeluaran' }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                Pengeluaran
            </a>
        </div>
    </div>

    {{-- Grid Kategori --}}
    <div class="kat-grid" id="katGrid">
        @forelse($kategori as $k)
        @php
            // Normalisasi: pastikan lowercase dan tanpa whitespace
            $jenisNorm = strtolower(trim($k->jenis));
            $isPemasukan = $jenisNorm === 'pemasukan';
            $jenisLabel = $isPemasukan ? 'Pemasukan' : 'Pengeluaran';
        @endphp
        
        <div class="kat-card" data-id="{{ $k->id_kategori }}" data-jenis="{{ $jenisNorm }}">
            <div class="kat-card__accent kat-card__accent--{{ $jenisNorm }}"></div>
            <div class="kat-card__body">
                <div class="kat-card__top">
                    <div class="kat-card__icon kat-card__icon--{{ $jenisNorm }}">
                        @if($isPemasukan)
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                        @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                        @endif
                    </div>
                    <div class="kat-card__badges">
                        <span class="kat-badge kat-badge--{{ $jenisNorm }}">
                            {{ $jenisLabel }}
                        </span>
                        @if($k->is_auto)
                        <span class="kat-badge kat-badge--auto">Bawaan</span>
                        @endif
                    </div>
                </div>

                <h3 class="kat-card__name">
                    <i class="bi {{ $k->icon ?? 'bi-tag' }} me-1"></i>
                    {{ $k->nama_kategori }}
                </h3>

                <p class="kat-card__usage">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    {{ $k->keuangans_count }} transaksi tercatat
                </p>

                @if(!$k->is_auto)
                <div class="kat-card__actions">
                    <button type="button" class="kat-card__btn kat-card__btn--edit" onclick="openEditModal({{ $k->id_kategori }}, '{{ $k->nama_kategori }}', '{{ $jenisNorm }}')" aria-label="Edit kategori">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <button type="button" class="kat-card__btn kat-card__btn--delete" onclick="openDeleteModal({{ $k->id_kategori }}, '{{ $k->nama_kategori }}', {{ $k->keuangans_count }})" aria-label="Hapus kategori">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        Hapus
                    </button>
                </div>
                @else
                <div class="kat-card__actions">
                    <span class="kat-card__locked">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Kategori bawaan sistem
                    </span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="kat-empty" id="katEmpty">
            <div class="kat-empty__icon">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
            </div>
            <h3 class="kat-empty__title">Belum Ada Kategori</h3>
            <p class="kat-empty__desc">
                @if($search !== '')
                    Tidak ditemukan kategori untuk pencarian "<strong>{{ $search }}</strong>".
                @elseif($currentJenis !== 'semua')
                    Belum ada kategori {{ $currentJenis }}.
                @else
                    Mulai buat kategori kustom pertamamu.
                @endif
            </p>
            @if($search !== '' || $currentJenis !== 'semua')
            <a href="{{ route('kategori.index') }}" class="kat-btn kat-btn--outline">Tampilkan Semua</a>
            @else
            <button type="button" class="kat-btn kat-btn--primary" onclick="openAddModal()">Buat Kategori Pertama</button>
            @endif
        </div>
        @endforelse
    </div>
    @endif

    {{-- ===== MODAL: TAMBAH / EDIT ===== --}}
    <div class="kat-modal-overlay" id="formModal" role="dialog" aria-modal="true" aria-labelledby="formModalTitle" aria-hidden="true">
        <div class="kat-modal">
            <div class="kat-modal__header modal-header-gradient">
                <h2 class="kat-modal__title" id="formModalTitle">Tambah Kategori</h2>
                <button type="button" class="kat-modal__close" onclick="closeFormModal()" aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="kategoriForm" onsubmit="submitKategori(event)">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" value="" id="formId">

                <div class="kat-modal__body">
                    <div class="kat-field">
                        <label class="kat-field__label" for="inputNama">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="inputNama" class="kat-field__input" placeholder="contoh: Jajanan, Freelance, Investasi" maxlength="50" required>
                        <span class="kat-field__counter"><span id="namaCount">0</span>/50</span>
                        <p class="kat-field__error" id="errorNama"></p>
                    </div>

                    <div class="kat-field">
                        <label class="kat-field__label">Jenis Kategori</label>
                        <div class="kat-radio-group">
                            <label class="kat-radio">
                                <input type="radio" name="jenis" value="pemasukan" required>
                                <span class="kat-radio__box"></span>
                                <span class="kat-radio__text">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
                                    Pemasukan
                                </span>
                            </label>
                            <label class="kat-radio">
                                <input type="radio" name="jenis" value="pengeluaran" required>
                                <span class="kat-radio__box"></span>
                                <span class="kat-radio__text">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                                    Pengeluaran
                                </span>
                            </label>
                        </div>
                        <p class="kat-field__error" id="errorJenis"></p>
                    </div>

                    <div class="kat-field">
                        <label class="kat-field__label">Pilih Ikon Kategori</label>
                        
                        <input type="hidden" name="icon" id="inputIcon" value="bi-tag">
                        
                        <div class="d-flex align-items-center gap-3 mb-2 p-2 border rounded bg-light" style="width: fit-content;">
                            <span class="fs-4 text-secondary"><i id="iconPreview" class="bi bi-tag"></i></span>
                            <small class="text-muted">Ikon Terpilih</small>
                        </div>

                        <div class="icon-selector-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; max-height: 120px; overflow-y: auto; padding: 5px; border: 1px solid #e2e8f0; border-radius: 6px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-tag')"><i class="bi bi-tag"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-wallet2')"><i class="bi bi-wallet2"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-cart')"><i class="bi bi-cart"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-cash-coin')"><i class="bi bi-cash-coin"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-house')"><i class="bi bi-house"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-car-front')"><i class="bi bi-car-front"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-lightning')"><i class="bi bi-lightning"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-heart')"><i class="bi bi-heart"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-gift')"><i class="bi bi-gift"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-cup-straw')"><i class="bi bi-cup-straw"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-controller')"><i class="bi bi-controller"></i></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-icon-item" onclick="selectIcon('bi-mortarboard')"><i class="bi bi-mortarboard"></i></button>
                        </div>
                        <p class="kat-field__error" id="errorIcon"></p>
                    </div>

                </div>

                <div class="kat-modal__footer">
                    <button type="button" class="kat-btn kat-btn--ghost" onclick="closeFormModal()">Batal</button>
                    <button type="submit" class="kat-btn kat-btn--primary" id="formSubmitBtn">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MODAL: KONFIRMASI HAPUS ===== --}}
    <div class="kat-modal-overlay" id="deleteModal" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="kat-modal kat-modal--sm">
            <div class="kat-modal__header">
                <h2 class="kat-modal__title kat-modal__title--danger" id="deleteModalTitle">Hapus Kategori</h2>
                <button type="button" class="kat-modal__close" onclick="closeDeleteModal()" aria-label="Tutup">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="kat-modal__body">
                <div class="kat-delete-warning">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <p class="kat-delete-text">
                    Apakah kamu yakin ingin menghapus kategori <strong id="deleteName"></strong>?
                </p>
                <p class="kat-delete-sub" id="deleteSub"></p>
            </div>
            <div class="kat-modal__footer">
                <button type="button" class="kat-btn kat-btn--ghost" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="kat-btn kat-btn--danger" id="deleteConfirmBtn" onclick="confirmDelete()">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- ===== TOAST CONTAINER ===== --}}
    <div class="kat-toast-container" id="toastContainer"></div>

</div>

@push('scripts')
<script>
    // ============================
    // STATE
    // ============================
    let editingId = null;
    let deletingId = null;
    let isDeleting = false; // Race condition guard
    let lastFocusedElement = null; // Accessibility: Focus return

    // ============================
    // UTILITAS DASAR
    // ============================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Escape khusus untuk atribut HTML (mencegah quote injection / XSS)
    function escapeAttr(str) {
        return str.replace(/&/g, '&amp;')
                  .replace(/"/g, '&quot;')
                  .replace(/'/g, '&#39;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;');
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (!meta) {
            console.error('CSRF meta tag tidak ditemukan.');
            return '';
        }
        return meta.getAttribute('content');
    }

    function clearErrors() {
        document.getElementById('errorNama').textContent = '';
        document.getElementById('errorJenis').textContent = '';
        document.getElementById('errorIcon').textContent = ''; // Tambahkan baris ini
    }

    // ============================
    // MODAL UTILITAS (ACCESSIBILITY)
    // ============================
    function trapFocus(modalElement) {
        const focusable = modalElement.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        if (focusable.length === 0) return;

        const firstFocusable = focusable[0];
        const lastFocusable = focusable[focusable.length - 1];

        modalElement._trapHandler = function(e) {
            if (e.key !== 'Tab') return;
            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    lastFocusable.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    firstFocusable.focus();
                    e.preventDefault();
                }
            }
        };

        modalElement.addEventListener('keydown', modalElement._trapHandler);
    }

    function openModal(id) {
        const el = document.getElementById(id);
        lastFocusedElement = document.activeElement; // Simpan fokus sebelumnya
        
        el.classList.add('kat-modal-overlay--open');
        el.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        
        // Fokus ke elemen pertama yang valid (biasanya input)
        const firstInput = el.querySelector('input:not([type="hidden"]), button:not(.kat-modal__close)');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
        
        trapFocus(el);
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        
        // Hapus focus trap
        if (el._trapHandler) {
            el.removeEventListener('keydown', el._trapHandler);
            delete el._trapHandler;
        }

        el.classList.remove('kat-modal-overlay--open');
        el.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        
        // Kembalikan fokus
        if (lastFocusedElement) {
            lastFocusedElement.focus();
            lastFocusedElement = null;
        }
    }

    // Tutup modal dengan klik overlay
    document.querySelectorAll('.kat-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
                editingId = null;
                deletingId = null;
            }
        });
    });

    // Tutup modal dengan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.kat-modal-overlay--open');
            if (openModal) {
                closeModal(openModal.id);
                editingId = null;
                deletingId = null;
            }
        }
    });

    // ============================
    // MODAL: TAMBAH / EDIT
    // ============================
    function openAddModal() {
        editingId = null;
        document.getElementById('formModalTitle').textContent = 'Tambah Kategori';
        document.getElementById('formSubmitBtn').textContent = 'Simpan Kategori';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formId').value = '';
        document.getElementById('inputNama').value = '';
        document.getElementById('namaCount').textContent = '0';
        document.querySelectorAll('input[name="jenis"]').forEach(r => r.checked = false);
        clearErrors();
        
        // SCRIPT PENYESUAIAN IKON: Kembalikan ke ikon default 'bi-tag'
        selectIcon('bi-tag'); 
        
        openModal('formModal');
    }

    // SCRIPT PENYESUAIAN PARAMETER: Tambahkan parameter 'icon' di paling belakang
    function openEditModal(id, nama, jenis, icon) {
        editingId = id;
        document.getElementById('formModalTitle').textContent = 'Edit Kategori';
        document.getElementById('formSubmitBtn').textContent = 'Perbarui Kategori';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('formId').value = id;
        document.getElementById('inputNama').value = nama;
        document.getElementById('namaCount').textContent = nama.length;
        document.querySelectorAll('input[name="jenis"]').forEach(r => {
            r.checked = r.value === jenis;
        });
        clearErrors();
        
        // SCRIPT PENYESUAIAN IKON: Set ke ikon lama milik kategori ini dari DB
        selectIcon(icon || 'bi-tag');
        
        openModal('formModal');
    }

    function closeFormModal() {
        closeModal('formModal');
        editingId = null;
    }

    // Tambahkan fungsi ini di bawah closeFormModal()
    function selectIcon(iconClass) {
        // Ubah value input hidden
        const inputIcon = document.getElementById('inputIcon');
        if (inputIcon) inputIcon.value = iconClass;
        
        // Ubah preview ikon di atas grid
        const previewEl = document.getElementById('iconPreview');
        if (previewEl) previewEl.className = 'bi ' + iconClass;

        // Beri highlight active pada tombol ikon yang dipilih
        document.querySelectorAll('.btn-icon-item').forEach(btn => {
            btn.classList.remove('btn-primary', 'text-white');
            btn.classList.add('btn-outline-secondary');
        });
        
        // Cari tombol yang aktif saat ini berdasarkan onclick string atau element target
        const activeBtn = Array.from(document.querySelectorAll('.btn-icon-item'))
            .find(btn => btn.getAttribute('onclick').includes(`'${iconClass}'`));
            
        if (activeBtn) {
            activeBtn.classList.remove('btn-outline-secondary');
            activeBtn.classList.add('btn-primary', 'text-white');
        }
    }

    // ============================
    // MODAL: HAPUS
    // ============================
    function openDeleteModal(id, nama, usageCount) {
        deletingId = id;
        document.getElementById('deleteName').textContent = '"' + nama + '"';
        const sub = document.getElementById('deleteSub');
        if (usageCount > 0) {
            sub.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="vertical-align:-2px;margin-right:4px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Kategori ini memiliki <strong>' + usageCount + ' transaksi</strong> tercatat dan tidak bisa dihapus.';
            document.getElementById('deleteConfirmBtn').disabled = true;
            document.getElementById('deleteConfirmBtn').classList.add('kat-btn--disabled');
        } else {
            sub.textContent = 'Tindakan ini tidak dapat dibatalkan.';
            document.getElementById('deleteConfirmBtn').disabled = false;
            document.getElementById('deleteConfirmBtn').classList.remove('kat-btn--disabled');
        }
        openModal('deleteModal');
    }

    function closeDeleteModal() {
        closeModal('deleteModal');
        deletingId = null;
    }

    // ============================
    // SUBMIT KATEGORI (AJAX)
    // ============================
    async function submitKategori(e) {
        e.preventDefault();
        clearErrors();

        const form = document.getElementById('kategoriForm');
        const btn = document.getElementById('formSubmitBtn');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.innerHTML = '<span class="kat-spinner"></span> Menyimpan...';

        const isEdit = editingId !== null;
        const url = isEdit
            ? '{{ route("kategori.update", "__ID__") }}'.replace('__ID__', editingId)
            : '{{ route("kategori.store") }}';

        const method = isEdit ? 'PUT' : 'POST';

        try {
            const formData = new FormData(form);
            formData.append('_method', method);

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
                closeFormModal();

                if (isEdit) {
                    updateCardInDOM(data.data);
                } else {
                    prependCardToDOM(data.data);
                    updateStatsUI(1, data.data.jenis);
                }
            } else if (response.status === 422) {
                if (data.errors?.nama_kategori) {
                    document.getElementById('errorNama').textContent = data.errors.nama_kategori[0];
                }
                if (data.errors?.jenis) {
                    document.getElementById('errorJenis').textContent = data.errors.jenis[0];
                }
                if (data.errors?.icon) {
                    document.getElementById('errorIcon').textContent = data.errors.icon[0];
                }
            } else {
                showToast(data.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            showToast('Gagal terhubung ke server.', 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = originalText;
        }
    }

    // ============================
    // HAPUS KATEGORI (AJAX)
    // ============================
    async function confirmDelete() {
        // 1. Guard race condition
        if (isDeleting) return;
        isDeleting = true;

        // 2. Amankan ID SEGERA
        const idYangAkanDihapus = deletingId;

        if (!idYangAkanDihapus) {
            console.error("Gagal menghapus: ID tidak ditemukan di state.");
            isDeleting = false;
            return;
        }

        const btn = document.getElementById('deleteConfirmBtn');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.innerHTML = '<span class="kat-spinner"></span> Menghapus...';

        try {
            const response = await fetch('{{ route("kategori.destroy", "__ID__") }}'.replace('__ID__', idYangAkanDihapus), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
                
                // 3. Ambil info jenis sebelum modal ditutup & elemen dihapus
                const kartu = document.querySelector(`.kat-card[data-id="${idYangAkanDihapus}"]`);
                const jenisYangDihapus = kartu ? kartu.dataset.jenis : null;
                
                // 4. Tutup modal
                closeDeleteModal();

                // 5. Hapus elemen dari DOM
                if (kartu) {
                    kartu.style.transition = '0.3s';
                    kartu.style.opacity = '0';
                    kartu.style.transform = 'scale(0.9)';
                    
                    setTimeout(() => {
                        kartu.remove();
                        // Update stat menggunakan data yang sudah diamankan
                        if (jenisYangDihapus) updateStatsUI(-1, jenisYangDihapus);
                        checkEmptyState();
                    }, 300);
                }
            } else {
                showToast(data.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            showToast('Gagal terhubung ke server.', 'error');
        } finally {
            isDeleting = false;
            btn.disabled = false;
            btn.textContent = originalText;
        }
    }

    // ============================
    // DOM MANIPULATION
    // ============================
    function buildCardHTML(k) {
        const isPemasukan = k.jenis === 'pemasukan';
        const jenisLabel = isPemasukan ? 'Pemasukan' : 'Pengeluaran';
        
        // SCRIPT PENYESUAIAN IKON: Gunakan ikon kustom dari database atau 'bi-tag' jika kosong
        const iconClass = k.icon ? k.icon : 'bi-tag';
        const customIcon = `<i class="bi ${iconClass}" style="font-size: 20px;"></i>`;

        return `
        <div class="kat-card kat-card--entering" data-id="${k.id_kategori}" data-jenis="${k.jenis}">
            <div class="kat-card__accent kat-card__accent--${k.jenis}"></div>
            <div class="kat-card__body">
                <div class="kat-card__top">
                    <div class="kat-card__icon kat-card__icon--${k.jenis}">${customIcon}</div>
                    <div class="kat-card__badges">
                        <span class="kat-badge kat-badge--${k.jenis}">${jenisLabel}</span>
                    </div>
                </div>
                <h3 class="kat-card__name">${escapeHtml(k.nama_kategori)}</h3>
                <p class="kat-card__usage">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    ${k.keuangans_count ?? 0} transaksi tercatat
                </p>
                <div class="kat-card__actions">
                    <button type="button" class="kat-card__btn kat-card__btn--edit" onclick="openEditModal(${k.id_kategori}, '${escapeAttr(k.nama_kategori)}', '${k.jenis}', '${escapeAttr(iconClass)}')" aria-label="Edit kategori">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <button type="button" class="kat-card__btn kat-card__btn--delete" onclick="openDeleteModal(${k.id_kategori}, '${escapeAttr(k.nama_kategori)}', ${k.keuangans_count ?? 0})" aria-label="Hapus kategori">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>`;
    }

    function prependCardToDOM(k) {
        const grid = document.getElementById('katGrid');
        if (!grid) return;
        
        const empty = document.getElementById('katEmpty');
        if (empty) empty.remove();

        // Cegah kartu muncul jika tidak sesuai dengan filter aktif
        const activeFilter = document.querySelector('.kat-filter__pill--active');
        const currentJenisText = activeFilter ? activeFilter.textContent.trim().toLowerCase() : 'semua';
        
        if (currentJenisText !== 'semua' && k.jenis !== currentJenisText) {
            showToast('Kategori ditambahkan, tapi tidak ditampilkan karena filter sedang aktif.', 'warning');
            updateStatsUI(1, k.jenis);
            return;
        }

        const temp = document.createElement('div');
        temp.innerHTML = buildCardHTML(k);
        const card = temp.firstElementChild;

        // Cari posisi yang tepat berdasarkan sorting
        const cards = Array.from(grid.querySelectorAll('.kat-card'));
        let inserted = false;
        for (const existing of cards) {
            const ej = existing.dataset.jenis;
            if (k.jenis === 'pemasukan' && ej === 'pengeluaran') {
                grid.insertBefore(card, existing);
                inserted = true;
                break;
            }
            if (k.jenis === ej) {
                const eName = existing.querySelector('.kat-card__name').textContent.trim().toLowerCase();
                if (k.nama_kategori.toLowerCase() < eName) {
                    grid.insertBefore(card, existing);
                    inserted = true;
                    break;
                }
            }
        }
        if (!inserted) grid.appendChild(card);
    }

    function updateCardInDOM(k) {
        const card = document.querySelector('.kat-card[data-id="' + k.id_kategori + '"]');
        if (!card) return;

        // Cek apakah perubahan jenis menyebabkan kartu tidak cocok dengan filter aktif
        const activeFilter = document.querySelector('.kat-filter__pill--active');
        const currentJenisText = activeFilter ? activeFilter.textContent.trim().toLowerCase() : 'semua';
        
        if (currentJenisText !== 'semua' && k.jenis !== currentJenisText) {
            card.remove();
            checkEmptyState();
            showToast('Jenis kategori berubah dan tidak ditampilkan karena filter sedang aktif.', 'warning');
            return;
        }

        const temp = document.createElement('div');
        temp.innerHTML = buildCardHTML(k);
        const newCard = temp.firstElementChild;

        newCard.classList.remove('kat-card--entering');
        newCard.classList.add('kat-card--updated');
        card.replaceWith(newCard);
    }

    function updateStatsUI(delta, jenis = null) {
        // Update Total
        const totalEl = document.querySelector('.kat-stat[data-stat="total"] .kat-stat__number');
        if (totalEl) {
            const val = Math.max(0, (parseInt(totalEl.textContent) || 0) + delta);
            totalEl.textContent = val;
        }
        
        // Update Jenis Spesifik (jika disediakan)
        if (jenis) {
            const jenisEl = document.querySelector(`.kat-stat[data-stat="${jenis}"] .kat-stat__number`);
            if (jenisEl) {
                const val = Math.max(0, (parseInt(jenisEl.textContent) || 0) + delta);
                jenisEl.textContent = val;
            }
        }
    }

    function checkEmptyState() {
        const grid = document.getElementById('katGrid');
        if (!grid) return;
        const cards = grid.querySelectorAll('.kat-card');
        
        if (cards.length === 0) {
            const activeFilter = document.querySelector('.kat-filter__pill--active');
            const currentJenisText = activeFilter ? activeFilter.textContent.trim().toLowerCase() : 'semua';
            
            let desc = 'Mulai buat kategori kustom pertamamu.';
            if (currentJenisText !== 'semua') {
                desc = `Belum ada kategori ${currentJenisText} yang bisa ditampilkan.`;
            }
            
            grid.innerHTML = `
            <div class="kat-empty" id="katEmpty">
                <div class="kat-empty__icon">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                </div>
                <h3 class="kat-empty__title">Belum Ada Kategori</h3>
                <p class="kat-empty__desc">${desc}</p>
                <button type="button" class="kat-btn kat-btn--primary" onclick="openAddModal()">Buat Kategori Pertama</button>
            </div>`;
        }
    }

    // ============================
    // PENCARIAN
    // ============================
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchForm').submit();
    }

    // Debounce pencarian
    let searchTimeout;
    document.getElementById('searchInput')?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 400);
    });

    // ============================
    // TOAST NOTIFICATION
    // ============================
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        
        // Batasi maksimal 3 toast agar tidak menumpuk
        const existingToasts = container.querySelectorAll('.kat-toast');
        if (existingToasts.length >= 3) {
            existingToasts[0].remove();
        }

        const toast = document.createElement('div');
        toast.className = 'kat-toast kat-toast--' + type;

        const icons = {
            success: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            error: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
            warning: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        };

        toast.innerHTML = `<span class="kat-toast__icon">${icons[type] || icons.success}</span><span class="kat-toast__msg">${message}</span>`;
        container.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('kat-toast--visible'));

        setTimeout(() => {
            toast.classList.remove('kat-toast--visible');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 4000);
    }

    // ============================
    // MISC EVENT LISTENERS
    // ============================
    
    // Character counter untuk input nama
    document.getElementById('inputNama')?.addEventListener('input', function() {
        document.getElementById('namaCount').textContent = this.value.length;
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(form => {
            form.setAttribute('data-no-overlay', 'true');
        });
    });
</script>
@endpush

@endsection