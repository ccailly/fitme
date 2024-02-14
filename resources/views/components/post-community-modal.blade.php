@props(['sports'])


<!-- Open the modal using ID.showModal() method -->
<button class="fixed bottom-20 right-4 btn btn-primary btn-circle" x-on:click="community_modal_form.showModal()">
    <x-heroicon-o-plus class="w-5 h-5 text-red" />
</button>

<dialog id="community_modal_form" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Créer une communauté</h3>

        <form method="post" action="{{ route('community.post') }}" enctype="multipart/form-data" class="mt-6">
            @csrf

            <div class="flex flex-col items-center justify-center gap-2">
                <span class="label-text flex flex-row gap-1">
                    Image de la communauté
                    <p class="text-error">*</p>
                </span>
                <x-avatar-input name="image" />
            </div>

            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text flex flex-row gap-1">
                        Nom de la communauté
                        <p class="text-error">*</p>
                    </span>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                    <input type="text" name="name" class="text-sm bg-base-100 grow" placeholder="Nom" />
                </label>
            </label>

            <label class="form-control mb-2">
                <div class="label">
                    <span class="label-text flex flex-row gap-1">
                        Description
                        <p class="text-error">*</p>
                    </span>
                </div>
                <textarea class="textarea textarea-bordered h-24" name="description" placeholder="Description"></textarea>
            </label>

            <x-items-selector :items="$sports" name="sports" label="Selectionnez des sports" placeholder="Selectionnez des sports" />

            <div class="modal-action">
                <button type="submit" class="w-full btn btn-primary">Créer</button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>Annuler</button>
    </form>
</dialog>
