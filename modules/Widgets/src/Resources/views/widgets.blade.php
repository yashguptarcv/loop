@extends('admin::layouts.app')

@section('title', 'Widgets Manager')

@section('styles')

@endsection

@section('content')
<!-- Stats Section -->
<div class="flex justify-between items-center mb-8">
    @include('admin::components.common.back-button', ['route' => route('admin.settings.index'), 'name' => 'Widgets Manager'])

    <div class="flex space-x-4">
        @if(bouncer()->hasPermission('admin.widgets.create'))
        <a href="{{route('admin.widgets.create')}}" class="bg-primary-100 hover:text-amber-200 text-amber-100 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> New Widget
        </a>
        @endif
    </div>
</div>
@php
    function fn_get_widget_value($is_currency, $value) {
        if($is_currency === 'Y') {
            return fn_convert_currency($value, fn_get_setting('general.currency'));
        } else {
            return number_format($value);
        }
    }
@endphp
<!-- Widgets Grid -->
<div class="bg-white rounded-lg mb-8">
    <div class="">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="widgets-container">
            @foreach($widgets as $w)
                <div class="border border-gray-200 rounded-lg  bg-white p-6 cursor-pointer" data-id="{{ $w->id }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex gap-2">
    
                            <button onclick="openDeleteModal('{{ route('admin.widgets.destroy', $w->id) }}')"
                                class="text-primary-100 hover:text-amber-200 text-sm font-medium">                    
                                <i class="fas fa-trash ml-1"></i>
                            </button>

                            <x-modal 
                                buttonText='Assign <i class="fas fa-arrow-right ml-1"></i>'
                                modalTitle="{{$w->title}}"
                                id="assigne_widgets"
                                ajaxUrl="{{route('admin.widgets.show', $w->id)}}"
                                buttonClass="text-primary-100 hover:text-amber-200 text-sm font-medium"
                                modalSize="2xl"
                            />
                        
                        </div>
                        
                        <div class="flex space-x-1">
                            @if($w->user_groups)
                                @foreach(array_slice($w->user_groups, 0, 3) as $group)
                                    <span class="group-pill text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-800" data-tooltip="{{ $group }}">
                                        {{ substr($group, 0, 1) }}
                                    </span>
                                @endforeach
                                @if(count($w->user_groups) > 3)
                                    <span class="group-pill text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-800" data-tooltip="And {{ count($w->user_groups) - 3 }} more">
                                        +{{ count($w->user_groups) - 3 }}
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        @includeIf('widgets::types.'.$w->widget_type, (new \Modules\Widgets\Http\Controllers\HomeController)->compute($w))
                    </div>                    
                   
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let container = document.getElementById('widgets-container');

    new Sortable(container, {
        animation: 150,
        handle: '.cursor-pointer', // drag handle
        onEnd: function (evt) {
            let order = [];
            document.querySelectorAll('#widgets-container > div').forEach((el, index) => {
                order.push({
                    id: el.dataset.id,
                    sort_order: index + 1
                });
            });

            fetch("{{ route('admin.widgets.sort') }}", {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({order})
            });
        }
    });

    // let grid = GridStack.init({
    //     float: true,
    //     cellHeight: 120,
    //     resizable: { handles: 'all' }
    // }, '#widgets-grid');

    // grid.on('change', function(event, items) {
    //     let positions = items.map(el => ({
    //         id: el.el.dataset.id,
    //         x: el.x,
    //         y: el.y,
    //         w: el.w,
    //         h: el.h
    //     }));

    //     fetch("{{ route('admin.widgets.position') }}", {
    //         method: 'POST',
    //         headers: {
    //             "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //             "Content-Type": "application/json",
    //         },
    //         body: JSON.stringify({positions})
    //     });
    // });
});

</script>
@endsection