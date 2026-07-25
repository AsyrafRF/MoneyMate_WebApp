// resources/js/pages/keuangan/index.js

import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import Swal from 'sweetalert2';

// 1. Jadikan global
window.Chart = Chart;
window.ChartDataLabels = ChartDataLabels;
window.Swal = Swal;

// 2. Daftarkan plugin global
Chart.register(ChartDataLabels);

// 3. SET KONFIGURASI GLOBAL
Chart.defaults.font.family = "'Poppins', sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.font.weight = '400';
Chart.defaults.color = '#333';

// 4. Import modul-modul chart
import { initdonutChart } from './laporan-donut.js';
import { initBarChart } from './laporan-bar.js';
import { initExportForm } from './laporan-sweetalert.js';
import { initDashboardPieChart } from './dashboard-pie.js'; // <-- Tambahkan ini

document.addEventListener('DOMContentLoaded', () => {
  initDashboardPieChart(); // <-- Jalankan di sini, aman walau element-nya tidak ada di halaman lain berkat proteksi `if (!ctx)`
  initdonutChart();
  initBarChart();
  initExportForm();
});