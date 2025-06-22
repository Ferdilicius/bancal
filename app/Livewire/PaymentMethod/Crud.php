<?php

namespace App\Livewire\PaymentMethod;

use Livewire\Component;
use App\Models\PaymentMethod;

class Crud extends Component
{
    public $paymentMethodId;
    public $name = '';
    public $type = '';
    public $details = '';
    public $status = 'active';

    public function mount($paymentMethodId = null)
    {
        $this->paymentMethodId = $paymentMethodId;

        if ($paymentMethodId) {
            // Cargar datos del método de pago existente
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($paymentMethodId);
            $this->name = $paymentMethod->name;
            $this->type = $paymentMethod->type;
            $this->details = $paymentMethod->details;
            $this->status = $paymentMethod->status;
        }
    }

    public function updated($property) {}

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'details' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($this->paymentMethodId) {
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($this->paymentMethodId);
        } else {
            $paymentMethod = new \App\Models\PaymentMethod();
        }

        $paymentMethod->name = $this->name;
        $paymentMethod->type = $this->type;
        $paymentMethod->details = $this->details;
        $paymentMethod->status = $this->status;
        $paymentMethod->save();

        session()->flash('success', 'Método de pago guardado correctamente.');

        return redirect()->route('private.profile');
    }

    public function delete()
    {
        if ($this->paymentMethodId) {
            PaymentMethod::findOrFail($this->paymentMethodId)->delete();
        }

        return redirect()->route('private.profile');
    }

    public function render()
    {
        return view('livewire.payment-method.crud')->layout('layouts.app');
    }
}
