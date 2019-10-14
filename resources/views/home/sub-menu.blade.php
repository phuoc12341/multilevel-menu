
    @if ( $menu->children->isEmpty())
        <li><a href="{{ $menu->url }}"> {{ $menu->name }} </a></li>
    @else
        @if ($menu->parent_id == 0)
            <li class="parent">
        @else 
            <li>
        @endif
                <a href="{{ $menu->url }}"><i class="icon-file-alt"></i> {{ $menu->name }} </a>
                <ul class="sub-menu">
                    @foreach ($menu->children as $menu)
                        @include('home.sub-menu', $menu)
                    @endforeach
                </ul>
            </li>
    @endif
