document.getElementById('loadingBtn').addEventListener('click', function(e) {
    this.classList.add('disabled');
    this.style.pointerEvents = 'none';
    this.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Loading...
    `;
});