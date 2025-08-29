
document.addEventListener("DOMContentLoaded", function () {
    // Pass preselected state ID from backend (null if none)
    const selectedState = [];

    function loadStates(countrySelect, stateSelect, preselected = null) {
        const countryId = countrySelect.value;
        if (!countryId) {
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            return;
        }

        // prevent duplicate fetches for same country
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

                // fallback: force-select if preselected was passed
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

        const countrySelect = container.querySelector("#country_select");
        const stateSelect   = container.querySelector("#state_select");
        if (!countrySelect || !stateSelect) return;

        // Bind change event only once
        if (!countrySelect.dataset.bound) {
            countrySelect.dataset.bound = "1";
            countrySelect.addEventListener("change", function () {
                delete countrySelect.dataset.loading; // clear previous cache
                loadStates(countrySelect, stateSelect);
            });
        }

        // On first load, fetch states & apply selectedState
        if (countrySelect.value && !countrySelect.dataset.loading) {
            loadStates(countrySelect, stateSelect, selectedState);
        }
    }

    // Observe AJAX inserts
    const observer = new MutationObserver(() => {
        const container = document.getElementById("country_state_container");
        attachCountryStateEvents(container);
    });
    observer.observe(document.body, { childList: true, subtree: true });

    // Initial attach
    attachCountryStateEvents(document.getElementById("country_state_container"));
});