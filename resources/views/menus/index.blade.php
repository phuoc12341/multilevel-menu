@extends('menus.layout')

@section('content')
    <div class="container">
        <div class="row">
            <a class="btn btn-primary" href="{{ route('menus.create') }}">{{ __('messages.add_new_menu') }}</a>
        </div>

        <div class="row">
            @if ( $listMenu->isNotEmpty() )
                <div class="dd">
                    <ol class="dd-list">
                        @foreach ($listMenu as $menu)
                            @include('menus.sub-menu', $menu)
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('messages.are_you_sure_to_delete_this_menu') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>{{ __('messages.name') }}: </span>  
                    <span id="modalData"></span>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.no') }}</button>
                        {!! Form::open(['route' => ['menus.destroy',  'menu' => ''], 'id' => 'deleteForm', 'method' => 'delete']) !!}
                            {!! Form::submit( __('messages.yes'), ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('style')
    <link rel="stylesheet" href="/bower_components/nestable2/jquery.nestable.css">
@endsection

@push('script')
    <script src="/bower_components/nestable2/jquery.nestable.js"></script>
    <script type="text/javascript">
        var idChangedNode = null
        $('.dd').nestable({
            maxDepth: 10,
            onDragStart: function(l,e){
                // l is the main container
                // e is the element that was moved

                idChangedNode = e.data('id')
            }
        });

        $('.dd').on('change', function() {
           let treeMenu = $('.dd').nestable('serialize');
            $.ajax({
                type: "patch",
                url: "api/v1/change-order",
                data: { 'tree_menu': treeMenu, 'id': idChangedNode},
                dataType: "json",
                success: function (response) {
                    console.log(response)
                }
            });
        });
    </script>
    <script>
        var baseActionDelete = $('#deleteForm').attr('action');
        $('.deleteButton').click(function() {
            let formName = $(this).data('menu-name')
            let deleteForm = $('#deleteForm')
            let menuId = $(this).data('menu-id')
            deleteForm.attr('action', baseActionDelete + '/' + menuId)
            let modalData = $("#modalData")
            modalData.text(formName)
        });

        $(".containActionUpdateDelete").mousedown(function(event) {
            event.stopPropagation()
        });

    </script>
@endpush
