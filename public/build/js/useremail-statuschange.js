// changeEmailUserOtpVerify
function changeEmailUserOtpVerify(id) {
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
      var isChecked = $('#user-otpverify-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userotpverifystatus/' + id,
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


// changeEmailUserForgotPassword
function changeEmailUserForgotPassword(id) {
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
      var isChecked = $('#user-forgotpassword-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userforgotpasswordstatus/' + id,
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


// changeEmailUserOrderPlaced
function changeEmailUserOrderPlaced(id) {
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
      var isChecked = $('#user-orderplacedservice-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userorderplacedservicestatus/' + id,
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


// changeEmailUserBookingAccepted
function changeEmailUserBookingAccepted(id) {
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
      var isChecked = $('#user-bookingaccepted-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userbookingacceptedstatus/' + id,
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


// changeEmailUserBookingInProgress
function changeEmailUserBookingInProgress(id) {
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
      var isChecked = $('#user-bookinginprogress-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userbookinginprogressstatus/' + id,
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


// changeEmailUserBookingHold
function changeEmailUserBookingHold(id) {
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
      var isChecked = $('#user-bookinghold-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userbookingholdstatus/' + id,
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


// changeEmailUserBookingCancelled
function changeEmailUserBookingCancelled(id) {
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
      var isChecked = $('#user-bookingcancelled-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userbookingcancelledstatus/' + id,
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


// changeEmailUserBookingRejected
function changeEmailUserBookingRejected(id) {
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
      var isChecked = $('#user-bookingrejected-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userbookingrejectedstatus/' + id,
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


// changeEmailUserProductInProgress
function changeEmailUserProductInProgress(id) {
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
      var isChecked = $('#user-productinprogress-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userproductinprogressstatus/' + id,
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


// changeEmailUserProductDelivered
function changeEmailUserProductDelivered(id) {
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
      var isChecked = $('#user-productdelivered-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-userproductdeliveredstatus/' + id,
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


// changeEmailUserCancelledbyProviderStatus
function changeEmailUserCancelledbyProviderStatus(id) {
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
      var isChecked = $('#user-cancelledbyprovider-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: "/changeemail-usercancelledbyproviderstatus/" + id,
        type: "get",
        data: { get_email: isChecked },
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Changed!",
              text: data.message,
              customClass: {
                confirmButton: "btn btn-success",
              },
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: data.message,
              customClass: {
                confirmButton: "btn btn-danger",
              },
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "There was an error changing the status.",
            customClass: {
              confirmButton: "btn btn-danger",
            },
          });
        },
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


// changeEmailUserRefundbyProviderStatus
function changeEmailUserRefundbyProviderStatus(id) {
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
      var isChecked = $('#user-refundbyprovider-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: "/changeemail-userrefundbyproviderstatus/" + id,
        type: "get",
        data: { get_email: isChecked },
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Changed!",
              text: data.message,
              customClass: {
                confirmButton: "btn btn-success",
              },
            }).then(function () {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: data.message,
              customClass: {
                confirmButton: "btn btn-danger",
              },
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "There was an error changing the status.",
            customClass: {
              confirmButton: "btn btn-danger",
            },
          });
        },
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