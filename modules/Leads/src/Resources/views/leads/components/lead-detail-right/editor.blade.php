<div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Message</h3>
                    <form>
                        <div class="mb-4">
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Email</option>
                                <option>Internal Note</option>
                                <option>Call Log</option>
                                <option>Task</option>
                            </select>
                        </div>
                        <textarea id="message-editor" class="hidden"></textarea>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex space-x-2">
                                <button type="button" class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <button type="button" class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-[var(--color-hover)] text-[var(--color-text-inverted)]-600 text-white rounded-md hover:bg-[var(--color-hover)] text-[var(--color-text-inverted)]-700">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>