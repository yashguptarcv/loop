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
        this.selected = options.selected || []; // load initial

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
        // this.popupBtn.addEventListener('click', () => this.openPopup());

        // Close dropdown on outside click
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

        fetch(`/admin/autocomplete/search?table=${this.table}&value_field=${this.valueField}&search_fields=${this.searchFields}&q=${this.search}`)
            .then(res => res.json())
            .then(data => {
                this.results = data;
                this.renderResults();
            });
    }

    renderResults() {
        this.resultsList.innerHTML = '';
        if (!this.results.length) {
            this.resultsList.classList.add('hidden');
            return;
        }

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
                this.selected.push(item);
            }
        } else {
            this.selected = [item];
        }

        this.search = '';
        this.input.value = '';
        this.results = [];
        this.renderResults();
        this.renderSelected();
    }

    removeItem(index) {
        this.selected.splice(index, 1);
        this.renderSelected();
    }

    renderSelected() {
        this.selectedItems.innerHTML = '';
        this.hiddenInputs.innerHTML = '';

        this.selected.forEach((item, index) => {
            // Badge
            let span = document.createElement('span');
            span.className = "px-3 py-1 bg-blue-100 text-blue-800 rounded flex items-center gap-2";

            let text = document.createElement('span');
            text.textContent = item[this.labelField] ?? item[this.valueField]; // show name

            let btn = document.createElement('button');
            btn.type = "button";
            btn.textContent = "×";
            btn.className = "text-red-600";
            btn.addEventListener('click', () => this.removeItem(index));

            span.appendChild(text);
            span.appendChild(btn);
            this.selectedItems.appendChild(span);

            // Hidden input (for form submit)
            let hidden = document.createElement('input');
            hidden.type = "hidden";
            hidden.name = this.multiple ? this.field + '[]' : this.field;
            hidden.value = item[this.valueField]; // submit ID, not text
            this.hiddenInputs.appendChild(hidden);
        });
    }
}

// init
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".autocomplete-component").forEach((element) => {
        new Autocomplete(element, {
            field: element.dataset.field,
            table: element.dataset.table,
            valueField: element.dataset.valueField,
            labelField: element.dataset.labelField,
            searchFields: element.dataset.searchFields,
            listAttributes: element.dataset.listAttributes,
            multiple: element.dataset.multiple === "true",
            actions: JSON.parse(element.dataset.actions || "[]"),
            selected: JSON.parse(element.dataset.selected || "[]")
        });
    });
});

