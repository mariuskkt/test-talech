<form
    {!!html_attr(($attributes ?? []) + ['method' => 'POST'])!!}>

    @foreach ($fields ?? [] as $field_id => $field)

        <label>
            <span>{{$field['label'] ?? ''}}</span>
            @if (in_array($field['type'], ['text', 'password', 'number', 'email', 'color', 'hidden', 'file','url']))
                <input {!! input_attr($field_id, $field) !!}>
            @elseif (in_array($field['type'], ['select']))
                <select {!!select_attr($field_id, $field)!!} >
                    @foreach ($field['options'] as $option_id => $option_title)
                        <option {!! option_attr($option_id,$field) !!}>
                            {{$option_title}}
                        </option>
                    @endforeach
                </select>
            @elseif (in_array($field['type'], ['textarea']))
                <textarea {!! textarea_attr($field_id, $field) !!}>
                    {{$field['value']}}
                </textarea>
            @elseif (in_array($field['type'], ['radio']))
                @foreach ($options as $option_id => $radio_value)
                    <label>
                        <div class="radio">
                            <span>{{$option_id}}</span>
                            <input {!! radio_attr($field, $field_id, $option_id) !!} >
                        </div>
                    </label>
                @endforeach
            @endif
        </label>
        @if($errors->has($field_id))
            <span>{{$errors->first($field_id)}}</span>
        @endif
    @endforeach
    @foreach ($buttons ?? [] as $button_id => $button)
        <button {!! html_attr(($button['extra']['attr'] ?? []) +
        [
            'name' => 'action',
            'value' => $button_id
                ])!!}>
            {{$button['title']}}
        </button>
    @endforeach
    @csrf
</form>
