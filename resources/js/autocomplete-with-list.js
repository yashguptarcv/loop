class Autocomplete {
    constructor(el, options) {
        this.el = el;
        this.field = options.field;
        this.table = options.table;
        this.valueField = options.valueField;
        this.labelField = options.labelField || 'name';
        this.searchFields = options.searchFields;
        this.listAttributes = options.listAttributes;
        this.multiple = options.multiple;
        this.actions = options.actions || {};

        this.search = '';
        this.results = [];
        this._selected = options.selected || []; // internal selected array

        // Wrap selected in a Proxy to detect changes
        this.selected = new Proxy(this._selected, {
            set: (target, prop, value) => {
                target[prop] = value;
                this.renderSelected();
                return true;
            },
            deleteProperty: (target, prop) => {
                delete target[prop];
                this.renderSelected();
                return true;
            }
        });

        // DOM refs
        this.input = el.querySelector('#search-input');
        this.resultsList = el.querySelector('#results-list');
        this.selectedItems = el.querySelector('#selected-items');
        this.hiddenInputs = el.querySelector('#hidden-inputs');
        this.popupBtn = el.querySelector('#open-popup');

        this.bindEvents();
        this.renderSelected(); // render preselected items
    }

    bindEvents() {
        this.input.addEventListener('input', () => this.fetchResults());

        document.addEventListener('click', (e) => {
            if (!this.el.contains(e.target)) {
                this.resultsList.classList.add('hidden');
            }
        });
    }

    fetchResults() {
        this.search = this.input.value.trim();
        if (!this.search.length) {
            this.results = [];
            this.renderResults();
            return;
        }

        fetch(`/api/autocomplete/search?table=${this.table}&value_field=${this.valueField}&search_fields=${this.searchFields}&q=${encodeURIComponent(this.search)}`)
            .then(res => res.json())
            .then(data => {
                this.results = data;
                this.renderResults();
            })
            .catch(error => {
                console.error('Autocomplete fetch error:', error);
                this.results = [];
                this.renderResults();
            });
    }

    renderResults() {
        this.resultsList.innerHTML = '';
        if (!this.results.length) {
            this.resultsList.classList.add('hidden');
            return;
        }

        this.resultsList.classList.remove('hidden');
        this.results.forEach(item => {
            let li = document.createElement('li');
            li.className = "px-3 py-2 hover:bg-blue-100 cursor-pointer";
            li.textContent = item[this.labelField] ?? item[this.valueField];
            li.addEventListener('click', () => this.selectItem(item));
            this.resultsList.appendChild(li);
        });

        this.resultsList.className = "relative left-0 right-0 mt-1 z-10 bg-white border rounded shadow max-h-60 overflow-y-auto";
    }

    selectItem(item) {
        if (this.multiple) {
            if (!this.selected.find(s => s[this.valueField] === item[this.valueField])) {
                this.selected.push(item); // Proxy triggers renderSelected
            }
        } else {
            this.selected.splice(0, this.selected.length, item); // replace single selection
        }

        this.search = '';
        this.input.value = '';
        this.results = [];
        this.renderResults();
        
        // Call onSelect action if defined
        if (this.actions.onSelect) {
            this.actions.onSelect(item);
        }
    }

    removeItem(index) {
        const removed = this.selected.splice(index, 1)[0]; // Proxy triggers renderSelected
        
        // Call onRemove action if defined
        if (this.actions.onRemove) {
            this.actions.onRemove(removed);
        }
    }

    renderSelected() {
        this.selectedItems.innerHTML = '';
        this.hiddenInputs.innerHTML = '';

        this.selected.forEach((item, index) => {
            // Badge
            let span = document.createElement('span');
            span.className = "px-3 py-1 bg-blue-100 text-blue-800 rounded flex items-center gap-2";

            let text = document.createElement('span');
            text.textContent = item[this.labelField] ?? item[this.valueField];

            let btn = document.createElement('button');
            btn.type = "button";
            btn.textContent = "×";
            btn.className = "text-red-600";
            btn.addEventListener('click', () => this.removeItem(index));

            span.appendChild(text);
            span.appendChild(btn);
            this.selectedItems.appendChild(span);

            // Hidden input
            let hidden = document.createElement('input');
            hidden.type = "hidden";
            hidden.name = this.multiple ? this.field + '[]' : this.field;
            hidden.value = item[this.valueField];
            this.hiddenInputs.appendChild(hidden);
        });
    }

    // New method to set selected programmatically
    setSelected(items) {
        if (this.multiple) {
            this.selected.splice(0, this.selected.length, ...items);
        } else {
            this.selected.splice(0, this.selected.length, items[0] || {});
        }
    }
}

// Initialize autocomplete components
function initAutocompleteComponents(container = document) {
    container.querySelectorAll(".autocomplete-component").forEach((element) => {
        // Check if already initialized
        if (!element.dataset.autocompleteInitialized) {
            try {
                new Autocomplete(element, {
                    field: element.dataset.field,
                    table: element.dataset.table,
                    valueField: element.dataset.valueField,
                    labelField: element.dataset.labelField,
                    searchFields: element.dataset.searchFields,
                    listAttributes: element.dataset.listAttributes,
                    multiple: element.dataset.multiple === "true",
                    actions: JSON.parse(element.dataset.actions || "{}"),
                    selected: JSON.parse(element.dataset.selected || "[]")
                });
                
                // Mark as initialized to prevent re-initialization
                element.dataset.autocompleteInitialized = "true";
            } catch (error) {
                console.error("Autocomplete initialization error:", error, element);
            }
        }
    });
}

// Initialize on DOM ready
document.addEventListener("DOMContentLoaded", () => {
    initAutocompleteComponents();
});

// Set up MutationObserver to handle dynamically added components
const observer = new MutationObserver((mutations) => {
    for (const mutation of mutations) {
        for (const node of mutation.addedNodes) {
            // Skip non-element nodes
            if (node.nodeType !== 1) continue;
            
            // Check if the added node is itself an autocomplete component
            if (node.matches && node.matches('.autocomplete-component')) {
                initAutocompleteComponents(node.parentNode);
            }
            
            // Check if the added node contains any autocomplete components
            if (node.querySelectorAll) {
                const components = node.querySelectorAll('.autocomplete-component');
                if (components.length) {
                    initAutocompleteComponents(node);
                }
            }
        }
    }
});

// Start observing the document for changes
observer.observe(document.body, {
    childList: true,
    subtree: true
});