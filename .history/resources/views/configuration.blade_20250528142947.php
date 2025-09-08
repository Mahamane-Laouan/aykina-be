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

        .skip-btn {
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 8px;
            border: none;
        }

        .continue-btn {
            background: #007bff;
            color: white;
        }

        .skip-btn {
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }

        /* Next button - solid blue */
        .continue-btn {
            background: #007bff;
            color: white;
        }

        /* Skip button - lighter, subtle look */
        .skip-btn {
            background: #111724;
            /* light gray background */
            color: #fff;
            /* dark gray text */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Skip button hover - brighten and add subtle scale */
        .skip-btn:hover {
            background: #111724;
            /* soft light blue */
            color: #ffff;
            /* deeper blue text */
            box-shadow: 0 4px 12px rgba(26, 26, 125, 0.3);
            transform: scale(1.05);
        }


        /* Make sure SweetAlert2 confirm buttons are always fully visible */
        .swal2-confirm {
            background-color: #28a745 !important;
            /* Green background */
            color: white !important;
            /* White text */
            border: none !important;
            opacity: 1 !important;
            box-shadow: none !important;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        /* Optional: Add hover effect */
        .swal2-confirm:hover {
            background-color: #218838 !important;
            /* Darker green on hover */
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


            <div class="flex w-full mx-auto md:space-x-6 mb-4">

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
                        class="flex items-center justify-center w-8 h-8 text-black rounded-full lg:w-10 lg:h-10 current-step">
                        2
                    </div>
                    <span id="line2" class="flex-grow block h-1 bg-gray-700 rounded-lg current-step"></span>
                </div>

                <!-- Step 3 -->
                <div class="flex items-center w-full">
                    <div id="step3"
                        class="flex items-center justify-center w-8 h-8 text-black rounded-full lg:w-10 lg:h-10 current-step">
                        3
                    </div>
                    <span id="line3" class="flex-grow block h-1 bg-gray-700 rounded-lg current-step"></span>
                </div>
                <!-- Step 4 -->
                <div class="flex items-center w-full">
                    <div id="step4"
                        class="flex items-center justify-center w-8 h-8 text-[#656971] bg-gray-700 rounded-full lg:w-10 lg:h-10 current-step">
                        4
                    </div>
                    <span id="line4" class="flex-grow block h-1 bg-gray-700 current-step"></span>
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
            <div class="relative flex flex-row items-center justify-center">
                <!-- Main Content Area -->
                <div class="relative z-20 p-6 text-gray-900 rounded-lg shadow-md w-[100%] bg-white py-10">
                    <!-- Step 1 Content -->
                    <div id="stepContent1" class="step-content">
                        <div class="grid items-center justify-between md:flex">
                            <div class="mt-[-1rem]">
                                <h2
                                    class="mb-4 text-[14px] font-[600] md:font-[500] lg:text-lg text-[#555555] fontfamily xl:text-2xl">
                                    <b> Step 4 </b> :Update Database Information
                                </h2>
                                <div class="relative top-[-0.5rem]">
                                    <p
                                        class="md:mb-6 text-xs xl:text-lg text-[#000000] lg:text-sm fontfamily font-[400] mr-[2.48rem] md:ml-2 lg:ml-0 md:mr-0">
                                        If you have entered the fields in the env file then you can skip this step.
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
                        <form id="installForm" class="px-3 pt-3 m-0 rounded-md"
                            style="
                          border-bottom: 1px solid #ececec;
                          box-shadow: 2px 4px 14.4px 0px #0000000f;
                        ">
                            <div class="grid grid-cols-1 gap-6 py-4 mb-6 md:grid-cols-2">
                                <!-- Database Name -->
                                <div class="flex flex-col gap-y-2 md:gap-y-[1rem] w-[95%] mx-auto">
                                    <!-- Grid container for Username label, asterisk, and info icon -->
                                    <div class="grid items-center grid-cols-[auto_auto_1fr] gap-x-2 relative">
                                        <!-- Username label -->
                                        <label for="dbHost"
                                            class="block text-sm xl:text-lg font-[500] text-[#000000]">
                                            Database Name
                                        </label>

                                        <!-- Info icon with tooltip -->
                                        <div class="relative group ml-[-0.2rem]">
                                            <img src="./image/info-circle1.jpg" class="w-4 h-4 cursor-pointer"
                                                alt="Info" />
                                            <!-- Tooltip (hidden by default, visible on hover) -->
                                            <div class="absolute top-[-2rem] left-4 md:top-[-2rem] md:py-3 md:text-sm px-2 font-normal py-2 text-[10px] text-[#555555] w-[7rem] duration-200 md:w-[15rem] z-50 xl:w-[20rem] mx-auto rounded md:left-10 border border-[#ececec] opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto"
                                                style="
                                    box-shadow: 0px 0px 10px 0px #00000040;
                                    background-color: white;
                                  ">
                                                Enter the Database name which doesn't Exist
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" id="db_name" name="db_name"
                                        value="{{ old('db_name', $db_name) }}"
                                        class="w-full p-2 px-6 py-2 transition-all duration-300 rounded-md md:py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 font-lg"
                                        placeholder="db_name" 
                                        style="border: 1px solid #d3d3d37d; background-color: #f0f0f0;" disabled />

                                </div>
                                <!-- Database Username -->
                                <div class="flex flex-col gap-y-2 md:gap-y-[1rem] w-[95%] mx-auto">
                                    <div class="grid items-center grid-cols-[auto_auto_1fr] gap-x-2 relative">
                                        <!-- Username label -->
                                        <label for="DBuser"
                                            class="block text-sm xl:text-lg font-[500] text-[#000000]">
                                            Database Username
                                        </label>

                                        <!-- Info icon with tooltip -->
                                        <div class="relative group">
                                            <img src="./image/info-circle1.jpg" class="w-4 h-4 cursor-pointer"
                                                alt="Info" />
                                            <!-- Tooltip (hidden by default, visible on hover) -->
                                            <div class="absolute top-[-2rem] left-4 md:top-[-2rem] md:py-3 md:text-sm px-2 font-normal py-2 text-[10px] text-[#555555] w-[7rem] duration-200 md:w-[15rem] z-50 xl:w-[20rem] mx-auto rounded md:left-10 border border-[#ececec] opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto"
                                                style="
                                    box-shadow: 0px 0px 10px 0px #00000040;
                                    background-color: white;
                                  ">
                                                Enter Database User name which possibly already exist
                                                or New will be created
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" id="username" name="username"
                                        value="{{ old('username', $db_user) }}"
                                        class="w-full p-2 py-2 transition-all duration-300 rounded-md md:py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 font-lg md:px-6"
                                        placeholder="Ex: root"  style="border: 1px solid #d3d3d37d; background-color: #f0f0f0;"
                                        disabled />
                                </div>
                                <!-- Database Password -->
                                <div class="relative flex flex-col gap-y-2 md:gap-y-[1rem] w-[95%] mx-auto">
                                    <div class="grid items-center grid-cols-[auto_auto_1fr] gap-x-2 relative">
                                        <label for="password"
                                            class="block text-sm xl:text-lg font-[500] text-[#000000]">
                                            Database Password
                                        </label>

                                        <div class="relative group">
                                            <img src="./image/info-circle1.jpg" class="w-4 h-4 cursor-pointer"
                                                alt="Info" />
                                            <div class="absolute top-[-2rem] left-4 md:top-[-2rem] md:py-3 md:text-sm px-2 font-normal py-2 text-[10px] text-[#555555] w-[7rem] duration-200 md:w-[15rem] z-50 xl:w-[16rem] mx-auto rounded md:left-10 border border-[#ececec] opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto"
                                                style="box-shadow: 0px 0px 10px 0px #00000040; background-color: white;">
                                                Enter the Database User's Password
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center relative">
                                        <input type="password" id="password" name="password"
                                            value="{{ old('password', $db_password) }}"
                                            class="w-full p-2 py-2 transition-all duration-300 rounded-md md:py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 font-lg md:px-6"
                                            placeholder="Ex: Password"  style="border: 1px solid #d3d3d37d; background-color: #f0f0f0;"
                                            disabled />

                                        <i class="bi bi-eye-slash absolute right-3 top-1/2 -translate-y-1/2 text-gray-600 cursor-pointer"
                                            id="togglePassword" onclick="togglePasswordVisibility()"
                                            style="margin-top: 1px;"></i>
                                    </div>
                                </div>
                                <!-- App Url -->
                                <div class="relative flex flex-col gap-y-2 md:gap-y-[1rem] w-[95%] mx-auto">
                                    <div class="grid items-center grid-cols-[auto_auto_1fr] gap-x-2 relative">
                                        <!-- APP_URL label -->
                                        <label for="app_url"
                                            class="block text-sm xl:text-lg font-[500] text-[#000000]">
                                            Application URL
                                        </label>

                                        <!-- Info icon with tooltip -->
                                        <div class="relative group">
                                            <img src="./image/info-circle1.jpg" class="w-4 h-4 cursor-pointer"
                                                alt="Info" />
                                            <!-- Tooltip (hidden by default, visible on hover) -->
                                            <div class="absolute top-[-2rem] left-4 md:top-[-2rem] md:py-3 md:text-sm px-2 font-normal py-2 text-[10px] text-[#555555] w-[7rem] duration-200 md:w-[15rem] z-50 xl:w-[16rem] mx-auto rounded md:left-10 border border-[#ececec] opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto"
                                                style="
                                                    box-shadow: 0px 0px 10px 0px #00000040;
                                                    background-color: white;
                                                ">
                                                Enter your application URL (e.g., https://yourdomain.com)
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="text" id="app_url" name="app_url"
                                            value="{{ old('app_url', $app_url) }}"
                                            class="w-full p-2 py-2 transition-all duration-300 rounded-md md:py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 font-lg md:px-6"
                                            placeholder="Ex: https://yourdomain.com"
                                             style="border: 1px solid #d3d3d37d; background-color: #f0f0f0;" disabled />
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div
                            class="mt-7 xl:mt-[3rem] text-center md:w-[20%] mx-auto rounded-lg group w-[75%] flex justify-center gap-4">

                            <!-- Skip Button -->
                            <button id="skipButton" class="skip-btn flex items-center justify-center gap-2">
                                <span>Skip</span>
                                <svg id="loadingSpinnerSkip" class="hidden w-5 h-5 text-white animate-spin"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </button>

                            <button id="continueButton" class="continue-btn flex items-center justify-center gap-2">
                                <span>Next</span>
                                <svg id="loadingSpinner" class="hidden w-5 h-5 text-white animate-spin"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </button>

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

    <script>
        document.getElementById("continueButton").addEventListener("click", function() {
            const continueBtn = document.getElementById("continueButton");
            const spinner = document.getElementById("loadingSpinner");

            // Disable button and show spinner
            continueBtn.disabled = true;
            spinner.classList.remove("hidden");

            let formData = new FormData();
            let app_url = document.getElementById("app_url").value;
            let db_name = document.getElementById("db_name").value;
            let db_username = document.getElementById("username").value;
            let db_password = document.getElementById("password").value;

            formData.append("app_url", app_url);
            formData.append("db_database", db_name);
            formData.append("db_username", db_username);
            formData.append("db_password", db_password);

            fetch("{{ route('save-configuration') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Re-enable button and hide spinner
                    continueBtn.disabled = false;
                    spinner.classList.add("hidden");

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Configuration updated successfully!',
                            confirmButtonText: 'OK',
                            position: 'center',
                            showConfirmButton: true,
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('done') }}";
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error updating configuration!',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    continueBtn.disabled = false;
                    spinner.classList.add("hidden");

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                    console.error("Error:", error);
                });
        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.src = "./image/eye.png"; // Open eye image
            } else {
                passwordInput.type = "password";
                toggleIcon.src = "./image/eye-slash.png"; // Closed eye image
            }
        }
    </script>

    <style>
        .continue-btn {
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
            transition: all 0.3s ease-in-out;
            border: none;
            cursor: pointer;
        }

        .continue-btn:hover {
            background: linear-gradient(to right, #ff9900, #ffcc00);
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }
    </style>

    <script>
        document.getElementById('skipButton').addEventListener('click', () => {
            // Show spinner on Skip button
            document.getElementById('loadingSpinnerSkip').classList.remove('hidden');

            // Optional: disable buttons to prevent double-click
            document.getElementById('skipButton').disabled = true;
            document.getElementById('continueButton').disabled = true;

            setTimeout(() => {
                window.location.href = "{{ route('done') }}";
            }, 1500); // 1.5 seconds delay before redirect
        });
    </script>


</body>

</html>
