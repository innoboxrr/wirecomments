<div class="comment">
    @if($isEditing)
        @include('wirecomments::livewire.partials.comment-form', [
            'method' => 'editComment',
            'state' => 'editState',
            'inputId' => 'reply-comment',
            'inputLabel' => 'Your Reply',
            'button' => 'Edit Comment'
        ])
    @else
        <article class="comment__card">
            <footer class="comment__header">
                <div class="comment__meta">
                    <p class="comment__user">
                        <img class="comment__avatar" src="{{ $comment->user->avatar() }}" alt="{{ $comment->user->name }}">
                        {{ Str::ucfirst($comment->user->name) }}
                    </p>
                    <p class="comment__date">
                        <time pubdate datetime="{{ $comment->presenter()->relativeCreatedAt() }}"
                              title="{{ $comment->presenter()->relativeCreatedAt() }}">
                            {{ $comment->presenter()->relativeCreatedAt() }}
                        </time>
                    </p>
                </div>

                <div class="comment__dropdown">
                    <button wire:click="$toggle('showOptions')" class="comment__dropdown-button" type="button">
                        <svg class="comment__dropdown-icon" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </button>

                    @if($showOptions)
                        <div class="comment__dropdown-menu">
                            <ul>
                                @can('update', $comment)
                                    <li>
                                        <button wire:click="$toggle('isEditing')" type="button" class="comment__dropdown-item">Edit</button>
                                    </li>
                                @endcan

                                @can('destroy', $comment)
                                    <li>
                                        <button x-on:click="confirmCommentDeletion" x-data="{
                                            confirmCommentDeletion() {
                                                if (window.confirm('You sure to delete this comment?')) {
                                                    @this.call('deleteComment')
                                                }
                                            }
                                        }" class="comment__dropdown-item">Delete</button>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    @endif
                </div>
            </footer>

            <div class="comment__body">
                {!! $comment->presenter()->replaceUserMentions($comment->presenter()->markdownBody()) !!}
            </div>

            <div class="comment__reactions">
                @livewire('wirecomments::livewire.like', [
                    'comment' => $comment,
                ], key($comment->id))

                @include('wirecomments::livewire.partials.comment-reply')
            </div>
        </article>
    @endif

    @if($isReplying)
        @include('wirecomments::livewire.partials.comment-form', [
            'method' => 'postReply',
            'state' => 'replyState',
            'inputId' => 'reply-comment',
            'inputLabel' => 'Your Reply',
            'button' => 'Post Reply'
        ])
    @endif

    @if($hasReplies)
        <article class="comment__replies">
            @foreach($comment->children as $child)
                @livewire('wirecomments::livewire.comment', [
                    'comment' => $child,
                ], key($child->id))
            @endforeach
        </article>
    @endif

    <script>
        function detectAtSymbol() {
            const textarea = document.getElementById('reply-comment');
            if (!textarea) return;

            const cursorPosition = textarea.selectionStart;
            const textBeforeCursor = textarea.value.substring(0, cursorPosition);
            const atSymbolPosition = textBeforeCursor.lastIndexOf('@');

            if (atSymbolPosition !== -1) {
                const searchTerm = textBeforeCursor.substring(atSymbolPosition + 1);
                if (searchTerm.trim().length > 0) {
                    @this.dispatch('getUsers', { searchTerm });
                }
            }
        }
    </script>
</div>
