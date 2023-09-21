<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TenantComponent extends Component
{
    public $tenant;
    public $selectedTenant;
    public $tenants;

    public function mount()
    {
        $this->tenant = '';
        $this->tenants = Tenant::all();
    }

    public function setTenant($tenant)
    {
        $this->selectedTenant = $tenant;
        if (is_null(Auth::user()->currentTeam())) {
            $team = Team::forceCreate([
                'user_id' => Auth::user()->id,
                'name' => explode(' ', Auth::user()->name, 2)[0] . "'s Team",
                'personal_team' => true
            ]);
        }
        Auth::user()->tenant_id = $tenant;
        Auth::user()->save();
        return redirect('dashboard');
    }

    public function render()
    {
        return view('livewire.tenant-component');
    }
}
