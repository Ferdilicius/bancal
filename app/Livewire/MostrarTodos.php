<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;
use App\Models\UserType;
use App\Models\Product;

class MostrarTodos extends Component
{ 
    public function render()
    {
        return view('livewire.mostrar-todos', [
            'users' => User::all(),
            'user_types' => UserType::all(),
            'products' => Product::all(),
        ]);
    }
}
