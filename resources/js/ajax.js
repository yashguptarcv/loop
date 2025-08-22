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
        spinner.className = 'animate-spin rounded-full h-10 w-10 border-4 border-solid border-t-blue-500 border-r-blue-500 border-b-transparent border-l-transparent';

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


    // Set up MutationObserver to handle dynamically added forms
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.addedNodes.length) {
          initializeAjaxForms();
          initTinyMCEEditors();
          initStateFormScript();
          initializeScriptTag();
        }
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
    

    function initializeScriptTag() {
      document.querySelectorAll('#tag-remove').forEach(tag => {
        tag.addEventListener('click', function (e) {
          e.preventDefault();
          console.log($(this).parent().parent().remove());
        });
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


    /**
     * Initialize TinyMCE editors for all textareas with editor="true" attribute
     */
    function initTinyMCEEditors() {
        document.querySelectorAll('textarea[editor="true"]').forEach(textarea => {
            const editorId = textarea.id || `tinymce-editor-${Math.random().toString(36).substr(2, 9)}`;
            textarea.id = editorId;
            
            tinymce.init({
                selector: `#${editorId}`,
                plugins: 'mentions autolink code table lists link wordcount',
                toolbar: 'undo redo | bold italic | bullist numlist | link | alignleft aligncenter alignright alignjustify',
                menubar: false,
                statusbar: false,
                height: 280,
                setup: function(editor) {
                    // Sync content back to textarea on change
                    editor.on('change', function() {
                        textarea.value = editor.getContent();
                    });
                    
                    // Initialize with current textarea content
                    editor.on('init', function() {
                        editor.setContent(textarea.value);
                    });
                }
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

    $(document).find('input[autocomplete="dropdown"]').on('input', function () {

      const $input = $(this);
      const container = $input.closest('#auto-complete');

      if (container.find('.autocomplete-results').length === 0) {
        const $resultsBox = $('<div>', {
          class: 'autocomplete-results absolute z-50 bg-white border border-gray-300 w-full max-h-52 overflow-auto shadow-md rounded-md hidden text-sm',
        });
        container.append($resultsBox);
      }

      var table = $(this).data('table');
      var select_columns = $(this).data('select_columns');
      var search_column = $(this).data('search_column');
      var id = $(this).data('id');
      var query = $(this).val();

      const $resultsBox = container.find('.autocomplete-results');

      // Position the dropdown above the input
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
          url: '/admin/autocomplete/autocomplete',
          type: 'get',
          data: {
            table: table,
            select_columns: select_columns,
            search_column: search_column,
            query: query,
            id: id
          },
          success: function (response) {

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
          error: function (xhr, status, error) {
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
    // Handle click outside to close dropdown
    $(document).on('click', function (e) {
      if (!$(e.target).closest('#auto-complete').length) {
        $('.autocomplete-results').hide();
      }
    });

    // Handle suggestion selection
    $(document).on('click', '.autocomplete-suggestion[role="option"]', function () {
      const $suggestion = $(this);
      const $input = $suggestion.closest('#auto-complete').find('input[autocomplete="dropdown"]');

      $input.val($suggestion.data('name'));
      if ($input.data('target')) {
        $('#' + $input.data('target')).val($suggestion.data('id'));
      }
      $('.autocomplete-results').hide();
    });

    // Keyboard navigation
    $('input[autocomplete="dropdown"]').on('keydown', function (e) {
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

    $(document).on('click', '.autocomplete-suggestion:not(.disabled)', function () {
      const $item = $(this);
      const $container = $item.closest('.col-sm-10');
      const $input = $container.find('input[autocomplete="dropdown"]');
      const targetId = $input.data('target');

      $input.val($item.data('name'));
      $('#' + targetId).val($item.data('id'));
      $container.find('.autocomplete-results').hide();
    });

    // Modified ceAjax function with loader and CSRF token support
    function ceAjax(method, url, options) {
      // Default options
      const config = {
        result_ids: '',
        caching: true,
        callback: null,
        errorCallback: null,
        beforeSend: null,
        complete: null,
        data: null,
        headers: {},
        loader: false, // Default to no loader
        ...options
      };

      // Show loader if enabled
      if (config.loader) {
        Loader.show();
      }

      // Execute beforeSend callback if provided
      if (typeof config.beforeSend === 'function') {
        config.beforeSend();
      }

      // Create XMLHttpRequest
      const xhr = new XMLHttpRequest();

      // Handle caching
      const finalUrl = config.caching ? url : `${url}${url.includes('?') ? '&' : '?'}_=${Date.now()}`;

      // Determine HTTP method
      const httpMethod = method === 'request' ? 'GET' : method.toUpperCase();

      xhr.open(httpMethod, finalUrl, true);

      // Set headers
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      // Add CSRF token for non-GET requests
      if (httpMethod !== 'GET') {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
          xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        }
      }

      // Add custom headers
      for (const [key, value] of Object.entries(config.headers)) {
        xhr.setRequestHeader(key, value);
      }

      xhr.onload = function () {
        // Hide loader if it was shown
        if (config.loader) {
          Loader.hide();
        }

        // Execute complete callback if provided
        if (typeof config.complete === 'function') {
          config.complete();
        }

        if (xhr.status >= 200 && xhr.status < 300) {
          let response;
          try {
            response = JSON.parse(xhr.responseText);
          } catch (e) {
            response = xhr.responseText;
          }

          // Automatic DOM updates based on result_ids
          if (config.result_ids) {
            const resultIds = typeof config.result_ids === 'string'
              ? config.result_ids.split(',')
              : Object.keys(config.result_ids);

            resultIds.forEach(id => {
              const element = document.getElementById(id.trim());
              if (element) {
                if (typeof response === 'object' && response[id.trim()]) {
                  element.innerHTML = response[id.trim()];
                } else if (typeof response === 'string') {
                  element.innerHTML = response;
                }
              }
            });
          }

          // Execute success callback if provided
          if (typeof config.callback === 'function') {
            config.callback(response, config.data);
          }
        } else {
          console.error('Request failed:', xhr.statusText);
          if (typeof config.errorCallback === 'function') {
            config.errorCallback(xhr);
          }
        }
      };

      xhr.onerror = function () {
        // Hide loader on error too
        if (config.loader) {
          Loader.hide();
        }

        // Execute complete callback if provided
        if (typeof config.complete === 'function') {
          config.complete();
        }

        console.error('Network error occurred');
        if (typeof config.errorCallback === 'function') {
          config.errorCallback(xhr);
        }
      };

      // Prepare data
      let requestData = null;
      if (config.data) {
        if (httpMethod === 'GET') {
          const params = new URLSearchParams(config.data).toString();
          xhr.open(httpMethod, `${finalUrl}${finalUrl.includes('?') ? '&' : '?'}${params}`, true);
        } else {
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          requestData = new URLSearchParams(config.data).toString();
        }
      }

      // Send request
      xhr.send(requestData);
    }

    // Make it available globally
    window.ceAjax = ceAjax;

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
    
    tagsInput.addEventListener('keydown', function(e) {
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
    
    tagsInput.addEventListener('blur', function() {
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
        
        tagElement.querySelector('button').addEventListener('click', function() {
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
