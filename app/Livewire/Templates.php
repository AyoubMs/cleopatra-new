<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Client;
use App\Models\Template;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Templates extends Component
{
    public $clients;
    public $selectedClient;
    public $templates;
    public $selectedTemplate;
    public $categories;
    public $selectedCategory;
    public $showCategories;
    public $showTemplates;
    public $showTemplate;

    public $fa_icons = [
        'Internet' => 'wifi',
        'Television' => 'tv',
        'Telephony' => 'mobile-screen',
        'Billing' => 'file-lines',
    ];

    #[On('openSidebar')]
    public function openSidebar()
    {
        $this->showTemplate = false;
        $this->showTemplates = false;
        $this->showCategories = true;
    }

    public function useTranslation()
    {
        $this->dispatch('useTemplate', $this->selectedTemplate['template_var']);
    }

    public function returnToTemplates()
    {
        $this->showTemplate = true;
    }

    public function selectTemplate($template)
    {
        $this->selectedTemplate = $template;
        $this->showTemplates = false;
        $this->showTemplate = true;
    }

    public function mount()
    {
        $this->selectedClient = Tenant::where('id', Auth::user()->tenant_id)->first();
        $this->templates = Template::where('tenant_id', Auth::user()->tenant_id)->get();
        $this->categories = Category::where('tenant_id', Auth::user()->tenant_id)->get();
        $this->showCategories = true;
        $this->showTemplates = false;
        $this->selectedTemplate = '';
    }

    public function returnToCategories()
    {
        $this->showCategories = true;
        $this->showTemplates = false;
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->templates = Template::where(['category_id' => $category['id']])->get();
        $this->showCategories = false;
        $this->showTemplates = true;
    }

    public function render()
    {
        return view('livewire.templates');
    }
}
