@if(config('wirecomments.comment_nesting') === true)
    @auth
        @if($comment->isParent())
            <button 
                type="button" 
                wire:click="$toggle('isReplying')"
                class="comment-reply__toggle">
                <svg aria-hidden="true" class="comment-reply__icon" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                Responder
            </button>
            <div wire:loading wire:target="$toggle('isReplying')">
                @include('wirecomments::livewire.partials.loader')
            </div>
        @endif
    @endauth

    @if($comment->children->count())
        <button 
            type="button" 
            wire:click="$toggle('hasReplies')"
            class="comment-reply__toggle"
        >
            @if(!$hasReplies)
                Ver todas las respuestas ({{ $comment->children->count() }})
            @else
                Ocultar respuestas
            @endif
        </button>
        <div wire:loading wire:target="$toggle('hasReplies')">
            @include('wirecomments::livewire.partials.loader')
        </div>
    @endif
@endif
