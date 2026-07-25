document.addEventListener("livewire:init", () => {
    Livewire.on("open-detail-modal", () => {
        var myModal = new bootstrap.Modal(
            document.getElementById("notifDetailModal"),
        );
        myModal.show();
    });
});
