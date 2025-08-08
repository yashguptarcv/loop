(function () {
  "use strict";
  const notifications = [];
  let forms = document.querySelectorAll('.form-ajax');

  forms.forEach(function (e) {
    e.addEventListener('submit', function (event) {
      event.preventDefault();
      let thisForm = this;
      let btnText = 'Submit';

      removeErrorDivs(thisForm); // remove errors;

      let action = thisForm.getAttribute('action');
      let method = thisForm.getAttribute('method');
      if (!action) {
        displayError(thisForm, 'The form action property is not set!');
        return;
      }

      thisForm.button.setAttribute('disabled', 'disabled');
      btnText = thisForm.button.innerHTML;
      thisForm.button.innerHTML = 'wait..';
      let formData = new FormData(thisForm);
      formData.append('is_ajax', '1');

      // Add headers for JSON
      const headers = new Headers();
      headers.append('X-Requested-With', 'XMLHttpRequest');
      headers.append('Accept', 'application/json');
      
      // Add CSRF token if it exists in the form
      const csrfToken = thisForm.querySelector('input[name="_token"]')?.value;
      if (csrfToken) {
          headers.append('X-CSRF-TOKEN', csrfToken);
      }
      call(thisForm, action, method, formData, btnText, headers);
    });
  });

  function call(thisForm, action, method, formData, btnText, headers) {
    fetch(action, {
      method: method,
      body: formData,
      headers:headers
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

  let extension = document.querySelectorAll('.list-group#modules div.list-group-item');

  extension.forEach(function (e) {
    e.addEventListener('click', function (event) {
      event.preventDefault();

      var code = $(this).attr('data-code');
      var url = $(this).attr('data-url');
      var method = 'GET';

      ajaxCall(url, method, '{code:' + code + '}');
    });
  });

  function ajaxCall(action, method, formData) {
    fetch(action, {
      method: method,
    })
      .then(response => {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error(`${response.status} ${response.statusText} ${response.url}`);
        }
      })
      .then(data => {
        var res = JSON.parse(data);

        if (res.errors) {
          errorCreate(res.errors, thisForm);
        }

        createModules(res);
      })
      .catch((error) => {
        showToast(error, 'error', 'Error');
      });
  }

  $('input[autocomplete="dropdown"]').on('input', function () {
    const $input = $(this);
    const container = $input.closest('.col-sm-10');

    if (container.find('.autocomplete-results').length === 0) {
      const $resultsBox = $('<div>', {
        class: 'autocomplete-results absolute z-50 bg-white border border-gray-300 w-2/3 max-h-52 overflow-auto shadow-md rounded-md hidden text-sm',
      });
      container.append($resultsBox);
    }

    var table = $(this).data('table');
    var select_columns = $(this).data('select_columns');
    var search_column = $(this).data('search_column');
    var id = $(this).data('id');
    var query = $(this).val();

    const $resultsBox = container.find('.autocomplete-results');
    if (query.length < 2) {
      $resultsBox.hide();
      return;
    }
    if (query.length >= 3) {
      $.ajax({
        url: 'admin.php?dispatch=common.autocomplete.autocomplete',
        type: 'get',
        data: {
          table: table,
          select_columns: select_columns,
          search_column: search_column,
          query: query,
          id: id
        },
        success: function (response) {
          var data = JSON.parse(response);
          if (data.length) {
            let html = '';
            data.forEach(item => {
              html += `<div class="autocomplete-suggestion px-3 py-2 hover:bg-gray-100 cursor-pointer" data-id="${item.id}" data-name="${item.name}">${item.name}</div>`;
            });
            $resultsBox.html(html).show();
          } else {
            $resultsBox.html('<div class="autocomplete-suggestion disabled px-3 py-2 text-gray-400">No results found</div>').show();
          }
        }
      });
    } else {
      $('.autocomplete-results').hide();
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

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.col-sm-10').length) {
      $('.autocomplete-results').hide();
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a[type="delete_selected"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();

        const formId = link.getAttribute('form');
        const form = document.getElementById(formId);
        if (!form) {
          showToast('Form not found.', 'error', 'Error');
          return;
        }

        const checkedBoxes = form.querySelectorAll('input[type="checkbox"]:checked');

        if (checkedBoxes.length === 0) {
          showToast('Please select at least one item to delete.', 'error', 'Error');
          return;
        }

        if (!confirm('Are you sure you want to delete selected items?')) {
          return;
        }

        form.setAttribute('action', link.getAttribute('dispatch'));
        form.submit();
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const toggleAllCheckbox = document.querySelector('.bulkedit-toggler');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    if (!toggleAllCheckbox) return;

    toggleAllCheckbox.addEventListener('change', function () {
      rowCheckboxes.forEach(cb => {
        cb.checked = toggleAllCheckbox.checked;
        toggleAllCheckbox.checked
          ? cb.setAttribute('checked', 'checked')
          : cb.removeAttribute('checked');
      });
    });

    rowCheckboxes.forEach(cb => {
      cb.addEventListener('change', function () {
        if (!this.checked) {
          toggleAllCheckbox.checked = false;
          toggleAllCheckbox.removeAttribute('checked');
        } else if (document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length) {
          toggleAllCheckbox.checked = true;
          toggleAllCheckbox.setAttribute('checked', 'checked');
        }

        this.checked
          ? this.setAttribute('checked', 'checked')
          : this.removeAttribute('checked');
      });
    });
  });


})();
