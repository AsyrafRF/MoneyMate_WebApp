// <!-- Script toggle input tujuan -->
document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori_id');
    const tujuanWrapper = document.getElementById('tujuanWrapper');
    const tujuanSelect = document.getElementById('tujuan_id');
    const keteranganInput = document.getElementById('keterangan');

    kategoriSelect.addEventListener('change', function () {
        const selectedText = kategoriSelect.options[kategoriSelect.selectedIndex].text;

        if (selectedText === "Tujuan Finansial") {
            tujuanWrapper.style.display = "block";
            tujuanSelect.setAttribute("required", "required");
        } else {
            tujuanWrapper.style.display = "none";
            tujuanSelect.removeAttribute("required");
        }
    });
});