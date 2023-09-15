<?php

namespace App\Livewire;

use App\Models\Template;
use DeepL\Translator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\On;
use Livewire\Component;

class TranslationComponent extends Component
{
    public $firstText;
    public $translatedText;

    public $language = 'none';
    public $detectedSourceLang;

    public $inverseText;
    public $inverseTranslatedText;
    public $errorMessage;

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

    public $targetLanguage = "EN-US";

    public $languageWidths = [
        'none' => 'w-40',
        'BG' => 'w-24',
        'CS' => 'w-20',
        'DA' => 'w-20',
        'DE' => 'w-24',
        'EL' => 'w-20',
        'EN-US' => 'w-24',
        'ES' => 'w-24',
        'ET' => 'w-24',
        'FI' => 'w-20',
        'FR' => 'w-20',
        'HU' => 'w-28',
        'ID' => 'w-28',
        'IT' => 'w-20',
        'JA' => 'w-24',
        'KO' => 'w-20',
        'LT' => 'w-28',
        'LV' => 'w-20',
        'NB' => 'w-44',
        'NL' => 'w-20',
        'PL' => 'w-20',
        'PT' => 'w-[22rem]',
        'RO' => 'w-28',
        'RU' => 'w-24',
        'SK' => 'w-20',
        'SL' => 'w-24',
        'SV' => 'w-24',
        'TR' => 'w-20',
        'UK' => 'w-24',
        'ZH' => 'w-24',
    ];
    public $languageWidthsDetected = [
        'none' => 'w-36',
        'BG' => 'w-44',
        'CS' => 'w-40',
        'DA' => 'w-40',
        'DE' => 'w-40',
        'EL' => 'w-40',
        'EN-US' => 'w-40',
        'ES' => 'w-40',
        'ET' => 'w-40',
        'FI' => 'w-40',
        'FR' => 'w-40',
        'HU' => 'w-44',
        'ID' => 'w-44',
        'IT' => 'w-36',
        'JA' => 'w-44',
        'KO' => 'w-40',
        'LT' => 'w-44',
        'LV' => 'w-40',
        'NB' => 'w-48',
        'NL' => 'w-40',
        'PL' => 'w-40',
        'PT' => 'w-54',
        'RO' => 'w-44',
        'RU' => 'w-40',
        'SK' => 'w-40',
        'SL' => 'w-40',
        'SV' => 'w-40',
        'TR' => 'w-40',
        'UK' => 'w-44',
        'ZH' => 'w-40',
    ];
    public $templates;

    public function mount($property = '', $template = '')
    {
        $this->fill(["inverseText" => $property === 'inverseText' ? $template : '', "firstText" => $property === 'firstText' ? $template : '']);
        $this->templates = Template::query()->where('tenant_id', Auth::user()->tenant_id)->get();
    }



    public function chooseATemplate()
    {
        $this->dispatch('openSidebar');
    }

    #[On('paste')]
    public function pasteFromClipboard($prop = '', $text = '')
    {
        $this->mount($prop, $text);
        if ($prop === 'inverseText') {
            $this->translateInverse();
        } else if ($prop === 'firstText') {
            $this->translate();
        }
    }

    #[On('useTemplate')]
    public function useTemplate($template)
    {
        $this->mount('inverseText', $template);
        $this->translateInverse();
    }

    public function translation($valueFromRedis, $valueSetRedis, $inverse = false)
    {
        if ($valueFromRedis) {
            $this->setPropertiesFromApi($valueFromRedis, $inverse);
            return;
        }
        $result = $this->queryDeeplAPI($inverse);
        if (gettype($result) === "string") {
            $this->errorMessage = "Please select a language";
            return;
        };
        $userTranslation = [
            'translatedText' => $result->text,
            'detectedSourceLang' => $result->detectedSourceLang,
            'selectedSourceLang' => $inverse ? $this->targetLanguage : $this->language
        ];
        Redis::hmset("$valueSetRedis", $userTranslation);
        $this->setPropertiesFromApi($userTranslation, $inverse);
    }

    public function translateInverse()
    {
        $inverseTargetLang = $this->language === 'none' ? $this->detectedSourceLang : $this->language;
        $this->translation(Redis::hgetall("$this->inverseText.$inverseTargetLang") , $this->inverseText.$inverseTargetLang, true);
    }

    public function translate($inverse = false)
    {
        if ($inverse) {
            $this->translateInverse();
            return;
        }
        foreach ($this->templates as $template) {
            foreach (json_decode($template->translations) as $translation) {
                if ($translation->lang === $this->lang_codes[$this->targetLanguage] && $template->template_var === $this->firstText) {
                    $api = [
                        'translatedText' => $translation->trans,
                        'detectedSourceLang' => $translation->lang,
                        'selectectedSourceLang' => $this->language
                    ];
                    $this->setPropertiesFromApi($api);
                    return;
                }
            }
        }
        $this->translation(Redis::hgetall("$this->firstText.$this->targetLanguage"), $this->firstText.$this->targetLanguage);
    }

    public function setPropertiesFromApi($api, $inverse = false)
    {
        if (!$inverse) {
            $this->translatedText = $api['translatedText'];
            $this->detectedSourceLang = strtoupper($api['detectedSourceLang']) === 'EN' ? 'EN-US' : strtoupper($api['detectedSourceLang']);
            $this->language = $api['selectedSourceLang'] === 'none' ? 'none' : strtoupper($api['selectedSourceLang']);
        } else {
            $this->inverseTranslatedText = $api['translatedText'];
        }
    }

    public function queryDeeplAPI($inverse = false)
    {
        try {
            $authKey = env('DEEPL_API_KEY');
            $translator = new Translator($authKey);
            if ($inverse) {
                $sourceLang = null;
            } else {
                $sourceLang = $this->language === 'none' ? null : $this->language;
            }
            return $translator->translateText($inverse ? $this->inverseText : $this->firstText, $sourceLang, !$inverse ? strtolower($this->targetLanguage) : strtolower($this->language));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.translation-component')->withLanguage($this->language);
    }
}
