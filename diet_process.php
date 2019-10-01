<?php
include("connect.php");
include("process_method.php");
include("process_lab.php");

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

if (isset($_FILES['docx'])) {

  $diagnose = $_POST['diagnose'];

  $docx = $_FILES['docx'];
  $docxName = $_FILES['docx']['name'];
  $docxError = $_FILES['docx']['error'];
  $docxTemp = $_FILES['docx']['tmp_name'];
  $docxType = $_FILES['docx']['type'];

  $docxExt = explode('.', $docxName);
  $docxActualExt = strtolower(end($docxExt));
  $allowed = array('docx');

  if (in_array($docxActualExt, $allowed)) {

    if ($docxError == 0) {

      include("read-docx.php");
      $docxObj = new DocxConversion($docxTemp, $docxActualExt);
      $docxText = $docxObj->convertToText();
      $docxList = array_values(array_filter(explode("\n", $docxText)));
  
      // var_dump($docxList);
      $patientInfo = implode(array_slice($docxList,0,4));
      $patientInfo = explode(" : ", strtoupper($patientInfo));

      $registNo = substr(trim($patientInfo[1], "DOKTER"), 0, -1);
      $doctorName = substr(trim($patientInfo[2], "NAMA PASIEN"), 0, -1);
      $patientName = substr(trim($patientInfo[3], "RUANG"), 0, -1);
      $room = substr(trim($patientInfo[4], "JENIS KELAMIN"), 0, -1);
      $gender = substr($patientInfo[5], 0, 9);
      $date = date_create(substr(trim($patientInfo[6], "UMUR"), 0, -1));
      $dateFormat = date_format($date,"d/m/Y H:i:s");
      $age = trim($patientInfo[7], "TAHUN ALAMAT");
      $address = substr(trim($patientInfo[8], " "), 0, -1);
        // var_dump($gender)  ;die;
      $data = [];

      $group = [
          "KIMIA DARAH" => "KIMIA DARAH",
          "DIABETES" => "KIMIA DARAH",
          "FUNGSI HATI" => "KIMIA DARAH",
          "FUNGSI GINJAL" => "KIMIA DARAH",
          "FUNGSI JANTUNG" => "KIMIA DARAH",
          "ELEKTROLIT" => "KIMIA DARAH",
          "LEMAK DARAH" => "KIMIA DARAH",
          "URINALISA" => "URINALISA"
      ];

      $items = [
          "DIABETES" => [
              "GLUKOSA DARAH PUASA", "GLUKOSA DARAH 2 JAM PP",
              "GLUKOSA DARAH SEWAKTU", "HB-A1C"
          ],
          "FUNGSI HATI" => [
              "ALBUMIN", "SGPT", "SGOT", "BILIRUBIN DIREK",
              "FOSFATASE ALKALI (ALP)", "GGT"
          ],
          "FUNGSI GINJAL" => [
              "KREATININ", "UREUM", "ASAM URAT"
          ],
          "FUNGSI JANTUNG" => [
              "LDH"
          ],
          "LEMAK DARAH" => [
              "KOLESTEROL LDL", "TRIGELISERIDA", "KOLESTEROL TOTAL",
              "KOLESTEROL HDL"
          ],
          "ELEKTROLIT" => [
              "NATRIUM", "KALIUM", "KLORIDA", "KALSIUM"
          ],
          "URINALISA" => [
              "WARNA", "KEJERNIHAN", "NITRIT", "PH", "BERAT JENIS", "GLUKOSA", "PROTEIN",
              "BILIRUBIN", "BLOOD", "PROTEIN", "UROBILINOGEN", "KETON", "SILINDER",
              "GLUKOSA", "ERITROSIT", "EPITEL", "LEUKOSIT", "SILINDER", "BAKTERI"
          ],
      ];


      $lastKey = "";
      $dt = [];

      // mengambil data dari array ke 6 dari docx berisi data tabel komponen darah
      for ($i = 6; $i <= count($docxList); $i++) {

        $rowName = strtoupper(trim($docxList[$i])); // list komponen, cth Eritrosit 0 - 1 LPB &lt; 3 tiap i

        $nextRowName = strtoupper(trim($docxList[$i + 1]));
        $isGroup = isset($group[$rowName]); // list komponen yang termasuk grup, misalnya Fungsi ginjal, diabetes, dsb

        if ($isGroup) {

            $dt = &$data[$rowName];
            $lastKey = $rowName;

        }else {

          foreach ($items[$lastKey] as $item) {

            $itemLen = strlen($item);
            $isThere = substr($rowName, 0, $itemLen) == $item;

            if ($isThere) {

              $value = trim(substr($rowName, $itemLen));
              $value = str_replace(" - ", "", $value);
              $value = str_replace(" – ", "", $value);
              $values = explode(' ', $value);
              $dt[$item] = $values[0];

            }
          }
        }

      }

      $data = array_filter($data);
      // var_dump($data);die;

      foreach ($data as $keyData => $valueData) {

        if ($keyData == 'ELEKTROLIT') {
          $el = $valueData;
        }

        if ($diagnose == 'DM') {

          if ($keyData == 'DIABETES') {
            $v = $valueData;
          }

        }else if ($diagnose == 'HDKE') {

          if ($keyData == 'FUNGSI HATI') {
            $v = $valueData;
          }

        }else {

          if ($keyData == 'FUNGSI GINJAL') {

            if ($diagnose == 'G') {

              foreach ($valueData as $c => $e) {
                if ($c == 'ASAM URAT') {
                  $v[$c] = $e;
                }
              }

            }else {

              foreach ($valueData as $c => $e) {
                if ($c !== 'ASAM URAT') {
                  $v[$c] = $e;
                }
              }
            }
          }
        }
      }

      // var_dump($v);
      foreach ($v as $key_v => $value_v) {
        if ($key_v == 'ASAM URAT') {
          $w['ASAM_URAT'] = $value_v;
        }else if ($key_v == 'GLUKOSA DARAH SEWAKTU') {
          $w['GLUKOSA_DARAH_SEWAKTU'] = $value_v;
        }else if ($key_v == 'GLUKOSA DARAH 2 JAM PP') {
          $w['GLUKOSA_DARAH_2_JAM_PP'] = $value_v;
        }else if ($key_v == 'GLUKOSA DARAH PUASA') {
          $w['GLUKOSA_DARAH_PUASA'] = $value_v;
        }else if ($key_v == 'HB-A1C') {
          $w['HBA1C'] = $value_v;
        }
        else {
          $w[$key_v] = $value_v;
        }
      }
      // var_dump($w);
      echo json_encode(array_merge(['patient_gender'=>@$gender,'patient_age'=>@$age], isset($el) ? $el:[], $w));
      return;
      // var_dump($el, $w);die;
      // $listPatientInfo = array($registNo, $doctorName, $patientName, $room, $gender, $dateFormat, $age, $address, $data);

    }else {

      echo "Unggah error";

    }

  }else {

    echo "Format file tidak didukung";

  }

}
// var_dump($listPatientInfo);die;

if ($_POST) {
  $diagnose = $_POST['diagnose'];
  $weight = $_POST['weight'];
  $height = $_POST['height'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  // E L E K T RO L I T
  $natrium = $_POST['natrium'];
  $kalium = $_POST['kalium'];
  $kalsium = $_POST['kalsium'];
  $klorida = $_POST['klorida'];
  // D I A B E T E S  M
  $glukosa_s = $_POST['glukosa_s'];
  $glukosa_p = $_POST['glukosa_p'];
  $glukosa_pp = $_POST['glukosa_pp'];
  $hba1c = $_POST['hba1c'];
    // var_dump($glukosa_pp, $glukosa_s, $glukosa_p);die;

  // H A T I  D A N  K A N D U N G  E M P E D U
  $sgot = $_POST['sgot'];
  $sgpt = $_POST['sgpt'];
  $ggt = $_POST['ggt'];
  $albumin = $_POST['albumin'];
  $alp = $_POST['alp'];
  $bilirubin = $_POST['bilirubin'];
  // G I N J A L  K R O N I K
  $kreatinin = $_POST['kreatinin'];
  $ureum = $_POST['ureum'];
  // G O U T
  $asam_urat = $_POST['asam_urat'];

  $diagnoseID = getDiagnoseID($diagnose);
  $compLab = array(
    'glukosa_darah_sewaktu'=>$glukosa_s,
    'glukosa_darah_puasa'=>$glukosa_p,
    'glukosa_darah_2_jam_pp'=>$glukosa_pp,
    'hba1c'=>$hba1c,
    'sgot'=>$sgot,
    'sgpt'=>$sgpt,
    'ggt'=>$ggt,
    'albumin'=>$albumin,
    'alp'=>$alp,
    'bilirubin'=>$bilirubin,
    'ggt' => $ggt,
    'kreatinin'=>$kreatinin,
    'ureum'=>$ureum,
    'asam_urat'=>$asam_urat,
    'natrium'=>$natrium,
    'kalium'=>$kalium,
    'kalsium'=>$kalsium,
    'klorida'=>$klorida
  );

  $labResult = array_filter($compLab);

  $dietNameSql = mysqli_fetch_array(mysqli_query($conn, "SELECT diagnose_name FROM diagnose WHERE diagnose_id=$diagnoseID"));
  $dietName = $dietNameSql[0]; // Mendapatkan nama diet utama

  $glukosa_s = $glukosa_s==""? 'NULL' : $glukosa_s;
  $glukosa_p = $glukosa_p==""? 'NULL' : $glukosa_p;
  $glukosa_pp = $glukosa_pp==""? 'NULL' : $glukosa_pp;
  $hba1c = $hba1c==""? 'NULL' : $hba1c;
  $sgot = $sgot==""? 'NULL' : $sgot;
  $sgpt = $sgpt==""? 'NULL' : $sgpt;
  $ggt = $ggt==""? 'NULL' : $ggt;
  $albumin = $albumin==""? 'NULL' : $albumin;
  $alp = $alp==""? 'NULL' : $alp;
  $bilirubin = $bilirubin==""? 'NULL' : $bilirubin;
  $ggt = $ggt==""? 'NULL' : $ggt;
  $kreatinin = $kreatinin==""? 'NULL' : $kreatinin;
  $ureum = $ureum==""? 'NULL' : $ureum;
  $asam_urat = $asam_urat==""? 'NULL' : $asam_urat;
  $natrium = $natrium==""? 'NULL' : $natrium;
  $kalium = $kalium==""? 'NULL' : $kalium;
  $kalsium = $kalsium==""? 'NULL' : $kalsium;
  $klorida = $klorida==""? 'NULL' : $klorida;

  // if ($_POST['pasien'] == 0) {
  //   $insertData = "INSERT INTO `laboratory`(`patient_age`, `patient_gender`, `patient_weight`, `patient_height`, `glukosa_darah_sewaktu`, `glukosa_darah_puasa`, `glukosa_darah_2_jam_pp`, `hba1c`, `sgpt`, `sgot`, `albumin`, `alp`, `bilirubin`, `ggt`, `kreatinin`, `ureum`, `asam_urat`, `natrium`, `kalium`, `klorida`, `kalsium`, `diagnose_id`) VALUES ($age,'$gender',$weight,$height,$glukosa_s,$glukosa_p,$glukosa_pp,$hba1c,$sgpt,$sgot,$albumin,$alp,$bilirubin,$ggt,$kreatinin,$ureum,$asam_urat,$natrium,$kalium,$klorida,$kalsium,$diagnoseID)";
  //   $insertPatientDb = insertIntoDb($conn, $insertData);
  // }

  $corpusTala = "corpora/stopword_tala.txt";
  $stopWords = getCorpusContent($corpusTala);

  include("diet_lab.php");

  $diet = $diagnoseID;
  $stress_factor = 1.4;
  $activity_factor = 1.2; // istirahat di tempat tidur

  $imt = getImt($weight, $height);
  $imtType = checkImtNormal($imt)[0];

  if ($diet == 3) {
    $activity = 0.3;
    $amb = getAmb($gender, $weight, $height, $age, $diet);
    $ambPlus = $amb;
    if ($age >= 40 && $age <= 59) {
      $amb -= $ambPlus * 0.05;
    }else if ($age >= 60 && $age <= 69 ) {
      $amb -= $ambPlus * 0.1;
    }else if ($age >= 70) {
      $amb -= $ambPlus * 0.2;
    }
    $amb = round($amb);
    $amb += $ambPlus * $activity;
    $energyNeeds = getEnergyDiabet($amb, $ambPlus, $imtType);

  }else {
    $imtStatus = checkImtNormal($imt)[1];
    $weightBr = $weight;

    // Jika jenis IMT tidak sama dengan status normal
    if ($imtType != 0) {
      $weight = getBbi($gender, $height); // Alokasi berat badan ideal pada variabel weight
      $imtNormal = getImt($weight, $height); // Mendapatkan nilai IMT baru dari BBI
      $imtTypeNormal = checkImtNormal($imtNormal)[0]; // Cek IMT normal
    }

    $amb = getAmb($gender, $weight, $height, $age, $diet); // Mendapatkan nilai AMB
    $energyNeeds = round($amb * $activity_factor * $stress_factor); // Mendapatkan nilai kebutuhan energi total
  }

  $nutrition = getNutrition($weight, $energyNeeds, $diet); // Mendapatkan nilai kebutuhan zat gizi
  // var_dump($nutrition);
  include("diet_nutrition.php");

  $finalText = "
  <div class='border rounded bg-light' style='padding:2%;margin-bottom:1%;padding-bottom:0'>
    <h6 style='color:#47D45B'><b>Ringkasan Hasil Pemeriksaan Laboratorium</b></h6><br /><p style='color:black'>".
    $textLab."</p>
  </div>
  <div class='border rounded bg-light' style='padding:2%;margin-bottom:1%'>
    <h6 style='color:#47D45B'><b>Ringkasan Diet</b></h6><br />".
    $textNutri."
  </div>
  <div class='border rounded bg-light' style='padding:2%;margin-bottom:1%'>
    <div class='row'>
      <div class='col-sm-6'>
        <h6 style='color:#47D45B'><b>Rincian Kebutuhan Zat Gizi</b></h6><br />".
          $nutritionText."
      </div>
      <div class='col-sm-6'>
        <canvas id='pieChart' width='0' height='0'></canvas>
      </div>
    </div>
  </div>";
}
// $kkal = "kkal";
?>
<div class="container">
  <div align="justify"><?=$finalText?></div>
</div>


<script type="text/javascript">
  var kalori = "<?=$calory?>";
  var karbo = "<?=$carbohydrate*4?>";
  var protein = "<?=$protein*4?>";
  var fat = "<?=$fat*9?>";
  var ctx = document.getElementById("pieChart").getContext('2d');
  var pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Karbohidrat (kkal)", "Protein (kkal)", "Lemak (kkal)"],
      datasets: [{
        backgroundColor: ["#b8e994", "#E46B52","#538CC4"],
        data: [karbo, protein, fat]
      }]
    },
    options: {
      title: {
        display: true,
        text:   'Kebutuhan energi ' + kalori + ' kkal/hari'
      }
    }
  });
</script>
