<div class="relative inline-block text-left">
    <button data-id="dropdownTrigger_{{$id}}" class="dropdown-trigger flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-200">
        <span class="material-icons-outlined text-gray-700">more_vert</span>
    </button>

    <!-- Dropdown menu (hidden by default) -->
    <div data-id="dropdownTrigger_{{$id}}" class="dropdown-menu absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 transition-all duration-200 transform opacity-0 scale-95 invisible origin-top-right z-50">
        <div class="py-1" role="menu" aria-orientation="vertical">
            @foreach($actions as $action) 
                                    
                @if($action['method'] === 'DELETE')
                    <button onclick="openDeleteModal('{{ $action['url'] }}')"
                        class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full">                    
                        <span class="material-icons-outlined text-gray-400 group-hover:text-primary text-base">{{$action['icon']}}</span>&nbsp;{{$action['title']}}
                    </button>
                @else
                    @if(!empty($action['is_popup'])) 
                        @php
                            $title = isset($action['icon']) ? "<span class='material-icons-outlined text-gray-400 group-hover:text-primary text-base'>".$action['icon']."</span>&nbsp;". $action['title'] : $action['title'] ;
                        @endphp
                        <x-modal 
                            buttonText="{!! $title !!}"
                            modalTitle="{{ $action['title'] }}"
                            id="{{$action['index']}}"
                            ajaxUrl="{{ $action['url'] }}"
                            buttonClass="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            modalSize="3xl"
                        />
                    @else
                        <a href="{{ $action['url'] }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full"
                            title="{{ $action['title'] }}">
                            @if($action['icon'])
                                <span class="material-icons-outlined text-gray-400 group-hover:text-primary text-base">{{ $action['icon'] }}</span>&nbsp;{{ $action['title'] }}
                            @else
                                {{ $action['title'] }}
                            @endif
                        </a>
                    @endif
                @endif
            @endforeach
    </div>
</div>
</div>