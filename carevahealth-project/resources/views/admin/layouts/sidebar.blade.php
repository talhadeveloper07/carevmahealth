<aside id="layout-menu" class="layout-menu menu-vertical menu">
          <div class="app-brand demo">
            <a href="/" class="app-brand-link">
              <span class="app-brand-logo demo">
                @if(!empty($global_setting->logo))
                <img src="{{ asset('Care_VMA.webp') }}" alt="Site Logo" style="height:auto;width:170px;">
              @else
                <img src="{{ asset('Care_VMA.webp') }}" alt="Default Logo" style="height:auto;width:170px;">
              @endif

              </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
              <i class="icon-base ti tabler-x d-block d-xl-none"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">



            <li class="menu-item">
              <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Employees">Employees</div>
              </a>
              <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="{{ route('all.employees') }}" class="menu-link">
                        <div data-i18n="All Employees">All Employees</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="{{ route('add.employee') }}" class="menu-link">
                        <div data-i18n="Add New Employee">Add New Employee</div>
                      </a>
                    </li>
                  </ul>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-calendar-week"></i>
                <div data-i18n="Attendance">Attendance</div>
              </a>
                <ul class="menu-sub">

                  <li class="menu-item">
                    <a href="{{ route('admin.attendance') }}" class="menu-link">
                      <div data-i18n="Employee Attendance">Employee Attendance</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{ route('admin.attendance.requests') }}" class="menu-link">
                      <div data-i18n="Change Requests">Change Requests</div>
                    </a>
                  </li>

                </ul>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-user-square-rounded"></i>
                <div data-i18n="Clients">Clients</div>
              </a>
                <ul class="menu-sub">

                  <li class="menu-item">
                    <a href="{{ route('all.clients') }}" class="menu-link">
                      <div data-i18n="All Clients">All Clients</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{ route('add.client') }}" class="menu-link">
                      <div data-i18n="Add New Client">Add New Client</div>
                    </a>
                  </li>

                </ul>
            </li>
            
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon icon-base ti tabler-settings"></i>
    <div data-i18n="Employee Settings">Employee Settings</div>
  </a>
  <ul class="menu-sub">

    <li class="menu-item">
      <a href="{{ route('departments.index') }}" class="menu-link">
        <div data-i18n="Departments">Departments</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('roles.index') }}" class="menu-link">
        <div data-i18n="Roles">Roles</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('employment-types.index') }}" class="menu-link">
        <div data-i18n="Employment Types">Employment Types</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('shift-types.index') }}" class="menu-link">
        <div data-i18n="Shift Types">Shift Types</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('designations.index') }}" class="menu-link">
        <div data-i18n="Designations">Designations</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('employee-statuses.index') }}" class="menu-link">
        <div data-i18n="Employee Status">Employee Status</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('expertises.index') }}" class="menu-link">
        <div data-i18n="Current Expertise">Current Expertise</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('reporting-managers.index') }}" class="menu-link">
        <div data-i18n="Reporting Managers">Reporting Managers</div>
      </a>
    </li>

  </ul>
</li>

<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon icon-base ti tabler-settings"></i>
    <div data-i18n="Client Options">Client Options</div>
  </a>
  <ul class="menu-sub">

    <li class="menu-item">
      <a href="{{ route('services.index') }}" class="menu-link">
        <div data-i18n="Services">Services</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ route('contracts.index') }}" class="menu-link">
        <div data-i18n="Contract Types">Contract Types</div>
      </a>
    </li>


  </ul>
</li>

            <!-- e-commerce-app menu end -->
          
          </ul>
        </aside>