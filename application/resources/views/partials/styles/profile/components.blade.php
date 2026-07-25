<style>
    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }

    .toast-container {
        top: 1rem !important;
        right: 1rem !important;
    }

    /* Custom CSS untuk Tampilan Finance */
    .text-xs {
        font-size: 0.75rem; /* Mengecilkan teks keterangan */
    }

    /* Wadah ikon dengan background soft */
    .icon-wrapper {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
    }

    /* Efek Hover & Transisi Elemen Menu */
    .menu-finance-item {
        background-color: #f8f9fa; /* Warna dasar abu-abu sangat muda */
        transition: all 0.25s ease-in-out;
        border: 1px solid #f1f3f5;
    }

    .menu-finance-item:hover {
        background-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #dee2e6;
    }

    /* Efek khusus untuk ikon chevron saat menu di-hover */
    .menu-finance-item:hover .bi-chevron-right {
        color: #212529 !important;
        transform: text-replace;
    }

    /* Kursor pointer khusus untuk Switch Bootstrap */
    .style-switch-pointer {
        cursor: pointer;
    }

    /* CSS Rotasi untuk Progress Ring */
    .transform-rotate-minus-90 {
        display: inline-block !important;
        transform: rotate(-90deg) !important;
    }

    /* Garis pembatas vertikal hanya aktif di layar md ke atas */
    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid #dee2e6 !important;
        }
    }

    /* Animasi Halus untuk Tombol */
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
    .transition-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }

    /* Efek Denyut Halus pada Badge Premium */
    .animate-pulse-custom {
        display: inline-block !important;
        /* Menggunakan ease-in-out agar transisi terang-redupnya terasa mulus */
        animation: cahaya-pulsing 2.5s infinite ease-in-out !important; 
    }

    @keyframes cahaya-pulsing {
        0% {
            filter: brightness(1); /* Kecerahan normal (warna asli) */
        }
        50% {
            filter: brightness(1.35); /* Menjadi lebih terang/bercahaya 35% */
        }
        100% {
            filter: brightness(1); /* Kembali ke normal */
        }
    }

    .border-start-gradient {
        position: relative;
        overflow: hidden;
    }

    .border-start-gradient::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #74b9ff, #0984e3);
    }

    .border-start-google {
        position: relative;
        overflow: hidden;
    }

    .border-start-google::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, #EA4335, #FBBC05, #34A853);
    }

    .bg-icon-google {
        background: conic-gradient(
            #4285F4 0deg 90deg, 
            #EA4335 90deg 180deg, 
            #FBBC05 180deg 270deg, 
            #34A853 270deg 360deg
        );
    }
</style>