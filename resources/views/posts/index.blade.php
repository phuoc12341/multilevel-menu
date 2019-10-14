@extends('posts.layout')

@section('content')
    <div class="container">
        <div class="row">
        <a class="btn btn-primary" href="{{ route('posts.create') }}">{{ __('messages.add_new_post') }}</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('messages.title') }}</th>
                    <th scope="col">{{ __('messages.description') }}</th>
                    <th scope="col">{{ __('messages.body') }}</th>
                    <th scope="col">{{ __('messages.slug') }}</th>
                    <th scope="col">{{ __('messages.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($listPost as $post)
                    <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td>{{ $post->body }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('posts.edit', ['menu' => $post->slug]) }}"><i class="fas fa-pen-square"></i></a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger deleteButton" data-post-title="{{ $post->title }}" data-post-slug="{{ $post->slug }}" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i></button>

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
                    <span>{{ __('messages.title') }}: </span>  
                    <span id="modalData"></span>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.no') }}</button>
                        {!! Form::open(['route' => ['posts.destroy',  'post' => ''], 'id' => 'deleteForm', 'method' => 'delete']) !!}
                            {!! Form::submit( __('messages.yes'), ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        var baseActionDelete = $('#deleteForm').attr('action');
        $('.deleteButton').click(function() {
            let formName = $(this).data('post-title')
            let deleteForm = $('#deleteForm')
            let postSlug = $(this).data('post-slug')
            deleteForm.attr('action', baseActionDelete + '/' + postSlug)
            let modalData = $("#modalData")
            modalData.text(formName)
        });
    </script>
@endsection
