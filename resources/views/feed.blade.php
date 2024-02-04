<x-app-layout title="Mon Feed" activeTab="1">
    <div x-data="{
        error: 'Error!',
        showError: false
    }">
        <div x-show="showError" role="alert" id="error-alert"
            class="transition-all duration-300 ease-in-out opacity-0 alert alert-error flex flex-row gap-4 fixed z-50 top-0 mx-6 mt-6 max-w-screen-sm"
            style="width: -webkit-fill-available;">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="error" class="text-left text-xs"></span>
        </div>
        @foreach ($feed_posts as $feed_post)
            <div class="card bordered bg-base-100 mx-2 mb-4">
                <div class="card-body -m-2">
                    <div class="flex flex-row justify-between">
                        <div class="justify-start items-center card-actions">
                            <img src="{{ $feed_post->user->avatar }}" class="w-10 rounded-full">
                            <div class="flex flex-col">
                                <a href="{{ route('user.show', ['user_id' => $feed_post->user->id]) }}"
                                    class="text-xs font-extrabold">{{ $feed_post->user->name }}</a>
                                <div class="flex flex-row gap-1">
                                    <img src="{{ $feed_post->community->image }}" class="w-4 rounded-full">
                                    <a href="{{ route('community.show', ['community_id' => $feed_post->community->id]) }}"
                                        class="text-xs">{{ $feed_post->community->name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-end items-center card-actions">
                            <p class="font-extrabold">•</p>
                            <p>{{ $feed_post->date->diffForHumans() }}</p>
                        </div>
                    </div>
                    <h2 class="card-title text-sm">{{ $feed_post->content }}</h2>
                    @if (isset($feed_post->event))
                        <div class="divider"></div>
                        <div class="card border border-dashed border-info">
                            <div class="absolute flex flex-row bg-base-100 left-16 right-16 -top-4 text-xl font-extrabold text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>                                  
                                <p>Événement</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-warning">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                            </div>
                            <div class="card-body" x-data="{ participate: {{ $feed_post->event->participate ? 'true' : 'false' }}, participants: {{ $feed_post->event->participants }}, event_id: {{ $feed_post->event->id }} }">
                                <p class="text-md font-extrabold">{{ $feed_post->event->name }}</p>
                                <p class="text-xs">{{ $feed_post->event->description }}</p>
                                <div class="flex flex-col justify-between">
                                    <div class="justify-start items-center card-actions">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                        </svg>
                                        <p class="text-xs">{{ $feed_post->event->date->diffForHumans() }} (
                                            {{ $feed_post->event->date->format('j F Y') }} )</p>
                                    </div>
                                    <div class="justify-start items-center card-actions">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <p class="text-xs">{{ $feed_post->event->location }}</p>
                                    </div>
                                </div>
                                <div class="justify-start items-center card-actions">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>
                                    <p class="text-xs w-min" x-text="participants"></p>
                                </div>
                                <div class="justify-end card-actions">
                                    <button class="btn btn-accent" x-on:click="toggleParticipate"
                                        x-bind:class="{ 'btn-outline': !participate }"
                                        x-text="participate ? 'Je participe !' : 'Participer'">
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="divider"></div>
                    <div class="justify-start card-actions" x-data="{
                        liked: {{ $feed_post->liked ? 'true' : 'false' }},
                        likes: {{ $feed_post->likes }},
                        post_id: {{ $feed_post->id }},
                        nb_comments: {{ count($feed_post->comments) }},
                        comments: [],
                        getComments: function() {
                            axios.get('/getComments?post_id=' + this.post_id)
                                .then(response => {
                                    if (response.data.message) {
                                        this.displayError(response.data.message);
                                        return;
                                    }
                                    this.comments = response.data.comments;
                                })
                                .catch(error => {
                                    this.displayError(error);
                                });
                        },
                        comment: '',
                        addComment: function() {
                            axios.post('/addComment', {
                                    csrf_token: '{{ csrf_token() }}',
                                    post_id: this.post_id,
                                    comment: this.comment
                                })
                                .then(response => {
                                    if (response.data.message) {
                                        this.displayError(response.data.message);
                                        return;
                                    }
                                    this.comments.unshift(response.data.comment);
                                    this.comment = '';
                                    this.nb_comments = response.data.nb_comments;
                                    var noCommentElement = document.getElementById('no-comment-{{ $feed_post->id }}');
                                    if (noCommentElement) {
                                        noCommentElement.parentNode.removeChild(noCommentElement);
                                    }
                                })
                                .catch(error => {
                                    this.displayError(error);
                                });
                        },
                        displayError: function(error) {
                            if (error.response.data.message) {
                                this.error = error.response.data.message;
                            } else {
                                this.error = error;
                            }
                            setTimeout(() => {
                                document.getElementById('error-alert').classList.remove('opacity-0');
                            }, 100);
                            this.showError = true;
                            setTimeout(() => {
                                document.getElementById('error-alert').classList.add('opacity-0');
                            }, 4700);
                            setTimeout(() => {
                                this.error = '';
                                this.showError = false;
                            }, 5000);
                        }
                    }">
                        <button @click="toggleLike" :class="{ 'btn-outline': !liked }" class="btn btn-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                            </svg>
                            <span x-text="likes"></span>
                        </button>

                        <label for="comments_modal_{{ $feed_post->id }}" @click="getComments()"
                            class="btn btn-outline btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            <span x-text="nb_comments"></span>
                        </label>

                        <input type="checkbox" id="comments_modal_{{ $feed_post->id }}" class="modal-toggle" />
                        <div class="modal modal-bottom sm:modal-middle" role="dialog">
                            <div class="modal-box max-h-[70%] overflow-y-hidden">
                                <h3 class="fixed font-bold text-lg">Commentaires</h3>
                                <ul class="py-4 mt-8 mb-6  max-h-[28rem] overflow-y-scroll">
                                    <template x-for="comment in comments">
                                        <div class="card bordered bg-base-100 mx-2 mb-4">
                                            <div class="card-body -m-2">
                                                <div class="flex flex-col justify-between">
                                                    <div class="flex flex-row justify-between">
                                                        <div class="justify-start items-center card-actions">
                                                            <img :src="comment.user.avatar" class="w-6 rounded-full">
                                                            <div class="flex flex-col">
                                                                <a :href="'/user/' + comment.user.id"
                                                                    class="text-xs font-extrabold"
                                                                    x-text="comment.user.name"></a>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex flex-row justify-end items-center card-actions">
                                                            <p class="font-extrabold">•</p>
                                                            <p class="text-xs" x-text="comment.posted_date"></p>
                                                        </div>
                                                    </div>
                                                    <p class="mt-1 text-sm" x-text="comment.content"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <li id="no-comment-{{ $feed_post->id }}" class="text-xs"
                                        x-show="comments.length === 0">Personne n'a commenté ce post. Soyez le premier
                                        !
                                    </li>
                                </ul>
                                <div class="relative">
                                    <textarea class="textarea textarea-primary min-w-full pr-8" placeholder="Commenter..." x-model="comment"></textarea>
                                    <svg @click="addComment" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 absolute top-10 right-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </div>
                            </div>
                            <label class="modal-backdrop" for="comments_modal_{{ $feed_post->id }}">Close</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        function toggleLike() {
            axios.post('/like', {
                    csrf_token: '{{ csrf_token() }}',
                    post_id: this.post_id,
                    liked: this.liked
                })
                .then(response => {
                    this.liked = response.data.liked;
                    this.likes = response.data.likes;
                })
                .catch(error => {
                    console.error(error);
                });
        }

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
    </script>

    <x-post-modal :communities="$communities" :events="$events" />
</x-app-layout>
