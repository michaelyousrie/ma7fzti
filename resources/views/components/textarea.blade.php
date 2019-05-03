<div class="form-group{{isset( $form_class ) ? ' ' . $form_class : ''}}">
    <label for="{{$id??''}}">{{$label??'Label'}}</label>
    <textarea name="{{$name??''}}" id="{{$id??''}}" cols="{{$cols??30}}" rows="{{$rows??10}}" class="form-control{{isset( $class ) ? ' ' . $class : ''}}">{{$value??''}}</textarea>
</div>
