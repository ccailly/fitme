<x-app-layout title="Communauté" activeTab="1">
    <div class="p-6" x-data="{
        following: {{ $following ? 'true' : 'false' }},
        members: {{ $members->nb }},
    }">
        <div class="flex flex-row gap-2 items-start">
            <div class="avatar">
                <div class="w-32 mask mask-squircle">
                    <img src="{{ $community->image }}" alt="{{ $community->name }}">
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <h2 class="text-2xl font-extrabold">{{ $community->name }}</h2>
                <p class="text-xs">{{ $community->description }}</p>
                <button class="btn btn-primary" x-on:click="toggleFollow" x-bind:class="{ 'btn-outline': !following }"
                    x-text="following ? 'Suivi' : 'Suivre'">
                </button>
            </div>
        </div>

        <h3 class="text-xl font-bold mt-6 mb-4" x-text="'Membres (' + members + ')'"></h3>
        <div class="flex flex-col items-center gap-2" @click.away="open = false" x-data="{
            allMembers: [],
            open: false,
            fetchMembers() {
                axios.get('/getAllMembers/{{ $community->id }}')
                    .then(response => {
                        this.allMembers = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }">
            <div class="grid grid-cols-2 gap-4">
                @foreach ($members as $member)
                    <a class="flex items-center space-x-4" href="{{ route('user.show', ['user_id' => $member->id]) }}">
                        <img class="h-8 w-8 rounded-full" src="{{ $member->avatar }}" alt="{{ $member->name }}">
                        <p class="text-sm">{{ $member->name }}</p>
                    </a>
                @endforeach
            </div>
            @if ($members->nb > 6)
                 tous les membres
                </label><label @click="fetchMembers()" for="modal_members" class="btn btn-accent btn-outline btn-sm mt-3">
                    Voir

                <input type="checkbox" id="modal_members" class="modal-toggle" />
                <div class="modal" role="dialog">
                    <div class="flex flex-col items-center modal-box max-h-[70%] overflow-y-hidden">
                        <h3 class="fixed font-bold text-lg">Membres</h3>
                        <ul class="min-w-full py-4 mt-8 mb-6  max-h-[28rem] overflow-y-scroll">
                            <template x-for="member in allMembers" :key="member.id">
                                <li class="card bordered bg-base-100 mx-2 mb-4">
                                    <a href="{{ route('user.show', ['user_id' => $member->id]) }}"
                                        class="card-body -m-2">
                                        <div class="flex flex-col justify-between">
                                            <div class="flex flex-row justify-between">
                                                <div class="justify-start items-center card-actions">
                                                    <img :src="member.avatar" class="w-6 rounded-full">
                                                    <div class="flex flex-col">
                                                        <p class="text-xs font-extrabold" x-text="member.name"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>
                        <label for="modal_members" class="btn btn-ghost btn-outline btn-sm">Fermer</label>
                    </div>
                </div>
            @endif
        </div>
        <h3 class="text-xl font-bold mt-6 mb-4">Événements ({{ count($events) }})</h3>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($events as $event)
                <div class="flex flex-col gap-2 p-4 border border-dashed rounded-lg" x-data="{
                    event_id: {{ $event->id }},
                    participate: {{ $event->participate ? 'true' : 'false' }},
                    participants: '{{ $event->participants }}',
                }">
                    <h4 class="text-lg font-bold">{{ $event->name }}</h4>
                    <div class="flex flex-col gap-2">
                        <div>
                            <p class="text-xs">{{ $event->description }}</p>
                        </div>
                        <div class="flex flex-row gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <a class="flex flex-row gap-1"
                                href="{{ route('user.show', ['user_id' => $event->owner->id]) }}">
                                <img class="h-6 w-6 rounded-full" src="{{ $event->owner->avatar }}"</img>
                                {{ $event->owner->name }}
                            </a>
                        </div>
                        <div class="flex flex-row gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            <p>{{ $event->date_time->diffForHumans() }} ( {{ $event->date_time->format('j F Y') }} )
                            </p>
                        </div>
                        <div class="flex flex-row gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <p>{{ $event->location }}</p>
                        </div>
                        <div class="flex flex-row gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <p x-text="participants"></p>
                        </div>
                        <button class="btn btn-secondary" x-on:click="toggleParticipate"
                            x-bind:class="{ 'btn-outline': !participate }"
                            x-text="participate ? 'Je participe !' : 'Participer'">
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        function toggleParticipate() {
            axios.post('/participate', {
                    csrf_token: '{{ csrf_token() }}',
                    event_id: this.event_id,
                    participated: this.participate
                })
                .then(response => {
                    this.participants = response.data.participants;
                    this.participate = response.data.participated;
                })
                .catch(error => {
                    console.error(error);
                });
        }

        function toggleFollow() {
            axios.post('/follow', {
                    csrf_token: '{{ csrf_token() }}',
                    community_id: {{ $community->id }},
                    following: this.following
                })
                .then(response => {
                    this.following = response.data.following;
                    this.members = response.data.members;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</x-app-layout>
