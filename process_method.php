<?php

function getDiagnoseID ($diagnose) {
  if ($diagnose === 'HDKE') {
    $diagnoseID = 1;
  }else if ($diagnose === 'GK') {
    $diagnoseID = 2;
  }else if ($diagnose === 'DM') {
    $diagnoseID = 3;
  }else {
    $diagnoseID = 4;
  }
  return $diagnoseID;
}

function insertIntoDb($conn, $sql) {
  if (!mysqli_query($conn, $sql)) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  mysqli_close($conn);
}

// Mencari nilai IMT
function getImt ($bb, $tb) {
  return $imt = round($bb/pow(($tb/100),2));
}

// Mencari jenis dan status IMT
function checkImtNormal($imt) {
  $imt_normal = 0;
  if ($imt > 18.5 && $imt <= 24.9) {
    $imt_normal = 0;
    $status = "normal";
  }else if ($imt < 18.5) {
    $imt_normal = -1;
    $status = "kurang";
  }else if ($imt >= 25.0 && $imt <= 29.9) {
    $imt_normal = 1;
    $status = "pra-obesitas";
  }else if ($imt >= 30.0 && $imt <= 34.9) {
    $imt_normal = 2;
    $status = "obesitas tingkat 1";
  }else if ($imt >= 35.0 && $imt <= 39.0) {
    $imt_normal = 3;
    $status = "obesitas tingkat 2";
  }else if ($imt >=40) {
    $imt_normal = 4;
    $status = "obesitas tingkat 3";
  }
  return array($imt_normal, $status);
}

function getEnergyDiabet($amb, $amb_add, $imt_type) {
  // $amb += $amb * $activity;
  // var_dump($amb, $amb_add, $imt_type);
  if ($imt_type < 0) {
    $amb += $amb_add * 0.25;
  }else if ($imt_type == 1) {
    $amb -= $amb_add * 0.25;
  }else if ($imt_type == 2) {
    $amb -= $amb_add * 0.25;
  }else if ($imt_type > 2) {
    $amb -= $amb_add * 0.3;
  }else {
    $amb += 0;
  }
  // var_dump($amb);die;
  return round($amb);
}


// Mencari berat badan ideal pasien
function getBbi($g, $tb) {
  if ($g == 1) {
    if ($tb >= 160) {
      $bbi = ($tb-100)-0.1*($tb-100);
    }else {
      $bbi = $tb-100;
    }
  }else {
    if ($tb >= 150) {
      $bbi = ($tb-100)-0.1*($tb-100);
    }else {
      $bbi = $tb-100;
    }
  }
  return $bbi;
}

// Mencari nilai AMB
function getAmb($g, $bb, $tb, $u, $diet) {
  if ($diet == 3) {
    if ($g === 'Laki-Laki') {
      $amb = 30 * $bb;
    }else {
      $amb = 25 * $bb;
    }

  }else {
    if ($g === 'Laki-Laki') {
      // $amb = 66+(13.7*$bb)+(5*$tb)-(6.8*$u);
      $amb = (10*$bb) + (6.25*$tb) - (5*$u) + 5;
    }else {
      // $amb = 655+(9.6*$bb)+(1.8*$tb)-(4.7*$u);
      $amb = (10*$bb) + (6.25*$tb) - (5*$u) - 161;
    }
  }
  return round($amb);
}

// Mencari nilai kebutuhan zat gizi
function getNutrition($bb, $et, $diet) {
  if ($diet == 1) {
    $energy = 42.5 * $bb;
    $protein = 1.25 * $bb * 4;
    $fat = 0.225 * $energy;
    $carbo = $energy - $protein - $fat;
    $result = array(round($energy), round($carbo/4), round($protein/4), round($fat/9));
  }else if ($diet == 2) {
    $energy = 32.5 * $bb;
    $protein = 1.0 * $bb * 4;
    $fat = 0.25 * $energy;
    $carbo = $energy - $protein - $fat;
    $result = array(round($energy), round($carbo/4), round($protein/4), round($fat/9));
  }else if ($diet == 3) {
    $energy = $et;
    $protein = 0.15 * $energy;
    $fat = 0.25 * $energy;
    $carbo = 0.6 * $energy;
    $result = array(round($energy), round($carbo/4), round($protein/4), round($fat/9));
  }else if ($diet == 4) {
    $energy = $et;
    $protein = 1.1 * $bb * 4;
    $fat = 0.2 * $energy;
    $carbo = 0.7 * $energy;
    $result = array(round($energy), round($carbo/4), round($protein/4), round($fat/9));
  }

  return $result;
}

// Menentukan tipe Diet Garam Rendah
function checkLowSalt($value) {
  $condition = NULL;
  if ($value == 1) {
    $condition = 'Garam Rendah 200-400 mg Na';
  }else if ($value == 2) {
    $condition = 'Garam Rendah 600-800 mg Na';
  }else if ($value == 3) {
    $condition = 'Garam Rendah 1000-1200 mg Na';
  }
  return $condition;
}

// Mencari kalimat-kalimat yg mengandung semua kata pada arraynya
function containsArray($string, array $array) {
  $count = 0;
  foreach($array as $value) {
    if (false !== stripos($string,$value)) {
      $count++;
    }
  }
  return $count == count($array);
}

// Mengumpulkan kalimat yang mengandung kata pada array
function getSentences($corpus, $array_word) {
  foreach ($corpus as $value) {
    if (containsArray($value, $array_word)) {
      $text[] = $value;
    }
  }
  return $text;
}

// Mendapatkan isi korpus yang telah terpisahkan oleh newline
function getCorpusContent($corpus) {
  $handle = fopen($corpus, 'r'); // read file stopword by tala
  $data = fread($handle, filesize($corpus)); // alokasi all string sw di variabel data
  $content = array_filter(explode("\n", $data)); // isi korpus yang terpisah antarnewline
  return $content;
}


function getSubjectClause($sentence, $stop_words) {
  $clause = str_replace(".", "", strtolower(implode(" ", $sentence))); // menjadikan semua kalimat2 yang didapat ke dalam satu string dan huruf kecil
  $wordsFromClause = explode(" ", $clause); // daftar kata2 yang menyusun kalimat2
  $wordsResult = array_unique($wordsFromClause); // daftar kata2 unik/tdk duplikat
  $words = array_filter(preg_replace('/\b('.implode('|',$stop_words).')\b/','',$wordsFromClause)); // daftar kata yang telah dipotong oleh stopwords
  $countWords = array_count_values($words); // menghitung jumlah masing2 kata yang terpilih

  $i = 0;
  foreach ($countWords as $keyCountWords => $valueCountWords) {
    $countWordsValue = $valueCountWords;

    $listWords[$keyCountWords] = $countWordsValue; // menyimpan kata2 pertama yang terpilih, mendapatkan nilai kata dan fitness masing2
    $listSortWords[$i] = $keyCountWords; // menyimpan kata2 yang terpilih dengan key berupa nomor berurut
    $i++;
  }

  ksort($listSortWords); // mengurutkan nilai key
  $listSortWords = array_values(array_unique($listSortWords)); // list kata2 yang terpilih dengan urutannya tanpa nilai frekuensi
  $totalFitness = array_sum($listWords); // total fitness dari keseluruhan kata

  foreach ($listWords as $keyListWords => $valueListWords) {
    $probability[] = number_format((float)($valueListWords/$totalFitness), 3, '.', ''); // probabilitas dari masing2 kata dengan desimal 3 angka di blkg koma
  }

  // mendapatkan subjek yang cocok dengan kata pertama pada kalimat pada korpus
  foreach ($listSortWords as $valueListSortWords) {
    foreach ($sentence as $keySentence => $valueSentence) {
      $valueSentence = explode(" ", str_replace(".", "", strtolower($valueSentence)));
      if ($valueSentence[0] === $valueListSortWords) {
        $subjectSentence[] = $valueListSortWords;
      }
    }
  }

  $subject = $listSortWords;
  // tournamen selection
  if (count($subject == 2)) {
    $k = 2;
    while ($k > 0) { // proses mengacak kata2 mengambil kata2 sebanyak k
      $randomWords[] = $subject[array_rand($subject)];
      $randomUnique = array_unique($randomWords); // menghapus kata yg dabel
      if ($k == 0 && count($randomUnique) <= 2) { // pengecekan apakah jumlah kata sudah sesuai k
        $k+=1;
      }
      $k--;
    }
  }else if (count($subject) > 2) {
    $k = 3;
    while ($k > 0) { // proses mengacak kata2 mengambil kata2 sebanyak k
      $randomWords[] = $subject[array_rand($subject)];

      $randomUnique = array_unique($randomWords); // menghapus kata yg dabel

      if ($k == 1 && count($randomUnique) <= 3) { // pengecekan apakah jumlah kata sudah sesuai k
        $k+=1;
      }

      $k--;
    }
  }


  $i = 0;
  foreach ($randomUnique as $valueRandomUnique) {
    foreach ($listWords as $keyListWords => $valueListWords) {
      if ($valueRandomUnique === $keyListWords) {
        $reSelection[$i][$keyListWords] = $valueListWords; // kromosom terpilih beserta kata dan jumlahnya
        $i++;
      }
    }
  }

  // var_dump($reSelection);

  // $randomFirstWord = $reSelection[array_rand($reSelection)]; // mendapatkan subjek pertama secara random
  //
  // foreach ($randomFirstWord as $keyRandomFirstWord => $valueRandomFirstWord) {
  //   $key = $keyRandomFirstWord;
  // }


  // mendapatkan kata pertama
  $value = 0;
  foreach ($reSelection as $keyReSelection => $valueReSelection) {
    foreach ($valueReSelection as $keyWordSelection => $valueWordSelection) {
      if ($valueWordSelection > $value) {
        $value = $valueWordSelection; // mendapatkan nilai paling tinggi
        $key = $keyWordSelection; // mendapatkan kata dengan nilai paling tinggi- kata pertama
      }
    }
  }

  // var_dump($key);die;
  return $key;
}

// ngram method
function get3Grams($sentence, $clause, $count, $total_words) {

  $arClause = explode(" ", $clause);
  if (count($arClause) > 2) {
    $arWords = array_slice($arClause, -2, 2, true);
    $subject = implode(" ", $arWords);
  }else {
    $arWords = $arClause;
    $subject = $clause;
  }

  foreach ($arWords as $valArWords) {
    $arWordsSort[] = $valArWords;
  }
  foreach ($sentence as $keySentence => $valueSentence) {
    $valueSentence = str_replace(".", "", strtolower($valueSentence));
    if (strpos($valueSentence, $subject) !== false) {
      $valueArSentence = explode(" ", $valueSentence);
      foreach ($valueArSentence as $keyArSentence => $valArSentence) {
        if ($arWordsSort[count($arWordsSort)-1] === $valArSentence) {
          $key[$valueSentence][$valArSentence] = $keyArSentence;
          $next[] = $valueArSentence[$keyArSentence+1];
        }
      }
    }
  }

  $i = 1;
  $inNext = array();
  foreach ($next as $keyNext => $valueNext) {
    if (array_key_exists($valueNext, $inNext)) {
      $inNext[$valueNext] = $inNext[$valueNext]+1;
    }else {
      $inNext[$valueNext] = 1;
    }

  }
  $maxNext = array_search(max($inNext), $inNext);
  // keputusan deteksi akhir kalimat tanda titik
  if ($maxNext === "") {
    if (max($total_words) > 8 && $count <= max($total_words)/3 || max($total_words) < 9 && $count < 4) {
      unset($inNext[$maxNext]);
      $maxNext = array_search(max($inNext), $inNext);
      $clause = $clause." ".$maxNext;
    }else {
      $count = max($total_words);
    }
  }
  else if (max($total_words) >= 8 && $count >= 6 && $maxNext === 'tidak_dianjurkan') {
    $count = max($total_words);
  }
  else {
    $clause = $clause." ".$maxNext;
  }
  // var_dump($clause);
  return array($clause, $count);

}

function randomNutrition($spec_nutrition, $code, $k) {
  $j = $k;
  while ($k > 0) {
    $random_nutrition[] = $spec_nutrition[array_rand($spec_nutrition)];
    $random_unique = array_unique($random_nutrition);
    if ($k == 1 && count($random_unique) < $j) {
      $k+=1;
    }
    $k--;
  }

  foreach ($random_unique as $value_random) {
    $sort_random[] = $value_random;
  }

  if ($code == 1) {
    $sort_random[1] = "atau ".$sort_random[1];
    $random_value = implode(" ", $sort_random);

  }else {
    $sort_random[2] = "dan ".$sort_random[2];
    $random_value = implode(", ", $sort_random);
  }


  return $random_value;
}

function getProVegetableValue($calory, $pro_vgt){
  if ($calory >= 1100 && $calory <= 1400) {
    $pro_vgt = "2 ptg sdg tempe dan 1 bj bsr tahu";
  }else if ($calory >= 1500 && $calory <= 1800) {
    $pro_vgt = "3 ptg sdg tempe dan 1 bj bsr tahu";
  }else if ($calory >= 1900 && $calory <= 2400) {
    $pro_vgt = "4 ptg sdg tempe dan 1 bj bsr tahu";
  }else if ($calory >= 2500) {
    $pro_vgt = "4 ptg sdg tempe dan 2 bj bsr tahu";
  }
  return $pro_vgt;
}

function getRiceValue($calory){
  if ($calory >= 1100 && $calory <= 1200) {
    $nasi = round(2.5 * 3/4);
    $kentang = 2.5 * 2;
    $jagung = 2.5 * 3;
    $roti = 2.5 * 3;
  }else if ($calory >= 1300 && $calory <= 1400) {
    $nasi = round(3 * 3/4);
    $kentang = 3 * 2;
    $jagung = 3 * 3;
    $roti = 3 * 3;
  }else if ($calory >= 1500 && $calory <= 1600) {
    $nasi = round(4 * 3/4);
    $kentang = 4 * 2;
    $jagung = 4 * 3;
    $roti = 4 * 3;
  }else if ($calory >= 1700 && $calory <= 1800) {
    $nasi = round(5 * 3/4);
    $kentang = 5 * 2;
    $jagung = 5 * 3;
    $roti = 5 * 3;
  }else if ($calory >= 1900 && $calory <= 2000) {
    $nasi = round(5.5 * 3/4);
    $kentang = 5.5 * 2;
    $jagung = 5.5 * 3;
    $roti = 5.5 * 3;
  }else if ($calory >= 2100 && $calory <= 2200) {
    $nasi = round(6 * 3/4);
    $kentang = 6 * 2;
    $jagung = 6 * 3;
    $roti = 6 * 3;
  }else if ($calory >= 2300 && $calory <= 2400) {
    $nasi = round(7 * 3/4);
    $kentang = 7 * 2;
    $jagung = 7 * 3;
    $roti = 7 * 3;
  }else if ($calory >= 2500) {
    $nasi = round(7.5 * 3/4);
    $kentang = 7.5 * 2;
    $jagung = 7.5 * 3;
    $roti = 7.5 * 3;
  }
  $bubur = 2 * $nasi;
  // var_dump(array($nasi, $bubur, $kentang, $jagung, $roti));die;
  return array($nasi, $bubur, $kentang, $jagung, $roti);
}



?>
