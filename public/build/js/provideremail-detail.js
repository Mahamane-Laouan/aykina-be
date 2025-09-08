// updateProviderOtpVerify
function updateProviderOtpVerify(templateData) {
  // Update the title and body
  document.getElementById('providerotpverify-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerotpverify-title').textContent = templateData.title || '';
  document.getElementById('providerotpverify-title2').textContent = templateData.title || '';
  document.getElementById('providerotpverify-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerotpverify-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerotpverify-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerotpverify-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerotpverify-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerotpverify-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerotpverify-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerotpverify-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerotpverify-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerotpverify-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerotpverify-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderForgotPassword(templateData) {
  // Update the title and body
  document.getElementById('providerforgotpassword-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerforgotpassword-title').textContent = templateData.title || '';
  document.getElementById('providerforgotpassword-title2').textContent = templateData.title || '';
  document.getElementById('providerforgotpassword-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerforgotpassword-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerforgotpassword-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerforgotpassword-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerforgotpassword-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerforgotpassword-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerforgotpassword-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerforgotpassword-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerforgotpassword-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerforgotpassword-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerforgotpassword-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderOrderReceived(templateData) {
  // Update the title and body
  document.getElementById('providerordereceived-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerordereceived-title').textContent = templateData.title || '';
  document.getElementById('providerordereceived-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerordereceived-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerordereceived-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerordereceived-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerordereceived-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerordereceived-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerordereceived-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerordereceived-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerordereceived-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerordereceived-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerordereceived-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderBookingAccepted(templateData) {
  // Update the title and body
  document.getElementById('providerbookingaccepted-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerbookingaccepted-title').textContent = templateData.title || '';
    document.getElementById('providerbookingaccepted-title2').textContent = templateData.title || '';
  document.getElementById('providerbookingaccepted-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerbookingaccepted-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerbookingaccepted-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerbookingaccepted-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerbookingaccepted-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerbookingaccepted-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerbookingaccepted-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerbookingaccepted-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerbookingaccepted-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerbookingaccepted-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerbookingaccepted-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderBookingRejected(templateData) {
  // Update the title and body
  document.getElementById('providerbookingrejected-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerbookingrejected-title').textContent = templateData.title || '';
    document.getElementById('providerbookingrejected-title2').textContent = templateData.title || '';
  document.getElementById('providerbookingrejected-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerbookingrejected-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerbookingrejected-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerbookingrejected-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerbookingrejected-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerbookingrejected-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerbookingrejected-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerbookingrejected-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerbookingrejected-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerbookingrejected-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerbookingrejected-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderAssignHandyman(templateData) {
  // Update the title and body
  document.getElementById('providerassignhandyman-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerassignhandyman-title').textContent = templateData.title || '';
    document.getElementById('providerassignhandyman-title2').textContent = templateData.title || '';
  document.getElementById('providerassignhandyman-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerassignhandyman-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerassignhandyman-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerassignhandyman-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerassignhandyman-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerassignhandyman-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerassignhandyman-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerassignhandyman-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerassignhandyman-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerassignhandyman-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerassignhandyman-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderRejectHandyman(templateData) {
  // Update the title and body
  document.getElementById('providerrejecthandyman-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerrejecthandyman-title').textContent = templateData.title || '';
    document.getElementById('providerrejecthandyman-title2').textContent = templateData.title || '';
  document.getElementById('providerrejecthandyman-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerrejecthandyman-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerrejecthandyman-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerrejecthandyman-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerrejecthandyman-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerrejecthandyman-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerrejecthandyman-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerrejecthandyman-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerrejecthandyman-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerrejecthandyman-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerrejecthandyman-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderOrderInProgress(templateData) {
  // Update the title and body
  document.getElementById('providerorderinprogress-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerorderinprogress-title').textContent = templateData.title || '';
    document.getElementById('providerorderinprogress-title2').textContent = templateData.title || '';
  document.getElementById('providerorderinprogress-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerorderinprogress-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerorderinprogress-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerorderinprogress-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerorderinprogress-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerorderinprogress-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerorderinprogress-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerorderinprogress-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerorderinprogress-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerorderinprogress-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerorderinprogress-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderOrderDelivered(templateData) {
  // Update the title and body
  document.getElementById('providerorderdelivered-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerorderdelivered-title').textContent = templateData.title || '';
    document.getElementById('providerorderdelivered-title2').textContent = templateData.title || '';
  document.getElementById('providerorderdelivered-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerorderdelivered-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerorderdelivered-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerorderdelivered-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerorderdelivered-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerorderdelivered-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerorderdelivered-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerorderdelivered-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerorderdelivered-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerorderdelivered-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerorderdelivered-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderBookingHold(templateData) {
  // Update the title and body
  document.getElementById('providerbookinghold-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerbookinghold-title').textContent = templateData.title || '';
    document.getElementById('providerbookinghold-title2').textContent = templateData.title || '';
  document.getElementById('providerbookinghold-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerbookinghold-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerbookinghold-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerbookinghold-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerbookinghold-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerbookinghold-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerbookinghold-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerbookinghold-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerbookinghold-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerbookinghold-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerbookinghold-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderBookingCompleted(templateData) {
  // Update the title and body
  document.getElementById('providerbookingcompleted-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerbookingcompleted-title').textContent = templateData.title || '';
    document.getElementById('providerbookingcompleted-title2').textContent = templateData.title || '';
  document.getElementById('providerbookingcompleted-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerbookingcompleted-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerbookingcompleted-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerbookingcompleted-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerbookingcompleted-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerbookingcompleted-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerbookingcompleted-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerbookingcompleted-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerbookingcompleted-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerbookingcompleted-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerbookingcompleted-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderPaymentReceived(templateData) {
  // Update the title and body
  document.getElementById('providerpaymentreceived-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerpaymentreceived-title').textContent = templateData.title || '';
    document.getElementById('providerpaymentreceived-title2').textContent = templateData.title || '';
  document.getElementById('providerpaymentreceived-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerpaymentreceived-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerpaymentreceived-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerpaymentreceived-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerpaymentreceived-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerpaymentreceived-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerpaymentreceived-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerpaymentreceived-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerpaymentreceived-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerpaymentreceived-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerpaymentreceived-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderPaymentSent(templateData) {
  // Update the title and body
  document.getElementById('providerpaymentsent-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerpaymentsent-title').textContent = templateData.title || '';
    document.getElementById('providerpaymentsent-title2').textContent = templateData.title || '';
  document.getElementById('providerpaymentsent-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerpaymentsent-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerpaymentsent-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerpaymentsent-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerpaymentsent-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerpaymentsent-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerpaymentsent-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerpaymentsent-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerpaymentsent-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerpaymentsent-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerpaymentsent-copyrightcontent').textContent =
    templateData.copyright_content || '';
}


function updateProviderReviewReceived(templateData) {
  // Update the title and body
  document.getElementById('providerreviewreceived-logo').src =
    templateData.logo || '/images/socialmedialogo/default-logo.png';

  document.getElementById('providerreviewreceived-title').textContent = templateData.title || '';
    document.getElementById('providerreviewreceived-title2').textContent = templateData.title || '';
  document.getElementById('providerreviewreceived-body').textContent =
    templateData.body ||
    '';

  document.getElementById('providerreviewreceived-sectionuscontact').textContent =
    templateData.section_text || '';

  // Update policy links
  document.getElementById('providerreviewreceived-privacypolicy').style.display = templateData.privacy_policy
    ? 'inline'
    : 'none';

  document.getElementById('providerreviewreceived-refundpolicy').style.display = templateData.refund_policy ? 'inline' : 'none';
  document.getElementById('providerreviewreceived-cancellationpolicy').style.display = templateData.cancellation_policy
    ? 'inline'
    : 'none';
  document.getElementById('providerreviewreceived-contactus').style.display = templateData.contact_us ? 'inline' : 'none';

  // Update social media links
  document.getElementById('providerreviewreceived-twitterlink').style.display = templateData.twitter ? 'inline' : 'none';
  document.getElementById('providerreviewreceived-linkdlnlink').style.display = templateData.linkedIn ? 'inline' : 'none';
  document.getElementById('providerreviewreceived-instagramlink').style.display = templateData.instagram ? 'inline' : 'none';
  document.getElementById('providerreviewreceived-facebooklink').style.display = templateData.facebook ? 'inline' : 'none';

  // Update copyright content
  document.getElementById('providerreviewreceived-copyrightcontent').textContent =
    templateData.copyright_content || '';
}











function fetchProviderOtpVerify() {
  fetch('/api/showprovideremail-providerotpverify')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderOtpVerify(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderForgotPassword() {
  fetch('/api/showprovideremail-providerforgotpassword')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderForgotPassword(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderOrderReceived() {
  fetch('/api/showprovideremail-providerorderreceived')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderOrderReceived(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderBookingAccepted() {
  fetch('/api/showprovideremail-providerbookingaccepted')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderBookingAccepted(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderBookingRejected() {
  fetch('/api/showprovideremail-providerbookingrejected')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderBookingRejected(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderAssignHandyman() {
  fetch('/api/showprovideremail-providerassignhandyman')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderAssignHandyman(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderRejectHandyman() {
  fetch('/api/showprovideremail-providerrejecthandyman')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderRejectHandyman(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderOrderinProgress() {
  fetch('/api/showprovideremail-providerorderinprogress')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderOrderInProgress(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderOrderDelivered() {
  fetch('/api/showprovideremail-providerorderdelivered')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderOrderDelivered(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderBookingHold() {
  fetch('/api/showprovideremail-providerbookinghold')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderBookingHold(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderBookingCompleted() {
  fetch('/api/showprovideremail-providerbookingcompleted')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderBookingCompleted(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderPaymentReceived() {
  fetch('/api/showprovideremail-providerpaymentreceived')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderPaymentReceived(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderPaymentSent() {
  fetch('/api/showprovideremail-providerpaymentsent')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderPaymentSent(data.data[0]); // Assuming first item is needed
      } else {
        console.error('Failed to fetch email template data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching email template data:', error);
    });
}


function fetchProviderReviewReceived() {
  fetch('/api/showprovideremail-providerreviewreceived')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateProviderReviewReceived(data.data[0]); // Assuming first item is needed
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
  fetchProviderOtpVerify();
  fetchProviderForgotPassword();
  fetchProviderOrderReceived();
  fetchProviderBookingAccepted();
  fetchProviderBookingRejected();
  fetchProviderAssignHandyman();
  fetchProviderRejectHandyman();
  fetchProviderOrderinProgress();
  fetchProviderOrderDelivered();
  fetchProviderBookingHold();
  fetchProviderBookingCompleted();
  fetchProviderPaymentReceived();
  fetchProviderPaymentSent();
  fetchProviderReviewReceived();
});
