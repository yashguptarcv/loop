document.addEventListener("DOMContentLoaded", function () {
    function loadStates(countrySelect, stateSelect, preselected = null) {
        const countryId = countrySelect.value;
        if (!countryId) {
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            return;
        }

        // prevent duplicate fetches for same country in same component
        if (countrySelect.dataset.loading === countryId) {
            return;
        }
        countrySelect.dataset.loading = countryId;

        fetch(`/api/countries/${countryId}/states`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Select State --</option>';
                data.forEach(state => {
                    let sel = (String(preselected) === String(state.id)) ? 'selected' : '';
                    options += `<option value="${state.id}" ${sel}>${state.name}</option>`;
                });
                stateSelect.innerHTML = options;

                // fallback: force-select
                if (preselected && !stateSelect.value) {
                    stateSelect.value = preselected;
                }
            })
            .catch(() => {
                stateSelect.innerHTML = '<option value="">-- Error loading states --</option>';
            });
    }

    function attachCountryStateEvents(container) {
        if (!container) return;

        const countrySelect = container.querySelector("[data-country]");
        const stateSelect   = container.querySelector("[data-state]");
        const selectedState = container.querySelector("[data-selected-state]")?.value || null;

        if (!countrySelect || !stateSelect) return;

        // Bind change event only once
        if (!countrySelect.dataset.bound) {
            countrySelect.dataset.bound = "1";
            countrySelect.addEventListener("change", function () {
                delete countrySelect.dataset.loading;
                loadStates(countrySelect, stateSelect);
            });
        }

        // On first load
        if (countrySelect.value && !countrySelect.dataset.loading) {
            loadStates(countrySelect, stateSelect, selectedState);
        }
    }

    function initAll() {
        document.querySelectorAll(".country_state_container").forEach(container => {
            attachCountryStateEvents(container);
        });
    }

    // Observe AJAX inserts
    const observer = new MutationObserver(() => {
        initAll();
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Initial
    initAll();
});