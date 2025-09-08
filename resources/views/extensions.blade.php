<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Handyman App Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <style>
        body {
            font-family: "Poppins", sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(to bottom, #ffeb3b, #ffc107);
        }

        .current-step {
            background: linear-gradient(to bottom, #ffeb3b, #ffc107);
        }

        .fontfamily {
            font-family: "Poppins", sans-serif;
        }

        #toast-danger {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            /* Ensure it
            appears above other content */
        }

        .flex.w-full.mx-auto.md\:space-x-6.mb-4 {
            margin-left: 80px;
        }
    </style>

<style>
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .heading {
        font-size: 24px;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .status-table {
        width: 100%;
        border-collapse: collapse;
    }

    .status-table th,
    .status-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .checkmark {
        color: green;
        font-weight: bold;
    }

    .error {
        color: red;
        font-weight: bold;
    }

    .next-btn-container {
        display: flex;
        justify-content: center;
        /* Horizontal center */
        align-items: center;
        /* Vertical center (अगर जरूरत हो) */
        margin-top: 20px;
        /* ऊपर से कुछ स्पेस */
    }

    .next-btn {
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        color: black;
        background: linear-gradient(to right, #ffcc00, #ff9900);
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        display: inline-block;
    }
</style>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="text-white bg-gray-900">
    <!-- Main Background and Content Wrapper -->
    <main class="relative min-h-screen"
        style="
        background-image: url('./image/bg-image.png');
        background-size: cover;
        background-position: center;
      ">
        <div class="absolute xl:top-[3rem] xl:right-[4rem] right-2 top-[4rem] md:top-[3rem]">
            <img src="./image/handyhue.png" alt="Chat App Logo" style="width: auto !important;"
                class="h-auto w-auto max-h-48    object-contain" />


        </div>
        <!-- tost message -->
        <div id="toast-danger"
            class="relative flex items-center hidden w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow toast"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="text-sm font-normal ms-3 tost-errormessage">
                Error message goes here.
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-danger" aria-label="Close" onclick="closeToast()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- tost successs -->

        <!-- Installation Container (Center) -->
        <div class="relative w-full max-w-6xl p-6 mx-auto">
            <div class="relative flex flex-col items-center justify-center xl:w-[90%] xl:mx-auto">
                <!-- Step Progress Bar -->
                <div class="flex flex-col mb-8 text-center md:gap-y-4 gap-y-2 xl:w-full">
                    <h1
                        class="text-lg mt-[2.4rem] md:mt-[1rem] md:text-4xl font-semibold lg:text-5xl xl:text-6xl text-[#FFFFFF] fontfamily">
                        Handyman APP Software Installation
                    </h1>
                    <style>

                    </style>
                    <p class="text-sm text-[#FFFFFF] md:text-lg xl:text-[1.5rem]  fontfamily custom-xl-text">
                        Please proceed with your envato username and script purchase code to setup
                    </p>
                </div>
            </div>

            <div class="flex w-full  mx-auto md:space-x-6 mb-4 justify-center">

                <!-- Step 1 -->
                <div class="flex items-center w-full">
                    <div id="step1"
                        class="flex items-center justify-center w-8 h-8 text-black rounded-full lg:w-10 lg:h-10 current-step">
                        1
                    </div>
                    <span id="line1" class="flex-grow block h-1 bg-gray-700 rounded-lg current-step"></span>
                </div>
                <!-- Step 2 -->
                <div class="flex items-center block w-full">
                    <div id="step2"
                        class="flex items-center justify-center w-8 h-8 text-[#656971] bg-gray-700 rounded-full lg:w-10 lg:h-10">
                        2
                    </div>
                    <span id="line2" class="flex-grow block h-1 bg-gray-700 rounded-lg"></span>
                </div>

                <!-- Step 3 -->
                <div class="flex items-center w-full">
                    <div id="step3"
                        class="flex items-center justify-center w-8 h-8 bg-gray-700 rounded-full lg:w-10 lg:h-10 text-[#656971]">
                        3
                    </div>
                    <span id="line3" class="flex-grow block h-1 bg-gray-700"></span>
                </div>
                <!-- Step 4 -->
                <div class="flex items-center w-full">
                    <div id="step4"
                        class="flex items-center justify-center w-8 h-8 text-[#656971] bg-gray-700 rounded-full lg:w-10 lg:h-10">
                        4
                    </div>
                    <span id="line4" class="flex-grow block h-1 bg-gray-700"></span>
                </div>
                <!-- step 5 -->
                <div class="flex items-center w-full">
                    <div id="step5"
                        class="flex items-center justify-center w-8 h-8 text-[#656971] bg-gray-700 rounded-full lg:w-10 lg:h-10">
                        5
                    </div>
                    {{-- <span id="line5" class="flex-grow block h-1 bg-gray-700"></span> --}}
                </div>


            </div>

            <!-- Step Form (Steps Container) -->
                <!-- Main Content Area -->
                <div class="relative z-20 p-6 text-gray-900 rounded-lg shadow-md w-[100%] bg-white py-10">
                    <!-- Step 1 Content -->
                    <div id="stepContent1" class="step-content">
                        <div class="grid items-center justify-between md:flex">
                            <div class="mt-[-1rem]">
                                <h2
                                    class="mb-4 text-[14px] font-[600] md:font-[500] lg:text-lg text-[#555555] fontfamily xl:text-2xl">
                                    <b> Step 1 </b> : Requirements PHP Extensions
                                </h2>
                                <div class="relative top-[-0.5rem]">
                                    <p
                                        class="md:mb-6 text-xs xl:text-lg text-[#000000] lg:text-sm fontfamily font-[400] mr-[2.48rem] md:ml-2 lg:ml-0 md:mr-0">

                                        <a href="#" class="py-1 fontfamily">
                                            Please make sure the PHP extensions listed below are installed
                                        </a>

                                    </p>
                                </div>
                            </div>
                            <div
                                class="relative md:top-[-2.5rem] flex md:justify-between pb-3 md:pb-0 items-center justify-center ml-2 md:left-[-1px] gap-x-1">
                                <a href="https://document.handyhue.com/"
                                    class="underline text-[#435CFF] text-sm fontfamily xl:text-[16px]" target="_blank"
                                    rel="noopener noreferrer">Read Documentation</a>
                                <div class="flex w-4 h-4">
                                    <img src="./image/info-circle.png" alt="" class="w-full h-full" />
                                </div>
                            </div>
                        </div>


                        <div class="container">
                            <h2 class="heading">Check & Verify File Permissions</h2>

                            <table class="status-table">
                                <thead>
                                    <tr>
                                        <th width="25%">Extension</th>
                                        <th width="25%">Status</th>
                                        <th width="25%">Extension</th>
                                        <th width="25%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PHP >= {{ $requiredPHPVersion }}</td>
                                         <td class=" {{ !! $phpVersionStatus ? 'text-green-600' : 'text-red-600' }}" style="text-align: center;">{!! $phpVersionStatus ? '✔' : '❌' !!}

                                        </td>

                                        <td>PHP Version</td>
                                        <td class=" {{ !! $currentPHPVersion ? 'text-green-600' : 'text-red-600' }}" style="text-align: center;">{!! $currentPHPVersion ? $currentPHPVersion : $currentPHPVersion !!}

                                       </td>
                                    </tr>
                                    @php
                                        $chunks = array_chunk($extensionsStatus, ceil(count($extensionsStatus) / 2), true);
                                    @endphp
                                    @for ($i = 0; $i < max(count($chunks[0]), count($chunks[1] ?? [])); $i++)
                                        <tr>
                                            @php
                                                $ext1 = array_keys($chunks[0])[$i] ?? null;
                                                $ext2 = isset($chunks[1]) ? (array_keys($chunks[1])[$i] ?? null) : null;
                                            @endphp

                                            @if ($ext1)
                                            <td style="padding: 10px; text-align: left;">{{ ucfirst($ext1) }}</td>
                                            <td class=" {{ !! $chunks[0][$ext1] ? 'text-green-600' : 'text-red-600' }}" style="text-align: center;">{!! $chunks[0][$ext1] ? '✔' : '❌' !!}</td>
                                            @else
                                                <td></td><td></td>
                                            @endif

                                            @if ($ext2)
                                            <td style="padding: 10px; text-align: left;">{{ ucfirst($ext2) }}</td>
                                            <td class=" {{ !! $chunks[0][$ext1] ? 'text-green-600' : 'text-red-600' }}" style="text-align: center;">{!! $chunks[0][$ext1] ? '✔' : '❌' !!}</td>
                                        @else
                                                <td></td><td></td>
                                            @endif
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>

                            {{-- <div class="next-btn-container">
                                <a href="{{ url('check-directories') }}" class="next-btn">Next ➡</a>
                            </div> --}}

                            <div class="next-btn-container">
                                <a href="{{ url('check-directories') }}" class="next-btn"
                                    @if ($missingExtensions) onclick="showMissingExtensionsAlert(event)" @endif>
                                    Next ➡
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="w-[100%] mx-auto mt-5 bg-[#424242] h-[1px]"></div>

            <footer class="relative flex items-center justify-between py-6 top-4 w-full">
                <div class="flex items-center cursor-pointer">
                    <div class="h-auto w-auto absolute left-8">
                        <!-- <img src="/image/logochat.png"
                            class="w-auto h-auto max-h-16 object-contain" />
                    </div> -->
                        <img src="/image/handyhue.png" style="width: auto !important;"
                            class="w-auto h-auto max-h-64   pt-20  object-contain" />

                    </div>
                    <div class="absolute right-8">
                        <p class="text-sm text-gray-500">@2025 | All Rights Reserved</p>
                    </div>
            </footer>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <style>
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .status-table {
            width: 100%;
            border-collapse: collapse;
        }

        .status-table th,
        .status-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .checkmark {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .next-btn-container {
            display: flex;
            justify-content: center;
            /* Horizontal center */
            align-items: center;
            /* Vertical center (अगर जरूरत हो) */
            margin-top: 20px;
            /* ऊपर से कुछ स्पेस */
        }

        .next-btn {
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: black;
            background: linear-gradient(to right, #ffcc00, #ff9900);
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            display: inline-block;
        }
    </style>

    @if ($missingExtensions)
        <script>
            function showMissingExtensionsAlert(event) {
                event.preventDefault(); // Prevent default redirection

                Swal.fire({
                    icon: 'error',
                    title: 'Missing PHP Extensions',
                    text: 'Some required PHP extensions are missing. Please install them before proceeding.',
                    confirmButtonText: 'OK'
                });
            }
        </script>
    @endif





</body>

</html>
