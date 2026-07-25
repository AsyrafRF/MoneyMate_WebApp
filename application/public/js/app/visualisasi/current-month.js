/* --- AUTO FILL CURRENT MONTH --- */
window.onload = function () {
    const now = new Date();
    const year = now.getFullYear();
    const month = ("0" + (now.getMonth() + 1)).slice(-2);
    const current = `${year}-${month}`;

    document.getElementById("periode").value = current;
    document.getElementById("start_month").value = current;
    document.getElementById("end_month").value = current;

    // Ambil status premium dari penanda HTML
    const isPremium =
        document.getElementById("premium-status").dataset.isPremium === "true";

    // Jika BUKAN premium, kunci fitur range secara permanen sejak halaman dimuat
    if (!isPremium) {
        document.getElementById("check_range").disabled = true;
        document.getElementById("check_single").checked = true; // Auto check bulanan
        updateState(); // Trigger update agar input text menyesuaikan
    }
};

/* --- CHECKLIST LOGIC (Hanya 1 Aktif) --- */
const checkSingle = document.getElementById("check_single");
const checkRange = document.getElementById("check_range");

const periodeInput = document.getElementById("periode");
const startInput = document.getElementById("start_month");
const endInput = document.getElementById("end_month");
const modeInput = document.getElementById("mode");

function updateState() {
    if (checkSingle.checked) {
        checkRange.checked = false;
        periodeInput.disabled = false;
        startInput.disabled = true;
        endInput.disabled = true;
        modeInput.value = "bulanan";
    }

    if (checkRange.checked) {
        checkSingle.checked = false;
        periodeInput.disabled = true;
        startInput.disabled = false;
        endInput.disabled = false;
        modeInput.value = "range";
    }
}

checkSingle.addEventListener("change", updateState);
checkRange.addEventListener("change", updateState);

/* --- VALIDASI RANGE --- */
endInput.addEventListener("change", function () {
    if (endInput.value < startInput.value) {
        alert("Sampai Bulan tidak boleh lebih kecil dari Mulai Bulan!");
        endInput.value = startInput.value;
    }
});

startInput.addEventListener("change", function () {
    if (endInput.value < startInput.value) {
        alert("Mulai Bulan tidak boleh lebih besar dari Sampai Bulan!");
        endInput.value = startInput.value;
    }
});
