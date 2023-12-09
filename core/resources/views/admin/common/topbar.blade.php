@section('topbar')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top" id="page_topbar">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <button type="button" class="navbar-toggle collapsed"
                    style="border:none; margin-top: 7px; background-color:transparent">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </a>
                </button>
            </li>
            <li class="nav-item">
                <div class="headerLogo">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img width="100" src="{{ asset('assets/admin/images/logo.png') }}" alt="our logo" width="5">

                    </a>
                    <div style="font-size: 23px;
                    color: green;
                    margin-left: -59px;">
                        ভূমি রেকর্ড ও জরিপ অধিদপ্তর</div>
                </div>

            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php
                    $role = App\Modules\User\Models\RolePermission::where('id', Auth::guard('web')->user()->role_id)->first();
                    ?>
                    @if (Auth::guard('web')->user()->type == 'superadmin')
                        <span class="ml-2 d-none d-lg-inline text-50 small"
                            style="font-size: 18px">{{ Auth::user()->name }}</span>
                    @else
                        <span class="ml-2 d-none d-lg-inline text-50 small" style="font-size: 18px">{{ Auth::user()->name }}
                            <span style="font-size: 14px">{{ $role->designations->name }}</span></span>
                    @endif
                    @if (Auth::user()->image)
                        <img class="img-profile rounded-circle" width="30" height="30"
                            src="{{ asset(Auth::user()->image) }}" />
                    @else
                        <img class="img-profile rounded-circle" width="30" height="30"
                            src="{{ asset('assets/admin/images/usersavator.png') }}" />
                    @endif
                    <b class="fa fa-angle-down"></b>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Logout Modal!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}" class="btn btn-primary"
                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }} </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
