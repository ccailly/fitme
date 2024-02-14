<x-app-layout title="Communautés" activeTab="2">
    <div x-data="{ search: '', communities: {{ $communities->toJson() }} }">
        <label class="input input-bordered flex items-center mx-6 mb-4">
            <input type="text" placeholder="Rechercher (Communautés, sports...)" class="text-sm bg-base-100 grow" x-model="search" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                <path fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
            </svg>
        </label>
        <template x-for="community in communities.filter(c => 
            c.name.toLowerCase().includes(search.toLowerCase()) || 
            c.sports.some(sport => sport.name.toLowerCase().includes(search.toLowerCase()))
        )" :key="community.id">
            <a :href="'/community/' + community.id"
                class="card bg-base-300 border-accent border-dotted border-[1px] mx-2 mb-4">
                <div class="card-body -m-2">
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-row flex-nowrap justify-start items-center card-actions w-2/3 px-3">
                            <img :src="community.image" class="w-16 mask mask-squircle">
                            <div class="flex flex-col line-clamp-1">
                                <p class="text-xs font-extrabold line-clamp-1" x-text="community.name"></p>
                                <p class="text-xs text-secondary font-bold line-clamp-1"
                                    x-text="community.members + ' membres'"></p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center card-actions w-1/3 px-3">
                            <template x-for="sport in community.sports" :key="sport.id">
                                <div class="text-xs text-primary font-bold line-clamp-1" x-text="sport.name"></div>
                            </template>
                        </div>
                        <div class="justify-end items-center card-actions px-3">
                            <x-heroicon-o-chevron-right class="h-5 w-5" />
                        </div>
                    </div>
                </div>
            </a>
        </template>
    </div>
</x-app-layout>
