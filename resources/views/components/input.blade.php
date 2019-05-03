<div class="form-group{{isset( $form_class ) ? ' ' . $form_class : ''}}">
    <label for="{{$id??''}}">{{$label??'Label'}}</label>
    <input type="{{$type??'text'}}" name="{{$name}}" id="{{$id??''}}" value="{{$value??''}}" class="form-control{{isset( $class ) ? ' ' . $class : ''}}">
</div>
