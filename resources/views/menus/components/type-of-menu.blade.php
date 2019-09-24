
    <div class="form-group">
        {!! Form::label('type_of_menu', __('messages.type_of_menu')) !!}
        {!! Form::select('type_of_menu', $typeMenuWantAssociate, $indexCurrentTypeMenu, ['class' => 'form-control', 'placeholder' => __('messages.pick_type_of_menu')]); !!}
    </div>
