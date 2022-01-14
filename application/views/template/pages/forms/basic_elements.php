<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url() ?>asset/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?= base_url() ?>asset/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>asset/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?= base_url() ?>asset/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>asset/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= base_url() ?>asset/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url() ?>asset/images/favicon.png" />
  <style>
    .error{
      font-size: .8rem;
      font-family: cursive;
      color: deeppink;
      font-style: italic;
    }
    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: none; }
    a:active { text-decoration: none; }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="<?= base_url() ?>asset/images/logo-2.jpeg" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?= base_url() ?>asset/images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="<?= base_url() ?>asset/images/faces/face28.jpg" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_settings-panel.html -->
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('welcome/dashboard') ?>">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('welcome/offer') ?>">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Generate Offer Letter</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.html">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Generate Payslips</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="icon-ban menu-icon"></i>
              <span class="menu-title">Error pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Application Form</h4>
                  <form class="form-sample" id="offer">
                    <p class="card-description">
                      Personal info
                    </p>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Title <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <select class="form-control title" name="title" size='1'>
                              <option value=''>--Select--</option>
                              <option value="Mr">Mr</option>
                              <option value="Mrs">Mrs</option>
                              <option value="Ms">Ms</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control name" name="name" placeholder="Full Name" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Job Location <span class="text-danger">*</span></label>
                          <div class="col-sm-7">
                            <select class="form-control location" name="location">
                              <option value="">--Select--</option>
                              <option value="Hyderabad">Hyderabad</option>
                              <option value="Mumbai">Mumbai</option>
                              <option value="Kolkata">Kolkata</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Cell No. <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control cell" name="cell" placeholder="Mobile Number" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Reference</label>
                          <div class="col-sm-9">
                            <input type="name" class="form-control ref" name="ref" placeholder="Reference Name / Code" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="card-description">
                      Address info
                    </p>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Line - 1 <span class="text-danger">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control add1" name="add1" placeholder="Address Line 1" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Line - 2 </label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control add2" name="add2" placeholder="Address Line 2" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control city" name="city" placeholder="Warangal" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control state" name="state" placeholder="Telangana" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Pincode <span class="text-danger">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control zipcode" name="zipcode" placeholder="560021" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select class="form-control country" name="country">
                              <!-- <option value="">--Select--</option> -->
                              <option value="India">India</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="card-description">
                      Employement Details
                    </p>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Position <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <select class="form-control position" name="position">
                              <option value="">--Select--</option>
                              <option value="Trainee Engineer">Trainee Engineer</option>
                              <option value="Software Developer">Software Developer</option>
                              <option value="Network Engineer">Network Engineer</option>
                              <option value="Database Engineer">Database Engineer</option>
                              <option value="Business Development Executive">Business Development Executive</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Salary <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control salary" name="salary" placeholder="per annum" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">From Date <span class="text-danger">*</span></label>
                          <div class="col-sm-8">
                            <input type="date" class="form-control from_date" name="from_date" placeholder="" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Branch <span class="text-danger">*</span></label>
                          <div class="col-sm-9">
                            <select class="form-control branch" name="branch">
                              <option value="">--Select--</option>
                              <option value="Trainee Engineer">Hyderabad</option>
                              <option value="Software Developer">Chennai</option>
                              <option value="Network Engineer">Kolkata</option>
                              <option value="Database Engineer">Database Engineer</option>
                              <option value="Business Development Executive">Business Development Executive</option>
                            </select>
                          </div>
                        </div>
                      </div> -->
                      <div class="col-md-5">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">To Date </label>
                          <div class="col-sm-8">
                            <input type="date" class="form-control to_date" name="to_date" placeholder="" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email id <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                              <input type="name" class="form-control email" name="email" placeholder="@gmail.com" />
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="mt-3 text-center">
                      <input class="btn btn-primary btn-md font-weight-medium auth-form-btn" type="submit" value="Generate Offer Letter" >
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Offer Letter Generated <?= date('Y-m-d h:i:s ') ?></h4>
                  <p class="card-description">
                    History of Offer letters
                  </p>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Full Name</th>
                          <th>City</th>
                          <th>From Date</th>
                          <th>To Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($user as $k=>$value){ ?>
                        <tr>
                          <td><?= $k+1 ?></td>
                          <td><?= $value['emp_name'] ?></td>
                          <td><?= $value['city'] ?></td>
                          <td><?= $value['from_date'] ?></td>
                          <td><?= $value['to_date'] ?></td>
                          <td>
                            <label class="badge badge-primary"><a href="<?= base_url('welcome/create_pdf/'.$this->CI->my_simple_crypt($value['offer_letter_id'], 'e')) ?>" target="_blank" rel="noopener noreferrer" class="text-white"><span class="ti-download"></span> Download</a></label>
                            <label class="badge badge-success edit" id="<?= $value['offer_letter_id'] ?>" data-toggle="modal" ><span class="ti-pencil"></span></label>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
        <!-- content-wrapper ends -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Your Address info</h5>
                
              </div> -->
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Update Your Address info</h5>
                
              <form id="edit">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Line - 1</label>
                      <input type="text" class="form-control add1_u" name="add1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Line - 2</label>
                      <input type="text" class="form-control add2_u" name="add2">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group m-0 p-0">
                      <label for="recipient-name" class="col-form-label">City</label>
                      <input type="text" class="form-control city_u" name="city">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group m-0 p-0">
                      <label for="recipient-name" class="col-form-label">State</label>
                      <input type="text" class="form-control state_u" name="state">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group m-0 p-0">
                      <label for="recipient-name" class="col-form-label">Pincode</label>
                      <input type="text" class="form-control zipcode_u" name="zipcode">
                    </div>
                  </div>
                </div>
                <div class="modal-footer mt-1">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  <a href="https://www.bootstrapdash.com/" target="_blank">AEES Global PVT. LTD </a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <a href="https://www.bootstrapdash.com/" target="_blank">Sunglade Digital Solutions</a><i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= base_url() ?>asset/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?= base_url() ?>asset/vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="<?= base_url() ?>asset/vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?= base_url() ?>asset/js/off-canvas.js"></script>
  <script src="<?= base_url() ?>asset/js/hoverable-collapse.js"></script>
  <script src="<?= base_url() ?>asset/js/template.js"></script>
  <script src="<?= base_url() ?>asset/js/settings.js"></script>
  <script src="<?= base_url() ?>asset/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?= base_url() ?>asset/js/file-upload.js"></script>
  <script src="<?= base_url() ?>asset/js/typeahead.js"></script>
  <script src="<?= base_url() ?>asset/js/select2.js"></script>
  <script src="<?= base_url() ?>asset/js/generate.js"></script>
  <script src="<?= base_url() ?>/asset/js/sweetalert.min.js"></script>
  <script src="<?= base_url() ?>/asset/js/jquery.validate.min.js"></script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
