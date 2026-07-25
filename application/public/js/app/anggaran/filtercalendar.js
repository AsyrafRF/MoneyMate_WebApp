document.addEventListener('DOMContentLoaded', function() {
    // === 1. Inisialisasi Elemen ===
    const filterToggle = document.getElementById('filterToggle');
    const filterCard = document.getElementById('filterCard');
    const periodeInput = document.getElementById('periode');
    const modeSelect = document.getElementById('mode');
    const formPeriode = document.getElementById('formPeriode');
    const alertBox = document.getElementById('alertPeriode');

    let flatpickrInstance = null;
    let isFilterOpen = false;

    // === 2. Fungsi Utama Flatpickr ===
    function setupFlatpickr(mode) {
        if (flatpickrInstance) {
            flatpickrInstance.destroy();
        }

        let config = {
            allowInput: false,
            clickOpens: true,
            disableMobile: true,
            dateFormat: 'Y-m-d',
            locale: 'id',
            defaultDate: periodeInput.value || new Date(),
            theme: 'material_blue',
            appendTo: document.body,
            position: "auto",

            onOpen: () => {
                isFilterOpen = false;
            },
            onClose: () => {
                setTimeout(() => {
                    filterCard.classList.remove('d-none');
                    isFilterOpen = true;
                }, 100);
            },
            onDayCreate: (dObj, dStr, fp, dayElem) => {
                dayElem.classList.remove('active-day', 'inactive-day', 'range-day');
                
                const date = dayElem.dateObj;
                const selectedDate = fp.selectedDates[0];

                // Logika Harian
                if (mode === 'harian' && selectedDate) {
                    if (date.toDateString() === selectedDate.toDateString()) {
                        dayElem.classList.add('active-day');
                    }
                }
                
                // Logika Mingguan (DIBATASI BULAN AKTIF)
                else if (mode === 'mingguan' && selectedDate) {
                    const currentMonth = fp.currentMonth;
                    const currentYear = fp.currentYear;
                    
                    // Batas bulan aktif
                    const monthStart = new Date(currentYear, currentMonth, 1);
                    const monthEnd = new Date(currentYear, currentMonth + 1, 0);

                    // Hitung range minggu (Senin - Minggu)
                    const startOfWeek = new Date(selectedDate);
                    const dayOfWeek = startOfWeek.getDay();
                    const diff = (dayOfWeek === 0 ? -6 : 1 - dayOfWeek);
                    startOfWeek.setDate(selectedDate.getDate() + diff);
                    
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);

                    // Potong range jika keluar batas bulan
                    const adjustedStart = startOfWeek < monthStart 
                        ? monthStart 
                        : new Date(startOfWeek);
                    const adjustedEnd = endOfWeek > monthEnd 
                        ? monthEnd 
                        : new Date(endOfWeek);

                    // Styling: highlight hanya yang dalam range & bulan aktif
                    if (
                        date >= adjustedStart && 
                        date <= adjustedEnd && 
                        date.getMonth() === currentMonth && 
                        date.getFullYear() === currentYear
                    ) {
                        dayElem.classList.add('range-day');
                    } else {
                        dayElem.classList.add('inactive-day');
                    }
                }

                // Logika Bulanan
                else if (mode === 'bulanan') {
                    if (date.getMonth() !== fp.currentMonth) {
                        dayElem.classList.add('inactive-day');
                    }
                }
            }
        };

        // Mode Bulanan - Plugin month select
        if (mode === 'bulanan') {
            config.plugins = [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "Y-m-01",
                    altFormat: "F Y",
                    theme: "light"
                })
            ];
        }

        // Mode Mingguan - Redraw saat ganti tanggal
        if (mode === 'mingguan') {
            config.onChange = (selectedDates, dateStr, instance) => {
                instance.redraw();
            };
        }

        flatpickrInstance = flatpickr(periodeInput, config);
    }

    // === 3. Event Listeners UI ===
    
    filterToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        isFilterOpen = !isFilterOpen;
        
        if (isFilterOpen) {
            filterCard.classList.remove('d-none');
            filterCard.classList.add('active');
            filterCard.style.animation = 'filterSlideIn 0.2s ease-out';
        } else {
            filterCard.style.animation = 'filterSlideOut 0.15s ease-in forwards';
            setTimeout(() => filterCard.classList.add('d-none'), 150);
        }
    });

    document.addEventListener('click', (e) => {
        const isClickInside = filterCard.contains(e.target) || filterToggle.contains(e.target);
        const isFlatpickrClick = e.target.closest('.flatpickr-calendar');

        if (isFilterOpen && !isClickInside && !isFlatpickrClick) {
            isFilterOpen = false;
            filterCard.style.animation = 'filterSlideOut 0.15s ease-in forwards';
            setTimeout(() => filterCard.classList.add('d-none'), 150);
        }
    });

    filterCard.addEventListener('click', (e) => e.stopPropagation());

    modeSelect.addEventListener('change', function() {
        setupFlatpickr(this.value);
    });

    formPeriode.addEventListener('submit', function(e) {
        if (!periodeInput.value) {
            e.preventDefault();
            alertBox.textContent = '⚠️ Silakan pilih periode terlebih dahulu!';
            alertBox.classList.remove('d-none');
        } else {
            alertBox.classList.add('d-none');
        }
    });

    // === 4. Inisialisasi Awal ===
    setupFlatpickr(modeSelect.value);
});