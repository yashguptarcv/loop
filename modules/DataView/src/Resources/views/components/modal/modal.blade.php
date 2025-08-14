
<!-- Trigger Button Only -->
@if(empty($color) && !empty($buttonClass))
    <!-- <button class="{{ $buttonClass }}" >
        {!! $buttonText ?? 'Open Modal' !!}
    </button> -->
    <button id="modal-trigger-{{ $id }}" class="{{$buttonClass}}" data-ajax-url="{{ $ajaxUrl }}" data-modal-id="{{ $id }}" data-modal-title="{{ $modalTitle ?? 'Modal Title' }}" data-modal-size="{{ $modalSize ?? 'md' }}">
        {!! $buttonText ?? 'Open Modal' !!}
    </button>
    
@else

    <x-button type="submit" 
        id="modal-trigger-{{ $id }}"
        class="{{ $color }}" 
        label="{!!$buttonText!!}" 
        icon='' 
        :calls="[
            'data-ajax-url'     => $ajaxUrl,
            'data-modal-id'     => $id,
            'data-modal-title'  => $modalTitle,
            'data-modal-size'   => $modalSize,
            ]"
    />   
    
@endif