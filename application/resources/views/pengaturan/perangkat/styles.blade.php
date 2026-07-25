{{-- Custom Style --}}
<style>
    body {
        background: #f5f7fb;
    }

    .device-card {
        transition: all 0.25s ease;
    }

    .device-card:hover {
        transform: translateY(-4px);
    }

    .device-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);
    }

    .device-info {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .info-item:not(:last-child) {
        border-bottom: 1px dashed #dbe3ef;
    }

    .label {
        color: #64748b;
        font-size: 14px;
    }

    .value {
        color: #0f172a;
        font-weight: 600;
        font-size: 14px;
    }

    .bg-success-subtle {
        background: rgba(34, 197, 94, 0.12);
    }

    @media (max-width: 768px) {
        .device-icon {
            width: 50px;
            height: 50px;
            font-size: 22px;
        }
    }
</style>