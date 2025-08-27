@extends('admin::layouts.app')

@section('title', 'Settings')

@section('page_title')
    Settings
@endsection

@section('content')
    <div class="flex flex-col w-full min-h-screen bg-[var(--color-bg)] p-6">
        {{-- Settings Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php                
                $event = new Modules\Core\Events\RegisterSettingsMenu();
                event($event);                     
                $settings = array_merge([], $event->items);
            @endphp

            @foreach ($settings as $setting)
                @if (!isset($setting['permission']) || bouncer()->hasPermission($setting['permission']))
                    <div class="bg-[var(--color-white)] rounded-xl shadow-sm border border-primary-100 overflow-hidden transition-all hover:shadow-md hover:border-primary-100 group">
                        <a href="{{ $setting['route'] }}" class="block h-full">
                            <div class="p-5 h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="p-3 rounded-lg text-primary-100">
                                        <span class="material-icons-outlined">{{ $setting['icon'] }}</span>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-black-100">
                                        {{ $setting['title'] }}
                                    </h3>
                                </div>
                                <p class="text-sm text-primary-100 mb-4 flex-grow">
                                    {{ $setting['description'] }}
                                </p>
                                <div class="flex items-center text-primary-100 group-hover:text-300 transition-colors">
                                    <span class="text-sm font-medium">Configure</span>
                                    <span class="material-icons-outlined ml-1 text-base">chevron_right</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection