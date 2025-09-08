// changeEmailProviderOtpVerify
function changeEmailProviderOtpVerify(id) {
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
      var isChecked = $('#provider-otpverify-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerotpverifystatus/' + id,
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


// changeEmailProviderForgotPassword
function changeEmailProviderForgotPassword(id) {
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
      var isChecked = $('#provider-forgotpassword-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerforgotpasswordstatus/' + id,
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


// changeEmailProviderOrderReceived
function changeEmailProviderOrderReceived(id) {
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
      var isChecked = $('#provider-orderplaced-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerordereceivedstatus/' + id,
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


// changeEmailProviderBookingAccepted
function changeEmailProviderBookingAccepted(id) {
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
      var isChecked = $('#provider-bookingaccepted-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerbookingacceptedstatus/' + id,
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


// changeEmailProviderBookingRejected
function changeEmailProviderBookingRejected(id) {
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
      var isChecked = $('#provider-bookingrejected-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerbookingrejectedstatus/' + id,
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


// changeEmailProviderAssignHandyman
function changeEmailProviderAssignHandyman(id) {
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
      var isChecked = $('#provider-assignhandyman-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerassignhandymanstatus/' + id,
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


// changeEmailProviderRejectHandyman
function changeEmailProviderRejectHandyman(id) {
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
      var isChecked = $('#provider-rejecthandyman-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerrejecthandymanstatus/' + id,
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


// changeEmailProviderOrderInProgress
function changeEmailProviderOrderInProgress(id) {
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
      var isChecked = $('#provider-orderinprogress-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerorderinprogressstatus/' + id,
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


// changeEmailProviderOrderDelivered
function changeEmailProviderOrderDelivered(id) {
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
      var isChecked = $('#provider-orderdelivered-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerorderdeliveredstatus/' + id,
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


// changeEmailProviderBookingHold
function changeEmailProviderBookingHold(id) {
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
      var isChecked = $('#provider-bookinghold-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerbookingholdstatus/' + id,
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


// changeEmailProviderBookingCompleted
function changeEmailProviderBookingCompleted(id) {
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
      var isChecked = $('#provider-bookingcompleted-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerbookingcompletedstatus/' + id,
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


// changeEmailProviderPaymentReceived
function changeEmailProviderPaymentReceived(id) {
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
      var isChecked = $('#provider-paymentreceived-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerpaymentreceivedstatus/' + id,
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


// changeEmailProviderPaymentSent
function changeEmailProviderPaymentSent(id) {
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
      var isChecked = $('#provider-paymentsent-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerpaymentsentstatus/' + id,
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


// changeEmailProviderReviewReceived
function changeEmailProviderReviewReceived(id) {
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
      var isChecked = $('#provider-reviewreceived-checkbox').is(':checked') ? 1 : 0; // Select using the specific id

      $.ajax({
        url: '/changeemail-providerreviewreceivedstatus/' + id,
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
