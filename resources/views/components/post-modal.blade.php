@props([
    'communities',
    'events'
])

<!-- Open the modal using ID.showModal() method -->
<button class="fixed bottom-20 right-4 btn btn-primary btn-circle" x-on:click="post_modal_form.showModal()">
    <x-heroicon-o-plus class="w-5 h-5 text-red" />
</button>

<dialog id="post_modal_form" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Ajouter une publication</h3>

        <form method="post" action="{{ route('feed.post') }}" x-data="{ include_event: false, event_id: -1 }" enctype="multipart/form-data">
            @csrf
            <!-- Select community -->
            <div class="mb-4" x-data="{ selectedCommunity: '{{ $communities[0]->id ?? -1 }}' }" x-init="updateEventsOptions(selectedCommunity)">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Sélectionner la communauté</span>
                    </div>
                    <select name="community_id" class="select select-bordered" x-model="selectedCommunity" x-on:change="updateEventsOptions(selectedCommunity)">
                        @foreach ($communities as $community)
                            <option value="{{ $community->id }}">{{ $community->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <!-- Post content -->
            <div class="mb-4" x-data="{ image: null }">
                <label class="form-control relative">
                    <div class="label">
                        <span class="label-text">Contenu</span>
                    </div>
                    <textarea name="content" class="textarea textarea-bordered h-24" placeholder="Contenu du post"></textarea>
                    <input type="file" name="image" class="hidden" @change="image = $event.target.files[0]" x-ref="fileInput">
                    <button type="button" class="btn btn-square btn-sm btn-outline absolute bottom-2 right-2" @click="$refs.fileInput.click()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </button>
                </label>

                <div class="mt-2" x-show="image instanceof File">
                    <img x-bind:src="image instanceof File ? URL.createObjectURL(image) : ''" class="max-h-16 max-w-16 object-cover">
                </div>
            </div>

            <!-- Post include an event -->
            <div class="mb-4">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Inclure un évènement</span>
                        <input name="is_event" type="checkbox" class="toggle" x-model="include_event" />
                    </label>
                </div>
            </div>

            <div x-show="include_event">
                <!-- Select event -->
                <div class="mb-4">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Sélectionner l'évènement</span>
                        </div>
                        <select name="event_id" class="select select-bordered" x-model="event_id">
                            <option value="-1" disabled>Sélectionner un évènement</option>
                            <option value="0">Nouvel évènement</option>
                        </select>
                    </label>
                </div>

                <div x-show="event_id == 0">
                    <!-- Event name -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Nom de l'évènement</span>
                            </div>
                            <input name="event_name" type="text" placeholder="Nom de l'évènement"
                                class="input input-bordered w-full" />
                        </label>
                    </div>

                    <!-- Event description -->
                    <div class="mb-4">
                        <label class="form-control">
                            <div class="label">
                                <span class="label-text">Description de l'évènement</span>
                            </div>
                            <textarea name="event_description" class="textarea textarea-bordered h-24" placeholder="Description de l'évènement"></textarea>
                        </label>
                    </div>

                    <!-- Event date -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Date de l'évènement</span>
                            </div>
                            <input name="event_date_time" type="datetime-local" placeholder="Date de l'évènement"
                                class="input input-bordered w-full" />
                        </label>
                    </div>

                    <!-- Event location -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Localisation de l'évènement</span>
                            </div>
                            <input name="event_location" type="text" placeholder="Localisation de l'évènement"
                                class="input input-bordered w-full" />
                        </label>
                    </div>

                    <!-- Event max participations -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Nombre maximum de participants</span>
                            </div>
                            <input name="event_max_participants" type="number" class="input input-bordered w-full" value="10" min="1"/>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div class="modal-action">
                <button type="submit" class="w-full btn btn-primary">Publier</button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>Annuler</button>
    </form>

    <script>
        function updateEventsOptions(selectedCommunity) {

            if (selectedCommunity === '-1') {
                return;
            }

            // Fetch events options based on the selected community ID
            const eventsOptions = @json($events);

            // Update the events dropdown options
            const eventsDropdown = document.querySelector('[name="event_id"]');
            eventsDropdown.innerHTML = '';

            // Add the default options
            const defaultOption1 = document.createElement('option');
            defaultOption1.value = "-1";
            defaultOption1.textContent = "Sélectionner un évènement";
            eventsDropdown.appendChild(defaultOption1);

            const defaultOption2 = document.createElement('option');
            defaultOption2.value = "0";
            defaultOption2.textContent = "Nouvel évènement";
            eventsDropdown.appendChild(defaultOption2);

            // Add the events options based on the selected community
            eventsOptions[selectedCommunity].forEach(event => {
                const option = document.createElement('option');
                option.value = event.id;
                option.textContent = event.name;
                eventsDropdown.appendChild(option);
            });
        }
    </script>
</dialog>
