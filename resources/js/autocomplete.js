// Initialize autocomplete functionality
function initAutocomplete(input) {
    const $input = $(input);
    
    // Skip if already initialized
    if ($input.data('autocomplete-initialized')) {
        return;
    }
    
    const container = $input.closest('#auto-complete');
    
    // Create results container if it doesn't exist
    if (container.find('.autocomplete-results').length === 0) {
        const $resultsBox = $('<div>', {
            class: 'autocomplete-results absolute z-50 bg-white border border-gray-300 w-full max-h-52 overflow-auto shadow-md rounded-md hidden text-sm',
        });
        container.append($resultsBox);
    }
    
    // Store initialization flag
    $input.data('autocomplete-initialized', true);
    
    // Handle input event
    $input.on('input', function() {
        const $input = $(this);
        const container = $input.closest('#auto-complete');
        const $resultsBox = container.find('.autocomplete-results');
        
        var table = $input.data('table');
        var select_columns = $input.data('select_columns');
        var search_column = $input.data('search_column');
        var id = $input.data('id');
        var query = $input.val();

        // Position the dropdown
        $resultsBox.css({
            'position': 'relative',
            'margin-bottom': '0.25rem',
            'margin-top': '10px',
            'width': 'auto',
            'display': 'block'
        });

        if (query.length < 2) {
            $resultsBox.hide();
            return;
        }

        if (query.length >= 3) {
            $.ajax({
                url: '/api/autocomplete/autocomplete',
                type: 'get',
                data: {
                    table: table,
                    select_columns: select_columns,
                    search_column: search_column,
                    query: query,
                    id: id
                },
                success: function(response) {
                    var data = response;

                    if (data.length) {
                        let html = '';
                        data.forEach(item => {
                            html += `
                                <div class="autocomplete-suggestion 
                                    px-4 py-2 
                                    hover:bg-gray-50 
                                    cursor-pointer 
                                    transition-colors 
                                    duration-150
                                    border-b border-gray-100
                                    last:border-b-0
                                    text-gray-700
                                    hover:text-gray-900
                                    focus:outline-none
                                    focus:bg-gray-100
                                    focus:ring-1 focus:ring-blue-500
                                    aria-selected:bg-blue-50
                                    aria-selected:text-blue-700"
                                    role="option"
                                    data-id="${item.id}"
                                    data-name="${item.name}"
                                    tabindex="0">
                                    ${item.name}
                                </div>`;
                        });
                        $resultsBox.html(html).removeClass('hidden').addClass('block');
                    } else {
                        $resultsBox.html(`
                            <div class="autocomplete-suggestion 
                                px-4 py-3 
                                text-gray-400 
                                italic
                                text-center
                                border-b border-gray-100"
                                role="status">
                                No results found
                            </div>`).removeClass('hidden').addClass('block');
                    }
                },
                error: function(xhr, status, error) {
                    $resultsBox.html(`
                        <div class="autocomplete-suggestion 
                            px-4 py-3 
                            text-red-500 
                            italic
                            text-center"
                            role="alert">
                            Error loading results
                        </div>`).removeClass('hidden').addClass('block');
                }
            });
        } else {
            $resultsBox.hide();
        }
    });

    // Keyboard navigation
    $input.on('keydown', function(e) {
        const $input = $(this);
        const $results = $input.closest('#auto-complete').find('.autocomplete-results');
        const $suggestions = $results.find('.autocomplete-suggestion[role="option"]');
        const currentFocus = $results.find('.autocomplete-suggestion[aria-selected="true"]');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (currentFocus.length) {
                currentFocus.removeAttr('aria-selected');
                const next = currentFocus.next('.autocomplete-suggestion[role="option"]');
                if (next.length) {
                    next.attr('aria-selected', 'true');
                    next[0].scrollIntoView({ block: 'nearest' });
                }
            } else if ($suggestions.length) {
                $suggestions.first().attr('aria-selected', 'true');
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (currentFocus.length) {
                currentFocus.removeAttr('aria-selected');
                const prev = currentFocus.prev('.autocomplete-suggestion[role="option"]');
                if (prev.length) {
                    prev.attr('aria-selected', 'true');
                    prev[0].scrollIntoView({ block: 'nearest' });
                }
            }
        } else if (e.key === 'Enter' && currentFocus.length) {
            e.preventDefault();
            currentFocus.trigger('click');
        } else if (e.key === 'Escape') {
            $results.hide();
        }
    });
}

// Initialize existing inputs on DOM ready
$(document).ready(function() {
    $('input[autocomplete="dropdown"]').each(function() {
        initAutocomplete(this);
    });
});

// Set up MutationObserver to detect new inputs
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes && mutation.addedNodes.length > 0) {
            for (let i = 0; i < mutation.addedNodes.length; i++) {
                const node = mutation.addedNodes[i];
                
                // Check if the added node is an input with autocomplete="dropdown"
                if (node.nodeType === 1 && node.matches('input[autocomplete="dropdown"]')) {
                    initAutocomplete(node);
                }
                
                // Check if the added node contains inputs with autocomplete="dropdown"
                if (node.nodeType === 1 && node.querySelectorAll) {
                    const inputs = node.querySelectorAll('input[autocomplete="dropdown"]');
                    inputs.forEach(function(input) {
                        initAutocomplete(input);
                    });
                }
            }
        }
    });
});

// Start observing the document
observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Handle click outside to close dropdown (only needs to be set up once)
$(document).on('click', function(e) {
    if (!$(e.target).closest('#auto-complete').length) {
        $('.autocomplete-results').hide();
    }
});

// Handle suggestion selection (only needs to be set up once)
$(document).on('click', '.autocomplete-suggestion[role="option"]', function() {
    const $suggestion = $(this);
    const $input = $suggestion.closest('#auto-complete').find('input[autocomplete="dropdown"]');

    $input.val($suggestion.data('name'));
    if ($input.data('target')) {
        $('#' + $input.data('target')).val($suggestion.data('id'));
    }
    $('.autocomplete-results').hide();
});

// Handle click on autocomplete suggestions (alternative handler)
$(document).on('click', '.autocomplete-suggestion:not(.disabled)', function() {
    const $item = $(this);
    const $container = $item.closest('.col-sm-10');
    const $input = $container.find('input[autocomplete="dropdown"]');
    const targetId = $input.data('target');

    $input.val($item.data('name'));
    $('#' + targetId).val($item.data('id'));
    $container.find('.autocomplete-results').hide();
});