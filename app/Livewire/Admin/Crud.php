<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\Payment;

use App\Models\ProductCategory;
use App\Models\Order;


class Crud extends Component
{
    public string $modelClass;
    public string $section;
    public $data;
    public $form = [];
    public $editingId = null;
    public $isEditing = false;
    public array $fillable = [];
    public array $validationRules = [];

    public $confirmingDeleteId = null;

    public function mount()
    {
        $this->section = request()->get('section', 'users');

        $this->modelClass = $this->getModelClassBySection($this->section);

        $this->fillable = $this->getFillableFromModel();

        $this->validationRules = $this->generateValidationRules();

        $this->loadData();
    }

    protected function getModelClassBySection(string $section): ?string
    {
        $map = [
            'users' => User::class,
            'products' => Product::class,
            'product_categories' => ProductCategory::class,
            'addresses' => Address::class,
            'address_types' => AddressType::class,
            'orders' => Order::class, // Assuming you have an Order model
            'payments' => Payment::class,
            'payments_types' => Payment::class, // Assuming you have a Payment model with types
        ];

        return $map[$section] ?? null;
    }

    protected function getFillableFromModel(): array
    {
        if (!$this->modelClass) return [];

        /** @var Model $model */
        $model = new $this->modelClass;

        return $model->getFillable();
    }

    protected function generateValidationRules(): array
    {
        $rules = [];
        foreach ($this->fillable as $field) {

            $rules["form.$field"] = $this->editingId ? 'nullable|string' : 'required|string';
        }

        if (in_array('email', $this->fillable)) {
            $rules['form.email'] = $this->editingId ? 'nullable|email' : 'required|email|unique:' . $this->getTableName() . ',email' . ($this->editingId ? ',' . $this->editingId : '');
        }

        if (in_array('password', $this->fillable)) {
            $rules['form.password'] = $this->editingId ? 'nullable|string|min:6' : 'required|string|min:6';
        }

        return $rules;
    }

    protected function getTableName(): string
    {
        /** @var Model $model */
        $model = new $this->modelClass;
        return $model->getTable();
    }

    public function loadData()
    {
        if (!$this->modelClass) {
            $this->data = collect();
            return;
        }
        $this->data = ($this->modelClass)::all();
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

        $record = ($this->modelClass)::findOrFail($id);

        $this->form = $record->only($this->fillable);

        if (isset($this->form['password'])) {
            $this->form['password'] = null;
        }
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function delete()
    {
        if ($this->confirmingDeleteId) {
            $record = ($this->modelClass)::findOrFail($this->confirmingDeleteId);
            $record->delete();
            $this->confirmingDeleteId = null;
            $this->loadData();
        }
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    public function save()
    {
        $validated = $this->validate($this->validationRules)['form'];

        /** @var Model $model */
        $model = new $this->modelClass;

        if ($this->editingId) {
            $record = $model->findOrFail($this->editingId);

            // Si existe password, actualizar con bcrypt, sino eliminar del array para no modificar
            if (array_key_exists('password', $validated)) {
                if (!empty($validated['password'])) {
                    $validated['password'] = bcrypt($validated['password']);
                } else {
                    unset($validated['password']);
                }
            }

            $record->fill($validated);
            $record->save();
        } else {
            if (array_key_exists('password', $validated)) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $model->create($validated);
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

    public function render()
    {
        return view('livewire.admin.crud', [
            'data' => $this->data,
            'fillable' => $this->fillable,
            'section' => $this->section,
            'confirmingDeleteId' => $this->confirmingDeleteId,
        ])->layout('layouts.app');
    }
}
