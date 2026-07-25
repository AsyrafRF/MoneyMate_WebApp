// resources/js/pages/keuangan/laporan-donut.js

import { getColorPalette } from './_helpers.js';

export function initdonutChart() {
  const { kategoriData } = window.__page || {};

  if (!window.__page || !window.__page.kategoriData) {
    console.info("Data laporan tidak ditemukan, skip inisialisasi chart laporan.");
    return;
  }

  const donutCanvas = document.getElementById('kategoridonutChart');
  if (!donutCanvas) return;

  Chart.register(ChartDataLabels);

  const myDonutChart = new Chart(donutCanvas, {
    type: 'doughnut',
    data: {
      labels: Object.keys(kategoriData),
      datasets: [
        {
          data: Object.values(kategoriData),
          backgroundColor: getColorPalette(Object.keys(kategoriData).length),
          _originalData: [...Object.values(kategoriData)],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: { display: false },
        datalabels: { display: false },
        tooltip: {
          callbacks: {
            label: function (context) {
              const value = context.raw;
              const dataset = context.dataset._originalData;
              const total = dataset.reduce((a, b) => a + b, 0);
              const percentage = ((value / total) * 100).toFixed(0);
              return `${context.label}: ${percentage}% (Rp${value.toLocaleString('id-ID')})`;
            },
          },
        },
        legend: { display: false },
      },
    },
    plugins: [ChartDataLabels],
  });

  renderdonutLegend(kategoriData, myDonutChart);
}

function renderdonutLegend(kategoriData, chart) {
  const ul = document.getElementById('donutLegend');
  if (!ul) return;
  ul.innerHTML = '';

  const labels = Object.keys(kategoriData);
  const values = Object.values(kategoriData);
  const colors = getColorPalette(labels.length);
  const total = values.reduce((a, b) => a + b, 0);

  // Array untuk menyimpan index mana saja yang sedang "Aktif dicari/dipilih"
  let activeFilters = [];

  let items = labels.map((label, i) => ({
    index: i,
    label,
    value: values[i],
    percent: values[i] / total,
    color: colors[i],
  }));

  items.sort((a, b) => b.percent - a.percent);

  // Buat element list dahulu dan simpan referensinya ke dalam array objek
  items.forEach((item) => {
    const percent = (item.percent * 100).toFixed(0);
    const li = document.createElement('li');

    li.style.cursor = 'pointer';
    li.style.display = 'flex';
    li.style.justifyContent = 'space-between';
    li.style.alignItems = 'center';
    li.style.gap = '10px';
    li.style.transition = 'all 0.2s ease';

    li.innerHTML = `
      <div class="legend-left d-flex align-items-center gap-2">
        <span class="legend-dot" style="background:${item.color}; width:12px; height:12px; display:inline-block; border-radius:50%;"></span>
        <span class="legend-label">${item.label}</span>
      </div>
      <span class="legend-value fw-semibold">${percent}%</span>
    `;

    // Simpan elemen li ke dalam objek item agar bisa dimanipulasi dari luar scope loop ini
    item.el = li;

    li.addEventListener('click', () => {
      const position = activeFilters.indexOf(item.index);

      if (position > -1) {
        // Jika index sudah ada di filter, artinya user nge-klik ulang untuk MEMATIKAN filter ini
        activeFilters.splice(position, 1);
      } else {
        // Jika belum ada, masukkan ke daftar filter aktif
        activeFilters.push(item.index);
      }

      // Jalankan fungsi update visibilitas chart dan gaya teks legend
      applyFilterVisibility(chart, items, activeFilters);
    });

    ul.appendChild(li);
  });
}

// Fungsi pembantu untuk mengatur efek coret/redup dan menyembunyikan chart slice
function applyFilterVisibility(chart, items, activeFilters) {
  items.forEach((item) => {
    if (activeFilters.length === 0) {
      // KONDISI 1: Tidak ada filter sama sekali (Semua menyala normal)
      chart.setDatasetVisibility(0, true); // Pastikan dataset utama aktif
      chart.show(0, item.index);           // Tampilkan slice chart

      item.el.style.opacity = '1';
      item.el.style.textDecoration = 'none';
    } else {
      // KONDISI 2: Ada filter yang aktif
      if (activeFilters.includes(item.index)) {
        // Jika item ini termasuk yang dipilih -> TAMPILKAN
        chart.show(0, item.index);
        item.el.style.opacity = '1';
        item.el.style.textDecoration = 'none';
      } else {
        // Jika item ini TIDAK dipilih -> SEMBUNYIKAN & CORET
        chart.hide(0, item.index);
        item.el.style.opacity = '0.3';
        item.el.style.textDecoration = 'line-through';
      }
    }
  });

  // Terapkan perubahan ke Chart.js
  chart.update();
}