
    <div class="form-group">
        {!! Form::label('body', __('messages.body')) !!}
        {!! Form::textarea('body', null, ['id' => 'body', 'class' => 'form-control', 'placeholder' => __('messages.enter_body')]) !!}
    </div>
        
    @section('script')
        <script src="https://cdn.ckeditor.com/4.13.0/full-all/ckeditor.js"></script>
        <script>
            var editor = CKEDITOR.replace('body', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
                filebrowserFlashBrowseUrl: '/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });

            CKFinder.setupCKEditor( editor );
        </script>
    @endsection
