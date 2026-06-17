<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@section('title') DSMNRU @show</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link href="{{asset('assets/admin/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-select.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
.eyebtn {
            cursor: pointer;
        }

        #loading-image {
            background: rgb(217 214 214 / 30%);
            position: fixed;
            z-index: 999999999999999999;
            height: 100%;
            width: 100%;
            top: 0px;
            text-align: center;
        }

        #loading-image img {
            width: 30%;
        }
        .sidebar-toggle-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            margin-right: 0.75rem;
            cursor: pointer;
        }
        .sidebar-toggle-btn img {
            width: 22px;
            height: auto;
        }
</style>
    @yield('styles')
</head>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        @auth
        <aside class="main-sidebar sidebar-dark-primary">
            <div class="navbg">
                <img src="/assets/admin/img/navtopbg.svg" />
            </div>

            <div class="sidebar">

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="mdi mdi-home-outline"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="mdi mdi-account-group"></i>
                                <p>Property Taax<i class="fa fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                
                                <li class="nav-item">
                                    <a href="{{ route('admin.property-tax.upload') }}" class="nav-link">
                                        <i class="mdi mdi-book-open-page-variant"></i>
                                        <p>Upload Property Tax Data</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                     <a href="{{ route('admin.property-tax.list') }}" class="nav-link">
                                        <i class="mdi mdi-shape-outline"></i>
                                        <p>Property Tax Bills</p>
                                    </a> 
                                </li> 
                            </ul>
                        </li>

                    </ul>
                </nav>

            </div>

        </aside>
        @endauth

        <div class="content-wrapper">
            <div class="content-header pb-0">
                <div class="container-fluid mt-3">

                    @auth
                    <div class="row mb-2">
                        <div class="col-md-4 col-1 d-flex align-items-center">
                            <a class="sidebar-toggle-btn d-none d-md-inline-flex" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar">
                                <img src="/assets/admin/img/menu-left-alt.svg" alt="Toggle sidebar" />
                            </a>
                            <a class="d-block d-md-none" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><img src="/assets/admin/img/menu-left-alt.svg" alt="Toggle sidebar" /></a>
                            <a class="d-block d-sm-none d-md-block" href="#" role="button">
                                <img style="max-height: 50px;" src="/assets/admin/img/logo.png" alt="Logo" />
                            </a>
                        </div>
                        <div class="col-md-7 col-11 user-profile offset-md-1">

                            <div class="float-right dropdown userData">
                                <a data-toggle="dropdown" href="#" aria-expanded="true">

                                   @php $user = auth()->user(); @endphp
                                   <p>User
                                    @if($user?->isDepartmentHead())
                                        <span>HOD</span>
                                    @elseif($user?->isAdmin())
                                        <span>Admin</span>
                                    @elseif($user?->isOperator())
                                        <span>Operator</span>
                                    @else
                                        <span>{{ ucfirst(str_replace('_', ' ', $user?->role?->name ?? 'User')) }}</span>
                                    @endif
                                   </p>

                                    <img src="/assets/admin/img/user.jpeg" class="img-circle mr-1" width="36" /> <img src="/assets/admin/img/dot.svg" class="float-none" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-md tableaction useraction-dropdown dropdown-menu-right" style="left: inherit; right: 0px;">
                                    <ul>
                                        <li>
                                            <form action="{{ route('logout') }}" method="post" class="m-0">
                                                @csrf
                                                <button class="dropdown-item" type="submit">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    @endauth


                   <div class="modal fade rightModal" id="forgetpassword" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-slideout" role="document">

                            <div class="modal-content bg-light">
							<form method="POST" class="needs-validation" action="{{ url('admin-password-change') }}" id="myform">
                                        @csrf

                                    <div class="modal-header pt-5 pl-5 pr-5 border-0">
                                        <div class="pt-3 col-md-12">
                                            <button type="button" class="close search-btn addaddressbtn" data-dismiss="modal" aria-label="Close">
                                                <img src="/assets/admin/img/close.svg"/>
                                            </button>
                                            <div class="">
                                                <h2>Password</h2>
                                                <h5>Update</h5>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-body pt-3 pr-5 pl-5">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-label-group">
												<label for="current_password">Current password</label>
												
                                                    <input type="password" id="current_password" name="current_password" class="form-control password" placeholder=" Enter Current Password" value="{{old('current_password')}}">
													<a style="bottom: 10px;" onclick="show_password($(this));" class="eyebtn"><img src="{{asset('assets/admin/img/eye-inactive.svg')}}" /></a>
													<div class="text-danger">{{$errors->first('current_password')}}</div>

                                                </div>
                                            </div>
											<div class="col-md-12">
                                                <div class="form-label-group">
												<label for="password">New password</label>
                                                    <input type="password" id="password" name="password" class="form-control password" placeholder="Enter New Password" value="{{old('password')}}"><a style="bottom: 10px;" onclick="show_password($(this));" class="eyebtn"><img src="{{asset('assets/admin/img/eye-inactive.svg')}}" /></a>
													<div class="text-danger">{{$errors->first('password')}}</div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-label-group">
												<label for="confirm_password">Re-type new password</label>
                                                    <input type="password" id="confirm_password"  name="confirm_password" class="form-control password" placeholder=" Confirm New Password" value=""><a onclick="show_password($(this));" class="eyebtn" style="bottom: 30px;"><img src="{{asset('assets/admin/img/eye-inactive.svg')}}" /></a>
													<div class="text-danger ">{{$errors->first('confirm_password')}}</div>
													<span class="text-danger">Enter Min 8 Characters for Password</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 text-center mt-4">
                                                <button type="submit" class="btn btn-secondary btn-radius">Update Password</button>
                                            </div>

                                        </div>

                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
            @yield('content')
            
        </div>

        @yield('form-model')

        <!-- </div> -->


<script src="/assets/admin/js/jquery.min.js"></script>
<script src="/assets/admin/js/jquery-ui.min.js"></script>
<script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
<script src="/assets/admin/css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/assets/admin/js/adminlte.js"></script>
<script src="/assets/admin/js/bootstrap-select.js"></script>
<script src="/assets/admin/js/custom-app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('scripts')
 
 
</script>

</body>

</html>
