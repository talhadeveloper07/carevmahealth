@extends('admin.layouts.app')

@section('admin_content')
<style>
    .pulse-icon {
        position: relative;
        display: inline-block;
    }
    .pulse-icon::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        background: rgba(0, 200, 83, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulse 1.5s infinite;
    }
    .pulse-danger::after { background: rgba(220, 53, 69, 0.3); }
    .pulse-warning::after { background: rgba(255, 193, 7, 0.3); }
    .pulse-secondary::after { background: rgba(108, 117, 125, 0.3); }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.9); opacity: 0.7; }
        70% { transform: translate(-50%, -50%) scale(1.4); opacity: 0; }
        100% { opacity: 0; }
    }
</style>

<div class="container">
    <h3 class="mb-4 mt-5">Today’s Attendance Status</h3>

    <!-- Live Users -->
    <h5 class="mb-3 text-success">Live Users</h5>
    <div class="row" id="liveUsersRow"></div>

    <!-- Checked Out Users -->
    <h5 class="mb-3 text-danger">Checked Out Users</h5>
    <div class="row" id="checkedOutUsersRow"></div>

    <!-- Offline Users -->
    <h5 class="mb-3 text-secondary">Offline Users</h5>
    <div class="row" id="offlineUsersRow"></div>

    <!-- Late Users -->
    <h5 class="mb-3 text-warning">Late Users</h5>
    <div class="row" id="lateUsersRow"></div>
</div>

<!-- ✅ AJAX Script -->
<script>
    function buildCard(user, type) {
        let icon = 'ti ti-login text-success';
        let border = 'card-border-shadow-success';
        let label = 'Live';
        let pulseClass = 'pulse-icon';

        if (type === 'checkedOut') { 
            icon = 'ti ti-logout text-danger'; 
            border = 'card-border-shadow-danger'; 
            label = 'CheckOut'; 
            pulseClass = 'pulse-icon pulse-danger'; 
        }
        if (type === 'offline') { 
            icon = 'ti ti-user text-muted'; 
            border = 'card-border-shadow-mute'; 
            label = 'Offline'; 
            pulseClass = 'pulse-icon pulse-secondary'; 
        }
        if (type === 'late') { 
            icon = 'ti ti-clock text-warning'; 
            border = 'card-border-shadow-warning'; 
            label = 'Late'; 
            pulseClass = 'pulse-icon pulse-warning'; 
        }

        return `
            <div class="col-lg-3 col-sm-6 mb-4 user-card" data-type="${type}">
                <div class="card ${border} h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <div class="${pulseClass} mb-2">
                            <i class="${icon} rounded icon-12px"></i>
                        </div>
                        <h5 class="mb-1">${user.full_name}</h5>
                        <p class="${type === 'offline' ? 'text-muted' : (type === 'checkedOut' ? 'text-danger' : (type === 'late' ? 'text-warning' : 'text-success'))} small mb-0">${label}</p>
                    </div>
                </div>
            </div>
        `;
    }

    async function refreshAttendance() {
        try {
            const res = await fetch("{{ route('live.users.stats') }}");
            if (!res.ok) return;
            const data = await res.json();

            const render = (arr, rowId, type) => {
                const row = document.getElementById(rowId);
                if (!row) return;
                if (arr.length === 0) {
                    row.innerHTML = `<div class="col-12"><p class="text-muted">No Users</p></div>`;
                    return;
                }
                let html = '';
                arr.forEach(u => { html += buildCard(u, type); });
                row.innerHTML = html;
            };

            render(data.liveUsers, 'liveUsersRow', 'live');
            render(data.checkedOutUsers, 'checkedOutUsersRow', 'checkedOut');
            render(data.offlineUsers, 'offlineUsersRow', 'offline');
            render(data.lateUsers, 'lateUsersRow', 'late');
        } catch (err) {
            console.error('Error fetching attendance data', err);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        refreshAttendance();
        setInterval(refreshAttendance, 10000);
    });
</script>
@endsection