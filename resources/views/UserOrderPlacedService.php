<!DOCTYPE html>
<html lang="en">

<?php

use App\Models\UserEmailProductDelivered;
use App\Models\GeneralSettings;
use App\Models\SocialMedia;

$email = UserEmailProductDelivered::first();
$general_settings = GeneralSettings::first();
$social_media = SocialMedia::first(); // Fetch the social media links

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Received</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <style>
        @media screen and (max-width: 600px) {
            .email-template-container {
                display: block;
            }

            .card {
                width: 100%;
                margin-bottom: 1rem;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "IBM Plex Sans", serif;
            background-color: #ffffff;
        }
    </style>
</head>

<body style="
      margin: 0;
      padding: 0;

      background-color: #ffffff;
    ">
    <div
        style="
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #ececec;
        border-radius: 10px;
        max-width: 800px;
        min-width: none;
        overflow-x: hidden;
      ">
        <h1
            style="
          font-weight: 500;
          font-size: 24px;
          color: #35415a;
          margin-bottom: 20px;
        ">
            Order Received
        </h1>

        <p style="color: #282c2f; font-size: 20px; margin-bottom: 10px">
            Hi <span style="font-weight: 500; color: #282c2f"><?= htmlspecialchars($firstname) ?></span>,
        </p>

        <p style="color: #282c2f; font-size: 16px; margin-bottom: 10px">
            We are pleased to inform you that you have a new order. You can view the
            details after logging into your panel.
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
                    <img src="<?= asset('images/socialmedialogo/' . htmlspecialchars($email->logo)) ?>" alt="logo"
                        style="
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
                    Order Info
                </h3>
            </div>

            <div
                style="
            background-color: #fcfdfd;
            
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 1.5rem;
            padding: 1rem;
          ">
                <!-- Two cards in email template -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="48%" style="vertical-align: top; padding-right: 20px;">
                            <!-- 1st Card -->
                            <div
                                style="
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
          border: 1px solid #ececec;
          border-radius: 10px;
          padding: 1rem;
        ">
                                <h3 style="color: #333333; margin: 0 0 12px 0">Order Summary</h3>
                                <ul style="list-style-type: none; padding: 0; margin: 0">
                                    <li style="margin-bottom: 0.5rem">
                                        <span style="font-weight: 600; color: #555555">Order #:</span>
                                        <span style="color: #555555"><?= htmlspecialchars($order_id) ?></span>
                                    </li>
                                    <li style="margin-bottom: 0.5rem">
                                        <span style="font-weight: 600; color: #555555">Date:</span>
                                        <span style="color: #555555"><?= htmlspecialchars($order_date) ?></span>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        <td width="48%" style="vertical-align: top;">
                            <!-- 2nd Card -->
                            <div
                                style="
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
          border: 1px solid #ececec;
          border-radius: 10px;
          padding: 1rem;
        ">
                                <h3 style="color: #333333; margin: 0 0 12px 0">Delivery Address</h3>
                                <ul style="list-style-type: none; padding: 0; margin: 0">
                                    <li style="margin-bottom: 0.5rem">
                                        <span style="color: #555555"><?= htmlspecialchars($my_name) ?></span>
                                    </li>
                                    <li style="margin-bottom: 0.5rem">
                                        <span style="color: #555555"><?= htmlspecialchars($addressString) ?></span>
                                    </li>
                                    <!-- <li style="margin-bottom: 0.5rem">
                    <span style="color: #555555">Manchester, Kentucky 39495</span>
                  </li> -->
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>

                <?php if (!empty($allItms_done)): ?>
                    <!-- service detail -->

                    <table style="width: 100%; border-collapse: collapse; margin-top: 1.5rem">
                        <thead style="background-color: #4c7fdb">
                            <tr>
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Service
                                </th>
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Quantity
                                </th>
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            style="border-left: #ddd solid 1px; border-right: #ddd solid 1px; border-bottom: #ddd solid 1px; box-shadow: 2px 4px 14.4px 0px #0000000f;">

                            <tr>
                                <td style="padding: 0.5rem; text-align: left; vertical-align: middle; color: #555555;">
                                    <!-- image -->
                                    <span
                                        style="vertical-align: middle; height: fit-content; display: inline-block; color: #282c2f; margin-left: 10px;">
                                        <?php echo htmlspecialchars($booking_services_name); ?>
                                    </span>
                                </td>
                                <td style="padding: 0.5rem; color: #282c2f; text-align: left;">
                                    1
                                </td>
                                <td style="padding: 0.5rem; color: #282c2f; text-align: left;">
                                    <?php echo htmlspecialchars($final_price); ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                <?php endif; ?>

                <!--  product -->

                <?php if (!empty($productItms_done)): ?>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 1.5rem">
                        <thead style="background-color: #4c7fdb; border-radius: 15px">
                            <tr style="border-radius: 5px">
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Product
                                </th>
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Quantity
                                </th>
                                <th style="padding: 0.5rem; color: #ffffff; text-align: left; font-size: 1rem;">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            style="border-left: #ddd solid 1px; border-right: #ddd solid 1px; border-bottom: #ddd solid 1px; box-shadow: 2px 4px 14.4px 0px #0000000f;">
                            <?php foreach ($productItms_done as $cartItem): ?>
                                <tr>
                                    <td style="padding: 0.5rem; text-align: left; vertical-align: middle; color: #555555;">
                                        <span
                                            style="vertical-align: middle; height: fit-content; display: inline-block; color: #282c2f; margin-left: 10px;">
                                            <?php echo htmlspecialchars($cartItem->product_name); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 0.5rem; color: #282c2f; text-align: left;">
                                        <?php echo htmlspecialchars($cartItem->quantity); ?>
                                    </td>
                                    <td style="padding: 0.5rem; color: #282c2f; text-align: left;">
                                        <?php echo htmlspecialchars($cartItem->product_price); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <!-- price detail; -->
                <table
                    style="
              max-width: 100%;
              width: 60%;
              border-collapse: collapse;
              margin-top: 1rem;
              margin-left: auto;

              border: 1px solid #ececec;
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
              border-radius: 8px;
            ">
                    <tbody style="height: 12rem; width: 100%">
                        <tr style="width: 100%">
                            <td
                                style="
                    color: #555555;
                   
                    padding-left: 1rem;
                    width: 50%;
                  ">
                                Item Price:
                            </td>
                            <td
                                style="
                    text-align: right;
                    color: #555555;
                   
                    padding-right: 1rem;
                    width: 50%;
                  ">
                                <?= htmlspecialchars($sub_total) ?>
                            </td>
                        </tr>

                        <tr style="width: 100%">
                            <td
                                style="
                    color: #555555;
                    
                    padding-left: 1rem;
                    width: 50%;
                  ">
                                Coupon Discount:
                            </td>
                            <td
                                style="
                    text-align: right;
                    color: #555555;
                    
                    padding-right: 1rem;
                    width: 50%;
                  ">
                                <?= '-' . htmlspecialchars($coupon) ?>
                            </td>
                        </tr>

                        <tr style="width: 100%">
                            <td
                                style="
                    color: #555555;
                   
                    padding-left: 1rem;
                    width: 50%;
                  ">
                                Sub Total:
                            </td>
                            <td
                                style="
                    text-align: right;
                    color: #555555;
                    
                    padding-right: 1rem;
                    width: 50%;
                  ">
                                <?= htmlspecialchars($sub_total) ?>
                            </td>
                        </tr>

                        <tr style="width: 100%">
                            <td style="color: #555555;  padding-left: 1rem">
                                VAT/Tax:
                            </td>
                            <td
                                style="
                    text-align: right;
                    color: #555555;
                    
                    padding-right: 1rem;
                  ">
                                <?= htmlspecialchars($tax) ?>
                            </td>
                        </tr>

                        <tr>
                            <td style="color: #555555;  padding-left: 1rem">
                                Platform Fee:
                            </td>
                            <td
                                style="
                    text-align: right;
                    color: #555555;
                   
                    padding-right: 1rem;
                  ">
                                <?= htmlspecialchars($service_charge) ?>
                            </td>
                        </tr>

                        <tr>
                            <td
                                style="
                    color: #555555;
                    font-size: 1.3rem;
                    font-weight: 500;
                    padding-left: 1rem;
                  ">
                                Total:
                            </td>
                            <td
                                style="
                    text-align: right;
                    font-weight: 700;
                    font-size: 1.2rem;
                    color: #71dd37;
                    padding-right: 1rem;
                  ">
                                <?= htmlspecialchars($total) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

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
                    <p>Thanks & Regards <br> <?= htmlspecialchars($general_settings->name) ?></p>

                </div>
            </div>
        </div>

        <!-- Pages -->
        <div style="padding-top: 1.5rem; text-align: center; font-weight: 600; color: #555555;">
            <?php if ($email->privacy_policy == 1): ?>
                <a href="http://145.223.23.5/privacy-policy-page"
                    style="color: #555555; text-decoration: none; margin-right: 1rem">Privacy Policy</a>
            <?php endif; ?>

            <?php if ($email->refund_policy == 1): ?>
                <a href="http://145.223.23.5/refund-policy-page"
                    style="color: #555555; text-decoration: none; margin-right: 1rem">Refund Policy</a>
            <?php endif; ?>

            <?php if ($email->cancellation_policy == 1): ?>
                <a href="http://145.223.23.5/cancel-policy-page"
                    style="color: #555555; text-decoration: none; margin-right: 1rem">Cancellation Policy</a>
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