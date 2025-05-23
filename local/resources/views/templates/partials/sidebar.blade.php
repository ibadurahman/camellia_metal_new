

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">Camellia Metal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">USERS</li>
          @guest
            <li class="nav-item">
              <a href="{{route('login')}}" class="nav-link">
                <i class="nav-icon fas fa-ellipsis-h"></i>
                <p>Login</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('register')}}" class="nav-link">
                <i class="nav-icon fas fa-file"></i>
                <p>Register</p>
              </a>
            </li>
          @else
            <div class="card bg-transparent">
              <div class="card-body text-primary" style="padding:8px; padding-left:15px;">
                Name: {{Auth::user()->name}}
                <br>
                Id: {{Auth::user()->employeeId}}
                <br>
              </div>
            </div>
            <li class="nav-item">
              <a href="{{route('change.password.index')}}" class="nav-link">
                <i class="nav-icon fas fa-key"></i>
                <p>Change Password</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
              </a>
              <form action="{{route('logout')}}" method="POST" id="logout-form">
                @csrf
              </form>
            </li>
          @endguest
          @hasrole('owner')
            <li class="nav-header">Owner</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Owner
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{-- <li class="nav-item">
                  <a href="{{route('admin.user.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Users</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{route('admin.line.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-industry"></i>
                    <p>Lines</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.machine.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Machines</p>
                  </a>
                </li>
              </ul>
            </li>
          @endhasrole
          @hasrole('super-admin|owner')
            <li class="nav-header">SUPER-ADMIN</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Super Admin
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.user.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Users</p>
                  </a>
                </li>
              </ul>
            </li>
          @endhasrole
          @hasanyrole('office-admin|super-admin|owner')
            <li class="nav-header">ADMIN</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Admin
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{-- <li class="nav-item">
                  <a href="{{route('admin.holiday.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Holiday</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.breaktime.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>Break</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{route('admin.supplier.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Suppliers</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.customer.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-handshake"></i>
                    <p>Customer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.color.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-brush"></i>
                    <p>Color</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.workorder.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard"></i>
                    <p>Workorders</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.workorder.closed')}}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-check"></i>
                    <p>Closed Workorder</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('bypass.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Bypass Workorder</p>
                  </a>
                </li>
              </ul>
            </li>
          @endhasanyrole
          <li class="nav-header">MAIN MENU</li>
          @hasanyrole('operator|super-admin|office-admin|warehouse|supervisor|owner')
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Realtimes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('dailyReport.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Reports</p>
            </a>
          </li>
          @endhasanyrole
          <li class="nav-item">
            <a href="{{route('workorder.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file-word"></i>
              <p>Workorders</p>
            </a>
          </li>
          @hasanyrole('operator|super-admin|owner')
            <li class="nav-header">OPERATOR</li>
            <li class="nav-item">
              <a href="{{route('schedule.index')}}" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Schedules</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('production.index')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>On Process Reports</p>
              </a>
            </li>
          @endhasanyrole
          @hasanyrole('warehouse|super-admin|owner')
            <li class="nav-header">WAREHOUSE</li>
            <li class="nav-item">
              <a href="{{route('warehouse.index')}}" class="nav-link">
                <i class="nav-icon fas fa-calendar"></i>
                <p>Schedules</p>
              </a>
            </li>
          @endhasanyrole
		  @hasanyrole('supervisor|super-admin|owner')
            <li class="nav-header">SUPERVISOR</li>
            <li class="nav-item">
              <a href="{{route('production.index')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>On Process Reports</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('spvproduction.index')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Report Check</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('downtimeReason.index')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Downtimer Reason</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('bypass.index')}}" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Bypass Workorder</p>
              </a>
            </li>
          @endhasanyrole
          <li class="nav-header">DOCUMENTATION</li>
          <li class="nav-item">
            <a href="{{route('help.index')}}" class="nav-link">
              <i class="nav-icon fas fa-question"></i>
              <p>Help</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>