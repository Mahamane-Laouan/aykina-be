/**
 *  review
 */

'use strict';

// apex-chart
(function () {
  let cardColor, shadeColor, labelColor, headingColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    headingColor = config.colors_dark.headingColor;
    shadeColor = 'dark';
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;
    shadeColor = '';
  }

  // Visitor Bar Chart
  // --------------------------------------------------------------------
  const visitorBarChartEl = document.querySelector('#reviewsChart'),
    visitorBarChartConfig = {
      chart: {
        height: 160,
        width: 190,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          barHeight: '75%',
          columnWidth: '40%',
          startingShape: 'rounded',
          endingShape: 'rounded',
          borderRadius: 5,
          distributed: true
        }
      },
      grid: {
        show: false,
        padding: {
          top: -25,
          bottom: -12
        }
      },
      colors: [
        config.colors_label.success,
        config.colors_label.success,
        config.colors_label.success,
        config.colors_label.success,
        config.colors.success,
        config.colors_label.success,
        config.colors_label.success
      ],
      dataLabels: {
        enabled: false
      },
      series: [
        {
          data: [20, 40, 60, 80, 100, 80, 60]
        }
      ],
      legend: {
        show: false
      },
      xaxis: {
        categories: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px'
          }
        }
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      responsive: [
        {
          breakpoint: 0,
          options: {
            chart: {
              width: '100%'
            },
            plotOptions: {
              bar: {
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            chart: {
              height: 150,
              width: 190,
              toolbar: {
                show: false
              }
            },
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1400,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            chart: {
              height: 130,
              width: 190,
              toolbar: {
                show: false
              }
            },
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 992,
          chart: {
            height: 150,
            width: 190,
            toolbar: {
              show: false
            }
          },
          options: {
            plotOptions: {
              bar: {
                borderRadius: 5,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 883,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 5,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            chart: {
              height: 150,
              width: 190,
              toolbar: {
                show: false
              }
            },
            plotOptions: {
              bar: {
                borderRadius: 4,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              width: '100%',
              height: '200',
              type: 'bar'
            },
            plotOptions: {
              bar: {
                borderRadius: 6,
                columnWidth: '30% '
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              chart: {
                width: '100%',
                height: '200',
                type: 'bar'
              },
              bar: {
                borderRadius: 3,
                columnWidth: '30%'
              }
            }
          }
        }
      ]
    };
  if (typeof visitorBarChartEl !== undefined && visitorBarChartEl !== null) {
    const visitorBarChart = new ApexCharts(visitorBarChartEl, visitorBarChartConfig);
    visitorBarChart.render();
  }
})();

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
  var dt_customer_review = $('.datatables-review'),
    customerView = baseUrl + 'app/ecommerce/customer/details/overview',
    statusObj = {
      Pending: { title: 'Pending', class: 'bg-label-warning' },
      Published: { title: 'Published', class: 'bg-label-success' }
    };

  dt_customer_review.before(
    '<h5 style="margin-top: 1rem !important; margin-left:1rem;" class="">Latest 5 Reviews</h5>'
  );
  // reviewer datatable
  if (dt_customer_review.length) {
    var dt_review = dt_customer_review.DataTable({
      serverSide: true,
      processing: true,
      searching: false,
      lengthMenu: [5],
      ajax: baseUrl + 'getreviewdata',
      columns: [
        { data: 'rev_id' },
        { data: 'rev_res' },
        { data: 'rev_user' },
        { data: 'rev_date' },
        { data: 'rev_stars' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // service name and image
          targets: 0,
          render: function (data, type, full, meta) {
            var $restaurantname = full['rev_res'];
            var $output;
            var $res_image = full['res_image'];

            if ($res_image) {
              // For Avatar image
              $output = '<img src="' + assetsPath + 'images/' + $res_image + '" alt="Avatar" class="rounded-circle">'; // Remove var keyword
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $restaurantname = full['rev_res'],
                $initials = $restaurantname?.match(/\b\w/g) || [];
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded bg-label-' + $state + '">' + $initials + '</span>';
            }
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center customer-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar me-2 rounded-2 bg-label-secondary">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium text-nowrap">' +
              $restaurantname +
              '</span></a>' +
              '<small class="text-muted">' +
              '</div>';
            return $row_output;
          }
        },
        {
          // username
          targets: 1,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $username = full['rev_user'];
            var $output;

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum],
              $username = full['rev_user'],
              $initials = $username?.match(/\b\w/g) || [];
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';

            // Creates full output for row without the link
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center customer-username">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar me-2">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $username +
              '</span>' +
              '<small class="text-muted text-nowrap">' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Review
          targets: 2,
          responsivePriority: 2,
          render: function (data, type, full, meta) {
            var $num = full['rev_stars'];
            var $comment = full['rev_text'];
            var $readOnlyRatings = $('<div class="read-only-ratings ps-0 mb-2"></div>');

            // Initialize rateYo plugin
            $readOnlyRatings.rateYo({
              rating: $num,
              rtl: isRtl,
              readOnly: true, // Make the rating read-only
              starWidth: '20px', // Set the width of each star
              spacing: '3px', // Spacing between the stars
              starSvg:
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,2 L15.09,8.09 L22,9.9 L17,14 L18.18,20 L12,17.5 L5.82,20 L7,14 L2,9.9 L8.91,8.09 L12,2 Z" /></svg>'
            });

            var $review =
              '<div>' +
              $readOnlyRatings.prop('outerHTML') + // Get the HTML string of the rateYo plugin
              '<p class="fw-medium mb-1 text-truncate text-capitalize">' +
              '</p>' +
              '<small class="text-break pe-3">' +
              $comment +
              '</small>' +
              '</div>';

            return $review;
          }
        },
        {
          // Date
          targets: 3,
          render: function (data, type, full, meta) {
            var date = new Date(full.rev_date);
            var formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            return '<span class="text-nowrap">' + formattedDate + '</span>';
          }
        },
        {
          // Actions
          targets: 4,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var userId = full.rev_id;
            return (
              '<div class="d-inline-block text-nowrap">' +
              '<button class="btn btn-sm btn-icon delete-record" onclick="deleteReview(' +
              userId +
              ')"><i class="bx bx-trash"></i></button>' +
              '</div>'
            );
          }
        }
      ],
      order: [[3, 'desc']],
      dom: '<"row mx-2"' + '<"col-md-12"<""f>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6">' + '>',

      autoWidth: false,

      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['reviewer'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
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
          .columns(6)
          .every(function () {
            var column = this;
            var select = $('<select id="Review" class="form-select"><option value=""> All </option></select>')
              .appendTo('.review_filter')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
              });
          });
      }
    });
    $('.dataTables_length').addClass('mt-0 mt-md-3');
    // To remove default btn-secondary in export buttons
    $('.dt-buttons > .btn-group > button').removeClass('btn-secondary');
  }

  // Delete Record
  $('.datatables-review tbody').on('click', '.delete-record', function () {
    dt_review.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});

function deleteReview(userId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this action!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete review',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Make an AJAX request to delete the user
      $.ajax({
        method: 'POST',
        url: 'reviews-delete/' + userId,
        data: {
          _token: csrfToken
        },
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'Review has been removed.',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            location.reload(); // Reload the page
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to delete review.',
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
