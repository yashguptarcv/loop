<!-- Header with back button -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        @include('admin::components.common.back-button', ['route' => route('admin.leads.index'), 'name' => 'Lead Detail / '.$lead->name.' / '.$lead->created_at . ' / ' . fn_get_currency($lead->value ?? 0) ])
        <div class="ml-auto flex space-x-3 mb-2">
            @if(bouncer()->hasPermission('admin.leads.edit'))
            
            <x-button type="button"    
                as="a"
                href="{{ route('admin.leads.edit', $lead) }}"
                class="primary" 
                label="<span class='material-icons-outlined mr-1'>edit</span>" 
                icon=''
                name="button" 
            />
            @endif
            @if(bouncer()->hasPermission('admin.application.send_application'))
            <x-modal
                buttonText='Send Application'
                modalTitle="Send Application"
                id='send_application'
                ajaxUrl="{{route('admin.application.send_application', $lead)}}"
                color="primary"
                modalSize="3xl" />
            @endif
        </div>
    </div>
    <!-- Main content area -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Left side - Lead details (sticky/fixed) -->
        <div class="lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)] lg:overflow-y-auto scroll-smooth">
            @include('leads::leads.components.details-left')
        </div>

        <!-- Right side - Activity tabs (scrollable) -->
        <div class="flex-1">
            @include('leads::leads.components.details-right')
        </div>
    </div>