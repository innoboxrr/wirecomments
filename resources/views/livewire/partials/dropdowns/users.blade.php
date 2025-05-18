<div class="user-dropdown">
    <ul class="user-dropdown__list">
        @foreach($users as $user)
            <li wire:click="selectUser('{{ $user->name }}')" wire:key="{{ $user->id }}">
                <a class="user-dropdown__item">
                    <img class="user-dropdown__avatar" src="{{ $user->avatar() }}" alt="{{ $user->name }}">
                    {{ $user->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
