@props([
    'items' => [],
    'selected' => [],
    'name' => '',
    'colors' => ['accent', 'primary', 'secondary', 'info', 'success', 'warning', 'error'],
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
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">Selectionner vos sports</label>

    <div class="relative">
        <div tabindex="0" role="button" @click="open = !open"
            class="select flex-wrap select-bordered w-full h-auto p-1 max-w-xs flex flex-row items-center">
            <template x-for="(item, index) in items" :key="index">
                <span :class="'badge badge-' + item.color + ' badge-outline m-1'" x-text="item.name"></span>
            </template>
        </div>

        <ul tabindex="0" x-show="open"
            class="max-h-44 overflow-y-scroll dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-52 absolute">
            @foreach ($items as $item)
                <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" role="option">
                    <div class="flex items-center">
                        <input id="{{ $item->id }}" type="checkbox"
                            class="form-checkbox h-4 w-4 text-indigo-600" value="{{ $item->name }}"
                            :checked="items.find(i => i.id === '{{ $item->id }}')"
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
