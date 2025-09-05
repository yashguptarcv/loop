 <div class="flex items-center mb-6">
        @if(!empty($route))
        <a href="{{$route}}" class="mr-4 text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>&nbsp;&nbsp;&nbsp;
        @endif
        <h1 class="text-2xl font-bold text-gray-800">{{$name}}</h1>
    </div>