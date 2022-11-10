@include('layouts.partials.head')

<body class="hold-transition sidebar-mini" style="height: auto;">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/image/default-avatar.png" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block">Soumya</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                User Details
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin_page" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage User</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="user_profile" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>User Details Table</h1> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Details</h3>
              </div>
              <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                  <div class="row">
                    <div class="col-sm-12">
                      <table id="dtblUser" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                        <thead>
                          <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Id</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Phone No</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Address</th>

                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="user_details">
            <form action="edit_user" id="user_form" method="post">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
              <input type="hidden" id="user_id" name="user_id">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Full name" id="user_name" name="user_name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" id="mail_id" name="mail_id">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <textarea class="form-control" placeholder="address" id="addres" name="addres" style="text-align:center"></textarea>
              </div>
              <div class="input-group mb-3">
                <input type="tel" class="form-control" placeholder="Mobile no" id="mob" name="mob">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="edit_user" onclick="edit()" value="Edit">
            </form>
            <button type="button" class="btn btn-secondary" id="inactive" onclick="status_inactive()">Inactive</button>
            <button type="button" class="btn btn-primary" id="active" onclick="status_active()">Active</button>
          </div>

        </div>
      </div>
    </div>


  </div>
</div>


@include('layouts.partials.footer');

<script src="assets/js/register.js"></script>
</body>
</head>