// changeEmailHandymanOtpVerify
function changeEmailHandymanOtpVerify(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-otpverify-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanotpverifystatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanForgotPassword
function changeEmailHandymanForgotPassword(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-forgotpassword-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanforgotpasswordstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanAssignForOrder
function changeEmailHandymanAssignForOrder(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-assignorder-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanassignfororderstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanAcceptBooking
function changeEmailHandymanAcceptBooking(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-acceptbooking-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanacceptbookingstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanRejectBooking
function changeEmailHandymanRejectBooking(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-rejectbooking-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanrejectbookingstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanCompletedBooking
function changeEmailHandymanCompletedBooking(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-completebooking-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymancompletedbookingstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}


// changeEmailHandymanReviewReceived
function changeEmailHandymanReviewReceived(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this status!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change status!',
    customClass: {
      confirmButton: 'btn btn-primary me-2',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.isConfirmed) {
      var isChecked = $('#handyman-reviewreceived-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-handymanreviewreceivedstatus/' + id,
        type: 'get',
        data: { get_email: isChecked },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Changed!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: data.message,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'There was an error changing the status.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Cancelled',
        text: 'Action cancelled :)',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(function () {
        location.reload();
      });
    }
  });
}
