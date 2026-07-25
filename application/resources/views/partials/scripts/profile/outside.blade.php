{{-- 🚀 JS Section: Cropper & Push Notification --}}
<!-- Push Notif -->
<script src="{{ asset('js/app/profile/push-notification.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new PushNotificationManager({
            toggleSelector: '#pushToggle',
            statusSelector: '#notif-status'
        });
    });
</script>
<!-- Cropper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LOGIKA CROPPER FOTO ---
        const input = document.getElementById('profile_photo');
        const previewImage = document.getElementById('preview');
        const imgProfile = document.querySelector('img[alt="Foto Profil"]');
        const cropModalElement = document.getElementById('cropModal');
        let cropModal;
        let cropper;

        // Cek jika elemen modal ada sebelum inisialisasi
        if (cropModalElement) {
            cropModal = new bootstrap.Modal(cropModalElement);
        }

        // Ketika user pilih file
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (event) => {
                previewImage.src = event.target.result;
                cropModal.show();

                // Hapus cropper lama jika ada
                if (cropper) cropper.destroy();

                // Inisialisasi cropper
                cropper = new Cropper(previewImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    movable: false,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        });

        // Ketika user klik simpan di modal crop    
        const cropButton = document.getElementById('cropButton');
        if(cropButton) {
            cropButton.addEventListener('click', () => {
                if (!cropper) return;
                
                const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
                // Ganti preview di halaman utama
                imgProfile.src = canvas.toDataURL('image/jpeg');
                // Convert hasil crop ke blob untuk dikirim ke server
                canvas.toBlob((blob) => {
                    const file = new File([blob], "cropped.jpg", { type: "image/jpeg" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;   // ubah input file jadi hasil crop
                });
                cropModal.hide();
            });
        }

        // ✅ Aktifkan semua toast otomatis
        document.querySelectorAll('.toast').forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
            toast.show();
        });
    });
</script>

<!-- ==================== -->
<!-- Script Confirm Toast -->
<!-- ==================== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('liveToast');

        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 9000
            });

            toast.show();
        }
    });
</script>
<!-- ======================= -->
<!-- EndScript Confirm Toast -->
<!-- ======================= -->