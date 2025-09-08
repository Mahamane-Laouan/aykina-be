/**
 * Product List
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

  // Product datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      serverSide: true,
      processing: true,
      pagination: 10,
      ajax: baseUrl + 'getproductdata',
      columns: [
        { data: 'product_id' },
        { data: 'product_name' },
        { data: 'vid' },
        { data: 'cat_id' },
        { data: 'product_price' },
        { data: 'status' },
        { data: 'action' }
      ],
      columnDefs: [
        { visible: false, targets: [0] },
        {
          // Service name and description
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $product_name = full['product_name'],
              $product_description = full['product_description'],
              $image = full['product_image'];

            // Truncate the description to a certain number of characters
            var maxDescLength = 50; // Set your desired maximum length
            var truncatedDesc =
              $product_description.length > maxDescLength
                ? $product_description.substring(0, maxDescLength) + '...'
                : $product_description;

            if ($image) {
              // For Avatar image
              var $output =
                '<img src="' +
                assetsPath +
                'images/product/' +
                $image.split('::::')[0] +
                '" alt="Avatar" class="rounded-circle">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $product_name = full['product_name'],
                $initials = $product_name.match(/\b\w/g) || [];
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
              $product_name +
              '</span>' +
              '<small class="text-muted">' +
              truncatedDesc +
              '</small>' + // Display truncated description
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Provider name and description
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full) {
            var provider_fullname = full['vid'] || '';
            var provider_email = full['provider_email'] || '';
            var image = full['provider_profile_pic'];

            var output = image
              ? '<img src="' +
                (image.includes('https') || image.includes('http') ? image : assetsPath + 'images/user/' + image) +
                '" alt="Avatar" class="rounded-circle">'
              : '<span class="avatar-initial rounded-circle bg-label-' +
                ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
                  Math.floor(Math.random() * 6)
                ] +
                '">' +
                (provider_fullname.match(/\b\w/g) || [])
                  .map(function (initial) {
                    return initial.toUpperCase();
                  })
                  .join('') +
                '</span>';

            return (
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-3">' +
              output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              (provider_fullname ? provider_fullname : '') +
              '</span>' +
              '<small class="text-muted">' +
              provider_email +
              '</small>' +
              '</div>' +
              '</div>'
            );
          }
        },
        {
          // Category Name
          targets: 3,
          render: function (data, type, full, meta) {
            var $categoryname = full['cat_id'] || '';

            return '<span class="fw-medium">' + $categoryname + '</span>';
          }
        },
        {
          // service price
          targets: 4,
          render: function (data, type, full, meta) {
            var $product_price = full['product_price'] || '';

            return '<span class="fw-medium"> $' + $product_price + '</span>';
          }
        },
        {
          // Status
          targets: 5,
          render: function (data, type, full, meta) {
            var status = full['status'];
            if (status == '1') {
              return (
                ' <label class="switch switch-primary switch-sm me-4 pe-2"><input type="checkbox" id="active" name="status" class="switch-input" checked=""><span class="switch-toggle-slider"  onclick="Changeproductfeature(' +
                full.product_id +
                ',' +
                status +
                ')"><span class="switch-on"></span><span class="switch-off"></span></span></label>'
              );
            } else {
              return (
                ' <label class="switch switch-primary switch-sm me-4 pe-2"><input id="inactive" type="checkbox" name="status" class="switch-input"><span class="switch-toggle-slider" onclick="Changeproductfeature(' +
                full.product_id +
                ',' +
                status +
                ')"><span class="switch-on"></span><span class="switch-off"></span></span></label>'
              );
            }
          }
        },
        {
          // Actions
          targets: 6,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var userId = full.product_id;
            return (
              '<div class="d-inline-block text-nowrap">' +
              '<a href="/products-edit/' +
              userId +
              '" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>' +
              '<button class="btn btn-sm btn-icon delete-record" onclick="deleteProduct(' +
              userId +
              ')"><i class="bx bx-trash"></i></button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[0, 'desc']],
      dom:
        '<"row mx-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end gap-3 flex-md-row flex-column mb-3 mb-md-0"   fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      buttons: [
        {
          text: '<i class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add Product</span>',
          className: 'add-new btn btn-primary',
          action: function (e, dt, node, config) {
            window.location.href = 'products-add';
          }
        }
      ],
      displayLength: 10,
      lengthMenu: [7, 10, 25, 50, 75, 100],
      autoWidth: false,
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },

      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== ''
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
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
    fields: {
      userFullname: {
        validators: {
          notEmpty: {
            message: 'Please enter fullname '
          }
        }
      },
      userEmail: {
        validators: {
          notEmpty: {
            message: 'Please enter your email'
          },
          emailAddress: {
            message: 'The value is not a valid email address'
          }
        }
      }
    },
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
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });
})();

// Delete Service
function deleteProduct(userId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert Product!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete Product!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: 'products-delete/' + userId,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          var parentTr = $('#user-deleted-' + data.userId).closest('tr');
          parentTr.remove();
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Product deleted successfully.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(function () {
            location.reload(); // Reload the page
          });
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

// Changeproviderfeature;
function Changeproductfeature(product_id, status) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: baseUrl + 'change-productstatus/' + product_id,
        data: {
          status: status
        },
        type: 'get',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          Swal.fire({
            icon: 'success',
            title: 'Changed!',
            text: 'Changed status.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(function () {
            location.reload(); // Reload the page
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Cancelled Action :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload(); // Reload the page
      });
    }
  });
}
