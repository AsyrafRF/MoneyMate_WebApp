class ModalQueue {
    constructor() {
        this.queue = [];
        this.active = false;
    }

    show(modalId) {
        this.queue.push(modalId);
        this.process();
    }

    process() {
        if (this.active || this.queue.length === 0) return;

        this.active = true;

        const modalEl = document.getElementById(this.queue.shift());
        const modal = new bootstrap.Modal(modalEl);

        modal.show();

        modalEl.addEventListener('hidden.bs.modal', () => {
            this.active = false;
            this.process();
        }, { once: true });
    }
}

window.modalQueue = new ModalQueue();