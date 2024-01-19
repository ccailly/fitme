<!-- Open the modal using ID.showModal() method -->
<button class="fixed bottom-20 right-4 btn btn-primary btn-circle" x-on:click="post_modal_form.showModal()">
    <x-heroicon-o-plus class="w-5 h-5 text-red" />
</button>

<dialog id="post_modal_form" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Ajouter une publication</h3>

        <form method="post" action="" x-data="{ include_event: false, event_id: -1 }">
            @csrf
            <!-- Select community -->
            <div class="mb-4">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Sélectionner la communauté</span>
                    </div>
                    <select class="select select-bordered">
                        <option>Star Wars</option>
                        <option>Harry Potter</option>
                        <option>Lord of the Rings</option>
                        <option>Planet of the Apes</option>
                        <option>Star Trek</option>
                    </select>
                </label>
            </div>

            <!-- Post content -->
            <div class="mb-4">
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Contenu</span>
                    </div>
                    <textarea name="content" class="textarea textarea-bordered h-24" placeholder="Contenu du post"></textarea>
                </label>
            </div>

            <!-- Post include an event -->
            <div class="mb-4">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Programmer un évènement</span>
                        <input type="checkbox" class="toggle" x-model="include_event" />
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
                        <select class="select select-bordered" x-model="event_id">
                            <option value="-1" disabled>Sélectionner un évènement</option>
                            <option value="0">Nouvel évènement</option>
                            <option value="1">Harry Potter</option>
                            <option value="2">Lord of the Rings</option>
                            <option value="3">Planet of the Apes</option>
                            <option value="4">Star Trek</option>
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
                            <input type="text" placeholder="Nom de l'évènement"
                                class="input input-bordered w-full" />
                        </label>
                    </div>

                    <!-- Event description -->
                    <div class="mb-4">
                        <label class="form-control">
                            <div class="label">
                                <span class="label-text">Contenu</span>
                            </div>
                            <textarea name="content" class="textarea textarea-bordered h-24" placeholder="Contenu du post"></textarea>
                        </label>
                    </div>

                    <!-- Event date -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Date de l'évènement</span>
                            </div>
                            <input type="datetime-local" placeholder="Date de l'évènement"
                                class="input input-bordered w-full" />
                        </label>
                    </div>

                    <!-- Event location -->
                    <div class="mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Localisation de l'évènement</span>
                            </div>
                            <input type="text" placeholder="Localisation de l'évènement"
                                class="input input-bordered w-full" />
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
</dialog>
