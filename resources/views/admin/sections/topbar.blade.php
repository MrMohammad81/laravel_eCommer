<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle">
        <i class="fa fa-bars" style="margin-top: 4px;"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small order-2" placeholder="جستجو ..."
                   aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav mr-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                 aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small order-2" placeholder="جستجو ..."
                               aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        @php
          $comments = \App\Models\Comment::all();
        @endphp
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ count($comments) }}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in text-right"
                 aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    کامنت ها
                </h6>
                @foreach($comments as $comment)
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('home.products.show' , $comment->product->slug) }}">

                    <div class="font-weight-bold">
                        <div class="text-truncate">
                            {{ $comment->text }}
                        </div>
                        <div class="small text-gray-500"> {{ $comment->product->name }} </div>
                    </div>

                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATCH') . $comment->product->primary_image) }}" alt="">
                        <div class="status-indicator bg-success"></div>
                    </div>

                </a>
                @endforeach
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('admin.comments.index') }}"> مشاهده تمام کامنت ها </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <span class="ml-2 d-none d-lg-inline text-gray-600 small">محمدحسین محیط</span>
                <img class="img-profile rounded-circle" src="{{ asset('admin/img/user.jpg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in text-right"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw ml-2 text-gray-400"></i>
                    پروفایل
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw ml-2 text-gray-400"></i>
                    تنظیمات
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw ml-2 text-gray-400"></i>
                    خروج
                </a>
            </div>
        </li>

    </ul>

</nav>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> لورم ایپسوم متن ساختگی </h5>
                <button class="close ml-0" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                است. </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="login.html"> خروج </a>
                <button class="btn btn-secondary" type="button" data-dismiss="modal"> لغو </button>
            </div>
        </div>
    </div>
</div>
