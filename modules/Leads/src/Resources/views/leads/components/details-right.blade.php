<!-- Right side - Activity tabs -->
<div class="w-full flex flex-col">
    <div class="bg-white rounded-lg shadow mb-6 flex-grow">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="switchTab('activity')" id="activity-tab" data-tab="activity" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    Comments
                </button>
                <button onclick="switchTab('notes')" id="notes-tab" data-tab="notes" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Logs
                </button>
                <button onclick="switchTab('files')" id="files-tab" data-tab="files" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Attachments
                </button>
                <button onclick="switchTab('application')" id="application-tab" data-tab="application" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Applications <span class="bg-blue-100 text-blue-600 rounded-lg px-2 py-1">{{$lead->application->count()}}</span>
                </button>
            </nav>
        </div>
        
        <!-- Tab contents -->
        <div class="p-6 h-[400px] md:h-[500px] lg:h-[600px] overflow-x-auto relative">
            <!-- Fixed left sidebar -->
            <!-- <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-full flex items-center pl-4 z-10">
                <button id="loadMoreButton" 
                        class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold shadow-md hover:bg-blue-200 hover:text-blue-700 transition-colors duration-200 cursor-pointer"
                        title="Load more activities">
                    {{ '20' }}
                </button>
            </div> -->

            <!-- Content area with left padding to avoid overlap -->
            <div id="leads_tab" class="tab-content lead-details active space-y-4">
                @include('leads::leads.components.lead-detail-right.activity', ['items' => $activities])
            </div>
        </div>
    </div>

    <!-- Message composer with TinyMCE -->
    @include('leads::leads.components.lead-detail-right.editor')

</div>