<?php
include_once 'connect.php';
$diagnose = mysqli_query($conn, "SELECT diagnose_name, slug FROM diagnose");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Disease Diet</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Roboto:100,300,400,500,700|Philosopher:400,400i,700,700i" rel="stylesheet">

  <!-- Bootstrap css -->
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.theme.default.min.css" rel="stylesheet">
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/modal-video/css/modal-video.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <header id="header" class="header header-hide">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="" class="scrollto"><span>D</span>iseaseDiet</a></h1>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="">Home</a></li>
          <li><a href="#analysis">Input</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <section id="hero" class="wow fadeIn">
    <div class="hero-container">
      <h1>Representasi Tekstual</h1>
      <h2>Diet Penyakit dan Kebutuhan Zat Gizi Pasien</h2>
      <img src="img/hero-img.png" alt="Hero Imgs" width="50%" height="60%">
      <a href="#analysis" class="btn-get-started scrollto">Mulai</a>
    </div>
  </section>

  <!--==========================
    Get Started Section
  ============================-->
  <section id="analysis" class="padd-section text-center wow fadeInUp">
    <form method="post" id="diagnose-form" action="diet_process.php" href="#analysis" enctype="multipart/form-data">
      <!-- <form id="diagnose-form" method="post" action="#summary" enctype="multipart/form-data"> -->

      <div class="container" style="margin-top:-4%">
        <div class="section-title" style="margin:0">
          <div class="form-group row feature-block rounded" style="padding:1% 0 0 0;background-color:#b8e994">
            <h4 class="col-sm-2 col-form-label-sm" style="margin-top:0.5%">Diagnosis</h4>
            <div class="col-sm-2" style="margin-top:0.5%">
              <select class="form-control form-control-sm" name="diagnose">
                <option value="0" selected>[Pilih salah satu]</option>
                <?php
                  while ($row = mysqli_fetch_assoc($diagnose)) {
                ?>
                <option value="<?php echo $row['slug'];?>"><?php echo $row['diagnose_name'];?></option>
                <?php } ?>
              </select>
            </div>
            <h6 class="col-sm-2 text-danger font-italic form-control-sm" id="error-log" style="font-family:Ubuntu;margin:0.5% 0 0 -4%"><!-- Pilih salah satu ! --></h6>
            <h4 class="col-sm-2 col-form-label-sm" style="margin-top:0.5%">Hasil Lab</h4>
            <div class="col-sm-3" style="font-family:Arial;font-size:14px;margin-top:0.5%">
              <input type="file" class="form-control-file border" name="docx" required></input>
            </div>
            <button type="submit" class="btn text-success" style="border:2px solid #47D45B;margin:0 1% 1% 2%;background-color:#ffffff;padding:1% 2% 1% 2%" name="upload"> Unggah </button>
          </div>
        </div>
      </div>

      <div class="container" style="padding:0">
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <div class="feature-block bg-light rounded" style="padding:5% 0 5% 5%">
              <img src="img/svg/application-form.svg" alt="img" class="img-fluid">
              <h4>Data Pasien</h4>
              <div class="form-group row" align="left">
                <label for="wg" class="col-sm-5 col-form-label-sm">Berat badan (kg)</label>:
                <div class="col-sm-6">
                  <input type="number" class="form-control form-control-sm" name="weight">
                  <span class="error-weight text-hide font-italic" style="font-family:Ubuntu;font-size:12px">Harap diisi!</span>
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="hg" class="col-sm-5 col-form-label-sm">Tinggi badan (cm)</label>:
                <div class="col-sm-6">
                  <input type="number" class="form-control form-control-sm" name="height">
                  <span class="error-height text-hide font-italic" style="font-family:Ubuntu;font-size:12px">Harap diisi!</span>
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="ag" class="col-sm-5 col-form-label-sm">Umur (tahun)</label>:
                <div class="col-sm-6">
                  <input type="number" class="form-control form-control-sm" name="age" >
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="gd" class="col-sm-5 col-form-label-sm">Jenis Kelamin</label>:
                <div class="col-sm-5 form-check form-check-inline" style="margin-top:-4%;margin-left:4%">
                 <input class="form-check-input" type="radio" name="gender" value="laki-laki">
                 <label class="form-check-label col-sm-4 col-form-label-sm"> L </label>
                 <input class="form-check-input" type="radio" name="gender" value="perempuan">
                 <label class="form-check-label col-sm-4 col-form-label-sm"> P </label>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4">
            <div class="feature-block bg-light rounded" style="padding:5% 0 5% 5%">
              <img src="img/svg/water-drop.svg" alt="img" class="img-fluid">
              <h4>Nilai Pemeriksaan Elektrolit</h4>
              <div class="form-group row" align="left">
                <label for="na" class="col-sm-5 col-form-label-sm">Natrium (mmol/L)</label>:
                <div class="col-sm-6">
                  <input type="number" step=".01" class="form-control form-control-sm" name="natrium">
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="ka" class="col-sm-5 col-form-label-sm">Kalium (mmol/L)</label>:
                <div class="col-sm-6">
                  <input type="number" step=".01" class="form-control form-control-sm" name="kalium">
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="kal" class="col-sm-5 col-form-label-sm">Kalsium (mmol/L)</label>:
                <div class="col-sm-6">
                  <input type="number" step=".01" class="form-control form-control-sm" name="kalsium">
                </div>
              </div>
              <div class="form-group row" align="left">
                <label for="klo" class="col-sm-5 col-form-label-sm">Klorida (mmol/L)</label>:
                <div class="col-sm-6">
                  <input type="number" step=".01" class="form-control form-control-sm" name="klorida">
                </div>
              </div>
            </div>
            <button type="button" class="btn text-success align-self-end submit" style="border:2px solid #47D45B;margin:0 1% 1% 0;background-color:#ffffff" name="submit"> Submit </button>
          </div>

          <div class="col-md-6 col-lg-4">
            <div id="formHolder"></div>
          </div>

        </div>
      </div>
    </form>
  </section>


  <!--==========================
    About Us Section
  ============================-->
  <section id="summary" class="about-us padd-section wow fadeInUp">
    <div class="container" id="summaryHolder"></div>
  </section>


    <!--==========================
    Footer
  ============================-->
  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-4">
          <div class="footer-logo">

            <a class="navbar-brand" href="">Disease Diet</a>
            <p>YUNDA ANDRIYANI x NIM.141402116 <br />
            University of Sumatera Utara<br />
            &copy; Copyrights 2018</p>

          </div>
        </div>
      </div>
    </div>
  </footer>


  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/modal-video/js/modal-video.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>



  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      formHolder = $('#formHolder')
      summaryHolder = $('#summaryHolder')
      diagnose = $('select[name=diagnose]')
      pasien = $('select[name=pasien]')
      errorLog = $('#error-log')
      form = $('#diagnose-form')
      submitBtn = $('.submit')
      weight = $('input[name=weight]')
      height = $('input[name=height]')
      dict = {
        "patient_weight": "weight",
        "patient_height": "height",
        "patient_gender": "gender",
        "patient_age": "age",
        "glukosa_darah_sewaktu": "glukosa_s",
        "glukosa_darah_puasa": "glukosa_p",
        "glukosa_darah_2_jam_pp": "glukosa_pp",
        "hba1c": "hba1c",
        "sgpt": "sgpt",
        "sgot": "sgot",
        "albumin": "albumin",
        "fosfatase alkali (alp)": "alp",
        "bilirubin direk": "bilirubin",
        "ggt": "ggt",
        "kreatinin": "kreatinin",
        "ureum": "ureum",
        "asam_urat": "asam_urat",
        "natrium": "natrium",
        "kalium": "kalium",
        "klorida": "klorida",
        "kalsium": "kalsium"
      }

      form.submit(function(e){
        if (diagnose.val() == 0) {
          errorLog.html("Pilih salah satu !")
          return false;
        }

        $.ajax({
          url: 'diet_process.php',
          type: 'POST',
          data: new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
          async:false,
        })
        .done(function(data) {
          data = JSON.parse(data)
          $('input:not([name=gender])').val("")
          $('input[name=gender]').attr('checked', false)
          jQuery.each(data, function(index, el) {
            if (el != null){
              if (index != 'patient_gender') {
                $('input[name='+dict[index.toLowerCase()]+']').val(el)
              }
              else {
                $('input[name="'+dict[index.toLowerCase()]+'"][value='+el.toLowerCase()+']').attr('checked', 'checked')
              }
            }
          });
          $('input').attr("readonly", true)
          $('input[name=weight]').attr("readonly", false)
          $('input[name=height]').attr("readonly", false)
        });


        return false;
      })

      submitBtn.click(function(e){
        if (diagnose.val() == 0) {
          errorLog.html("Pilih salah satu !")
          return false;
        }
        $('.error-weight').addClass('text-hide')
        $('.error-height').addClass('text-hide')

        if (weight.val() < 1) {
          $('.error-weight').removeClass('text-hide')
        }
        if (height.val() < 1) {
          $('.error-height').removeClass('text-hide')
        }

        if (weight.val() < 1 || height.val() < 1) {
          return false;
        }

        $.ajax({
          url: 'diet_process.php',
          type: 'POST',
          data: form.serialize()
        })
        .done(function(d) {
          summaryHolder.html(d)
          window.location.href = "#summary";
        });


        return false;
      })

      pasien.change(function(){
        if (this.value != 0) {
          errorLog.html('')
          $('input:not([name=gender])').val("")
          $('input[name=gender]').attr('checked', false)
          $.get( "form-parts/pasien/data.php", { id: this.value } )
            .done(function( data ) {
              data = JSON.parse(data)

              jQuery.each(data, function(index, el) {
                if (el != null){
                  if (index != 'patient_gender') {
                    $('input[name='+dict[index]+']').val(el)
                  }
                  else {
                    $('input[name="'+dict[index]+'"][value='+el+']').attr('checked', 'checked')
                  }
                }
              });
              $('input').attr("readonly", true)
            });
          return true;
        }
      })

      diagnose.change(function(){
        $('input').attr("readonly", false)
        $('input:not([name=gender])').val("")
        $('input[name=gender]').attr('checked', false)
        if (this.value != 0) {
          errorLog.html('')
          $.get('form-parts/diagnose/'+this.value+'.php', function(e){
            formHolder.html(e)
          })
          $.get( "form-parts/pasien/pasien.php", { diagnose: this.value } )
            .done(function( data ) {
              pasien.html("")
              pasien.html(data)
            });
          return true;
        }
      })

    })
  </script>

</body>
</html>
