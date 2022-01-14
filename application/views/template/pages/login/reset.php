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
  <link rel="stylesheet" href="<?= base_url() ?>asset/css/vertical-layout-light/toastr.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
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
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?= base_url() ?>asset/sunglade.png" alt="logo">
              </div>
              <h4>Opps! Reset your password</h4>
              <!-- <h6 class="font-weight-light">Sign in to continue.</h6> -->
              <form class="pt-3" id="reset">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="password" id="exampleInputEmail1" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="c_password" id="exampleInputPassword1" placeholder="Conform Password">
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" value="SIGN IN" >
                </div>
                
                <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="<?= base_url('welcome/forgot') ?>" class="auth-link text-black">Forgot password?</a>
                </div> -->
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Connect using facebook
                  </button>
                </div> -->
                <!-- <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="<?= base_url('welcome/register') ?>" class="text-primary">Create</a>
                </div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= base_url() ?>asset/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?= base_url() ?>asset/js/off-canvas.js"></script>
  <script src="<?= base_url() ?>asset/js/toastr.min.js"></script>
  <script src="<?= base_url() ?>asset/js/sweetalert.min.js"></script>
  <script src="<?= base_url() ?>asset/js/hoverable-collapse.js"></script>
  <script src="<?= base_url() ?>/asset/js/template.js"></script>
  <script src="<?= base_url() ?>/asset/js/settings.js"></script>
  <script src="<?= base_url() ?>/asset/js/todolist.js"></script>
  <script src="<?= base_url() ?>/asset/js/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>/asset/js/reset.js"></script>
  <!-- endinject -->
  <script>
    $(function(){
      <?php if($response['status']==0){ ?>
          swal({
            title: "Error!!!", 
            text: '<?= $response['msg'] ?>', 
            icon: "error",
        }).then((willDelete) => {
            if(willDelete){
                $('#reset').trigger("reset");
                window.location.replace('<?= $response['url'] ?>');
            }
        });
      <?php  } ?>
    })
  </script>
</body>

</html>
