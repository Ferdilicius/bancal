<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use App\Models\PaymentMethod;

class PaymentMethods extends Component
{
    public $paymentMethods;

    public function mount()
    {
        $this->paymentMethods = PaymentMethod::all();
    }

    public function deletePaymentMethod($id)
    {
        PaymentMethod::findOrFail($id)->delete();
        $this->paymentMethods = PaymentMethod::all();
    }

    public function render()
    {
        return view('livewire.private.tabs.payment-methods', [
            'paymentMethods' => $this->paymentMethods,
        ]);
    }
}