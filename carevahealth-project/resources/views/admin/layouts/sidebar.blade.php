<aside id="layout-menu" class="layout-menu menu-vertical menu">
          <div class="app-brand demo">
            <a href="/" class="app-brand-link">
              <span class="app-brand-logo demo">
                @if(!empty($global_setting->logo))
                <img src="" alt="Site Logo" style="height: 60px;">
              @else
                <img src="" alt="Default Logo" style="height: 60px;">
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

          
            <!-- e-commerce-app menu start -->
            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-shield-cog"></i>
                <div data-i18n="Services">Services</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-map"></i>
                <div data-i18n="Zipcodes">Zipcodes</div>
              </a>
            </li>
            
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shopping-cart"></i>
                <div data-i18n="Products">Products</div>
              </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="#" class="menu-link">
                        <div data-i18n="Product List">Product List</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="#" class="menu-link">
                        <div data-i18n="Add Product">Add Product</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-category-list.html" class="menu-link">
                        <div data-i18n="Category List">Category List</div>
                      </a>
                    </li>
                  </ul>
              
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Employees">Employees</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users-group"></i>
                <div data-i18n="Customers">Customers</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar-week"></i>
                <div data-i18n="Calendar">Calendar</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar"></i>
                <div data-i18n="Appointments">Appointments</div>
              </a>
            </li>

            <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-ticket"></i>
                <div data-i18n="Promotions">Promotions</div>
              </a>
            </li>

            <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>
                <div data-i18n="Setting">Setting</div>
              </a>
            </li>
            

            <!-- e-commerce-app menu end -->
          
          </ul>
        </aside>