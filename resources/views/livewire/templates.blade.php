<div>
    @if($showCategories)
        <x-categories :selectedClient="$selectedClient" :categories="$categories" :fa_icons="$fa_icons" :templates="$templates"/>
    @elseif($showTemplates)
        <x-categories-list :categories="$categories" :fa_icons="$fa_icons" :templates="$templates" :selectedClient="$selectedClient" :selectedCategory="$selectedCategory"/>
    @elseif($showTemplate)
        <x-template :categories="$categories" :fa_icons="$fa_icons" :templates="$templates" :selectedCategory="$selectedCategory" :selectedTemplate="$selectedTemplate"/>
    @endif
</div>
