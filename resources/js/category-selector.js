document.addEventListener("DOMContentLoaded", function () {
    function loadChildren(parentSelect, childSelect, preselected = null) {
        const parentId = parentSelect.value;
        if (!parentId) {
            childSelect.innerHTML = '<option value="">-- Select Child --</option>';
            toggleOtherInput(childSelect, false);
            return;
        }

        if (parentSelect.dataset.loading === parentId) {
            return;
        }
        parentSelect.dataset.loading = parentId;

        fetch(`/api/categories/${parentId}/children`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- choose category --</option>';
                if (Array.isArray(data)) {
                    data.forEach(cat => {
                        let sel = (String(preselected) === String(cat.id)) ? 'selected' : '';
                        options += `<option value="${cat.id}" ${sel}>${cat.name}</option>`;
                    });
                }

                // Always append "Other" option
                options += '<option value="other">Other</option>';

                childSelect.innerHTML = options;

                if (preselected && !childSelect.value) {
                    childSelect.value = preselected;
                }

                // Bind change event for "Other"
                bindOtherOption(childSelect);
            })
            .catch(err => {
                console.error("Error loading children:", err);
                childSelect.innerHTML = '<option value="">-- Error loading --</option>';
            });
    }

    function bindOtherOption(childSelect) {
        if (!childSelect.dataset.boundOther) {
            childSelect.dataset.boundOther = "1";
            
            childSelect.addEventListener("change", function () {
                if (this.value === "other") {
                    toggleOtherInput(this, true);
                } else {
                    toggleOtherInput(this, false);
                }
            });
        }
    }

    function toggleOtherInput(childSelect, show) {
        let container = childSelect.closest(".category_container");
        let other = childSelect.dataset.otherName
        if (!container) return;

        let existingInput = container.querySelector("[data-other-input]");
        if (show) {
            if (!existingInput) {
                let input = document.createElement("input");
                input.type = "text";
                input.name = `${other}`;
                input.placeholder = "Enter custom category";
                input.className = "w-full bg-[#383c3c] text-gray-200 px-4 py-3 pr-12 mt-4 mb-4 rounded-full border border-white/10 shadow-lg shadow-gray-800/40 focus:outline-none focus:ring-1 focus:ring-white placeholder-gray-400";
                input.setAttribute("data-other-input", "1");
                childSelect.insertAdjacentElement("afterend", input);
            }
        } else {
            if (existingInput) {
                existingInput.remove();
            }
        }
    }

    function attachCategoryEvents(container) {
        const parentSelect   = container.querySelector("[data-parent]");
        const childSelect    = container.querySelector("[data-child]");
        const selectedChild  = container.querySelector("[data-selected-child]")?.value || null;

        if (!parentSelect || !childSelect) return;

        if (!parentSelect.dataset.bound) {
            parentSelect.dataset.bound = "1";
            parentSelect.addEventListener("change", function () {
                delete parentSelect.dataset.loading;
                loadChildren(parentSelect, childSelect);
            });
        }

        if (parentSelect.value && !parentSelect.dataset.loading) {
            loadChildren(parentSelect, childSelect, selectedChild);
        }
    }

    function initAll() {
        document.querySelectorAll(".category_container").forEach(container => {
            attachCategoryEvents(container);
        });
    }

    const observer = new MutationObserver(() => {
        initAll();
    });
    observer.observe(document.body, { childList: true, subtree: true });

    initAll();
});
