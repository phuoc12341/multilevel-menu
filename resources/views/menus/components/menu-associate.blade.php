
    <div class="form-group">
        {!! Form::label('menu_associate', __('messages.menu_associate')) !!}
        {!! Form::select('menu_associate', $listMenuAssociate, $associatedMenuId, ['class' => 'form-control', 'placeholder' => __('messages.pick_a_associate')]); !!}
    </div>
