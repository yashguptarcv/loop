<!-- Right side - Activity tabs -->
<div class="w-full flex flex-col">
    <div class="bg-white rounded-lg shadow mb-6 flex-grow">
        <!-- Tabs -->
        <div class="border-b divide-gray-100">
            <nav class="flex -mb-px">
                <button onclick="switchTab('activity')" id="activity-tab" data-tab="activity" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-primary-100 text-primary-100">
                    Comments
                </button>
                <button onclick="switchTab('notes')" id="notes-tab" data-tab="notes" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Logs
                </button>
                <button onclick="switchTab('files')" id="files-tab" data-tab="files" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Attachments
                </button>
                <button onclick="switchTab('application')" id="application-tab" data-tab="application" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Applications <span class="bg-primary-100 text-amber-100 rounded-lg px-2 py-1">{{$lead->application->count()}}</span>
                </button>
            </nav>
        </div>
        
        <!-- Tab contents -->
        <div class="p-6 h-[400px] md:h-[500px] lg:h-[600px] overflow-x-auto relative">
            <!-- Content area with left padding to avoid overlap -->
            <div id="leads_tab" class="tab-content lead-details active space-y-4" 
                data-tab="activity">
                @include('leads::leads.components.lead-detail-right.activity', ['items' => $activities])
            </div>
        </div>
    </div>

    <!-- Message composer with TinyMCE -->
    @include('leads::leads.components.lead-detail-right.editor')

</div>