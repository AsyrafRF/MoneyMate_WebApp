// Carousel - Slide
document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector('#moneyMateCarousel');
    if (carousel) {
        new bootstrap.Carousel(carousel, {
            interval: 4000,
            ride: 'carousel',
            pause: false,
            wrap: true
        });
    }
});

// Satistik Counter
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".counter");
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute("data-target");
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            updateCount();
        });
    };

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            animateCounters();
            observer.disconnect();
        }
    }, { threshold: 0.5 });

    const counterBox = document.querySelector(".counter-box");
    if (counterBox) {
        observer.observe(counterBox);
    }
});

// Login - Register Password Toggle & Validation
document.addEventListener('DOMContentLoaded', function () {

    // ====== TOGGLE PASSWORD VISIBILITY ======
    function toggleVisibility(input, button) {
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // Login toggle
    const loginPassword = document.getElementById('login_password');
    const toggleLoginPassword = document.getElementById('toggleLoginPassword');
    if (loginPassword && toggleLoginPassword)
        toggleLoginPassword.addEventListener('click', () => toggleVisibility(loginPassword, toggleLoginPassword));

    // Register toggle
    const registerPassword = document.getElementById('register_password');
    const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
    const confirmPassword = document.getElementById('register_password_confirmation');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    if (registerPassword && toggleRegisterPassword)
        toggleRegisterPassword.addEventListener('click', () => toggleVisibility(registerPassword, toggleRegisterPassword));
    if (confirmPassword && toggleConfirmPassword)
        toggleConfirmPassword.addEventListener('click', () => toggleVisibility(confirmPassword, toggleConfirmPassword));

    // ====== PASSWORD STRENGTH VALIDATION ======
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('strengthText');
    const matchMessage = document.getElementById('matchMessage');

    if (registerPassword) {
        registerPassword.addEventListener('input', function () {
            const value = registerPassword.value;
            let strength = 0;

            if (value.length >= 8) strength++;
            if (/[a-z]/.test(value)) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^A-Za-z0-9]/.test(value)) strength++;

            if (value.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.className = 'progress-bar bg-secondary';
                strengthText.textContent = '';
                return;
            }

            const percentage = (strength / 5) * 100;
            strengthBar.style.width = percentage + '%';

            if (strength <= 2) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Password lemah';
            } else if (strength === 3 || strength === 4) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Password cukup kuat';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Password sangat kuat';
            }
        });
    }

    // ====== PASSWORD MATCH VALIDATION ======
    if (confirmPassword && registerPassword) {
        confirmPassword.addEventListener('input', function () {
            if (confirmPassword.value === '') {
                matchMessage.textContent = '';
            } else if (confirmPassword.value === registerPassword.value) {
                matchMessage.textContent = 'Password cocok ✓';
                matchMessage.classList.remove('text-danger');
                matchMessage.classList.add('text-success');
            } else {
                matchMessage.textContent = 'Password tidak cocok ✗';
                matchMessage.classList.remove('text-success');
                matchMessage.classList.add('text-danger');
            }
        });
    }
});

// Script Zoom in modal preview bukti
document.addEventListener("DOMContentLoaded", () => {
    const previewImage = document.getElementById('previewBuktiImage');

    if (!previewImage) return;

    let isZoomed = false;
    let isDragging = false;
    let startX, startY, currentX = 0, currentY = 0;
    let clickCount = 0;
    let clickTimer = null;

    // ------------------
    //  CLICK HANDLING
    // ------------------
    previewImage.addEventListener('click', function () {
        clickCount++;

        if (clickCount === 1) {
            // tunggu sebentar untuk cek apakah double click
            clickTimer = setTimeout(() => {
                // SINGLE CLICK
                // Jika belum zoom → zoom
                if (!isZoomed) {
                    isZoomed = true;
                    previewImage.classList.add("zoomed");
                }
                // Jika sudah zoom → klik kedua mengaktifkan drag (tidak zoom out)
                else {
                    // aktifkan drag mode, tidak melakukan apapun,
                    // karena drag terjadi saat mouse/touch move
                }

                clickCount = 0;
            }, 250); // delay 250 ms untuk double-click detection
        } 
        
        else if (clickCount === 2) {
            // DOUBLE CLICK → Zoom Out
            clearTimeout(clickTimer);
            clickCount = 0;

            isZoomed = false;
            currentX = 0;
            currentY = 0;
            previewImage.classList.remove("zoomed");
            previewImage.style.transform = "scale(1)";
        }
    });

    // ------------------
    // DRAG / PAN HANDLING
    // ------------------
    const startDrag = (e) => {
        if (!isZoomed) return;

        isDragging = true;
        previewImage.classList.add('dragging');

        startX = e.pageX || e.touches[0].pageX;
        startY = e.pageY || e.touches[0].pageY;
    };

    const stopDrag = () => {
        isDragging = false;
        previewImage.classList.remove('dragging');
    };

    const onDrag = (e) => {
        if (!isDragging || !isZoomed) return;

        e.preventDefault();

        const x = e.pageX || e.touches[0].pageX;
        const y = e.pageY || e.touches[0].pageY;

        const dx = x - startX;
        const dy = y - startY;

        currentX += dx;
        currentY += dy;

        previewImage.style.transform =
            `scale(2) translate(${currentX / 2}px, ${currentY / 2}px)`;

        startX = x;
        startY = y;
    };

    previewImage.addEventListener("mousedown", startDrag);
    previewImage.addEventListener("touchstart", startDrag);
    document.addEventListener("mouseup", stopDrag);
    document.addEventListener("touchend", stopDrag);
    document.addEventListener("mousemove", onDrag);
    document.addEventListener("touchmove", onDrag);
});

// Toast Notification
document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('toastWarning');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
    }
});

// Script Nominal Currency Input
// document.addEventListener("input", function (e) {
//     if (!e.target.classList.contains("nominal")) return;

//     let value = e.target.value.replace(/\D/g, "");
//     e.target.value = formatRupiah(value);
// });

// Format ke angka murni ketika form disubmit
// document.addEventListener("submit", function (e) {
//     const nominalInputs = e.target.querySelectorAll(".nominal");

//     nominalInputs.forEach(input => {
//         input.value = input.value.replace(/\./g, ""); // hapus titik
//     });
// });

// function formatRupiah(angka) {
//     if (!angka) return "";
//     return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
// }

document.addEventListener("DOMContentLoaded", function () {

    // Delegation untuk input nominal
    document.addEventListener("input", function (e) {
        if (!e.target.classList.contains("nominal")) return;

        let input = e.target;

        // Ambil angka saja
        let angka = input.value.replace(/\D/g, "");

        // Animasi halus
        input.style.transition = "0.15s ease";

        // Format dengan prefix Rp
        input.value = angka ? "Rp " + formatRupiah(angka) : "";
    });

    // Saat submit → ubah kembali menjadi angka tanpa Rp & titik
    document.addEventListener("submit", function (e) {
        const inputs = e.target.querySelectorAll(".nominal");

        inputs.forEach(input => {
            input.value = input.value.replace(/\D/g, ""); // Hanya angka murni
        });
    });

});

// Fungsi pemisah ribuan
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}   