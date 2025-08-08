<!-- Right side - Activity tabs -->
            <div class="w-full flex flex-col">
                <div class="bg-white rounded-lg shadow mb-6 flex-grow">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button onclick="switchTab('activity')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                Activity
                            </button>
                            <button onclick="switchTab('logs')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Logs
                            </button>
                            <button onclick="switchTab('notes')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Notes
                            </button>
                            <button onclick="switchTab('files')" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Files
                            </button>
                        </nav>
                    </div>

                    <!-- Tab contents -->
                    <div class="p-6">
                        <!-- Activity Tab -->
                        @include('leads::leads.components.lead-detail-right.activity')

                        <!-- Logs Tab -->
                        @include('leads::leads.components.lead-detail-right.logs')
                        
                        <!-- Notes Tab -->
                        @include('leads::leads.components.lead-detail-right.notes')
                        
                        <!-- Files Tab -->
                        @include('leads::leads.components.lead-detail-right.filters')
                        
                    </div>
                </div>
                
                <!-- Message composer with TinyMCE -->
                @include('leads::leads.components.lead-detail-right.editor')
                
            </div>