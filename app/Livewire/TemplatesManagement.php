<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Template;
use App\Models\Tenant;
use DeepL\Translator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\On;
use Livewire\Component;
use stdClass;

class TemplatesManagement extends Component
{
    public $tenants;
    public $selectedTenant;
    public $templates;
    public $selectedTemplate;
    public $templateTitle;
    public $templateBody;
    public $create = false;

    public $lang_codes = [
        "BG" => "Bulgarian",
        "CS" => "Czech",
        "DA" => "Danish",
        "DE" => "German",
        "EL" => "Greek",
        "EN-US" => "English",
        "ES" => "Spanish",
        "ET" => "Estonian",
        "FI" => "Finnish",
        "FR" => "French",
        "HU" => "Hungarian",
        "ID" => "Indonesian",
        "IT" => "Italian",
        "JA" => "Japanese",
        "KO" => "Korean",
        "LT" => "Lithuanian",
        "LV" => "Latvian",
        "NB" => "Norwegian (Bokmål)",
        "NL" => "Dutch",
        "PL" => "Polish",
        "PT" => "Portuguese (all Portuguese varieties mixed)",
        "RO" => "Romanian",
        "RU" => "Russian",
        "SK" => "Slovak",
        "SL" => "Slovenian",
        "SV" => "Swedish",
        "TR" => "Turkish",
        "UK" => "Ukrainian",
        "ZH" => "Chinese"
    ];
    public $categories;
    public $selectedCategory = 1;
    public $languages;
    public $language;
    public $openLanguagesDropdown = false;
    public $templatesLanguage;
    public $translation = false;

    public function mount($create = false, $title = '', $template = '', $selectedTemplate = null)
    {
        $this->fill(['selectedTemplate' => $selectedTemplate, 'templateTitle' => $title, 'templateBody' => $template, 'create' => $create]);
        $this->selectedTenant = Auth::user()->tenant_id;
        $this->tenants = Tenant::all();
        $this->templates = Template::query()->with('tenant')->where('tenant_id', $this->selectedTenant)->get();
        $this->categories = Category::query()->with('tenant')->where('tenant_id', $this->selectedTenant)->get();
        $this->templatesLanguage = Tenant::query()->select('templates_lang')->where('id', $this->selectedTenant)->first()->templates_lang;
        $this->languages = json_decode(Tenant::query()->where('id', $this->selectedTenant)->first()->supported_langs);
    }

    public function addLanguagesToTenant()
    {
        $tenant = Tenant::query()->where('id', $this->selectedTenant)->first();
        $tenant->supported_langs = json_encode($this->languages, JSON_FORCE_OBJECT);
        $tenant->save();
    }

    #[On('removeLanguage')]
    public function removeLanguage($language = '')
    {
        unset($this->languages->$language);
        $this->addLanguagesToTenant();
    }

    #[On('selectLanguage')]
    public function selectLanguage($language = '', $index = 0)
    {
        if($this->languages === null) {
            $this->languages = (object) [];
        }
        $this->languages->$index = $language;
        $this->addLanguagesToTenant();
        $obj = $this->createObject($language, "");
        foreach ($this->templates as $template) {
            $templateFromDB = Template::query()->with('tenant')->where('id', $template->id)->first();
            if(json_decode($template->translations) === null) {
                $templateFromDB->translations = json_encode([$obj]);
                $templateFromDB->save();
            } elseif (json_decode($template->translations) !== null) {
                $translations = json_decode($template->translations);
                foreach ($translations as $translation) {
                    if ($translation->lang === $language) {
                        return;
                    }
                }
                $translations[] = $obj;
                $templateFromDB->translations = $translations;
                $templateFromDB->save();
            }
        }
    }

    #[On('openLanguages')]
    public function openLanguages()
    {
        $this->openLanguagesDropdown = ! $this->openLanguagesDropdown;
    }

    public function createTemplate()
    {
        if (!$this->create) {
            $this->mount(true);
        }
        if ($this->templateTitle !== '') {
            $template = Template::create([
                'title' => $this->templateTitle,
                'template_var' => $this->templateBody,
                'tenant_id' => $this->selectedTenant,
                'category_id' => $this->selectedCategory
            ]);
            $template->save();
            $this->mount();
        }
    }

    public function cancel()
    {
        $this->mount();
        $this->translation = false;
    }

    public function updateTranslation()
    {
        $this->update(true);
        $this->translation = false;
    }

    public function update($translation = false)
    {
        $template = Template::query()->with('tenant')->where('id', $this->selectedTemplate['id'])->first();
        if (!$translation) {
            $template->title = $this->templateTitle;
            $template->template_var = $this->templateBody;
        } elseif ($translation) {
            $translations = json_decode($template->translations);
            foreach ($translations as $translation) {
                if ($translation->lang === $this->language) {
                    $obj = $this->createObject($this->language, $this->templateBody);
                    $translations = array_filter($translations, function($value, $key) {
                        return $value->lang !== $this->language;
                    }, ARRAY_FILTER_USE_BOTH);
                    $translations[] = $obj;
                    $template->translations = json_encode($translations);
                }
            }
        }
        $template->save();
        $this->mount();
    }

    #[On('selectTemplate')]
    public function selectTemplate($template, $language = '')
    {
        $this->selectedTemplate = $template;
        if ($language !== '') {
            foreach (json_decode($template['translations']) as $translation) {
                if ($translation->lang === $language) {
                    $this->translation = true;
                    $this->language = $language;
                    $this->mount(false, '', $translation->trans, $template);
                    return;
                }
            }
        }
        $this->mount(false, $template['title'], $template['template_var'], $this->selectedTemplate);
    }

    public function createObject($lang, $trans)
    {
        $obj = new StdClass();
        $obj->lang = $lang;
        $obj->trans = $trans;
        return $obj;
    }

    public function render()
    {
        return view('livewire.templates-management');
    }
}
