<x-app-layout title="Utilisateur" activeTab="1">
    <div class="flex flex-col">
        <img class="w-full h-auto mt-[-1.5rem]" src="https://source.unsplash.com/1500x500/?sport-{{ $user->name }}" />
        <div class="w-28 mt-[-3.5rem] ml-8 bg-base-100 rounded-full ring ring-primary ring-offset-primary ring-offset-1 ring-">
            <img class="p-1 rounded-full" src="{{ $user->avatar }}" />
        </div>
    </div>
    <div class="flex flex-col mt-[-2.5rem] w-full items-start justify-center px-7 gap-7">
        <div class="flex flex-row w-full justify-end gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div class="flex flex-col items-start justify-center">
            <h1 class="text-xl font-bold mb-4">{{ $user->name }}</h1>
        </div>
        <div class="flex flex-col w-full gap-4">
            <p class="text-xl font-bold">Communautés ({{ count($communities) }})</p>
            <div class="flex flex-col w-full gap-3">
                @foreach ($communities as $community)
                    <div class="flex flex-row items-center w-full justify-between gap-2" x-data="{
                        following: {{ $community->following ? 'true' : 'false' }},
                        community_id: {{ $community->id }},
                        toggleFollow: function() {
                            axios.post('/follow', {
                                    csrf_token: '{{ csrf_token() }}',
                                    community_id: this.community_id,
                                    following: this.following
                                })
                                .then(response => {
                                    this.following = response.data.following;
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        }
                    }">
                        <a href="{{ route('community.show', ['community_id' => $community->id]) }}" class="flex flex-row items-center gap-2">
                            <img class="w-8 h-8 rounded-full" src="{{ $community->image }}" />
                            <p class="text-sm">{{ $community->name }}</p>
                        </a>
                        <button class="btn btn-accent" x-on:click="toggleFollow"
                            x-bind:class="{ 'btn-outline': !following }"
                            x-text="following ? 'Suivi' : 'Suivre'">
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <p class="text-xl font-bold">Sports ({{ count($sports) }})</p>
            <div class="flex flex-col gap-3">
                @foreach ($sports as $sport)
                    <div class="flex flex-row items-center gap-2">
                        <img class="w-8 h-8 rounded-full" src="{{ $sport->image }}" />
                        <p class="text-sm">{{ $sport->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
