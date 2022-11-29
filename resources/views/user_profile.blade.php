@include('layouts.partials.head')

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="btn btn-primary" href="logout" id="logout_btn" name="logout_btn">Log Out</a>
        </li>
      </ul>
    </nav>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            @if($load != 'dashboard')

            @foreach($select_profile as $profile_pic)
            <?php $img = 'storage/' . $profile_pic->img_path; ?>
            <img src="{{asset($img)}}" class="img-circle elevation-2">
            @endforeach
            @endif
          </div>
          <div class="info">
            <a href="#" class="d-block">Soumya</a>
          </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="dashboard_page" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            @if($user_type=="admin")
            <li class="nav-item">
              <a href="admin_page" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Manage User</p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="user_profile" class="nav-link">
                <i class="fas fa-user nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="upload_gallery" class="nav-link">
                <i class="nav-icon far fa-image"></i>
                <p>Gallery</p>
              </a>
            </li>

          </ul>
          </li>
          <!-- </ul>
            </li> -->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">

              @if($load!='gallery')

              <h1>Profile</h1>
              @endif
              @if($load=='gallery')

              <h1>Gallery</h1>
              @endif
            </div>

          </div>
        </div>
      </section>
      <!-- Main content -->

      <section class="content">
        <div class="container-fluid">
          @if($load == 'dashboard')

          <div class="row">
            <div class="col-lg-3 col-6">

              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{$galleries}}</h3>
                  <p>Number Of Galleries</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>

              </div>
            </div>
            <div class="col-lg-3 col-6">

              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{$images}}</h3>
                  <p>Total Images</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>

              </div>
            </div>
            <div class="col-lg-3 col-6">

              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>44</h3>
                  <p>Weekly Uploaded</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>

              </div>
            </div>
            <div class="col-lg-3 col-6">

              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>65</h3>
                  <p>Monthly Uploaded</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
          </div>
          @endif
          @if($load!='gallery' && $load!='dashboard')

          <div class="row">
            <div class="col-md-12">

              <div class="card card-widget widget-user">
                <form method="POST" enctype="multipart/form-data" id="crop-form">

                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                  <div class="widget-user-header text-white" style="background:url('assets/dist/img/photo1.png') center center;">

                    <input type="file" id="banner_imgupload" name="banner_imgupload" onchange="crop_class.loadbanner_img(this,2)" style="display:none" />
                    <h3 class="text-left text-white"> <i class="nav-icon far fa-image text" id="banner_btn"></i></h3>
                    @foreach($user_details as $user_data)
                    <h3 class="widget-user-username text-right">{{$user_data->username}}</h3>
                    @endforeach
                    <h5 class="widget-user-desc text-right">Web Designer</h5>
                  </div>
                  <div class="widget-user-image">
                    @foreach($select_profile as $profile_pic)
                    <?php $img = 'storage/' . $profile_pic->img_path; ?>
                    <img class="profile-user-img  img-circle" src="{{asset($img)}}" id="profile_image" name="profile_image">
                    @endforeach
                    <input type="file" id="profile_imgupload" name="profile_imgupload" onchange="crop_class.loadprofile_img(this,1)" style="display:none" />
                    <i class="fas fa-camera text-white upload-profile" id="profileupload"></i>

                  </div>
                  @include('layouts.partials.modal')
                </form>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-4 border-right">
                      <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4 ">
                          <div class="description-block">

                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="col-sm-4 border-right">
                      <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                      </div>

                    </div>

                    <div class="col-sm-4">
                      <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                      </div>

                    </div>

                  </div>

                </div>
              </div>

            </div>
          </div>
          @endif
          <div class="row">
            <div class="col-md-12">


              <!-- About Me Box -->
              @if($load=='user_details')

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">About Me</h3>
                  @foreach($user_details as $user_data)
                  <?php $user_id = $user_data->id ?>
                  <i class="far fa-edit float-right" id="edit_user" onclick="edit_user()"></i>
                </div>
                <div class="card-body">

                  <strong><i class="fas fa-user mr-1"></i> Name:</strong>
                  <span id="username1" name="username">{{$user_data->name}}</span>
                  <hr>
                  <strong><i class="fas fa-envelope mr-1"></i> Email:</strong>
                  <span id="email1" name="email">{{$user_data->email}}</span>
                  <hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Address:</strong>
                  <span id="address1" name="address">{{$user_data->address}}</span>
                  <hr>
                  <strong><i class="fas fa-phone mr-1"></i> Phone No:</strong>
                  <span id="phn_no1" name="phn_no">{{$user_data->phone_no}}</span>
                  @endforeach
                </div>
              </div>
              @endif
              <!-- /.card -->
              @if($load=='gallery')

              <div class="card-header d-flex p-0">

                <h3 class="card-title p-3"></h3>

                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Select Gallery <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      @foreach($gallery_type as $user_gallery)
                      <?php $gallery_id = $user_gallery->id; ?>
                      <a class="dropdown-item select_gallery" tabindex="-1" onclick="select_image(<?= $gallery_id ?>)" id="{{$user_gallery->id}}" value="{{$user_gallery->id}}">{{$user_gallery->gallery_name}}</a>
                      @endforeach
                    </div>
                  </li>
                  @if($user_type=="admin")
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Select User <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      @foreach($all_user_name as $user_data)
                      <?php $user_id = $user_data->id; ?>
                      <a class="dropdown-item select_gallery" tabindex="-1" onclick="select_user_profile(<?= $user_id ?>)" id="{{$user_data->id}}" value="{{$user_data->id;}}">{{$user_data->name}}</a>
                      @endforeach
                    </div>
                  </li>
                  @endif
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Action <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      
                      <a class="dropdown-item" tabindex="-1" id="add_gallery">Add Gallery</a>
                      <a class="dropdown-item" tabindex="-1" id="remove_pic">Remove Photos</a>

                  </li>
                </ul>
              </div>
              <div class="card-body" id="image_body">
                <p style="width:100%;height:100px;text-align:center;color:black;font-Size:50px">No Gallery Found</p>
              </div>
              @endif
            </div>
          </div>
          <!-- /.tab-content -->
          <!-- </div>
          
        /.card-body -->

        </div>
        <!-- /.card -->
        <!--</div> -->
        <!-- /.col -->
    </div>
    <!-- /.row -->


  </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <div class="modal fade" id="add_gallery_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <input type="hidden" id="new_galley_id">
        <div class="modal-body">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
          <label>gallery name</label>
          <input type="text" id="gallery_name" name="gallery_name" class="form-control sm">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="new_gallery" onclick="new_gallery()">Add Gallery</button>
        </div>

      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @if($load=='user_details')
        @foreach($user_details as $user_data)
        <?php $user_id = $user_data->id ?>
        <form action="edit_user" id="user_form" method="post">
          <div class="modal-body" id="user_details">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" id="user_id" name="user_id">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Full name" id="user_name" name="user_name" value="{{$user_data->name}}">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Email" id="mail_id" name="mail_id" value="{{$user_data->email}}">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input class="form-control" placeholder="address" id="addres" name="addres" style="text-align:center" value="{{$user_data->address}}">
            </div>
            <div class="input-group mb-3">
              <input type="tel" class="form-control" placeholder="Mobile no" id="mob" name="mob" value="{{$user_data->phone_no}}">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="edit_user_details" onclick="edit_user_details(<?= $user_id ?>)" value="Edit">
          </div>
        </form>
        @endforeach
        @endif

      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>

  <!-- ./wrapper -->

  @include('layouts.partials.footer')
  <script src="assets/cropper/cropper.min.js"></script>
  <script src="assets/js/profile_upload.js"></script>
</body>
</head>