<!DOCTYPE html>
<html lang="en">

<!-- Php Code -->
<?php

use App\Models\ProviderEmailReviewReceived;
use App\Models\GeneralSettings;
use App\Models\SocialMedia;

$email = ProviderEmailReviewReceived::first();
$general_settings = GeneralSettings::first();
$social_media = SocialMedia::first(); // Fetch the social media links

?>


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($email->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
</head>

<body
    style="
      margin: 0;
      padding: 0;
      font-family: Montserrat, serif;
      background-color: #ffffff;
    ">
    <div
        style="
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        max-width: 800px;
        min-width: none;
        overflow-x: hidden;
      ">


        <p style="color: #282c2f; font-size: 20px; margin-bottom: 10px">
            Hi <span style="font-weight: 500; color: #282c2f"><?= htmlspecialchars($firstname) ?></span>,
        </p>

        <div
            style="
          background-color: #4c7fdb;
          margin-top: 1.5rem;
          border-radius: 0.5rem;
          padding: 1.5rem;
        ">
            <div style="text-align: center">
                <?php if ($email->logo): ?>
                    <img src="<?= asset('images/socialmedialogo/' . htmlspecialchars($email->logo)) ?>" alt="logo" style="
              border-radius: 50%;
              width: 6rem;
              height: 6rem;
              background: white;
              padding: 4px;
            " />
                <?php else: ?>
                    <p>No Logo</p>
                <?php endif; ?>
                <h3 style="font-weight: 500; color: #ffffff; font-size: 1.8rem">
                    <?= htmlspecialchars($email->title) ?>
                </h3>
            </div>

            <div
                style="
            background-color: #fcfdfd;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 1.5rem;
          ">
                <!-- New Review Received detail -->

                <div
                    style="
              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
              padding: 1rem;
              border: 1px solid #ececec;
            ">
                    <!-- descrition -->
                    <h4 style="color: #333333; font-weight: 500">
                        <?= htmlspecialchars(str_replace(
                            ['[[booking_id]]', '[[service_name]]', '[[rating]]'],
                            ['#' . $booking_id, $service_name, $rating],
                            $email->body
                        )) ?>
                    </h4>
                    <!-- line -->

                    <hr />

                    <!-- content -->
                    <ul style="list-style-type: none; padding: 0">
                        <li style="margin-bottom: 0.5rem">
                            <span style="font-weight: 600; color: #555555">Reviewer Name:</span>
                            <span style="color: #555555">#<?= htmlspecialchars($provider_name) ?></span>
                        </li>

                        <li style="margin-bottom: 0.5rem">
                            <span style="font-weight: 600; color: #555555">Review:</span>
                            <span style="color: #555555">#<?= htmlspecialchars($text) ?></span>
                        </li>

                        <li style="margin-bottom: 0.5rem">
                            <span style="font-weight: 600; color: #555555">Rating:</span>
                            <span style="color: #555555">#<?= htmlspecialchars($rating) ?></span>
                        </li>

                        <li style="margin-bottom: 0.5rem">
                            <span style="font-weight: 600; color: #555555">Date: </span>
                            <span style="color: #555555"><?= htmlspecialchars($booking_date) ?></span>
                        </li>


                    </ul>
                </div>

                <!--  contact -->

                <p
                    style="
              color: #555555;
              font-size: 1rem;
              margin-bottom: 10px;
              align-items: center;
              width: 100%;
              margin-top: 1rem;
            ">
                    <?= htmlspecialchars($email->section_text) ?>
                </p>

                <div style="color: #555555; font-size: 1rem;  ">
                    <p>Thanks & Regards <br><?= htmlspecialchars($general_settings->name) ?></p>

                </div>
            </div>
        </div>

        <!-- Pages -->
        <div style="padding-top: 1.5rem; text-align: center; font-weight: 600; color: #555555;">
            <?php if ($email->privacy_policy == 1): ?>
                <a href="http://145.223.23.5/privacy-policy-page" style="color: #555555; text-decoration: none; margin-right: 1rem">Privacy Policy</a>
            <?php endif; ?>

            <?php if ($email->refund_policy == 1): ?>
                <a href="http://145.223.23.5/refund-policy-page" style="color: #555555; text-decoration: none; margin-right: 1rem">Refund Policy</a>
            <?php endif; ?>

            <?php if ($email->cancellation_policy == 1): ?>
                <a href="http://145.223.23.5/cancel-policy-page" style="color: #555555; text-decoration: none; margin-right: 1rem">Cancellation Policy</a>
            <?php endif; ?>

            <?php if ($email->contact_us == 1): ?>
                <a href="http://145.223.23.5/contact-us-page" style="color: #555555; text-decoration: none">Contact Us</a>
            <?php endif; ?>
        </div>

        <!-- Social Logos and Icons -->
        <!-- Social Logos and Icons -->
        <div style="text-align: center; margin: 3rem 0.5rem 0.5rem 0.5rem">
            <?php if ($social_media->twitter_link): ?>
                <a href="<?= htmlspecialchars($social_media->twitter_link) ?>" target="_blank"><img
                        src="http://145.223.23.5/images/socialmedialogo/twitter.png" alt="Twitter"
                        style="width: 2rem; height: auto; margin-right: 1rem" /></a>
            <?php endif; ?>

            <?php if ($social_media->linkdln_link): ?>
                <a href="<?= htmlspecialchars($social_media->linkdln_link) ?>" target="_blank"><img
                        src="http://145.223.23.5/images/socialmedialogo/linkedin.png" alt="LinkedIn"
                        style="width: 2rem; height: auto; margin-right: 1rem" /></a>
            <?php endif; ?>

            <?php if ($social_media->instagram_link): ?>
                <a href="<?= htmlspecialchars($social_media->instagram_link) ?>" target="_blank"><img
                        src="http://145.223.23.5/images/socialmedialogo/instagram.png" alt="Instagram"
                        style="width: 2rem; height: auto; margin-right: 1rem" /></a>
            <?php endif; ?>

            <?php if ($social_media->facebook_link): ?>
                <a href="<?= htmlspecialchars($social_media->facebook_link) ?>" target="_blank"><img
                        src="http://145.223.23.5/images/socialmedialogo/facebook.png" alt="Facebook"
                        style="width: 2rem; height: auto; margin-right: 1rem" /></a>
            <?php endif; ?>
        </div>



        <!-- Copyright -->
        <div style="text-align: center; margin-top: 1.5rem; color: #555555">
            <p><?= htmlspecialchars($email->copyright_content) ?></p>
        </div>
    </div>
</body>

</html>