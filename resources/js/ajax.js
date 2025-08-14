(function () {
  "use strict";
  document.addEventListener('DOMContentLoaded', function () {
    const notifications = [];

    // Initialize all existing forms
    initializeAjaxForms();

    // Set up MutationObserver to handle dynamically added forms
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.addedNodes.length) {
          initializeAjaxForms();
        }
      });
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });

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

    function ceAjax(method, url, options) {
      // Default options
      const config = {
        result_ids: '',
        caching: true,
        callback: null,
        data: null,
        headers: {},
        ...options
      };

      // Create XMLHttpRequest
      const xhr = new XMLHttpRequest();

      // Handle caching
      const finalUrl = config.caching ? url : `${url}${url.includes('?') ? '&' : '?'}_=${Date.now()}`;

      // Determine HTTP method
      const httpMethod = method === 'request' ? 'GET' : method.toUpperCase();

      xhr.open(httpMethod, finalUrl, true);

      // Set headers
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      for (const [key, value] of Object.entries(config.headers)) {
        xhr.setRequestHeader(key, value);
      }

      xhr.onload = function () {
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

          // Execute callback if provided
          if (config.callback) {
            config.callback(response, config.data);
          }
        } else {
          console.error('Request failed:', xhr.statusText);
        }
      };

      xhr.onerror = function () {
        console.error('Network error occurred');
      };

      // Send request
      if (config.data) {
        if (httpMethod === 'GET') {
          const params = new URLSearchParams(config.data).toString();
          xhr.open(httpMethod, `${finalUrl}${finalUrl.includes('?') ? '&' : '?'}${params}`, true);
          xhr.send();
        } else {
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.send(new URLSearchParams(config.data));
        }
      } else {
        xhr.send();
      }
    }

     window.ceAjax = ceAjax;
  });

})();
