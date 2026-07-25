// resources/js/pages/keuangan/laporan-bar.js

export function initBarChart() {
  const {
    kategoriLabels,
    anggaranData,
    realisasiData,
  } = window.__page || {};

  // Atau lakukan pengecekan sebelum inisialisasi laporan:
  if (!window.__page || !window.__page.kategoriData) {
    console.info("Data laporan tidak ditemukan, skip inisialisasi chart laporan.");
    return; // Keluar dari fungsi secara aman tanpa merusak script lain
  }

  const barCanvas = document.getElementById('anggaranBarChart');
  if (!barCanvas) return;

  const anggaran = anggaranData.map((v) =>
    parseInt(String(v).replace(/\./g, ''), 10)
  );
  const realisasi = realisasiData.map((v) =>
    parseInt(String(v).replace(/\./g, ''), 10)
  );

  const overBudget = realisasi.map((val, i) => val > anggaran[i]);

  const terpakaiBorderColors = overBudget.map((isOver) =>
    isOver ? 'rgba(255, 0, 0, 1)' : 'rgba(0, 188, 245, 1)'
  );
  const terpakaiBorderWidth = overBudget.map((isOver) => (isOver ? 3 : 1));

  const anggaranBorderColors = overBudget.map((isOver) =>
    isOver ? 'rgba(255, 0, 0, 1)' : 'rgba(0, 61, 194, 1)'
  );
  const anggaranBorderWidth = overBudget.map((isOver) => (isOver ? 3 : 1));

  const tooltipDescriptions = realisasi.map((val, i) =>
    val > anggaran[i]
      ? '⚠️ Kategori ini melebihi batas anggaran!'
      : '✔ Masih dalam batas anggaran'
  );

  new Chart(barCanvas, {
    type: 'bar',
    data: {
      labels: kategoriLabels,
      datasets: [
        {
          label: 'Terpakai',
          data: realisasi,
          backgroundColor: 'rgba(27, 148, 215, 1)',
          borderRadius: 8,
          barThickness: 22,
          borderColor: terpakaiBorderColors,
          borderWidth: terpakaiBorderWidth,
        },
        {
          label: 'Total Anggaran',
          data: anggaran,
          backgroundColor: 'rgba(5, 92, 168, 1)',
          borderRadius: 8,
          barThickness: 22,
          borderColor: anggaranBorderColors,
          borderWidth: anggaranBorderWidth,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          onClick: function (e, legendItem, legend) {
            const chart = legend.chart;
            const index = legendItem.datasetIndex;

            const isIsolated = chart.data.datasets.some((ds) => ds._isolated);

            if (isIsolated) {
              chart.data.datasets.forEach((ds) => {
                ds.hidden = false;
                ds._isolated = false;
              });
              chart.update();
              return;
            }

            chart.data.datasets.forEach((ds, i) => {
              if (i === index) {
                ds.hidden = false;
                ds._isolated = true;
              } else {
                ds.hidden = true;
                ds._isolated = true;
              }
            });

            chart.update();
          },
        },
        datalabels: {
          display: false,
        },
        title: {
          display: true,
          text: 'Perbandingan Anggaran vs Pengeluaran per Kategori',
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          callbacks: {
            label: function (context) {
              const value = context.raw;
              return `${context.dataset.label}: Rp${value.toLocaleString('id-ID')}`;
            },
            afterBody: function (context) {
              const index = context[0].dataIndex;
              if (context[0].dataset.label === 'Terpakai') {
                return tooltipDescriptions[index];
              }
            },
          },
        },
      },
      scales: {
        x: {
          stacked: false,
          grid: { display: false },
        },
        y: {
          beginAtZero: true,
          grid: { display: false },
          ticks: {
            callback: function (value) {
              return 'Rp' + value.toLocaleString('id-ID');
            },
          },
        },
      },
    },
  });
}