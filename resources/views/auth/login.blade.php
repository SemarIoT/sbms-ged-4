
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign in - SBMS</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Choices.js-->
    <link rel="stylesheet" href="vendor/choices.js/public/assets/styles/choices.min.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.light.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/icon.jpg">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="login-page">
      <div class="container d-flex align-items-center position-relative py-5">
        <div class="card shadow-sm w-100 rounded overflow-hidden bg-none">
          <div class="card-body p-0">
            <div class="row gx-0 align-items-stretch">
              <!-- Logo & Information Panel-->
              <div class="col-lg-6">
                <div class="info d-flex justify-content-center flex-column p-4 h-100 bg-gradient">
                  <div class="py-5">
                    <h1 class="display-6 fw-bold">Sign In</h1>
                    <p class="fw-bold fs-4 mb-0">Smart Building Management System</p>
                  </div>
                  <div class="fs-6 my-0 py-0 text-gray-200">
                    <span>Need Free Access?</span> <br>
                    <span>username: guest</span><br>
                    <span>password: guestlabiot123</span>
                  </div>
                </div>
              </div>
              <!-- Form Panel    -->
              <div class="col-lg-6 bg-whitesmoke">
                <div class="d-flex align-items-center px-4 px-lg-5 h-100">
                  <form class="login-form py-5 w-100" action="{{url('proses_login')}}" method="POST">
                    @csrf
                    {{-- {{ csrf_field() }} --}}
                    @error('login_gagal')
                    <div class="form-control is-invalid bg-white mb-3" role="alert">
                        <span class="text-danger "><strong>Warning!</strong> {{ $message }}</span>
                    </div>
                    @enderror
                    <div class="input-material-group mb-3 text-gray-600">
                          <input class="input-material" 
                                id="inputEmailAddress"
                                name="username"
                                type="text"
                                >
                          <label class="label-material"for="inputEmailAddress">Username</label>
                    </div>
                    <div class="input-material-group mb-4 text-gray-600">
                      <input class="input-material" 
                              id="inputPassword"
                              type="password"
                              name="password">
                        <label class="label-material" for="inputPassword">Password</label></div>
                    <button class="btn btn-info mb-3" id="login" type="submit">Login</button>
                  </form>
                  
                  

                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <!-- JavaScript files-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/just-validate/js/just-validate.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
      // ------------------------------------------------------- //
      //   Inject SVG Sprite - 
      //   see more here 
      //   https://css-tricks.com/ajaxing-svg-sprite/
      // ------------------------------------------------------ //
      function injectSvgSprite(path) {
      
          var ajax = new XMLHttpRequest();
          ajax.open("GET", path, true);
          ajax.send();
          ajax.onload = function(e) {
          var div = document.createElement("div");
          div.className = 'd-none';
          div.innerHTML = ajax.responseText;
          document.body.insertBefore(div, document.body.childNodes[0]);
          }
      }
      // this is set to BootstrapTemple website as you cannot 
      // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
      // while using file:// protocol
      // pls don't forget to change to your domain :)
      injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
      
      
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  </body>
</html>