@php
    function fn_get_widget_value($is_currency, $value) {
        if($is_currency === 'Y') {
            return fn_convert_currency($value, fn_get_setting('general.currency'));
        } else {
            return number_format($value);
        }
    }
@endphp


    @foreach($widgets as $w)        
            <div class="mb-4">
                @includeIf('widgets::types.' . $w->widget_type, 
                    (new \Modules\Widgets\Http\Controllers\HomeController)->compute($w)
                )
        </div>
    @endforeach
