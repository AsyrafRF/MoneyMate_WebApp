// resources/js/pages/keuangan/dashboard-pie.js
import { getColorPalette } from './_helpers.js';

export function initDashboardPieChart() {
    const ctx = document.getElementById('expensePieChart');
    if (!ctx) return;

    const Chart = window.Chart;
    if (!Chart) return;

    // 1. Ambil data awal dari atribut HTML (jika ada)
    const initialDataRaw = ctx.getAttribute('data-chart-initial');
    let initialLabels = [];
    let initialDatasets = [];
    let initialColors = [];

    if (initialDataRaw) {
        try {
            const parsed = JSON.parse(initialDataRaw);
            initialLabels = parsed.labels || [];
            initialDatasets = parsed.data || [];
            initialColors = getColorPalette(initialDatasets.length);

            // Langsung kirim warna awal ke Alpine agar legend tidak abu-abu
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('update-chart-colors', { detail: initialColors }));
            }, 100);
        } catch (e) {
            console.error("Gagal membaca data awal chart:", e);
        }
    }

    // 2. Inisialisasi Chart dengan data awal
    let expenseChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: initialLabels,
            datasets: [{
                data: initialDatasets,
                backgroundColor: initialColors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // Kembalikan padding agar saat di-hover kue tidak terpotong tepi canvas
            layout: {
                padding: 10
            },
            plugins: {
                legend: {
                    display: false // Mematikan legend bawaan Chart.js karena sudah buat sendiri di HTML
                },
                datalabels: {
                    display: false // Mematikan teks angka di dalam kue agar tidak berantakan
                }
            }
        }
    });

    // 3. Fungsi pembantu untuk update (untuk request reaktif berikutnya, misal ganti bulan/filter)
    const updateChart = (chartData) => {
        if (!chartData || !chartData.data) return;

        const generatedColors = getColorPalette(chartData.data.length);
        expenseChart.data.labels = chartData.labels;
        expenseChart.data.datasets[0].data = chartData.data;
        expenseChart.data.datasets[0].backgroundColor = generatedColors;
        expenseChart.update();

        window.dispatchEvent(new CustomEvent('update-chart-colors', { detail: generatedColors }));
    };

    // Dengarkan perubahan data berikutnya dari Livewire
    document.addEventListener('livewire:init', () => {
        Livewire.on('updateChartData', (eventData) => {
            const data = Array.isArray(eventData) ? eventData[0] : eventData;
            updateChart(data);
        });
    });

    window.addEventListener('updateChartData', event => {
        const data = event.detail?.[0] || event.detail;
        updateChart(data);
    });
}