// resources/js/pages/keuangan/laporan-sweetalert.js

export function initExportForm() {
  window.showSuccessNotif = function () {
    const mode = document.getElementById('mode')?.value;
    let isValid = false;

    if (mode === 'bulanan') {
      const periode = document.getElementById('periode')?.value;
      if (periode) isValid = true;
    } else if (mode === 'range') {
      const start = document.getElementById('start_month')?.value;
      const end = document.getElementById('end_month')?.value;
      if (start && end) isValid = true;
    }

    if (isValid) {
      setTimeout(() => {
        Swal.fire({
          icon: 'success',
          title: 'Permintaan Diproses',
          text: 'Laporan Anda sedang dibuat dan akan segera terunduh.',
          timer: 4000,
          showConfirmButton: false,
        });
      }, 500);
    }
  };
}