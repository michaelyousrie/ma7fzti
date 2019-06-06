<div class="form-group{{isset( $form_class ) ? ' ' . $form_class : ''}}">
    <label for="{{$id??''}}">{{$label??'Label'}}</label>
    <select name="{{$name??''}}" id="{{$id??''}}" class="form-control select2{{isset( $class ) ? ' ' . $class : ''}}">
        @if ( $options )
            @foreach( $options as $option )
                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
            @endforeach
        @endif
    </select>
</div>
