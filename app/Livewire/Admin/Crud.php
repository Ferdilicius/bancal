<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;


class Crud extends Component
{

    public string $section;
    public $data;
    public $form = [];
    public $editingId = null;
    public $isEditing = false;

    protected $rules = [];

    public function updatedSection()
    {
        $this->resetForm();
        $this->loadData();
    }

    public function mount()
    {
        $this->section = request()->get('section', 'users');
        $this->loadData();
    }


    public function loadData()
    {
        switch ($this->section) {
            case 'users':
                $this->data = User::all();
                break;
            case 'products':
                $this->data = Product::all();
                break;
            case 'addresses':
                $this->data = Address::all();
                break;
            default:
                $this->data = [];
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $this->isEditing = true;

        switch ($this->section) {
            case 'users':
                $user = User::findOrFail($id);
                $this->form = $user->toArray();
                break;
            case 'products':
                $product = Product::findOrFail($id);
                $this->form = $product->toArray();
                break;
            case 'addresses':
                $address = Address::findOrFail($id);
                $this->form = $address->toArray();
                break;
        }
    }

    public function save()
    {
        switch ($this->section) {
            case 'users':
                $data = $this->validate([
                    'form.name' => 'required|string',
                    'form.email' => 'required|email',
                    'form.password' => $this->editingId ? 'nullable|string|min:6' : 'required|string|min:6',
                    'form.user_type' => 'required|in:admin,particular,empresa',
                ])['form'];

                // Asegurarse de que user_type solo sea uno de los permitidos
                $allowedTypes = ['admin', 'particular', 'empresa'];
                if (!in_array($data['user_type'], $allowedTypes)) {
                    throw new \Exception('Tipo de usuario no válido.');
                }

                if ($this->editingId) {
                    $user = User::findOrFail($this->editingId);
                    $user->user_type = $data['user_type'];
                    $user->name = $data['name'];
                    $user->email = $data['email'];
                    if (!empty($data['password'])) {
                        $user->password = bcrypt($data['password']);
                    }
                    $user->save();
                } else {
                    $data['password'] = bcrypt($data['password']);
                    User::create($data);
                }
                break;

            case 'products':
                $data = $this->validate([
                    'form.name' => 'required|string',
                    'form.price' => 'required|numeric',
                    'form.description' => 'required|string',
                    'form.quantity' => 'required|integer',
                    'form.status' => 'required|string',
                    'form.category_id' => 'required|integer',
                    'form.quantity_type' => 'required|string',
                    'form.user_id' => 'required|string|exists:users,id',
                ])['form'];


                if ($this->editingId) {
                    Product::findOrFail($this->editingId)->update($data);
                } else {
                    Product::create($data);
                }
                break;

            case 'addresses':
                $data = $this->validate([
                    'form.name' => 'required|string',
                    'form.address' => 'required|string',
                    'form.user_id' => 'required|string|exists:users,id',
                    'form.address_type_id' => 'required|integer|exists:address_types,id',
                    'form.status' => 'required|in:activo,inactivo',
                ])['form'];

                $this->editingId
                    ? Address::findOrFail($this->editingId)->update($data)
                    : Address::create($data);
                break;
        }

        $this->resetForm();
        $this->loadData();
    }

    public function resetForm()
    {
        $this->form = [];
        $this->editingId = null;
        $this->isEditing = false;
    }

    public function delete($id)
    {
        switch ($this->section) {
            case 'users':
                User::findOrFail($id)->delete();
                break;
            case 'products':
                Product::findOrFail($id)->delete();
                break;
            case 'addresses':
                Address::findOrFail($id)->delete();
                break;
        }
        $this->loadData();
    }


    public function render()
    {
        return view('livewire.admin.crud', [
            'data' => $this->data,
            'section' => $this->section,
        ])->layout('layouts.app');
    }
}
