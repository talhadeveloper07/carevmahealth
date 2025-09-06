<div class="nav-align-top">
    <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
        <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}" href="{{ route('client.profile', $client->id) }}"            
        ><i class="icon-base ti tabler-user me-1_5"></i> Profile</a
        >
        <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.assigned.va') ? 'active' : '' }}" href="{{ route('client.assigned.va', $client->id) }}"            
        ><i class="icon-base ti tabler-calendar-week me-1_5"></i> Schedule</a
        >
        </li>
        <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.schedule') ? 'active' : '' }}" href="{{ route('client.schedule', $client->id) }}"
            ><i class="icon-base ti tabler-user me-1_5"></i> Assign VA</a
        >
        </li>
        <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('daily.report') ? 'active' : '' }}" href="{{ route('daily.report', $client->id) }}"
            ><i class="icon-base ti tabler-clock icon-sm me-1_5"></i>Daily Work Report</a
        >
        </li>
        <li class="nav-item">
        <a class="nav-link" href="app-user-view-billing.html"
            ><i class="icon-base ti tabler-bookmark icon-sm me-1_5"></i>Billing & Plans</a
        >
        </li>
        <li class="nav-item">
        <a class="nav-link" href="app-user-view-notifications.html"
            ><i class="icon-base ti tabler-bell icon-sm me-1_5"></i>Notifications</a
        >
        </li>
    </ul>
</div>