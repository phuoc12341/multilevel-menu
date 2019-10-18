@extends('pages.layout')

@section('content')
    <div class="container">
        <div class="row">
        <a class="btn btn-primary" href="{{ route('pages.create') }}">{{ __('messages.add_new_page') }}</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('messages.name') }}</th>
                    <th scope="col">{{ __('messages.slug') }}</th>
                    <th scope="col">{{ __('messages.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($listPage as $page)
                    <tr>
                        <th scope="row">{{ $page->id }}</th>
                        <td>{{ $page->name }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('pages.edit', ['menu' => $page->slug]) }}"><i class="fas fa-pen-square"></i></a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger deleteButton" data-page-name="{{ $page->name }}" data-page-slug="{{ $page->slug }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('messages.are_you_sure_to_delete_this_post') }}</h5>
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
                        {!! Form::open(['route' => ['pages.destroy',  'page' => ''], 'id' => 'deleteForm', 'method' => 'delete']) !!}
                            {!! Form::submit( __('messages.yes'), ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
    <script>
        var baseActionDelete = $('#deleteForm').attr('action');
        $('.deleteButton').click(function() {
            let formName = $(this).data('page-name')
            let deleteForm = $('#deleteForm')
            let pageSlug = $(this).data('page-slug')
            deleteForm.attr('action', baseActionDelete + '/' + pageSlug)
            let modalData = $("#modalData")
            modalData.text(formName)
        });
    </script>
@endpush
