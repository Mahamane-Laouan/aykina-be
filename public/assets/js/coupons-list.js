/**
 * Coupons List
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

  // Coupons datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      serverSide: true,
      processing: true,
      pagination: 10,
      ajax: baseUrl + 'getcoupondata',
      columns: [
        { data: 'id' },
        { data: 'code' },
        { data: 'discount' },
        { data: 'type' },
        { data: 'expire_date' },
        { data: 'coupon_for' },
        { data: 'status' },
        { data: 'action' }
      ],
      columnDefs: [
        { visible: false, targets: [0] },
        {
          // Code
          targets: 1,
          render: function (data, type, full, meta) {
            var $code = full['code'] || '';

            return '<span class="fw-medium">' + $code + '</span>';
          }
        },
        {
          // Discount
          targets: 2,
          render: function (data, type, full, meta) {
            var $discount = full['discount'] || '';

            return '<span class="fw-medium">' + $discount + '</span>';
          }
        },
        {
          // Type
          targets: 3,
          render: function (data, type, full, meta) {
            var $type = full['type'];

            if ($type == 'Percentage') {
              return '<span class="badge bg-label-success" text-capitalized>' + 'Percentage' + '</span>';
            } else if ($type == 'Fixed') {
              return '<span class="badge bg-label-secondary" text-capitalized>' + 'Fixed' + '</span>';
            } else {
              return '<span class="badge bg-label-default" text-capitalized>' + $type + '</span>';
            }
          }
        },
        {
          // Date
          targets: 4,
          render: function (data, type, full, meta) {
            var $expire_date = full['expire_date'] || '';

            return '<span class="fw-medium">' + $expire_date + '</span>';
          }
        },
        {
          // Role
          targets: 5,
          render: function (data, type, full, meta) {
            var $coupon_for = full['coupon_for'];

            if ($coupon_for == 'Product') {
              return '<span class="badge bg-label-success" text-capitalized>' + 'Product' + '</span>';
            } else if ($coupon_for == 'Service') {
              return '<span class="badge bg-label-info" text-capitalized>' + 'Service' + '</span>';
            } else {
              return '<span class="badge bg-label-default" text-capitalized>' + $coupon_for + '</span>';
            }
          }
        },
        {
          // Status
          targets: 6,
          render: function (data, type, full, meta) {
            var status = full['status'];
            if (status == '1') {
              return (
                ' <label class="switch switch-primary switch-sm me-4 pe-2"><input type="checkbox" id="active" name="status" class="switch-input" checked=""><span class="switch-toggle-slider"  onclick="ChangeCouponStatus(' +
                full.id +
                ',' +
                status +
                ')"><span class="switch-on"></span><span class="switch-off"></span></span></label>'
              );
            } else {
              return (
                ' <label class="switch switch-primary switch-sm me-4 pe-2"><input id="inactive" type="checkbox" name="status" class="switch-input"><span class="switch-toggle-slider" onclick="ChangeCouponStatus(' +
                full.id +
                ',' +
                status +
                ')"><span class="switch-on"></span><span class="switch-off"></span></span></label>'
              );
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
              '<button class="btn btn-sm btn-icon delete-record" onclick="deleteCoupon(' +
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
          text: '<i class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add Coupon</span>',
          className: 'add-new btn btn-primary',
          action: function (e, dt, node, config) {
            // Toggle the sidebar
            var sidebar = document.getElementById('addEventSidebar');
            var sidebarInstance = new bootstrap.Offcanvas(sidebar);
            sidebarInstance.toggle();
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

// Delete Coupon
function deleteCoupon(userId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert Coupon!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete Coupon!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: 'coupons-delete/' + userId,
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
            text: 'Coupon deleted successfully.',
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

// ChangeCouponStatus;
function ChangeCouponStatus(id, status) {
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
        url: baseUrl + 'change-couponstatus/' + id,
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
