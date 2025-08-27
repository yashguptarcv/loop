(function () {
  "use strict";

  let forms = document.querySelectorAll('.form-ajax');

  console.log(forms);
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

      console.log(thisForm.button);

      thisForm.button.setAttribute('disabled', 'disabled');
      btnText = thisForm.button.innerHTML;
      thisForm.button.innerHTML = 'wait..';
      // thisForm.querySelector('.error-message').classList.remove('d-block');
      // thisForm.querySelector('.sent-message').classList.remove('d-block');

      let formData = new FormData(thisForm);

      formData.append('is_ajax', '1'); // Append the is_ajax field with the value '1'

      call(thisForm, action, method, formData, btnText);
    });
  });

  function call(thisForm, action, method, formData, btnText) {

    fetch(action, {
      method: method,
      body: formData,
      // headers: {'X-Requested-With': 'XMLHttpRequest'}
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
        // thisForm.querySelector('.loading').classList.remove('d-block');

        var res = JSON.parse(data);

        if (res.errors) {
          errorCreate(res.errors, thisForm);
        }

        if (res.success) {
          // thisForm.querySelector('.sent-message').innerHTML = res.message;
          // thisForm.querySelector('.sent-message').classList.add('d-block');
          // thisForm.reset();
          showToast(res.message, 'success', 'Success');

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
    if (errors.length == undefined) {
      $.each(errors, function (i, v) {
        var errorText = `<div class="text-danger" id="errors" style="font-size:12px;"><small>${v}</small></div>`;

        var id = `#${i}`;
        showToast(v, 'error', 'Error');


        if ($(formData).find(id).length) {
          $(formData).find(id).css({
            'border': '1px solid red'
          });
          $(formData).find(id).parent().append(errorText);
        }

      });
    } else {
      showToast(errors, 'error', 'Error');
    }
  }

  function removeErrorDivs(formData) {
    var errorElement = `#errors`;

    var errorElements = formData.querySelectorAll(errorElement);

    errorElements.forEach(function (errorElement) {
      console.log($(errorElement).parent().find('input, select, textarea').css({
        'border': 'none'
      }));
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

    // Check if .autocomplete-results already exists, if not, create it
    if (container.find('.autocomplete-results').length === 0) {
      const $resultsBox = $('<div>', {
        class: 'autocomplete-results form-control',
        css: {
          display: 'none',
          position: 'absolute',
          zIndex: 1000,
          background: '#fff',
          border: '1px solid #ccc',
          width: '65%',
          maxHeight: '200px',
          overflow: 'auto'
        }
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
    if (query.length >= 3) {  // Start fetching results after 2 characters
      $.ajax({
        url: 'admin.php?dispatch=common.autocomplete.autocomplete',  // Modify the URL based on your route
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
              html += `<div class="autocomplete-suggestion" style="cusror:pointer;" data-id="${item.id}" data-name="${item.name}">${item.name}</div>`;
            });
            $resultsBox.html(html).show();
          } else {
            $resultsBox.html('<div class="autocomplete-suggestion disabled">No results found</div>').show();
          }
        }
      });
    } else {
      $('#autocomplete-results').hide();
    }
  });

  // On select
  $(document).on('click', '.autocomplete-suggestion:not(.disabled)', function () {

    const $item = $(this);
    const $container = $item.closest('.col-sm-10');
    const $input = $container.find('input[autocomplete="dropdown"]');
    const targetId = $input.data('target');

    $input.val($item.data('name'));
    $('#' + targetId).val($item.data('id'));
    $container.find('.autocomplete-results').hide();
  });

  // Optional: Hide on click outside
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
        console.log(form);
        if (!form) {
          showToast('Form not found.', 'error', 'Error');

          return;
        }

        const checkedBoxes = form.querySelectorAll('input[type="checkbox"]:checked');

        if (checkedBoxes.length === 0) {
          showToast('Please select at least one item to delete.', 'error', 'Error');


          return;
        }

        // Optional confirmation
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

    // Select/Deselect all checkboxes
    toggleAllCheckbox.addEventListener('change', function () {
      rowCheckboxes.forEach(cb => {
        cb.checked = toggleAllCheckbox.checked;
        if (toggleAllCheckbox.checked) {
          cb.setAttribute('checked', 'checked');
        } else {
          cb.removeAttribute('checked');
        }
      });
    });

    // Update the "select all" checkbox based on individual selection
    rowCheckboxes.forEach(cb => {
      cb.addEventListener('change', function () {
        if (!this.checked) {
          toggleAllCheckbox.checked = false;
          toggleAllCheckbox.removeAttribute('checked');
        } else if (document.querySelectorAll('.row-checkbox:checked').length === rowCheckboxes.length) {
          toggleAllCheckbox.checked = true;
          toggleAllCheckbox.setAttribute('checked', 'checked');
        }
        // Reflect individual checkbox state
        if (this.checked) {
          this.setAttribute('checked', 'checked');
        } else {
          this.removeAttribute('checked');
        }
      });
    });
  });
})();