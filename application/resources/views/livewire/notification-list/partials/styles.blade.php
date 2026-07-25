{{-- ================= CSS ================= --}}
@push('styles')
<style>
/* Switch toggle */
.switch {
    position: relative;
    width: 52px;
    height: 28px;
    display: inline-block;
}
.switch input { display: none; }
.slider {
    position: absolute;
    inset: 0;
    cursor: pointer;
    background: #ccc;
    transition: .4s;
    border-radius: 34px;
}
.slider:before {
    content: "";
    position: absolute;
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: .4s;
    border-radius: 50%;
}
input:checked + .slider:before {
    transform: translateX(24px);
}
.opacity-75 {
    opacity: .7;
}
.card-body {
    background: #E7EDF1;
}
.switch input:checked + .slider {
    background-color: #198754;
}
.switch .slider:before {
    background-color: white;
}
.new-notif {
    animation: flashNotif .8s ease;
}
@keyframes flashNotif {
    from { background-color: #d1e7dd; }
    to { background-color: #E7EDF1; }
}
/* Mobile view */
@media (max-width: 576px) {
    .notif-card {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 6px;
    }
    .notif-badge {
        order: 1;
        margin-bottom: 4px;
        justify-content: flex-start;
    }
    .notif-badge span {
        font-size: 11px;
        padding: 4px 8px;
    }
    .notif-date {
        order: 2;
        font-size: 12px;
        margin-bottom: 6px;
    }
    .notif-content {
        order: 3;
    }
}
</style>
@endpush