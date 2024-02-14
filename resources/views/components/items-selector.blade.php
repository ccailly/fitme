@props([
    'items' => [],
    'selected' => collect(),
    'name' => '',
    'colors' => ['accent', 'primary', 'secondary', 'info', 'success', 'warning', 'error'],
    'placeholder' => '',
])

<div x-data="{
    items: {{ $selected->pluck('name', 'id')->map(function ($name, $id) use ($colors) {
            return [
                'id' => str($id),
                'name' => $name,
                'color' => $colors[array_rand($colors)],
            ];
        })->values()->toJson() }},
    colors: {{ json_encode($colors) }},
    open: false
}" x-init="items = items.map(item => ({ ...item, color: colors[Math.floor(Math.random() * colors.length)] }))">
    <label for="{{ $name }}" class="block text-sm font-medium mb-2">Selectionner vos sports</label>

    <div class="relative">
        <div tabindex="0" role="button" @click="open = !open"
            class="select flex-wrap select-bordered w-full h-auto p-1 max-w-xs flex flex-row items-center">
            <template x-for="(item, index) in items" :key="index">
                <span :class="'badge badge-' + item.color + ' badge-outline m-1'" x-text="item.name"></span>
            </template>
            <span x-show="items.length === 0" class="flex flex-row gap-2 ml-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                </svg>
                <p class="text-gray-400">{{ $placeholder }}</p>
            </span>
        </div>

        <ul tabindex="0" x-show="open"
            class="max-h-44 overflow-y-scroll dropdown-content z-[1] p-2 shadow bg-base-300 rounded-box w-52 absolute">
            @foreach ($items as $item)
                <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" role="option">
                    <div class="flex items-center">
                        <input id="{{ $item->id }}" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600"
                            value="{{ $item->name }}" :checked="items.find(i => i.id === '{{ $item->id }}')"
                            @change="if ($event.target.checked) {
                                items.push({
                                    id : '{{ $item->id }}',
                                    name: '{{ $item->name }}',
                                    color: colors[Math.floor(Math.random() * colors.length)] 
                                });
                            } else {
                                const index = items.findIndex(i => i.id === '{{ $item->id }}');
                                if (index > -1) { items.splice(index, 1); }
                            }">
                        <label for="{{ $item->id }}"
                            class="text-base-content ml-3 block text-sm font-normal">{{ $item->name }}</label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <input type="hidden" name="{{ $name }}" x-bind:value="items.map(item => item.id)">
</div>
