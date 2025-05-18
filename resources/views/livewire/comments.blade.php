<div class="comments">
    <section class="comments__section">
        <div class="comments__container">
            <div class="comments__header">
                <h2 class="comments__title">
                    Discusión ({{ $comments->count() }})
                </h2>
            </div>

            @auth
                @include('wirecomments::livewire.partials.comment-form', [
                    'method' => 'postComment',
                    'state' => 'newCommentState',
                    'inputId' => 'comment',
                    'inputLabel' => 'Your comment',
                    'button' => 'Publicar comentario'
                ])
            @else
                <a 
                    class="comments__login-link" 
                    style="display: block; margin-bottom: 1rem;"
                    href="{{ $login }}?redirect={{ request()->url() }}"
                    title="Inicia sesión para comentar"
                    rel="nofollow">
                    Inicia sesión para comentar
                </a>
            @endauth

            @if($comments->count())
                @foreach($comments as $comment)
                    @livewire('wirecomments::livewire.comment', [
                        'comment' => $comment,
                    ], key($comment->id))
                @endforeach

                <div class="comments__pagination">
                    {{ $comments->links() }}
                </div>
            @else
                <p class="comments__empty">Aún no hay comentarios.</p>
            @endif
        </div>
    </section>
</div>
