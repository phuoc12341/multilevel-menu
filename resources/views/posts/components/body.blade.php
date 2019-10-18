
    <div class="form-group">
        {!! Form::label('body', __('messages.body')) !!}
        {!! Form::textarea('body', null, ['id' => 'body', 'class' => 'form-control my-editor', 'placeholder' => __('messages.enter_body')]) !!}
    </div>
        
    @push('scripts')
        <script>
            var test = tinymce // thuc ra ko can dong nay

            var editor_config = {
                path_absolute : "/",
                selector: "textarea.my-editor",
                branding: false,
                contextmenu: "link image imagetools table",
                draggable_modal: true,
                base_url: 'http://127.0.0.1:5000/',
                plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                    'save table directionality emoticons template paste'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
                relative_urls: false,
                file_picker_callback: function (callback, value, meta) {
                    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    let type = 'image' === meta.filetype ? 'Images' : 'Files',
                        url  = editor_config.path_absolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

                    // tinymce.activeEditor.windowManager.openUrl({    // tu dung tinymce.activeEditor = null khi goi callback anh ak, nen em phai hotfix ow dong duoi
                    test.activeEditor.windowManager.openUrl({
                        url : url,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        onMessage: (api, message) => {
                            callback(message.content);
                        }
                    });
                }
            };

            tinymce.init(editor_config);
        </script>
    @endpush
