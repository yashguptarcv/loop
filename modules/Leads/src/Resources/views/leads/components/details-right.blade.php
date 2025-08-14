<!-- Right side - Activity tabs -->
<div class="w-full flex flex-col">
    <div class="bg-white rounded-lg shadow mb-6 flex-grow">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="switchTab('activity')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    Activity
                </button>
                <button onclick="switchTab('notes')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Logs
                </button>
                <button onclick="switchTab('files')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Files
                </button>
                <button onclick="switchTab('application')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Applications <span class="bg-blue-100 text-blue-600 rounded-lg px-2 py-1">{{$lead->application->count()}}</span>
                </button>
            </nav>
        </div>
        <!-- Tab contents -->
        <div class="p-6 h-[400px] md:h-[500px] lg:h-[600px] overflow-x-auto">
            <!-- Activity Tab -->
            <div id="activity-tab" class="tab-content lead-details active space-y-4">
                @include('leads::leads.components.lead-detail-right.activity')
            </div>

            <!-- Notes Tab -->
            <div id="notes-tab" class="tab-content lead-details space-y-4">
                @include('leads::leads.components.lead-detail-right.notes')
            </div>

            <!-- Files Tab -->
            <div id="files-tab" class="tab-content lead-details space-y-4">
                @include('leads::leads.components.lead-detail-right.filters')
            </div>

            <div id="application-tab" class="tab-content lead-details space-y-4">
                @include('leads::leads.components.lead-detail-right.application')
            </div>
        </div>
    </div>

    <!-- Message composer with TinyMCE -->
    @include('leads::leads.components.lead-detail-right.editor')

</div>