<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Validator;

class PaymentMethods extends Component
{
    public $paymentMethods;
    public $selectedMethods = [];

    public $types = [
        'card' => 'Tarjeta',
        'paypal' => 'PayPal',
        'bizum' => 'Bizum',
        'bank_transfer' => 'Transferencia Bancaria',
    ];

    public $newMethod = [
        'type' => '',
        'provider' => '',
        'expiration_date' => '',
        'is_default' => false,
        'account_name' => '',
        'account_number' => '',
    ];
    public $showAddForm = false;

    public $confirmingDelete = null;

    public function confirmDelete($id)
{
    $method = $this->paymentMethods->find($id) ?? \App\Models\PaymentMethod::find($id);
    if ($method) {
        $method->delete();
        $this->paymentMethods = $this->paymentMethods->where('id', '!=', $id);
        session()->flash('message', 'Método de pago eliminado correctamente.');
    }
    $this->confirmingDelete = null;
}

    public function addMethod()
    {
        $this->validate([
            'newMethod.type' => 'required|string',
            'newMethod.provider' => 'required|string|max:255',
            'newMethod.expiration_date' => 'required|date',
            'newMethod.is_default' => 'boolean',
            'newMethod.account_name' => 'required|string|max:255',
            'newMethod.account_number' => 'required|string|max:50',
        ]);

        $data = $this->newMethod;
        $data['user_id'] = Auth::id();

        if (!empty($data['is_default'])) {
            PaymentMethod::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        PaymentMethod::create($data);

        $this->reset('newMethod', 'showAddForm');
        $this->paymentMethods = Auth::user()->paymentMethods()->get();

        session()->flash('message', 'Método de pago añadido correctamente.');
    }



    public function mount()
    {
        $this->paymentMethods = Auth::user()->paymentMethods()->get();
    }

    public function deleteMethod($methodId)
    {
        $method = PaymentMethod::findOrFail($methodId);
        $method->delete();

        $this->paymentMethods = Auth::user()->paymentMethods()->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.payment-methods', [
            'paymentMethods' => $this->paymentMethods,
            'types' => $this->types,
            'confirmingDelete' => $this->confirmingDelete ?? null,
        ]);
    }
}
