<x-app-layout title="Communauté" activeTab=2>
    <x-slot name="title">Communauté</x-slot>
    <div class="container mx-auto mt-auto">
        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex flex-row justify-between">
                <div class="flex flex-row gap-4">
                    <div class="avatar placeholder">
                        <div class="avatar">
                            <div class="w-8 rounded-full">
                                <img src="{{$community->image}}" />
                            </div>
                        </div>
                    </div>
                    <p class="text-2xl font-semibold ">{{$community->name}}</p>
                </div>
                <button class="btn btn-secondary">Rejoindre</button>
            </div>
            <div class="py-1">
                <p>{{$community->description}}</p>
            </div>
                <p class="text-end text-right py-0">{{$community->members()->count()}} suivent</p>
        </div>
    </div>
</x-app-layout>

