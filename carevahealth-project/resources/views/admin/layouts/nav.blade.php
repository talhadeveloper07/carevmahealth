<style>
    .badge-notifications {
        min-width: 18px;
        height: 18px;
        font-size: 12px;
        line-height: 18px;
        text-align: center;
        padding: 0 5px;
    }
</style>
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ti tabler-menu-2 icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
            </div>
        </div>

        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">

            <li>
                <span id="live-datetime" class="badge bg-info"></span>
            </li>
            <!-- Quick links  -->
            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
                <a class="" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="icon-base ti tabler-layout-grid-add icon-22px text-heading"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-0">
                    <div class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="mb-0 me-auto">Shortcuts</h6>
                            <a href="javascript:void(0)"
                                class="dropdown-shortcuts-add py-2 btn btn-text-secondary rounded-pill btn-icon"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
                                    class="icon-base ti tabler-plus icon-20px text-heading"></i></a>
                        </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-calendar icon-26px text-heading"></i>
                                </span>
                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                <small>Appointments</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-file-dollar icon-26px text-heading"></i>
                                </span>
                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                <small>Manage Accounts</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-user icon-26px text-heading"></i>
                                </span>
                                <a href="app-user-list.html" class="stretched-link">User App</a>
                                <small>Manage Users</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-users icon-26px text-heading"></i>
                                </span>
                                <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                <small>Permission</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-device-desktop-analytics icon-26px text-heading"></i>
                                </span>
                                <a href="index.html" class="stretched-link">Dashboard</a>
                                <small>User Dashboard</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-settings icon-26px text-heading"></i>
                                </span>
                                <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                                <small>Account Settings</small>
                            </div>
                        </div>
                        <div class="row row-bordered overflow-visible g-0">
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-help-circle icon-26px text-heading"></i>
                                </span>
                                <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                <small>FAQs & Articles</small>
                            </div>
                            <div class="dropdown-shortcuts-item col">
                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                    <i class="icon-base ti tabler-square icon-26px text-heading"></i>
                                </span>
                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                <small>Useful Popups</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- Quick links -->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                <a class="" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                    <span class="position-relative">
                        <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                        <span
                            class="rounded-pill badge-notification border position-absolute start-100 translate-middle"
                            style="position: relative;top: -2px;padding: 3px;background: red;font-size: 10px;font-weight: bold;color: white;width: 24px;height: 23px;display: inline-block;text-align: center;">+</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end p-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="mb-0 me-auto">Notification</h6>
                            <div class="d-flex align-items-center h6 mb-0">
                                {{-- <span class="badge bg-label-primary me-2"> New</span> --}}
                                <form action="{{ route('notifications.readAll') }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-notifications-all p-2 btn btn-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read">
                                        <i class="icon-base ti tabler-mail-opened text-heading"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush" id="notifications-list">
                            <!-- JS will inject notifications here -->
                            <div class="text-center p-5">
                                Loading...
                            </div>
                        </ul>
                    </li>

                    <li class="border-top">
                        <div class="d-grid p-4">
                            <a class="btn btn-primary btn-sm d-flex" href="{{ route('notifications.index') }}">
                                <small class="align-middle">View all notifications</small>
                            </a>
                        </div>
                    </li>
                </ul>

            </li>
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt=""
                                class="rounded-circle " style="object-fit: cover" width="100">
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        @if (Auth::user()->profile_image)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                                alt="" class="rounded-circle" width="100">
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <small class="text-body-secondary">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-profile-user.html">
                            <i class="icon-base ti tabler-user me-3 icon-md"></i><span class="align-middle">My
                                Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <i class="icon-base ti tabler-settings me-3 icon-md"></i><span
                                class="align-middle">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-billing.html">
                            <span class="d-flex align-items-center align-middle">
                                <i class="flex-shrink-0 icon-base ti tabler-file-dollar me-3 icon-md"></i><span
                                    class="flex-grow-1 align-middle">Billing</span>
                                <span
                                    class="flex-shrink-0 badge bg-danger d-flex align-items-center justify-content-center">4</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-pricing.html">
                            <i class="icon-base ti tabler-currency-dollar me-3 icon-md"></i><span
                                class="align-middle">Pricing</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-faq.html">
                            <i class="icon-base ti tabler-question-mark me-3 icon-md"></i><span
                                class="align-middle">FAQ</span>
                        </a>
                    </li>
                    <li>
                        <div class="d-grid px-2 pt-2 pb-1">

                            <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <small class="align-middle">Logout</small>
                                <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>


<script>
    // ✅ Initialize Pusher
    Pusher.logToConsole = true;
    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: false
    });

    // Load removed IDs from localStorage
    let removedIds = JSON.parse(localStorage.getItem('removedNotifications')) || [];

    // Update badge
    function updateNotificationBadge(count) {
        let badge = document.querySelector(".badge-notification");
        if (count > 0) {
            badge.style.display = "inline-block";
            badge.innerText = count;
        } else {
            badge.style.display = "none";
        }
    }

    // Fetch & render notifications
    function fetchNotifications() {
        fetch("{{ route('notifications.all') }}")
            .then(res => res.json())
            .then(data => {
                let list = document.getElementById('notifications-list');
                list.innerHTML = "";

                data.forEach(notification => {
                    // Skip removed notifications
                    if (removedIds.includes(notification.id)) return;

                    let notifData = typeof notification.data === "string" ?
                        JSON.parse(notification.data) :
                        notification.data;

                    let name = notifData.first_name ?
                        notifData.first_name + " " + (notifData.last_name ?? "") :
                        notifData.name ?? "Unknown User";

                    let message = "";
                    if (notification.type === "UserRegistered") {
                        message = `New user <b>${name}</b> registered!`;
                    } else if (notification.type === "ProfileUpdated") {
                        message = `<b>${name}</b> has updated their profile!`;
                    }

                    let unreadClass = notification.is_read == 0 ?
                        'style="background:#0e31800d;color:#fff;"' : "";

                    let markReadLink = notification.is_read == 0 ?
                        `<div class="flex-shrink-0 ms-2">
                                <a href="javascript:void(0)" class="mark-single-read small" data-id="${notification.id}">
                                    <span style="
                                        display:inline-block;
                                        width:12px;
                                        height:12px;
                                        background:#0E3180;
                                        border-radius:50%;
                                    "></span>
                                </a>
                           </div>` :
                        "";

                    let closeBtn = `<div class="flex-shrink-0 ms-2">
                                        <a href="javascript:void(0)" class="notification-close text-danger small" data-id="${notification.id}">×</a>
                                    </div>`;

                    list.innerHTML += `
                        <li class="list-group-item list-group-item-action dropdown-notifications-item d-flex justify-content-between align-items-center" ${unreadClass} data-id="${notification.id}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-success">
                                            ${name.substring(0,2).toUpperCase()}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">${message}</h6>
                                    <small class="text-body-secondary">
                                        ${new Date(notification.created_at).toLocaleString()}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                ${markReadLink}
                                ${closeBtn}
                            </div>
                        </li>
                    `;
                });

                // Update badge count (only unread and not removed)
                updateNotificationBadge(data.filter(n => !n.is_read && !removedIds.includes(n.id)).length);
            });
    }

    // Initial fetch
    fetchNotifications();

    // Pusher real-time updates
    var userChannel = pusher.subscribe("userregistered");
    var profileChannel = pusher.subscribe("profileupdated");

    userChannel.bind("UserRegisteredNotification", fetchNotifications);
    profileChannel.bind("ProfileUpdatedNotification", fetchNotifications);

    // Mark all as read (AJAX)
    $(document).on("click", ".dropdown-notifications-all", function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('notifications.readAll') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                $("#notifications-list li").css({
                    "background": "",
                    "color": ""
                });
                updateNotificationBadge(0);
            }
        });
    });

    // Mark single as read (AJAX)
    $(document).on("click", ".mark-single-read", function(e) {
        e.preventDefault();
        let id = $(this).data("id");

        $.ajax({
            url: "{{ route('notifications.readSingle') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function() {
                let li = $(`#notifications-list li[data-id="${id}"]`);
                li.css({
                    "background": "",
                    "color": ""
                });
                li.find(".mark-single-read").hide();
                let count = parseInt($(".badge-notification").text()) - 1;
                updateNotificationBadge(count);
            }
        });
    });

    // Close notification (× button, frontend only, persistent hide)
    $(document).on("click", ".notification-close", function(e) {
        e.preventDefault();
        let li = $(this).closest("li.dropdown-notifications-item");
        let id = li.data("id");

        // Add to removedIds and save in localStorage
        removedIds.push(id);
        localStorage.setItem('removedNotifications', JSON.stringify(removedIds));

        li.remove();

        // Update badge count if it was unread
        if (li.find(".mark-single-read").length) {
            let count = parseInt($(".badge-notification").text()) - 1;
            updateNotificationBadge(count);
        }
    });
</script>





<script>
    function updateDateTime() {
        const now = new Date();

        // Format date and time
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
        };

        document.getElementById('live-datetime').textContent =
            now.toLocaleString('en-US', options);
    }

    // Update immediately
    updateDateTime();

    // Update every second
    setInterval(updateDateTime, 1000);
</script>