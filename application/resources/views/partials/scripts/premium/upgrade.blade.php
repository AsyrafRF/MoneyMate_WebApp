<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleYearly = document.getElementById('toggleYearly');
    const labelBulanan = document.getElementById('labelBulanan');
    const labelTahunan = document.getElementById('labelTahunan');
    
    const priceBulanan = document.getElementById('premiumPriceBulanan');
    const priceTahunan = document.getElementById('premiumPriceTahunan');
    
    // Tarik elemen tombol checkout
    const btnCheckout = document.getElementById('btnCheckout');
    const btnCheckoutTrial = document.getElementById('btnCheckoutTrial'); // <--- Ditambahkan untuk Trial

    // Elemen user premium reguler
    const currentPlanMonthlyText = document.getElementById('currentPlanMonthlyText');
    const btnCheckoutYearly = document.getElementById('btnCheckoutYearly');
    const currentPlanYearlyText = document.getElementById('currentPlanYearlyText');
    const downgradeText = document.getElementById('downgradeText');

    // Base URL checkout dari Laravel
    const checkoutBaseUrl = "{{ route('premium.checkout', ['plan' => 'PLAN_PLACEHOLDER']) }}";

    toggleYearly.addEventListener('change', function () {
        if (this.checked) {
            // === TAHUNAN AKTIF ===
            labelBulanan.classList.remove('active');
            labelTahunan.classList.add('active');
            priceBulanan.classList.add('hidden');
            priceTahunan.classList.remove('hidden');

            // Ubah link untuk user biasa jika ada
            if (btnCheckout) {
                btnCheckout.href = checkoutBaseUrl.replace('PLAN_PLACEHOLDER', 'yearly');
            }
            
            // Ubah link untuk user TRIAL ke paket yearly
            if (btnCheckoutTrial) {
                btnCheckoutTrial.href = checkoutBaseUrl.replace('PLAN_PLACEHOLDER', 'yearly');
            }
            
            // Logika user bulanan / tahunan reguler
            if (currentPlanMonthlyText) currentPlanMonthlyText.classList.add('hidden');
            if (btnCheckoutYearly) btnCheckoutYearly.classList.remove('hidden');
            if (currentPlanYearlyText) currentPlanYearlyText.classList.remove('hidden');
            if (downgradeText) downgradeText.classList.add('hidden');

        } else {
            // === BULANAN AKTIF ===
            labelBulanan.classList.add('active');
            labelTahunan.classList.remove('active');
            priceBulanan.classList.remove('hidden');
            priceTahunan.classList.add('hidden');

            // Ubah link untuk user biasa jika ada
            if (btnCheckout) {
                btnCheckout.href = checkoutBaseUrl.replace('PLAN_PLACEHOLDER', 'monthly');
            }

            // Ubah link untuk user TRIAL ke paket monthly
            if (btnCheckoutTrial) {
                btnCheckoutTrial.href = checkoutBaseUrl.replace('PLAN_PLACEHOLDER', 'monthly');
            }

            // Logika user bulanan / tahunan reguler
            if (currentPlanMonthlyText) currentPlanMonthlyText.classList.remove('hidden');
            if (btnCheckoutYearly) btnCheckoutYearly.classList.add('hidden');
            if (currentPlanYearlyText) currentPlanYearlyText.classList.add('hidden');
            if (downgradeText) downgradeText.classList.remove('hidden');
        }
    });
});
</script>