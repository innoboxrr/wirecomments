<form class="comment-form" wire:submit="{{ $method }}">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="comment-form__alert">
                <span class="comment-form__alert-label">¡Éxito!</span>
                {{ session('message') }}
            </div>
        </div>
    @endif

    @csrf

    <div class="comment-form__input-wrapper">
        <label for="{{ $inputId }}" class="sr-only">{{ $inputLabel }}</label>

        <textarea
            id="{{ $inputId }}"
            rows="6"
            class="comment-form__textarea @error($state.'.body') comment-form__textarea--error @enderror"
            placeholder="Escribe un comentario..."
            wire:model.live="{{ $state }}.body"
            oninput="detectAtSymbol()"
        ></textarea>

        @if (!empty($users) && $users->count() > 0)
            @include('wirecomments::livewire.partials.dropdowns.users')
        @endif

        @error($state.'.body')
            <p class="comment-form__error">{{ $message }}</p>
        @enderror
    </div>

    <button
        wire:loading.attr="disabled"
        type="submit"
        class="comment-form__submit" >
        <div wire:loading wire:target="{{ $method }}">
            @include('wirecomments::livewire.partials.loader')
        </div>
        {{ $button }}
    </button>
</form>
