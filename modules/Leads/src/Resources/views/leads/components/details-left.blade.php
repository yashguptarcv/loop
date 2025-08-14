<!-- Left side - Lead details -->
<div class="lg:w-full bg-white rounded-lg shadow p-6">
    <div class="flex items-center mb-6">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-sm font-bold mr-3">
            {{strtoupper(substr($lead->name,0,2))}}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{$lead->name}}</h2>
        </div>
    </div>

    <div class="space-y-4">
        @if($lead->email || $lead->phone)
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Contact Information</h3>
            @if($lead->email)
            <div class="flex items-center text-gray-700 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                {{$lead->email}}
            </div>
            @endif
            @if($lead->phone)
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {{$lead->phone}}
            </div>
            @endif
            @if($lead->website)
            <div class="flex items-center text-gray-700">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                </svg>&nbsp;&nbsp;
                <span class="truncate max-w-[200px]">{{$lead->website}}</span>
            </div>
            @endif
        </div>
        @endif

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Company Details</h3>
            @if($lead->company)
            <p class="text-gray-700 mb-1"><span class="font-medium">{{$lead->company}}</span></p>
            @else
            <p class="text-gray-700 mb-1"><span class="font-medium">{{'----'}}</span></p>
            @endif

            @if($lead->address)
            <p class="text-gray-700 mb-1">{{$lead->address}}</p>
            <p class="text-gray-700">{{$lead->state .', ' ?? ''}}{{$lead->country .', ' ?? ''}}{{$lead->postal_code ?? ''}}</p>
            @endif
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Lead Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Status</p>
                    @if(!empty($lead->status->name))
                    <p class="text-gray-700 text-sm">{{$lead->status->name}}</p>
                    @else
                    <p class="text-gray-700 text-sm">{{'----'}}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500">Source</p>
                    @if(!empty($lead->source->name))
                    <p class="text-gray-700 text-sm">{{$lead->source->name}}</p>
                    @else
                    <p class="text-gray-700 text-sm">{{'----'}}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500">Value</p>
                    @if(!empty($lead->value))
                    <p class="text-gray-700 text-sm">{{fn_convert_currency($lead->value, 'USD')}}</p>
                    @else
                    <p class="text-gray-700 text-sm">{{fn_convert_currency('0', 'USD')}}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500">Industry</p>
                    @if(!empty($lead->industries))
                    <p class="text-gray-700 text-sm">{{$lead->industries}}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500">Created</p>
                    @if(!empty($lead->created_at))
                    <p class="text-gray-700 text-sm">{{$lead->created_at}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Assigned</h3>
            @if(!empty($lead->assignedTo->name))
            <div class="flex">
                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-sm font-bold mr-2">
                    {{strtoupper(substr($lead->assignedTo->name,0,2))}}
                </div>

                @if(bouncer()->hasPermission('admin.leads.update-assignment'))
                <div class="w-40 relative" id="auto-complete">
                    <div class="flex items-center">
                        <form class="form-ajax flex" action="{{route('admin.leads.update-assignment', $lead->id)}}" method="POST">
                            @csrf
                            <input
                                type="text"
                                autocomplete="dropdown"
                                name="assign_name"
                                value="{{$lead->assignedTo->name}}"
                                placeholder="{{$lead->assignedTo->name}}"
                                id="input-assign_id"
                                class="w-full px-1 py-1 border border-gray-300 rounded-md"
                                data-table="admins"
                                data-select_columns="id, name"
                                data-search_column="name"
                                data-target="assign_id"
                                data-original-value="{{$lead->assignedTo->name}}" />
                            <input
                                type="hidden"
                                name="assign_id"
                                id="assign_id"
                                value="{{$lead->assignedTo->id}}"
                                class="mt-1"
                                data-original-value="{{$lead->assignedTo->id}}" />
                            <button
                                type="submit"
                                id="update-assign-btn"
                                name="button"
                                class="ml-2 px-2 py-1 bg-blue-100 text-white-600 rounded-md  text-sm hidden"
                                data-lead-id="{{$lead->id}}">
                                <span class="material-icons-outlined mr-1 text-sm">edit</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <span class="text-gray-700">{{$lead->assignedTo->name}}</span>
                @endif
            </div>
            @else
            <div class="flex items-center">{{'Not assigned'}}</div>
            @endif
        </div>

        @if(!empty($lead->tags))
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Tags</h3>
            <div class="flex flex-wrap gap-1">
                @foreach($lead->tags as $tag)
                                        
                <span class="inline-flex px-2 py-1 bg-{{$tag->color??'gray'}}-100 text-{{$tag->color??'gray'}}-800 dark:text-{{$tag->color??'gray'}}-200 font-medium text-xs rounded-full">{{$tag->name}}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>