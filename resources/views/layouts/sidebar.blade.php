<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN WORKS</li>
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('assets*') ? 'active' : '' }}">
                <a href="{{ route('assets.index') }}">
                    <i class="fa fa-list-alt"></i> <span>Asset Manager</span>
                </a>
            </li>
            <li class="{{ Request::is('computers*') ? 'active' : '' }}">
                <a href="{{ route('computers.index') }}">
                    <i class="fa fa-laptop"></i> <span> Manager Computer</span>
                </a>
            </li>
            <li class="header">REPORTS MANAGERS</li>
            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-user-circle"></i> <span> Manager Report</span>
                </a>
            </li>
            <li class="{{ Request::is('report/assets/active*') ? 'active' : '' }}">
                <a href="{{ route('assets.report.active') }}">
                    <i class="fa fa-list"></i> <span> Active Asset Report</span>
                </a>
            </li>
            <li class="{{ Request::is('asset-pending*') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-list"></i> <span> Pending Asset Report</span>
                </a>
            </li>
            <li class="{{ Request::is('asset-archived*') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-list"></i> <span> Archived Asset Report</span>
                </a>
            </li>
            <li class="{{ Request::is('asset-unavailable*') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-list"></i> <span> Unavailable Asset Report</span>
                </a>
            </li>
            <li class="{{ Request::is('asset-lost*') ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-list"></i> <span> Lost Asset Report</span>
                </a>
            </li>
            <li class="treeview" style="height: auto;">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <li><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>
            <li class="header">SETTINGS</li>
            @can('category.view')
                <li class="{{ Request::is('categories*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}">
                        <i class="fa fa-tags"></i> <span> Manager Category</span>
                    </a>
                </li>
            @endcan
            <li class="{{ Request::is('costcenters*') ? 'active' : '' }}">
                <a href="{{ route('costcenters.index') }}">
                    <i class="fa fa-location-arrow"></i> <span> Manager Cost Center</span>
                </a>
            </li>
            <li class="{{ Request::is('models*') ? 'active' : '' }}">
                <a href="{{ route('models.index') }}">
                    <i class="fa fa-modx"></i> <span> Manager Model</span>
                </a>
            </li>
            <li class="{{ Request::is('brands*') ? 'active' : '' }}">
                <a href="{{ route('brands.index') }}">
                    <i class="fa fa-product-hunt"></i> <span> Manager Brand</span>
                </a>
            </li>
            <li class="{{ Request::is('locations*') ? 'active' : '' }}">
                <a href="{{ route('locations.index') }}">
                    <i class="fa fa-product-hunt"></i> <span> Manager Location</span>
                </a>
            </li>
            <li class="{{ Request::is('statuses*') ? 'active' : '' }}">
                <a href="{{ route('statuses.index') }}">
                    <i class="fa fa-scissors"></i> <span> Manager Status</span>
                </a>
            </li>
            @can('user.view')
            <li class="{{ Request::is('user*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-user-circle"></i> <span> Manager User</span>
                </a>
            </li>
            @endcan
            @can('role.view')
            <li class="{{ Request::is('role*') ? 'active' : '' }}">
                <a href="{{ url('/role') }}">
                    <i class="fa fa-user-circle"></i> <span> Role & Permission</span>
                </a>
            </li>
            @endcan
            <li class="header">LABELS</li>
            <li>
                <a onclick="logout()"><i class="fa fa-power-off text-red"></i> <span>Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
