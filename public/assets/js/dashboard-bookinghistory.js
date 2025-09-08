/**
 * Dashboard Booking History
 */

'use strict';

// Datatable (jquery)
$(function () {
  let borderColor, bodyBg, headingColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2 = $('.select2'),
    userView = baseUrl + '',
    statusObj = {
      1: { title: 'Block', class: 'bg-label-danger' },
      2: { title: 'Active', class: 'bg-label-success' }
    };

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  dt_user_table.before('<h5 style="margin-top: 1rem !important; margin-left:1rem;" class="">Latest 5 Bookings</h5>');
  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      serverSide: true,
      processing: true,
      searching: false,
      lengthMenu: [5],
      ajax: baseUrl + 'getbookingdata',
      columns: [
        { data: 'id' },
        { data: 'username' },
        { data: 'res_id' },
        { data: 'date' },
        { data: 'time' },
        { data: 'description' },
        { data: 'action' }
      ],
      columnDefs: [
        { visible: false, targets: [0] },
        {
          // Date
          targets: 1,
          render: function (data, type, full, meta) {
            var $date = full['date'];

            return '<span class="fw-medium">' + $date + '</span>';
          }
        },
        {
          // Time
          targets: 2,
          render: function (data, type, full, meta) {
            var $time = full['time'];

            return '<span class="fw-medium">' + $time + '</span>';
          }
        },
        {
          // User full name and email
          targets: 3,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $username = full['username'],
              $useremail = full['user_id'];
            var $output;
            {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $username = full['username'],
                $initials = $username.match(/\b\w/g) || [];
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            }

            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-3">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $username +
              '</span>' +
              '<small class="text-muted">' +
              $useremail +
              '</small>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },

        {
          // Restaurant Name
          targets: 4,
          render: function (data, type, full, meta) {
            var $restaurantname = full['res_id'];

            return '<span class="fw-medium">' + $restaurantname + '</span>';
          }
        },

        {
          // Description
          targets: 5,
          render: function (data, type, full, meta) {
            var $description = full['description'];

            return '<span class="fw-medium">' + $description + '</span>';
          }
        },

        {
          // Payment Mode
          targets: 6,
          render: function (data, type, full, meta) {
            var $paymentmode = full['payment_mode'];

            if ($paymentmode == '6') {
              return '<span class="badge bg-label-danger" text-capitalized>' + 'COD' + '</span>';
            } else if ($paymentmode == '1') {
              return '<span class="badge bg-label-success" text-capitalized>' + 'Stripe' + '</span>';
            } else if ($paymentmode == '2') {
              return '<span class="badge bg-label-primary" text-capitalized>' + 'Razor' + '</span>';
            } else if ($paymentmode == '5') {
              return '<span class="badge bg-label-warning" text-capitalized>' + 'Cheque' + '</span>';
            } else if ($paymentmode == '4') {
              return '<span class="badge bg-label-info" text-capitalized>' + 'PayPal' + '</span>';
            } else if ($paymentmode == '3') {
              return '<span class="badge bg-label-info" text-capitalized>' + 'Flutterwave' + '</span>';
            } else {
              return '<span class="badge bg-label-default" text-capitalized>' + $paymentmode + '</span>';
            }
          }
        },

        {
          // Actions
          targets: 7,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var userId = full.id;
            return (
              '<div class="d-inline-block text-nowrap">' +
              '<button class="btn btn-sm btn-icon delete-record" onclick="deleteHistory(' +
              userId +
              ')"><i class="bx bx-trash"></i></button>' +
              '</div>'
            );
          }
        }
      ],

      order: [[0, 'desc']],
      dom: '<"row mx-2"' + '<"col-md-12"<""f>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6">' + '>',

      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
          .columns(2)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Role </option></select>'
            )
              .appendTo('.user_role')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                if (d !== undefined) {
                  select.append('<option value="' + d + '">' + d + '</option>');
                }
              });
          });
        // Adding plan filter once table initialized
        this.api()
          .columns(3)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="UserPlan" class="form-select text-capitalize"><option value=""> Select Plan </option></select>'
            )
              .appendTo('.user_plan')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                if (d !== undefined) {
                  select.append('<option value="' + d + '">' + d + '</option>');
                }
              });
          });
        // Adding status filter once table initialized
        this.api()
          .columns(5)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="FilterTransaction" class="form-select text-capitalize"><option value=""> Select Status </option></select>'
            )
              .appendTo('.user_status')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                if (statusObj[d] && statusObj[d].title) {
                  select.append(
                    '<option value="' +
                      statusObj[d].title +
                      '" class="text-capitalize">' +
                      statusObj[d].title +
                      '</option>'
                  );
                }
              });
          });
      }
    });

    // To remove default btn-secondary in export buttons
    $('.dt-buttons > .btn-group > button').removeClass('btn-secondary');
  }

  // Delete Record
  $('.datatables-users tbody').on('click', '.delete-record', function () {
    dt_user.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

// Validation & Phone mask
(function () {
  const phoneMaskList = document.querySelectorAll('.phone-mask'),
    addNewUserForm = document.getElementById('addNewUserForm');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }
  // Add New User Form Validation
  const fv = FormValidation.formValidation(addNewUserForm, {
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-3';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });
})();

function deleteHistory(userId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this action!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete user',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      // Get the CSRF token from a meta tag in your HTML
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Make an AJAX request to delete the user
      $.ajax({
        method: 'POST',
        url: 'history-delete/' + userId,
        data: {
          _token: csrfToken
        },
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'User has been removed.',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            location.reload(); // Reload the page
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to delete user.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        title: 'Cancelled',
        text: 'Cancelled Delete :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });
    }
  });
}
