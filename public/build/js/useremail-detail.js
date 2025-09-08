function updateUserOtpVerify(templateData) {
  // Update the title and body
  document.getElementById("userotpverify-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userotpverify-title").textContent =
    templateData.title || "";
  document.getElementById("userotpverify-title2").textContent =
    templateData.title || "";
  document.getElementById("userotpverify-body").textContent =
    templateData.body || "";

  document.getElementById("userotpverify-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userotpverify-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userotpverify-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById("userotpverify-cancellationpolicy").style.display =
    templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userotpverify-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userotpverify-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userotpverify-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userotpverify-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userotpverify-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userotpverify-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserForgotPassword(templateData) {
  // Update the title and body
  document.getElementById("userforgotpassword-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userforgotpassword-title").textContent =
    templateData.title || "";
  document.getElementById("userforgotpassword-title2").textContent =
    templateData.title || "";
  document.getElementById("userforgotpassword-body").textContent =
    templateData.body || "";

  document.getElementById("userforgotpassword-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userforgotpassword-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userforgotpassword-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userforgotpassword-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userforgotpassword-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userforgotpassword-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userforgotpassword-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userforgotpassword-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userforgotpassword-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userforgotpassword-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserOrderPlacedService(templateData) {
  // Update the title and body
  document.getElementById("userorderplacedservice-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userorderplacedservice-title").textContent =
    templateData.title || "";
  document.getElementById("userorderplacedservice-body").textContent =
    templateData.body || "";

  document.getElementById(
    "userorderplacedservice-sectionuscontact"
  ).textContent = templateData.section_text || "";

  // Update policy links
  document.getElementById(
    "userorderplacedservice-privacypolicy"
  ).style.display = templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userorderplacedservice-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userorderplacedservice-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userorderplacedservice-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userorderplacedservice-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userorderplacedservice-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById(
    "userorderplacedservice-instagramlink"
  ).style.display = templateData.instagram ? "inline" : "none";
  document.getElementById("userorderplacedservice-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById(
    "userorderplacedservice-copyrightcontent"
  ).textContent = templateData.copyright_content || "";
}

function updateUserBookingAccepted(templateData) {
  // Update the title and body
  document.getElementById("userbookingaccepted-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userbookingaccepted-title").textContent =
    templateData.title || "";
  document.getElementById("userbookingaccepted-title2").textContent =
    templateData.title || "";
  document.getElementById("userbookingaccepted-body").textContent =
    templateData.body || "";

  document.getElementById("userbookingaccepted-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userbookingaccepted-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userbookingaccepted-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userbookingaccepted-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userbookingaccepted-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userbookingaccepted-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userbookingaccepted-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userbookingaccepted-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userbookingaccepted-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userbookingaccepted-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserBookingInProgress(templateData) {
  // Update the title and body
  document.getElementById("userbookinginprogress-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userbookinginprogress-title").textContent =
    templateData.title || "";
  document.getElementById("userbookinginprogress-title2").textContent =
    templateData.title || "";
  document.getElementById("userbookinginprogress-body").textContent =
    templateData.body || "";

  document.getElementById(
    "userbookinginprogress-sectionuscontact"
  ).textContent = templateData.section_text || "";

  // Update policy links
  document.getElementById("userbookinginprogress-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userbookinginprogress-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userbookinginprogress-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userbookinginprogress-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userbookinginprogress-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userbookinginprogress-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userbookinginprogress-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userbookinginprogress-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById(
    "userbookinginprogress-copyrightcontent"
  ).textContent = templateData.copyright_content || "";
}

function updateUserBookingHold(templateData) {
  // Update the title and body
  document.getElementById("userbookinghold-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userbookinghold-title").textContent =
    templateData.title || "";
  document.getElementById("userbookinghold-title2").textContent =
    templateData.title || "";
  document.getElementById("userbookinghold-body").textContent =
    templateData.body || "";

  document.getElementById("userbookinghold-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userbookinghold-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userbookinghold-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById("userbookinghold-cancellationpolicy").style.display =
    templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userbookinghold-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userbookinghold-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userbookinghold-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userbookinghold-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userbookinghold-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userbookinghold-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserBookingCancelled(templateData) {
  // Update the title and body
  document.getElementById("userbookingcancelled-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userbookingcancelled-title").textContent =
    templateData.title || "";
  document.getElementById("userbookingcancelled-title2").textContent =
    templateData.title || "";
  document.getElementById("userbookingcancelled-body").textContent =
    templateData.body || "";

  document.getElementById("userbookingcancelled-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userbookingcancelled-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userbookingcancelled-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userbookingcancelled-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userbookingcancelled-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userbookingcancelled-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userbookingcancelled-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userbookingcancelled-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userbookingcancelled-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userbookingcancelled-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserBookingRejected(templateData) {
  // Update the title and body
  document.getElementById("userbookingrejected-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userbookingrejected-title").textContent =
    templateData.title || "";
  document.getElementById("userbookingrejected-title2").textContent =
    templateData.title || "";
  document.getElementById("userbookingrejected-body").textContent =
    templateData.body || "";

  document.getElementById("userbookingrejected-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userbookingrejected-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userbookingrejected-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userbookingrejected-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userbookingrejected-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userbookingrejected-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userbookingrejected-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userbookingrejected-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userbookingrejected-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userbookingrejected-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserProductinProgress(templateData) {
  // Update the title and body
  document.getElementById("userproductinprogress-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userproductinprogress-title").textContent =
    templateData.title || "";
  document.getElementById("userproductinprogress-title2").textContent =
    templateData.title || "";
  document.getElementById("userproductinprogress-body").textContent =
    templateData.body || "";

  document.getElementById(
    "userproductinprogress-sectionuscontact"
  ).textContent = templateData.section_text || "";

  // Update policy links
  document.getElementById("userproductinprogress-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userproductinprogress-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userproductinprogress-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userproductinprogress-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userproductinprogress-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userproductinprogress-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userproductinprogress-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userproductinprogress-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById(
    "userproductinprogress-copyrightcontent"
  ).textContent = templateData.copyright_content || "";
}

function updateUserProductDelivered(templateData) {
  // Update the title and body
  document.getElementById("userproductdelivered-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userproductdelivered-title").textContent =
    templateData.title || "";
  document.getElementById("userproductdelivered-title2").textContent =
    templateData.title || "";
  document.getElementById("userproductdelivered-body").textContent =
    templateData.body || "";

  document.getElementById("userproductdelivered-sectionuscontact").textContent =
    templateData.section_text || "";

  // Update policy links
  document.getElementById("userproductdelivered-privacypolicy").style.display =
    templateData.privacy_policy ? "inline" : "none";

  document.getElementById("userproductdelivered-refundpolicy").style.display =
    templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userproductdelivered-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userproductdelivered-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userproductdelivered-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userproductdelivered-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById("userproductdelivered-instagramlink").style.display =
    templateData.instagram ? "inline" : "none";
  document.getElementById("userproductdelivered-facebooklink").style.display =
    templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById("userproductdelivered-copyrightcontent").textContent =
    templateData.copyright_content || "";
}

function updateUserCancelledbyProvider(templateData) {
  // Update the title and body
  document.getElementById("usercancelledbyprovider-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("usercancelledbyprovider-title").textContent =
    templateData.title || "";
  document.getElementById("usercancelledbyprovider-title2").textContent =
    templateData.title || "";
  document.getElementById("usercancelledbyprovider-body").textContent =
    templateData.body || "";

  document.getElementById(
    "usercancelledbyprovider-sectionuscontact"
  ).textContent = templateData.section_text || "";

  // Update policy links
  document.getElementById(
    "usercancelledbyprovider-privacypolicy"
  ).style.display = templateData.privacy_policy ? "inline" : "none";

  document.getElementById(
    "usercancelledbyprovider-refundpolicy"
  ).style.display = templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "usercancelledbyprovider-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("usercancelledbyprovider-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("usercancelledbyprovider-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("usercancelledbyprovider-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById(
    "usercancelledbyprovider-instagramlink"
  ).style.display = templateData.instagram ? "inline" : "none";
  document.getElementById(
    "usercancelledbyprovider-facebooklink"
  ).style.display = templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById(
    "usercancelledbyprovider-copyrightcontent"
  ).textContent = templateData.copyright_content || "";
}


function updateUserRefundbyProvider(templateData) {
  // Update the title and body
  document.getElementById("userrefundbyprovider-logo").src =
    templateData.logo || "/images/socialmedialogo/default-logo.png";

  document.getElementById("userrefundbyprovider-title").textContent =
    templateData.title || "";
  document.getElementById("userrefundbyprovider-title2").textContent =
    templateData.title || "";
  document.getElementById("userrefundbyprovider-body").textContent =
    templateData.body || "";

  document.getElementById(
    "userrefundbyprovider-sectionuscontact"
  ).textContent = templateData.section_text || "";

  // Update policy links
  document.getElementById(
    "userrefundbyprovider-privacypolicy"
  ).style.display = templateData.privacy_policy ? "inline" : "none";

  document.getElementById(
    "userrefundbyprovider-refundpolicy"
  ).style.display = templateData.refund_policy ? "inline" : "none";
  document.getElementById(
    "userrefundbyprovider-cancellationpolicy"
  ).style.display = templateData.cancellation_policy ? "inline" : "none";
  document.getElementById("userrefundbyprovider-contactus").style.display =
    templateData.contact_us ? "inline" : "none";

  // Update social media links
  document.getElementById("userrefundbyprovider-twitterlink").style.display =
    templateData.twitter ? "inline" : "none";
  document.getElementById("userrefundbyprovider-linkdlnlink").style.display =
    templateData.linkedIn ? "inline" : "none";
  document.getElementById(
    "userrefundbyprovider-instagramlink"
  ).style.display = templateData.instagram ? "inline" : "none";
  document.getElementById(
    "userrefundbyprovider-facebooklink"
  ).style.display = templateData.facebook ? "inline" : "none";

  // Update copyright content
  document.getElementById(
    "userrefundbyprovider-copyrightcontent"
  ).textContent = templateData.copyright_content || "";
}

function fetchUserOtpVerify() {
  fetch("/api/showuseremail-userotpverify")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserOtpVerify(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserForgotPassword() {
  fetch("/api/showuseremail-userforgotpassword")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserForgotPassword(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserOrderPlacedService() {
  fetch("/api/showuseremail-userorderplacedservice")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserOrderPlacedService(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserBookingAccepted() {
  fetch("/api/showuseremail-userbookingaccepted")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserBookingAccepted(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserBookingInProgress() {
  fetch("/api/showuseremail-userbookinginprogress")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserBookingInProgress(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserBookingHold() {
  fetch("/api/showuseremail-userbookinghold")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserBookingHold(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserBookingCancelled() {
  fetch("/api/showuseremail-userbookingcancelled")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserBookingCancelled(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserBookingRejected() {
  fetch("/api/showuseremail-userbookingrejected")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserBookingRejected(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserProductinProgress() {
  fetch("/api/showuseremail-userproductinprogress")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserProductinProgress(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserProductDelivered() {
  fetch("/api/showuseremail-userproductdelivered")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserProductDelivered(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserCancelledbyProvider() {
  fetch("/api/showuseremail-usercancelledbyprovider")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserCancelledbyProvider(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

function fetchUserRefundbyProvider() {
  fetch("/api/showuseremail-userrefundbyprovider")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateUserRefundbyProvider(data.data[0]); // Assuming first item is needed
      } else {
        console.error("Failed to fetch email template data:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching email template data:", error);
    });
}

// Initialize both functions when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  fetchUserOtpVerify();
  fetchUserForgotPassword();
  fetchUserOrderPlacedService();
  fetchUserBookingAccepted();
  fetchUserBookingInProgress();
  fetchUserBookingHold();
  fetchUserBookingCancelled();
  fetchUserBookingRejected();
  fetchUserProductinProgress();
  fetchUserProductDelivered();
  fetchUserCancelledbyProvider();
  fetchUserRefundbyProvider();
});
