<?php

namespace App\Livewire;

use App\Jobs\SendEmail;
use App\Mail\InviteUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UsersManagement extends Component
{
    use WithPagination;
    public $searchTerm = "";
    public $sortField;
    public $sortAsc = true;
    public $edit = false;
    public $create = false;
    public $selectedRole = 3;
    public $selectedEmail;
    public $selectedName;
    public $roles;
    public $error;
    protected $queryString = ['searchTerm', 'sortAsc'];

    public function mount()
    {
        $this->roles = Role::query()->get();
    }

    public function createAndInviteUser()
    {
        if (User::query()->where('email', $this->selectedEmail)->first() === null) {
            $user = User::create(['name' => $this->selectedName, 'email' => $this->selectedEmail, 'tenant_id' => Auth::user()->tenant->id]);
            $user->role_id = $this->selectedRole;
            $user->tenant_id = Auth::user()->tenant->id;
            $user->save();
            $this->create = false;
            dispatch(new SendEmail($this->selectedEmail, Auth::user()->tenant->name));
        } else {
            $this->error = 'User already exist!';
        }
    }

    public function updateUser()
    {
        $user = User::query()->where('email', $this->selectedEmail)->first();
        $user->role_id = $this->selectedRole;
        $user->save();
        $this->edit = false;
    }

    public function cancel()
    {
        if($this->edit === true) {
            $this->edit = false;
        } elseif ($this->create === true) {
            $this->create = false;
        }
    }

    #[On('editUser')]
    public function editUser($user)
    {
        $this->edit = true;
        $this->selectedEmail = $user['email'];
        $this->selectedName = $user['name'];
        $this->selectedRole = $user['role_id'];
    }

    #[On('createUser')]
    public function createUser()
    {
        $this->create = true;
        $this->selectedEmail = "";
        $this->selectedName = "";
        $this->selectedRole = 3;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = [];
        if (Auth::user()->role->name === 'supervisor') {
            $users = User::where(function($query) {
                $query->where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('email', 'like', '%'.$this->searchTerm.'%');
            })->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc')->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })->paginate(10);
        } else {
            $users = User::where(function($query) {
                $query->where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('email', 'like', '%'.$this->searchTerm.'%');
            })->orderBy('created_at', 'desc')->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })->paginate(10);
        }

        return view('livewire.users-management', ['users' => $users]);
    }
}
