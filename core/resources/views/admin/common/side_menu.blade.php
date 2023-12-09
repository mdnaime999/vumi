@section('sidebar')
    <?php $access = config('global.access') ? config('global.access') : [];
    $checkAdmin = Auth::guard('web')->user()->type == 'admin' || Auth::guard('web')->user()->type == 'superadmin' ? true : false;
    ?>
    <style>
        [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
        [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus,
        [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
            background-color: rgb(12 41 102) !important;
            color: #f9f9f9 !important;
        }
    </style>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 sticky-top" id="page_sidebar">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link text-center" style="border-bottom:none">
            <span class=""></span>
            <span class="brand-text font-weight-light"
                style="font-size:16px;font-family: cursive; font-weight:bold; margin-left: 10px"><i
                    class="fas fa-cogs fa-sm fa-fw mr-2 rotate" style="font-size: 16px;"></i>বাংলাদেশ <i
                    class="fas fa-cogs fa-sm fa-fw mr-2 rotate" style="font-size: 16px;"></i></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border: none"></div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li
                        class="nav-item has-treeview
                    @if (array_search('user/view_users', $access) > -1 || $checkAdmin == true) @elseif (array_search('user/view_role_permissions', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/view_user_role_permission', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/manage/designation', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/manage/department', $access) > -1 || $checkAdmin == true)
                    @else d-none @endif

                   menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-area" aria-hidden="true"></i>
                            <p> স্টোর <i class="right fas fa-angle-left"></i></p>
                        </a>

                        {{-- </li> --}}
                        <ul class="nav nav-treeview" style="display: block;">
                            <li class="nav-item nav-item has-treeview" style="margin-left:8%;" style="display: block;">
                                <a href="{{ route('manage.port.list') }}"
                                    class="nav-link @if (Request::is('admin/manage/port/report')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>স্টোর রিপোর্ট</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview" style="display: block;">
                            <li class="nav-item nav-item has-treeview" style="margin-left:8%;" style="display: block;">
                                <a href="{{ route('manage.product.stock.info', ['id' => 1]) }}"
                                    class="nav-link @if (Request::is('admin/manage/product/stock/info')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>অফিস সরঞ্জাম </p>
                                </a>
                            </li>
                            <li class="nav-item nav-item has-treeview" style="margin-left:8%;" style="display: block;">
                                <a href="{{ route('manage.product.stock.info', ['id' => 2]) }}"
                                    class="nav-link @if (Request::is('user/manage/product/stock/info')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>স্টেশনারি </p>
                                </a>
                            </li>
                        </ul>
                        <hr>
                    </li>

                    <li
                        class="nav-item has-treeview
                        @if (array_search('admin/manage/product/stock', $access) > -1 || $checkAdmin == true) @elseif(array_search('admin/user/stock/info', $access) > -1 || $checkAdmin == true) @else d-none @endif
                        menu-open">
                        <a href="#" class="nav-link">
                            <i class="fas fa-store nav-icon"></i>
                            <p> ক্রয় পক্রিয়া <i class="right fas fa-angle-left"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('manage.product.stock') }}"
                                    class="nav-link @if (Request::is('admin/manage/product/stock') ||
                                            Request::is('admin/add/product/stock') ||
                                            Request::is('admin/edit/product/stock/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> পণ্য স্টক (মজুদ) </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item @if (array_search('admin/manage/product/stock/info', $access) > -1 || $checkAdmin == true) @else d-none @endif ">
                                <a href="{{ route('manage.product.stock.info') }}"
                                    class="nav-link @if (Request::is('admin/manage/product/stock/info')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> স্টক (মজুদ) তথ্য </p>
                                </a>
                            </li>
                        </ul> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.stock.info') }}"
                                    class="nav-link @if (Request::is('admin/user/stock/info')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> ব্যবহারকারীর স্টক (মজুদ) তথ্য </p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link @if (Request::is('admin/user/stock/info')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> মেরামত প্রক্রিয়া </p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>
                    <hr>
                    <li
                        class="nav-item has-treeview
                        @if (array_search('admin/manage/requisition', $access) > -1 || $checkAdmin == true) @else d-none @endif
                        menu-open">
                        <a href="#" class="nav-link">
                            <i class="fas fa-paper-plane nav-icon"></i>
                            <p> অনুমোদন পক্রিয়া <i class="right fas fa-angle-left"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('manage.requisition') }}"
                                    class="nav-link @if (Request::is('admin/manage/requisition') ||
                                            Request::is('admin/add/requisition') ||
                                            Request::is('admin/edit/requisition/*')) ) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> স্টেশনারী চাহিদা </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('requisition.request') }}"
                                    class="nav-link @if (Request::is('admin/requisition/request')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> স্টেশনারীর অনুরোধ </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('manage.role.transfer') }}"
                            class="nav-link @if (Request::is('admin/manage/role/transfer')) active @endif">
                            {{-- <i class="nav-icon fa fa-user"></i> --}}
                            <i class="fas fa-share nav-icon"></i>
                            <p>ছুটিকালিন সময় দায়িত্ব</p>
                        </a>
                    </li>
                    <hr>
                    <li
                        class="nav-item has-treeview menu-open
                    @if (array_search('user/view_users', $access) > -1 || $checkAdmin == true) @elseif (array_search('user/view_role_permissions', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/view_user_role_permission', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/manage/designation', $access) > -1 || $checkAdmin == true)
                    @elseif (array_search('user/manage/department', $access) > -1 || $checkAdmin == true)
                    @else d-none @endif
                    @if (Request::is('user/view_users') ||
                            Request::is('user/add_user') ||
                            Request::is('user/edit_user/*') ||
                            Request::is('user/view_role_permissions') ||
                            Request::is('user/add_role_permission') ||
                            Request::is('user/edit_role_permission/*') ||
                            Request::is('user/view_user_role_permission') ||
                            Request::is('admin/manage/designation') ||
                            Request::is('admin/add/designation') ||
                            Request::is('admin/edit/designation/*') ||
                            Request::is('admin/manage/department') ||
                            Request::is('admin/add/department') ||
                            Request::is('admin/edit/department/*')) menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-user"></i>

                            <p> চাহীদাকারী <i class="right fas fa-angle-left"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- <li class="nav-item">
                                <a href="{{ route('view_user_role_permission') }}"
                                    class="nav-link @if (Request::is('user/view_user_role_permission')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>সকল কর্মচারী</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('view_users') }}"
                                    class="nav-link @if (Request::is('user/view_users')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>চাহীদাকারী ম্যানেজ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_role_permissions') }}"
                                    class="nav-link @if (Request::is('user/view_role_permissions')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>অনুমতি ম্যানেজ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.designation') }}"
                                    class="nav-link @if (Request::is('admin/manage/designation')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>পদবী ম্যানেজ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.department') }}"
                                    class="nav-link @if (Request::is('admin/manage/department')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>বিভাগ ম্যানেজ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a href="{{ route('view_user_role_permission') }}"
                            class="nav-link @if (Request::is('user/view_user_role_permission')) active @endif">
                            <i class="fas fa-users nav-icon"></i>
                            <p>সকল কর্মচারী</p>
                        </a>
                    </li>
                    <hr>
                    {{-- <li
                        class="nav-item has-treeview
                        @if (array_search('admin/manage/land/classification', $access) > -1 || $checkAdmin == true) @elseif (array_search('admin/manage/land/type', $access) > -1 || $checkAdmin == true)
                        @elseif (array_search('admin/view_ports', $access) > -1 || $checkAdmin == true)
                        @elseif (array_search('admin/manage/ls/case', $access) > -1 || $checkAdmin == true)
                        @elseif (array_search('admin/manage/tofsil', $access) > -1 || $checkAdmin == true)
                        @elseif (array_search('admin/manage/establishment', $access) > -1 || $checkAdmin == true)
                        @elseif (array_search('admin/manage/land/type', $access) > -1 || $checkAdmin == true)
                        @else d-none @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p> বন্দর <i class="right fas fa-angle-left"></i> </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('manage.land.classification') }}"
                                    class="nav-link @if (Request::is('admin/land/classification') || Request::is('admin/add/land/classification') || Request::is('admin/edit/land/classification/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>জমির শ্রেণীবিভাগ ম্যানেজ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.land.type') }}"
                                    class="nav-link @if (Request::is('admin/land/type') || Request::is('admin/add/land/type') || Request::is('admin/edit/land/type/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>জমির ধরন</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('view_port') }}"
                                    class="nav-link @if (Request::is('admin/view_ports') || Request::is('admin/add_port') || Request::is('admin/edit_port/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>বন্দর ম্যানেজ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.ls.case') }}"
                                    class="nav-link @if (Request::is('admin/manage/ls/case') || Request::is('admin/add/ls/case') || Request::is('admin/edit/ls/case/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>এল এ কেস নং </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.tofsil') }}"
                                    class="nav-link @if (Request::is('admin/manage/tofsil') || Request::is('admin/add/tofsil') || Request::is('admin/edit/tofsil/*')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>তফসিল</p>
                                </a>
                            </li>

                        </ul>
                    </li> --}}
                    <hr>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection
