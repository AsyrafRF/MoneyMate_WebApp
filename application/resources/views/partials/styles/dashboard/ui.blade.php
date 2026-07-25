<style>
    .fw-black { font-weight: 800 !important; }
    .tracking-tight { letter-spacing: -0.03em !important; }
    .tracking-wider { letter-spacing: 0.08em !important; }
    .fs-7 { font-size: 0.85rem !important; }
    .fs-8 { font-size: 0.75rem !important; }
    .fs-9 { font-size: 0.65rem !important; }

    .card-modern {
        border-radius: 20px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .border-start-expense {
        border-left: 6px solid #dc3545 !important;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: 0 !important;
    }

    .table-custom th, .table-custom td {
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .progress {
        background-color: #f1f3f5;
        overflow: visible;
    }
    
    .shadow-inner {
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.06);
    }
    
    .transition-all {
        transition: all 0.4s ease-in-out;
    }

    .chart-container-permanent {
        position: relative; 
        height: 180px; 
        width: 100%; 
        max-width: 180px; /* Mengunci diameter lingkaran chart agar tidak membesar liar */
    }

    @keyframes pulse-animation {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }
    .animate-pulse {
        animation: pulse-animation 2s infinite ease-in-out;
    }

    .premium-bdg {
        position: relative;
        overflow: hidden; /* Wajib agar kilauan tidak luber keluar border-radius */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 12px;
        font-family: 'Poppins', sans-serif; /* Opsional, font modern */
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #111; /* Teks gelap di atas warna emas agar kontras */
        border-radius: 20px;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        
        /* Kombinasi warna dasar emas premium (Metallic Gold) */
        background: linear-gradient(135px, #f6d365 0%, #fda085 100%);
        /* Alternatif warna emas yang lebih deep: */
        background: linear-gradient(135px, #bf953f 0%, #fcf6ba 25%, #b38728 50%, #fbf5b7 75%, #aa771c 100%);
    }

        /* Efek Kilauan (Shimmer) */
        .premium-bdg::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 30px; /* Lebar kilauan diperkecil karena ukuran badge yang mini */
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.6), /* Kilauan putih sedikit lebih tebal agar kontras dengan emas */
                transparent
            );
            transform: skewX(-30deg); /* Kemiringan kilauan */
            animation: badgeShine 2.5s infinite linear;
        }

        /* Animasi Pergerakan Kilauan */
        @keyframes badgeShine {
            0% {
                left: -100%;
            }
            20% {
                left: 100%; /* Kilauan bergerak cepat melewati badge */
            }
            100% {
                left: 100%; /* Sisa waktu digunakan sebagai jeda (delay) agar tidak terlalu sering berkedip */
            }
        }

        /* Variasi VIP (Jika ingin background gelap dengan border & teks emas) */
        .premium-bdg.VIP {
            color: #fcf6ba;
            background: #111;
            border: 1px solid #bf953f;
            box-shadow: 0 2px 10px rgba(191, 149, 63, 0.2);
            }
            .premium-badge.VIP::before {
            /* Kilauan untuk versi gelap dibuat lebih halus */
            background: linear-gradient(
                90deg,
                transparent,
                rgba(252, 246, 186, 0.4), /* Kilauan bernuansa emas muda transparan */
                transparent
            );
        }
</style>