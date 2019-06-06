<div class="form-group{{isset( $form_class ) ? ' ' . $form_class : ''}}">
    <button type="submit" class="{{$class ?? 'btn btn-success'}}" id="{{$id??''}}">{{$label ?? "Submit"}}</button>
</div>
    