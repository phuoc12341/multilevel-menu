
    <li class="dd-item" data-id="{{ $menu->id }}">
        <div class="dd-handle"> {{ $menu->name }}
            <span class="containActionUpdateDelete">
                <a class="btn btn-warning" href="{{ route('menus.edit', ['menus' => $menu->id, 'order' => $menu->order]) }}"><i class="fas fa-pen-square"></i></a>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger deleteButton" data-menu-name="{{ $menu->name }}" data-menu-id="{{ $menu->id }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i></button>
            </span>
        </div>

        @if ($menu->children->isNotEmpty())
            <ol class="dd-list">
                @foreach ($menu->children as $menu)
                    @include('menus.sub-menu', $menu)
                @endforeach
            </ol>
        @endif
    </li>
