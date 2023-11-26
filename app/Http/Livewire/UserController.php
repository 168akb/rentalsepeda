<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use App\Level;

class UserController extends Component
{

	public $email, $name, $level_id, $active;

    public function render()
    {
    	$this->users = User::all();
        return view('livewire.user.user');
    }
}
