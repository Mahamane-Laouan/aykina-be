// updateHandymanOtpVerify
function updateHandymanOtpVerify(templateData) {
  // Update the title and body
  document.getElementById('handymanotpverify-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanotpverify-title').textContent = templateData.title || '';
  document.getElementById('handymanotpverify-title2').textContent = templateData.title || '';
  document.getElementById('handymanotpverify-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanotpverify-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanotpverify-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanotpverify-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanotpverify-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanotpverify-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanotpverify-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanotpverify-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanotpverify-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanotpverify-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanotpverify-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanForgotPassword(templateData) {
  // Update the title and body
  document.getElementById('handymanforgotpassword-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanforgotpassword-title').textContent = templateData.title || '';
  document.getElementById('handymanforgotpassword-title2').textContent = templateData.title || '';
  document.getElementById('handymanforgotpassword-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanforgotpassword-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanforgotpassword-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanforgotpassword-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanforgotpassword-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanforgotpassword-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanforgotpassword-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanforgotpassword-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanforgotpassword-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanforgotpassword-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanforgotpassword-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanAssignforOrder(templateData) {
  // Update the title and body
  document.getElementById('handymanassignfororder-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanassignfororder-title').textContent = templateData.title || '';
  document.getElementById('handymanassignfororder-title2').textContent = templateData.title || '';
  document.getElementById('handymanassignfororder-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanassignfororder-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanassignfororder-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanassignfororder-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanassignfororder-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanassignfororder-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanassignfororder-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanassignfororder-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanassignfororder-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanassignfororder-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanassignfororder-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanBookingAccepted(templateData) {
  // Update the title and body
  document.getElementById('handymanacceptbooking-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanacceptbooking-title').textContent = templateData.title || '';
  document.getElementById('handymanacceptbooking-title2').textContent = templateData.title || '';
  document.getElementById('handymanacceptbooking-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanacceptbooking-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanacceptbooking-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanacceptbooking-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanacceptbooking-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanacceptbooking-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanacceptbooking-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanacceptbooking-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanacceptbooking-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanacceptbooking-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanacceptbooking-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanBookingRejected(templateData) {
  // Update the title and body
  document.getElementById('handymanrejectbooking-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanrejectbooking-title').textContent = templateData.title || '';
  document.getElementById('handymanrejectbooking-title2').textContent = templateData.title || '';
  document.getElementById('handymanrejectbooking-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanrejectbooking-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanrejectbooking-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanrejectbooking-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanrejectbooking-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanrejectbooking-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanrejectbooking-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanrejectbooking-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanrejectbooking-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanrejectbooking-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanrejectbooking-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanBookingCompleted(templateData) {
  // Update the title and body
  document.getElementById('handymancompletedbooking-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymancompletedbooking-title').textContent = templateData.title || '';
  document.getElementById('handymancompletedbooking-title2').textContent = templateData.title || '';
  document.getElementById('handymancompletedbooking-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymancompletedbooking-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymancompletedbooking-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymancompletedbooking-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymancompletedbooking-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymancompletedbooking-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymancompletedbooking-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymancompletedbooking-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymancompletedbooking-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymancompletedbooking-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymancompletedbooking-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateHandymanReviewReceived(templateData) {
  // Update the title and body
  document.getElementById('handymanreviewreceived-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('handymanreviewreceived-title').textContent = templateData.title || '';
  document.getElementById('handymanreviewreceived-title2').textContent = templateData.title || '';
  document.getElementById('handymanreviewreceived-body').textContent =
    templateData.body ||
    '';

  document.getElementById('handymanreviewreceived-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('handymanreviewreceived-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('handymanreviewreceived-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('handymanreviewreceived-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('handymanreviewreceived-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('handymanreviewreceived-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('handymanreviewreceived-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('handymanreviewreceived-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('handymanreviewreceived-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('handymanreviewreceived-copyrightcontent').textContent =
    templateData.copyright_content || '';
}












function fetchHandymanOtpVerify() {
  fetch('/api/showhandymanemail-handymanotpverify')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanOtpVerify(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanForgotPassword() {
  fetch('/api/showhandymanemail-handymanforgotpassword')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanForgotPassword(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanAssignforOrder() {
  fetch('/api/showhandymanemail-handymanassignfororder')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanAssignforOrder(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanBookingAccepted() {
  fetch('/api/showhandymanemail-handymanbookingaccepted')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanBookingAccepted(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanBookingRejected() {
  fetch('/api/showhandymanemail-handymanbookingrejected')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanBookingRejected(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanBookingCompleted() {
  fetch('/api/showhandymanemail-handymanbookingcompleted')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanBookingCompleted(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchHandymanReviewReceived() {
  fetch('/api/showhandymanemail-handymanreviewreceived')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateHandymanReviewReceived(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


// Initialize both functions when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
  fetchHandymanOtpVerify();
  fetchHandymanForgotPassword();
  fetchHandymanAssignforOrder();
  fetchHandymanBookingAccepted();
  fetchHandymanBookingRejected();
  fetchHandymanBookingCompleted();
  fetchHandymanReviewReceived();
});
