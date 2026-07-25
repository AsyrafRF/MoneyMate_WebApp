 <script>
document.addEventListener("DOMContentLoaded", function() {
    // In-page toast
    window.showInPageToast = function(notification) {
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-dark border-2 position-fixed bottom-0 end-0 m-3 rounded-3';
        toast.style.border = '2px solid #1B94D7';
        toast.innerHTML = `<div class="d-flex"><div class="toast-body">${notification.content}</div>
            <button type="button" class="btn-close btn-close-dark me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
        document.body.appendChild(toast);
        new bootstrap.Toast(toast, { delay: 55000 }).show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    };
});
</script>