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
    public $search;

    public $fa_icons = [
        'Internet' => 'wifi',
        'Television' => 'tv',
        'Telephony' => 'mobile-screen',
        'Billing' => 'file-lines',
    ];

    #[On('openSidebar')]
    public function openSidebar()
    {
        $this->mount();
    }

    #[On('useTranslation')]
    public function useTranslation()
    {
        $this->dispatch('useTemplate', $this->selectedTemplate['template_var']);
        $this->templateAndTemplates(false, false);
        $this->categoriesAndTemplates();
    }

    #[On('templateAndTemplates')]
    public function templateAndTemplates($showTemplate = false, $showTemplates = true)
    {
        $this->showTemplate = $showTemplate;
        $this->showTemplates = $showTemplates;
    }

    #[On('selectTemplateTemplates')]
    public function selectTemplate($template)
    {
        $this->selectedTemplate = $template;
        $this->templateAndTemplates(true, false);
        $this->categoriesAndTemplates(false);
        $this->search = '';
        $this->selectedCategory = Category::where('id', $template['category_id'])->first();
    }

    public function mount()
    {
        $this->selectedClient = Tenant::where('id', Auth::user()->tenant_id)->first();
        $this->templates = Template::query()->select('id', 'template_var', 'category_id', 'title')->with('tenant')->where('tenant_id', Auth::user()->tenant_id)->get();
        $this->categories = Category::query()->with('tenant')->where('tenant_id', Auth::user()->tenant_id)->get();
        $this->categoriesAndTemplates();
        $this->selectedTemplate = '';
    }

    #[On('categoriesAndTemplates')]
    public function categoriesAndTemplates($showCategories = true, $showTemplates = false)
    {
        $this->showCategories = $showCategories;
        $this->showTemplates = $showTemplates;
    }

    #[On('selectCategory')]
    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->templates = Template::with('tenant')->where(['category_id' => $category['id']])->get();
        $this->categoriesAndTemplates(false, true);
    }

    public function render()
    {
        $searchedTemplates = Template::where(function($query) {
            $query->where('title', 'like', '%'.$this->search.'%')->orWhere('template_var', 'like', '%'.$this->search.'%');
        })->orderBy('created_at', 'desc')->get();

        return view('livewire.templates', ['searchedTemplates' => $searchedTemplates]);
    }
}
