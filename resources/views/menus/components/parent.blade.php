
    <div class="form-group">
        {!! Form::label('parent_id', __('messages.parent_menu')) !!}
        {!! Form::select('parent_id', $listSelectMenu, $parentMenu, ['class' => 'form-control', 'placeholder' => __('messages.pick_a_parent_menu')]); !!}
    </div>
