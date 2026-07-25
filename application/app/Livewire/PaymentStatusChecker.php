<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PremiumTransaction;
use Livewire\Attributes\Layout;

class PaymentStatusChecker extends Component
{
    public $transactionId;

    public function mount($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function render()
    {
        $transaction = PremiumTransaction::where('id', $this->transactionId)
            ->where('user_id', auth()->id()) // Hanya pemilik yang bisa akses
            ->firstOrFail();

        return view('livewire.payment-status-checker', [
            'transaction' => $transaction
        ])
        ->layout('layouts.app')
        ->title('Payment Status');
    }
}