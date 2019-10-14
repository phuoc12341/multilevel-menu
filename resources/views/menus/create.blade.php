@extends('menus.layout')

@section('content')
    <div class="container">
        {!! Form::open(['route' => ['menus.store']]) !!}
            @component('menus.create-or-edit-form', $arrPushToComponent)

            @endcomponent
        {!! Form::close() !!}
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        var menuAssociate = $("[name=menu_associate]")
        $(document).ready(function () {
            $("[name=type_of_menu]").change(function() {
                let data = $(this).val();
                $.ajax({
                    type: "get",
                    url: "api/v1/menu/type",
                    data: {'type': data},
                    dataType: "json",
                    success: function (response) {
                        menuAssociate.empty()
                        $.map(response, function (elementOrValue, indexOrKey) {
                            menuAssociate.append('<option value="' + indexOrKey + '">' + elementOrValue + '</option>')
                        });
                    }
                });
            });
        });
    </script>
@endpush
