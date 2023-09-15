<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <script defer src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://kit.fontawesome.com/2d9d6c4361.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">

    <style>
        dialog::backdrop {
            background: red;
        }

        .top-100 {
            top: 100%
        }

        .bottom-100 {
            bottom: 100%
        }

        .max-h-select {
            max-height: 300px;
        }
    </style>

    <!-- Styles -->
    @livewireStyles
</head>
<body x-data="{ open: false }" class="font-sans antialiased bg-gray-100">
<x-banner/>

<div class="min-h-screen bg-gray-100 flex">
    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="mx-auto grid justify-center items-center">
        {{ $slot }}
    </main>
</div>

@stack('modals')

@livewireScripts
<script>
    async function useTranslation() {
        await triggerEvent('useTranslation', [])
    }

    async function templateAndTemplates() {
        await triggerEvent('templateAndTemplates', [])
    }

    async function categoriesAndTemplates() {
        await triggerEvent('categoriesAndTemplates', [])
    }

    async function selectCategory(category) {
        await triggerEvent('selectCategory', [category])
    }

    async function openLanguages() {
        await triggerEvent('openLanguages', [])
    }

    async function selectTemplate(template, language = '') {
        await triggerEvent('selectTemplate', [template, language])
    }

    async function selectLanguage(language, index) {
        await triggerEvent('selectLanguage', [language, index]);
    }

    async function removeLanguage(language) {
        await triggerEvent('removeLanguage', [language]);
    }

    async function triggerEvent(eventName, details) {
        try {
            window.dispatchEvent(new CustomEvent(eventName, {
                detail: [...details]
            }))
        } catch (err) {
            console.error('Failed the event: ', err)
        }
    }

    async function copyToClipboard(id) {
        const text = document.getElementById(id).innerText;
        try {
            await navigator.clipboard.writeText(text);
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    }

    async function readFromClipboard(id) {
        let text;
        try {
            text = await navigator.clipboard.readText();
            window.dispatchEvent(new CustomEvent('paste', {
                detail: [id, text]
            }))
            document.getElementById(id).focus();
            document.getElementById(id).value = text;
        } catch (err) {
            console.error('Failed to paste: ', err)
        }
    }

    function useTemplate() {
        document.getElementById('inverseText').value = document.getElementById('selectedTemplate').innerText
    }
</script>
</body>
</html>
