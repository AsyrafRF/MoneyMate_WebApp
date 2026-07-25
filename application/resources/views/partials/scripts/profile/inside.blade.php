<!-- ===================== -->
<!-- Script Ganti Password -->
<!-- ===================== -->
{{-- Toggle Show/Hide Password --}}
<script>
document.getElementById('toggleRegisterPassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('new_password');
    const icon = this.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}); 
document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('new_password_confirmation');
    const icon = this.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});
</script>

{{-- ✅ VALIDASI FRONTEND --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const saveBtn = document.getElementById('savePasswordBtn');
    const passwordError = document.getElementById('passwordError');
    const matchMessage = document.getElementById('matchMessage');
    const strengthBar = document.getElementById('passwordStrengthBar');

    function validatePassword() {
        const value = newPassword.value;
        const confirm = confirmPassword.value;

        const rules = {
            min: value.length >= 8,
            lowercase: /[a-z]/.test(value),
            uppercase: /[A-Z]/.test(value),
            number: /\d/.test(value),
            symbol: /[\W_]/.test(value)
        };

        let valid = Object.values(rules).every(Boolean);
        let message = "";

        if (!rules.min) message = "Minimal 8 karakter.";
        else if (!rules.lowercase) message = "Harus mengandung huruf kecil.";
        else if (!rules.uppercase) message = "Harus mengandung huruf besar.";
        else if (!rules.number) message = "Harus mengandung angka.";
        else if (!rules.symbol) message = "Harus mengandung simbol.";

        // Update bar
        const strength = Object.values(rules).filter(Boolean).length * 20;
        strengthBar.style.width = strength + "%";
        strengthBar.className = "progress-bar";
        strengthBar.classList.add(
            strength < 40 ? "bg-danger" :
            strength < 80 ? "bg-warning" :
            "bg-success"
        );

        passwordError.textContent = message;

        // Konfirmasi password
        if (confirm && value !== confirm) {
            matchMessage.textContent = "Konfirmasi password tidak cocok.";
        } else {
            matchMessage.textContent = "";
        }

        // Aktifkan tombol jika semua valid
        if (valid && value === confirm && value !== "" && confirm !== "") {
            saveBtn.disabled = false;
        } else {
            saveBtn.disabled = true;
        }
    }

    newPassword.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Jika user baru saja konfirmasi password, langsung buka modal
        @if (session('showPasswordModal'))
            const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
        @endif
    });
</script>
<!-- ======================== -->
<!-- EndScript Ganti Password -->
<!-- ======================== -->
