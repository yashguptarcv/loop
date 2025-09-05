(function () {
  "use strict";
  document.addEventListener('DOMContentLoaded', function () {
    const notifications = [];


    // Loader Management Functions
    const Loader = {
      // Create loader element with blur background
      createLoader: function () {
        const loader = document.createElement('div');
        loader.id = 'ajax-loader';
        loader.className = 'fixed inset-0 backdrop-blur-sm z-50 flex items-center justify-center';

        // Semi-transparent overlay
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-white-100 bg-opacity-20';
        loader.appendChild(overlay);

        // Centered rounded box (smaller size)
        const loaderBox = document.createElement('div');
        loaderBox.className = 'relative bg-blue-100 bg-opacity-90 rounded-xl p-3 shadow-xl flex flex-col items-center justify-center';
        loaderBox.style.minWidth = '80px';
        loaderBox.style.minHeight = '80px';

        // Circular loader animation (smooth and modern)
        const spinner = document.createElement('div');
        spinner.className = 'animate-spin rounded-full h-10 w-10 border-4 border-solid border-t-primary-500 border-r-primary-100 border-b-transparent border-l-transparent';

        // // Optional loading text
        // const loadingText = document.createElement('div');
        // loadingText.className = 'mt-3 text-gray-600 text-sm font-medium';
        // loadingText.textContent = 'Loading...';

        loaderBox.appendChild(spinner);
        // loaderBox.appendChild(loadingText);
        loader.appendChild(loaderBox);
        document.body.appendChild(loader);

        return loader;
      },

      // Show loader
      show: function () {
        let loader = document.getElementById('ajax-loader');
        if (!loader) {
          loader = this.createLoader();
        }
        loader.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scrolling
      },

      // Hide loader
      hide: function () {
        const loader = document.getElementById('ajax-loader');
        if (loader) {
          loader.style.display = 'none';
          document.body.style.overflow = ''; // Restore scrolling
          // Optional: Remove loader from DOM after hiding
          setTimeout(() => {
            if (loader.parentNode) {
              loader.parentNode.removeChild(loader);
            }
          }, 300);
        }
      }
    };

    // Add the required CSS dynamically
    const loaderCSS = `
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      .animate-spin {
        animation: spin 0.8s linear infinite;
      }
      #ajax-loader {
        display: none;
      }
      .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
      }
    `;
    const style = document.createElement('style');
    style.type = 'text/css';
    style.appendChild(document.createTextNode(loaderCSS));
    document.head.appendChild(style);
    // Initialize all existing forms
    initializeAjaxForms();
    initTinyMCEEditors();
    initializeScriptTag();
    initStateFormScript();
    initializeScriptSource();
    initializeImageUploaders();
    // setupDropdowns();


    // Set up MutationObserver to handle dynamically added forms
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.addedNodes.length) {
          initializeAjaxForms();
          initTinyMCEEditors();
          initStateFormScript();
          initializeScriptTag();
          initializeScriptSource();
          initializeImageUploaders();

        }
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });

    // start dropdown
    const GAP = 8;
    let openMenu = null;

    function closeMenu() {
      if (openMenu) {
        openMenu.style.display = "none";
        openMenu.classList.add("opacity-0", "scale-95", "invisible");
        openMenu = null;
      }
    }

    function openMenuAt(trigger, menu) {
      closeMenu();

      // make measurable
      menu.style.display = "block";
      menu.style.position = "fixed";
      menu.style.visibility = "hidden";
      menu.classList.remove("opacity-0", "scale-95", "invisible");

      const triggerRect = trigger.getBoundingClientRect();
      const menuRect = menu.getBoundingClientRect();
      const vw = window.innerWidth;
      const vh = window.innerHeight;

      let top = triggerRect.bottom + GAP;
      let left = triggerRect.right - menuRect.width;

      // flip up if not enough space below
      if (vh - triggerRect.bottom < menuRect.height + GAP) {
        top = triggerRect.top - menuRect.height - GAP;
      }

      // keep inside viewport horizontally
      if (left < 8) left = 8;
      if (left + menuRect.width > vw - 8) left = vw - menuRect.width - 8;

      // apply final position
      menu.style.top = `${top}px`;
      menu.style.left = `${left}px`;
      menu.style.visibility = "visible";

      menu.classList.add("opacity-100", "scale-100", "visible");
      openMenu = menu;
    }

    document.addEventListener("click", function (e) {
      const trigger = e.target.closest(".dropdown-trigger");
      if (trigger) {
        e.preventDefault();
        const id = trigger.getAttribute("data-id");
        const menu = document.querySelector(`.dropdown-menu[data-id="${id}"]`);
        if (!menu) return;

        if (menu === openMenu) {
          closeMenu();
        } else {
          openMenuAt(trigger, menu);
        }
      } else if (!e.target.closest(".dropdown-menu")) {
        closeMenu();
      }
    });
    // end dropdown

    function initializeImageUploaders() {
      document.querySelectorAll(".image-uploader").forEach((uploader, uploaderIndex) => {
        const fileInput = uploader.querySelector(".image-input");
        const previewContainer = uploader.querySelector(".preview-container");

        if (!fileInput || !previewContainer) return;

        // --- clear old listeners (important if MutationObserver re-inits) ---
        fileInput.removeEventListener("change", handleFileChange);
        previewContainer.removeEventListener("click", handleRemoveClick);

        fileInput.addEventListener("change", handleFileChange);
        previewContainer.addEventListener("click", handleRemoveClick);

        function handleFileChange(e) {
          previewContainer.innerHTML = ""; // reset previews

          [...e.target.files].forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (ev) {
              const imageCard = document.createElement("div");
              imageCard.className =
                "relative border rounded-lg p-2 w-[160px] h-[160px] flex flex-col justify-between items-center bg-white shadow new-image";
              imageCard.dataset.index = index;

              imageCard.innerHTML = `
            <img src="${ev.target.result}" class="h-[100px] w-full object-contain rounded">
            <input type="text" name="new_alts[${uploaderIndex}][]" value="${file.name}" 
                   class="mt-2 px-2 py-1 border border-gray-300 rounded text-sm w-full"
                   placeholder="Alt text">
            <button type="button" class="absolute top-1 right-1 text-red-500 hover:text-red-700 remove-btn">
              <i class="fas fa-times"></i>
            </button>
          `;

              previewContainer.appendChild(imageCard);
            };
            reader.readAsDataURL(file);
          });
        }

        function handleRemoveClick(e) {
          if (e.target.closest(".remove-btn")) {
            const card = e.target.closest(".new-image");
            if (!card) return;

            const index = parseInt(card.dataset.index, 10);
            card.remove();

            // rebuild FileList without removed file
            const dt = new DataTransfer();
            [...fileInput.files].forEach((f, i) => {
              if (i !== index) dt.items.add(f);
            });
            fileInput.files = dt.files;
          }
        }
      });
    }


    function initializeScriptTag() {
      $(document).off('click', '.tag-remove').on('click', '.tag-remove', function (e) {
        e.preventDefault();

        // Get the tag ID from the button's data attribute
        const tagId = $(this).data('tag-id');

        $(this).closest('tr').remove();
      });

      $(document).off('click', '#tag-add').on('click', '#tag-add', function (e) {
        e.preventDefault();

        const $currentRow = $(this).closest('tr');
        const $clonedRow = $currentRow.clone();

        // Change Add → Remove
        const $button = $clonedRow.find('#tag-add');
        $button
          .removeClass('bg-blue-100 text-blue-600 border-blue-300 hover:border-blue-300 hover:text-blue-300')
          .addClass('bg-red-100 text-red-600 border-red-300 hover:border-red-300 hover:text-red-300')
          .attr('id', 'tag-remove')
          .html("<span class='material-icons-outlined mr-1 text-xs'>delete</span>");

        // Clear inputs
        $clonedRow.find('input').val('');

        // Insert before current row
        $currentRow.before($clonedRow);
      });


    }

    function initializeScriptSource() {

      $(document).off('click', '.source-remove').on('click', '.source-remove', function (e) {
        e.preventDefault();

        // Get the source ID from the button's data attribute
        const sourceId = $(this).data('source-id');
        $(e.target).closest('tr').remove();

      });


      $(document).off('click', '#source-add').on('click', '#source-add', function (e) {
        e.preventDefault();
        console.log("Clicked");

        const $currentRow = $(this).closest('tr');
        const $clonedRow = $currentRow.clone();

        // Change Add → Remove
        const $button = $clonedRow.find('#source-add');
        $button
          .removeClass('bg-blue-100 text-blue-600 border-blue-300 hover:border-blue-300 hover:text-blue-300')
          .addClass('bg-red-100 text-red-600 border-red-300 hover:border-red-300 hover:text-red-300')
          .attr('id', 'source-remove')
          .html("<span class='material-icons-outlined mr-1 text-xs'>delete</span>");

        // Clear inputs
        $clonedRow.find('input').val('');

        // Insert before current row
        $currentRow.before($clonedRow);
      });
    }

    /**
     * Initialize TinyMCE editors for all textareas with editor="true" attribute
     */
    function initTinyMCEEditors() {
      document.querySelectorAll('textarea[editor="true"]').forEach(textarea => {
var heightEditor = textarea.dataset.height || 280; 
        const editorId = textarea.id || `tinymce-editor-${Math.random().toString(36).substr(2, 9)}`;
        textarea.id = editorId;

        tinymce.init({
          selector: `#${editorId}`,
          plugins: 'mentions autolink code table lists link wordcount',
          toolbar: 'undo redo | bold italic | bullist numlist | link | alignleft aligncenter alignright alignjustify',
          menubar: false,
          statusbar: false,
          height: heightEditor,
          setup: function (editor) {
            // Sync content back to textarea on change
            editor.on('change', function () {
              textarea.value = editor.getContent();
            });

            // Initialize with current textarea content
            editor.on('init', function () {
              editor.setContent(textarea.value);
            });
          }
        });
      });
    }

    function initQuillEditors() {
      document.querySelectorAll('textarea[editor="true"]').forEach(textarea => {
        const id = textarea.id || `quill-editor-${Math.random().toString(36).substr(2, 9)}`;
        textarea.style.display = "none"; // hide original textarea

        // Create a wrapper div for Quill
        const editorDiv = document.createElement("div");
        editorDiv.id = "quill-" + id;
        editorDiv.style.height = "280px";
        textarea.parentNode.insertBefore(editorDiv, textarea.nextSibling);

        // Init Quill
        const quill = new Quill(editorDiv, {
          theme: "snow",
          modules: {
            toolbar: [
              [{ 'undo': 'undo', 'redo': 'redo' }], // you need custom module for undo/redo
              ["bold", "italic", "underline", "strike"],
              [{ "list": "ordered" }, { "list": "bullet" }],
              [{ "align": [] }],
              ["link", "code-block", "table"]
            ]
          }
        });

        // Set initial content from textarea
        quill.root.innerHTML = textarea.value;

        // Sync back to textarea on change
        quill.on("text-change", () => {
          textarea.value = quill.root.innerHTML;
        });
      });
    }

    function initializeAjaxForms() {
      document.querySelectorAll('.form-ajax').forEach(form => {
        // Skip forms that already have event listeners
        if (form.hasAttribute('data-ajax-initialized')) return;

        form.setAttribute('data-ajax-initialized', 'true');

        form.addEventListener('submit', function (e) {
          e.preventDefault();
          handleFormSubmission(this);
        });
      });
    }

    function initStateFormScript() {
      const form = document.getElementById('stateForm');
      if (!form) return; // if form not present, skip

      const countrySelect = form.querySelector('#country');
      const countryCodeInput = form.querySelector('#country_code');
      if (!countrySelect || !countryCodeInput) return;

      function setCountryCodeFromSelected() {
        const selectedOption = countrySelect.options[countrySelect.selectedIndex];
        const code = selectedOption.getAttribute('data-code') || '';
        countryCodeInput.value = code;
      }

      // bind only once (prevent duplicate binding if popup reopens)
      if (!countrySelect.dataset.bound) {
        countrySelect.addEventListener('change', setCountryCodeFromSelected);
        countrySelect.dataset.bound = "true";
      }

      if (!countryCodeInput.value) {
        setCountryCodeFromSelected();
      }
    }

    function handleFormSubmission(form) {
      // Find the submit button (more reliable than form.button)
      const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
      let btnText = submitButton ? submitButton.textContent : 'Submit';

      removeErrorDivs(form); // Remove existing errors

      const action = form.getAttribute('action');
      const method = form.getAttribute('method') || 'POST'; // Default to POST

      if (!action) {
        displayError(form, 'The form action property is not set!');
        return;
      }

      Loader.show();

      // Disable submit button and show loading state
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';
      }

      const formData = new FormData(form);
      formData.append('is_ajax', '1');

      // Set up headers
      const headers = new Headers();
      headers.append('X-Requested-With', 'XMLHttpRequest');
      headers.append('Accept', 'application/json');

      // Add CSRF token from multiple possible sources
      const csrfToken = form.querySelector('input[name="_token"]')?.value ||
        form.querySelector('input[name="csrf_token"]')?.value ||
        document.querySelector('meta[name="csrf-token"]')?.content;

      if (csrfToken) {
        headers.append('X-CSRF-TOKEN', csrfToken);
      }

      // Make the AJAX call
      call(form, action, method, formData, btnText, headers, submitButton);
    }

    function call(thisForm, action, method, formData, btnText, headers) {
      fetch(action, {
        method: method,
        body: formData,
        headers: headers
      })
        .then(response => {
          Loader.hide();
          if (response.ok) {
            return response.text();
          } else {
            throw new Error(`${response.status} ${response.statusText} ${response.url}`);
          }
        })
        .then(data => {
          thisForm.button.removeAttribute('disabled');
          thisForm.button.innerHTML = btnText;

          var res = JSON.parse(data);

          if (res.errors) {
            errorCreate(res.errors, thisForm);
          }

          if (res.success) {
            showToast(res.message, 'success', 'Success');
            sessionStorage.setItem('toastMessage', JSON.stringify({
              message: res.message,
              type: 'success',
              title: 'Success'
            }));
          }

          if (res.callback) {
            // res.callback;
            if (res.callback && typeof res.callback === 'string') {
              new Function(res.callback)(); // runs "loadOrder()"
            }
          }

          if (res.redirect_url) {
            window.location.href = res.redirect_url;
          }


        })
        .catch((error) => {
          displayError(thisForm, error, btnText);
        });
    }

    function displayError(thisForm, error, btnText) {
      showToast(error, 'error', 'Error');
      thisForm.button.removeAttribute('disabled');
      thisForm.button.innerHTML = btnText;
    }

    function errorCreate(errors, formData) {
      if (errors.length === undefined) {
        $.each(errors, function (i, v) {
          var errorText = `<div class="text-red-500 text-sm mt-1" id="errors"><small>${v}</small></div>`;
          var id = `#${i}`;
          showToast(v, 'error', 'Error');
          if ($(formData).find(id).length) {
            $(formData).find(id).addClass('border border-red-500');
            $(formData).find(id).parent().append(errorText);
          }
        });
      } else {
        showToast(errors, 'error', 'Error');
      }
    }

    function removeErrorDivs(formData) {
      var errorElements = formData.querySelectorAll('#errors');
      errorElements.forEach(function (errorElement) {
        $(errorElement).parent().find('input, select, textarea').removeClass('border border-red-500');
        errorElement.remove();
      });
    }

    // Robust ceAjax with reliable result_ids handling and append option
    window.ceAjax = function (method, url, options = {}) {
      const config = {
        result_ids: '',        // string "id1,id2" or ['id1','id2'] or { id1: 'replace', id2: 'append' }
        append: false,         // if true -> append (insertAdjacentHTML 'beforeend'), otherwise replace innerHTML
        caching: true,
        callback: null,
        errorCallback: null,
        beforeSend: null,
        complete: null,
        data: null,
        headers: {},
        loader: false,
        debug: false,          // set true to log response & mapping
        ...options
      };

      if (config.loader && window.Loader && typeof Loader.show === 'function') Loader.show();
      if (typeof config.beforeSend === 'function') config.beforeSend();

      const xhr = new XMLHttpRequest();
      let finalUrl = config.caching ? url : `${url}${url.includes('?') ? '&' : '?'}_=${Date.now()}`;
      const httpMethod = method.toUpperCase();

      // Append GET data params to URL before opening (so we don't re-open)
      if (httpMethod === 'GET' && config.data) {
        const params = new URLSearchParams(config.data).toString();
        finalUrl += (finalUrl.includes('?') ? '&' : '?') + params;
      }

      xhr.open(httpMethod, finalUrl, true);

      // CSRF token only for non-GET
      if (httpMethod !== 'GET') {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
      }

      // Apply custom headers (if any)
      if (config.headers && typeof config.headers === 'object') {
        for (const [key, value] of Object.entries(config.headers)) {
          if (key && value !== undefined) xhr.setRequestHeader(key, value);
        }
      }

      // Must be last so it never gets overridden
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      xhr.onload = function () {
        if (config.loader && window.Loader && typeof Loader.hide === 'function') Loader.hide();
        if (typeof config.complete === 'function') config.complete();

        // success
        if (xhr.status >= 200 && xhr.status < 300) {
          let response;
          try {
            response = JSON.parse(xhr.responseText);
          } catch (e) {
            response = xhr.responseText;
          }

          if (config.debug) {
            console.log('ceAjax response:', response);
          }

          // handle result_ids mapping
          if (config.result_ids) {
            // normalize resultIds into an array of ids
            let resultIds = [];
            if (Array.isArray(config.result_ids)) resultIds = config.result_ids;
            else if (typeof config.result_ids === 'string') resultIds = config.result_ids.split(',').map(s => s.trim()).filter(Boolean);
            else if (typeof config.result_ids === 'object') resultIds = Object.keys(config.result_ids);

            // function to set content on an element according to mode
            const applyContent = (el, content, mode = 'replace') => {
              if (!el) return;
              if (content === null || content === undefined) return;
              if (mode === 'append') {
                // insert HTML as-is
                el.insertAdjacentHTML('beforeend', typeof content === 'string' ? content : String(content));
              } else if (mode === 'prepend') {
                el.insertAdjacentHTML('afterbegin', typeof content === 'string' ? content : String(content));
              } else { // replace
                el.innerHTML = typeof content === 'string' ? content : String(content);
              }
            };

            // response is a string (HTML) -> apply same HTML to all target elements (or first only if desired)
            if (typeof response === 'string') {
              resultIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el && config.debug) console.warn(`ceAjax: no element with id="${id}"`);
                applyContent(el, response, config.append ? 'append' : 'replace');
              });
            } else if (typeof response === 'object' && response !== null) {
              // if server returned per-id html keys, use them (highest priority)
              resultIds.forEach(id => {
                const el = document.getElementById(id);
                if (!el) {
                  if (config.debug) console.warn(`ceAjax: no element with id="${id}"`);
                  return;
                }

                // determine mode for this id: if config.result_ids was an object with modes, respect it
                let mode = config.append ? 'append' : 'replace';
                if (typeof config.result_ids === 'object' && config.result_ids[id]) {
                  const val = config.result_ids[id];
                  if (val === 'append' || val === 'prepend' || val === 'replace') mode = val;
                }

                // priority mapping:
                // 1) response[id]  (exact key)
                // 2) response.html (common pattern)
                // 3) response.data (sometimes used)
                // 4) fallback: stringify response (only in debug mode, normally skip)
                if (response.hasOwnProperty(id) && (response[id] !== null && response[id] !== undefined)) {
                  applyContent(el, response[id], mode);
                } else if (response.hasOwnProperty('html') && response.html !== null && response.html !== undefined) {
                  applyContent(el, response.html, mode);
                } else if (response.hasOwnProperty('data') && typeof response.data === 'string') {
                  applyContent(el, response.data, mode);
                } else {
                  if (config.debug) {
                    console.warn(`ceAjax: response did not contain html for id="${id}". Response keys:`, Object.keys(response));
                  }
                }
              });
            }
          }

          if (typeof config.callback === 'function') config.callback(response, config.data);
        } else {
          // error
          if (config.debug) console.error('ceAjax error', xhr.status, xhr.responseText);
          if (typeof config.errorCallback === 'function') config.errorCallback(xhr);
        }
      };

      xhr.onerror = function () {
        if (config.loader && window.Loader && typeof Loader.hide === 'function') Loader.hide();
        if (typeof config.complete === 'function') config.complete();
        if (typeof config.errorCallback === 'function') config.errorCallback(xhr);
      };

      // prepare body for non-GETs
      let requestData = null;
      if (config.data && httpMethod !== 'GET') {
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        requestData = new URLSearchParams(config.data).toString();
      }

      xhr.send(requestData);
    };



  });

  // Tags manager
  const tagContainer = document.getElementById('tag-container');
  const tagsInput = document.getElementById('tags-input');
  const hiddenInput = document.getElementById('tags');
  const datalist = document.getElementById('tagList');

  // Check if required elements exist
  if (!tagContainer || !tagsInput || !hiddenInput || !datalist) {
    console.error('One or more required elements for tag manager not found');
    return;
  }

  // Initialize with existing tags
  const initialTags = hiddenInput.value ? hiddenInput.value.split(',').filter(tag => tag.trim()) : [];
  initialTags.forEach(tag => addTag(tag.trim()));
  updateHiddenInput();

  tagsInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      handleTagInput();
    } else if (e.key === ',' || e.key === ';') {
      e.preventDefault();
      handleTagInput();
    } else if (e.key === 'Backspace' && this.value === '') {
      const tags = tagContainer.querySelectorAll('.tag');
      if (tags.length > 0) {
        const lastTag = tags[tags.length - 1];
        removeTag(lastTag);
        tagsInput.focus();
      }
    }
  });

  tagsInput.addEventListener('blur', function () {
    if (this.value.trim() !== '') {
      handleTagInput();
    }
  });

  function handleTagInput() {
    if (tagsInput.value.trim() !== '') {
      addTag(tagsInput.value.trim());
      tagsInput.value = '';
    }
  }

  function addTag(tagName) {
    if (!tagName) return;

    // Check if tag already exists
    const existingTags = Array.from(tagContainer.querySelectorAll('.tag')).map(tag => tag.dataset.tag);
    if (existingTags.includes(tagName)) {
      tagsInput.value = '';
      return;
    }

    const tagElement = document.createElement('div');
    tagElement.className = 'tag inline-flex items-center bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm';
    tagElement.dataset.tag = tagName;

    tagElement.innerHTML = `
            ${tagName}
            <button type="button" class="ml-1.5 -mr-1 text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-100 focus:outline-none">
                &times;
            </button>
        `;

    tagElement.querySelector('button').addEventListener('click', function () {
      removeTag(tagElement);
      tagsInput.focus();
    });

    // Insert before the input
    tagContainer.insertBefore(tagElement, tagsInput);
    updateHiddenInput();
  }

  function removeTag(tagElement) {
    if (tagElement && tagElement.parentNode) {
      tagElement.remove();
      updateHiddenInput();
    }
  }

  function updateHiddenInput() {
    if (!hiddenInput) return;
    const tags = Array.from(tagContainer.querySelectorAll('.tag')).map(tag => tag.dataset.tag);
    hiddenInput.value = tags.join(',');
  }

})();
