<x-app-layout>
    @foreach ($feed_posts as $feed_post)
        <div class="card bordered bg-base-100 m-2">
            <div class="card-body">
                <h2 class="card-title">{{ $feed_post->content }}</h2> 
                <p>Posté le {{ $feed_post->date->format('d-m-Y H:i') }}</p>
                <div class="justify-end card-actions">
                    <button class="btn btn-outline btn-accent">Likes: {{ $feed_post->likes }}</button>
                </div>
                @if(count($feed_post->comments) > 0)
                    <div class="divider"></div>
                    <p class="text-sm text-gray-500">Commentaires:</p>
                    @foreach($feed_post->comments as $comment)
                        <div class="p-2 bg-gray-100 rounded mt-2">
                            <p class="text-sm">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</x-app-layout>
