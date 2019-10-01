<?php

$calory = $nutrition[0]%100 > 50 ? $nutrition[0]-$nutrition[0]%100+100 : $nutrition[0]-$nutrition[0]%100; // nilai pembulatan kalori

$carbohydrate = $nutrition[1];
$protein = $nutrition[2];
$fat = $nutrition[3];
// var_dump($nutrition);

$nasi = getRiceValue($calory)[0];
$bubur = getRiceValue($calory)[1];
// $kentang = getRiceValue($calory)[2];
// $jagung = getRiceValue($calory)[3];
// $roti = getRiceValue($calory)[4];

$carbo = array (
  "$nasi gls nasi",
  "$bubur gls bubur"
  // "$kentang bj sdg kentang",
  // "$jagung bj sdg jagung",
  // "$roti iris roti putih"
);

$proAnmHeart = array (
  "1 1/2 btr putih telur",
  "1 ptg sdg daging ayam tanpa kulit",
  "1 ptg sdg ikan",
  "1 ptg sdg daging sapi tanpa lemak"
);

$proAnm = array (
  "1 btr telur",
  "1 ptg sdg daging ayam",
  "1 ptg sdg ikan",
  "1 ptg sdg daging sapi"
);

$fruit = array(
  "1 ptg sdg pepaya",
  "2 bh sdg jeruk manis",
  "1 bh apel merah",
  "1 bh bsr belimbing",
  "2 bh bsr jambu air",
  "2 bh sdg salak"
);

$fruitCKG = array(
  // "1 ptg sdg pepaya",
  // "2 bh sdg jeruk manis",
  // "1 bh apel merah",
  // "1 bh bsr belimbing",
  "1/4 bh sdg melon",
  "2 ptg sdg semangka",
  "2 bh bsr jambu air",
  "2 bh sdg salak"
);

$sukrosa = round($energyNeeds * 0.05 / 4);
$aspartam = round($weight * 0.05);
$siklamat = $weight * 11;

$sugar = array(
  "sukrosa $sukrosa gr/hari",
  "fruktosa < 50 gr/hari",
  "sorbitol < 30 gr/hari",
  "manitol < 20 gr/hari",
  "aspartam $aspartam gr/hari",
  "sakarin 1 gr/hari",
  "siklamat $siklamat mg/hari"
);

$proAnmHeart = randomNutrition($proAnmHeart, 2, 3);
$fruit = randomNutrition($fruit, 2, 3);
$fruitCKG = randomNutrition($fruitCKG, 2, 3);
$sugar = randomNutrition($sugar, 1, 7);
$proAnm = randomNutrition($proAnm, 2, 3);
$proVgt = getProVegetableValue($calory, $proVgt);
$carb = randomNutrition($carbo, 1, 2);

$fruitHiperK = "";
$detailFruitHiperK = "";
$vegetHiperK = "";
$detailVegetHiperK = "";

if ($hiperK == 1) {
  $fruitHiperK = "buah-buahan";
  $detailFruitHiperK = "apel, alpukat, jeruk, pisang, dan pepaya (buah tinggi kalium untuk pasien hiperkalemia)";
  $vegetHiperK = "sayuran";
  $detailVegetHiperK = "peterseli, buncis, bayam, dan daun pepaya muda (sayuran tinggi kalium untuk pasien hiperkalemia)";
}

$dietWords = [
  "asupan_zat_gizi" => [
    "karbohidrat" => [
      "1" => "sumber karbohidrat",
      "2" => "sumber karbohidrat",
      "3" => "sumber karbohidrat",
      "4" => "sumber karbohidrat"
    ],
    "protein hewani" => [
      "1" => "sumber protein hewani",
      "2" => "sumber protein hewani",
      "3" => "sumber protein hewani",
      "4" => "sumber protein hewani"
    ],
    "protein nabati" => [
      "1" => "sumber protein nabati",
      "2" => "sumber protein nabati",
      "3" => "sumber protein nabati",
      "4" => "sumber protein nabati"
    ],
    "buah" => [
      "1" => "buah-buahan",
      "2" => "buah-buahan",
      "3" => "buah-buahan",
      "4" => "buah-buahan"
    ]
  ],
  "jenis_makanan" => [
    "karbohidrat" => [
      "1" => $carb,
      "2" => $carb,
      "3" => $carb,
      "4" => $carb
    ],
    "protein hewani" => [
      "1" => $proAnmHeart,
      "2" => $proAnm,
      "3" => $proAnmHeart,
      "4" => $proAnm

    ],
    "protein nabati" => [
      "1" => $proVgt,
      "2" => $proVgt,
      "3" => $proVgt,
      "4" => $proVgt
    ],
    "buah" => [
      "1" => $fruit,
      "2" => $fruitCKG,
      "3" => $fruit,
      "4" => $fruit
    ]
  ],
  "sifat_bahan_makanan" => [
    "1" => "bahan makanan yang mengandung lemak dan menimbulkan gas",
    "2" => "bahan makanan yang mengandung garam, kalium, fosfor, dan elektrolit lainnya",
    "3" => "bahan makanan yang mengandung banyak gula, lemak, dan natrium",
    "4" => "bahan makanan yang mengandug kadar purin tinggi"
  ],
  "gizi_pokok_d" => [
    "karbohidrat" => [
      "1" => "sumber karbohidrat",
      "2" => "sumber karbohidrat",
      "4" => "sumber karbohidrat"
    ],
    "protein hewani" => [
      "3" => "sumber protein hewani",
      "4" => "sumber protein hewani"
    ],
    "lemak" => [
      "2" => "sumber lemak"
    ],
    "protein nabati" => [
      "3" => "sumber protein nabati"
    ],
    "sayuran" => [
      "3" => "sayuran tinggi serat",
      "4" => "sayuran"
    ],
    "buah" => [
      "3" => "buah-buahan",
      "4" => "buah-buahan"
    ],
    "lain-lain" => [
      "2" => "asupan karbohidrat sederhana"
    ]
  ],
  "bahan_makanan_gizi_d" => [
    "karbohidrat" => [
      "1" => "nasi, kentang, roti, mie, makaroni, bihun, gula, dan tepung-tepungan yang dibuat bubur atau puding",
      "2" => "nasi, bihun jagung, kentang, makaroni, mi, tepung-tepungan, singkong, dan ubi",
      "4" => "nasi, bubur, bihun, roti, gandum, makaroni, pasta, jagung, kentang, ubi, talas, singkong, dan havermout"
    ],
    "protein hewani" => [
      "3" => "ayam tanpa kulit, ikan, putih telur, dan daging tidak berlemak",
      "4" => "telur, dan susu skim/susu rendah lemak"
    ],
    "protein nabati" => [
      "3" => "tempe, tahu, kacang hijau, kacang merah, kacang tanah, dan kacang kedelai"
    ],
    "lemak" => [
      "2" => "minyak jagung, minyak kacang tanah, minyak kelapa, minyak kedelai, dan margarin rendah garam"
    ],
    "sayuran" => [
      "3" => "kangkung, daun kacang, oyong, ketimun, tomat, labu air, kembang kol, lobak, sawi, selada, seledri, dan terong",
      "4" => "wortel, labu siam, kacang panjang, terong, pare, oyong, ketimun, labu air, selada air, tomat, selada, dan lobak"
    ],
    "buah" => [
      "3" => "jeruk, apel, pepaya, jambu air, salak, dan belimbing",
      "4" => "buah yang mengandung banyak air"
    ],
    "lain-lain" => [
      "2" => "gula, selai, sirup, permen, madu untuk menambah energi (suplemen), agar-agar, dan jelly"
    ]
  ],
  "gizi_pokok_b" => [
    "karbohidrat" => [
      "1" => "sumber karbohidrat",
      "3" => "sumber karbohidrat"
    ],
    "protein hewani" => [
      "1" => "sumber protein hewani",
      "2" => "sumber protein hewani",
      "3" => "sumber protein hewani yang tinggi lemak jenuh",
      "4" => "sumber protein hewani"
    ],
    "protein nabati" => [
      "2" => "sumber protein nabati",
      "4" => "sumber protein nabati"
    ],
    "lemak" => [
      "2" => "sumber lemak"
    ],
    "sayuran" => [
      "2" => "$vegetHiperK",
      "3" => "sayuran",
      "4" => "sayuran"
    ],
    "buah" => [
      "2" => $fruitHiperK,
      "3" => "buah-buahan"
    ]
  ],
  "bahan_makanan_gizi_b" => [
    "karbohidrat" => [
      "1" => "ketan, ubi, singkong, talas, serta kue gurih dan cake",
      "3" => "nasi, bubur, roti, mie, kentang, singkong, ubi, sagu, gandum, pasta, jagung, dan sereal"
    ],
    "protein hewani" => [
      "1" => "daging berlemak, daging asap, daging/ikan yang diawetkan, susu full cream, susu kental manis dan hasil olahan keju, serta es krim",
      "2" => "daging kambing, ayam, ikan, hati, keju , udang, dan telur",
      "3" => "kornet, sosis, sarden, otak, jeroan, dan kuning telur",
      "4" => "daging, ayam, ikan tongkol, tenggiri, bawal, bandeng, kerang, dan udang (maksimal 50 g/hari)"
    ],
    "protein nabati" => [
      "2" => "tahu, tempe, oncom, kacang tanah, kacang merah, kacang tolo, kacang hijau, kacang kedelai",
      "4" => "tempe dan tahu (maksimum 50 g/hari), serta kacang hijau, kacang tanah, dan kedelai (maksimum 25 g/hari)"
    ],
    "lemak" => [
      "2" => "minyak kelapa sawit, santan kental, mentega, dan lemak hewan"
    ],
    "sayuran" => [
      "2" => $detailVegetHiperK,
      "3" => "bayam, buncis, daun melinjo, labu siam, daun singkong, kapri, kacang panjang, pare, dan wortel",
      "4" => "bayam, buncis, daun/biji melinjo, kapri, kacang polong, kembang kol, asparagus, kangkung dan jamur (maksimum 100 g/hari)"
    ],
    "buah" => [
      "2" => $detailFruitHiperK,
      "3" => "nanas, anggur, mangga, sirsak, pisang, alpukat, sawo, semangka, dan nangka masak"
    ]
  ],
  "sumber_dihindari" => [
    "protein hewani" => [
      "4" => "sumber protein hewani dengan kandungan purin tinggi"
    ],
    "buah" => [
      "1" => "buah-buahan yang tinggi serat, tinggi lemak, dapat menimbulkan gas",
      "3" => "buah-buahan yang manis dan diawetkan"
    ],
    "sayuran" => [
      "1" => "sayuran yang berserat dan menimbulkan gas"
    ],
    "lain" => [
      "3" => "makanan dan minuman yang manis"
    ]
  ],
  "makanan_dihindari" => [
    "protein hewani" => [
      "4" => "hati, ginjal, jantung, jeroan, otak, ham, sosis, babat, usus, paru, sarden, kaldu daging, bebek, burung, remis dan kerang"
    ],
    "buah" => [
      "1" => "nangka, nanas, durian, dan kedondong",
      "3" => "durian, nangka, alpukat, kurma, dan manisan buah"
    ],
    "sayuran" => [
      "1" => "kol, sawi, lobak, daun singkong, nangka muda, dan kembang kol"
    ],
    "lain" => [
      "3" => "gula pasir, gula jawa, jeli, susu kental manis, cake, dodol, sirop, soft drink, dan es krim"
    ]
  ],
  "lain_lain" => [
    "1" => "minuman beralkohol, teh, atau kopi kental, goreng-gorengan, santan kental, kelapa, tape, serta bumbu",
    "3" => "goreng-gorengan, ikan asin, telur asin, dan makanan yang diawetkan",
    "4" => "minuman yang mengandung soda dan alkohol, seperti soft drink, arak, ciu, dan bir"
  ],
  "bahan_masak" => [
    "3" => "santan kental saat memasak"
  ],
  "alternatif" => [
    "3" => "aspartam maksimal sebanyak $aspartam gr/hari"
  ],
  "cara_masak" => [
    "1" => "merebus, mengukus, memanggang, mengungkep, atau pepes",
    "2" => "menumis, memanggang, mengukus, atau membakar (tak berkuah)",
    "4" => "merebus, mengukus, mengungkep, menumis, memanggang, atau pepes"
  ]

];


$conditionWords = array(
  array(
    'ASUPAN_ZAT_GIZI', // asupan protein hewani, asupan karbohidrat
    'JENIS_MAKANAN' // 1 ptg sdg ayam tanpa kulit, 1 ptg sdg ikan, dan 1 butir putih telur ayam
  ),
  array(
    'SIFAT_BAHAN_MAKANAN' // bahan makanan yang mengandung lemak dan menimbulkan gas
  ),
  array(
    'GIZI_POKOK_D', // bahan makanan sumber karbohidrat,  bahan makanan sumber protein hewani
    'BAHAN_MAKANAN_GIZI_D', // daging berlemak, daging asap, sosis, sarden,
    'dianjurkan' // dianjurkan, tidak dianjurkan
  ),
  array(
    'GIZI_POKOK_B', // bahan makanan sumber karbohidrat,  bahan makanan sumber protein hewani
    'BAHAN_MAKANAN_GIZI_B', // daging berlemak, daging asap, sosis, sarden,
    'dibatasi' // dianjurkan, tidak dianjurkan
  ),
  array(
    'SUMBER_DIHINDARI', // buah-buahan yang tinggi serat, tinggi lemak, dan dapat menimbulkan gas,
    'MAKANAN_DIHINDARI'
  ),
  array(
    'LAIN_LAIN'
  ),
  array(
    'BAHAN_MASAK'
  ),
  array(
    'ALTERNATIF'
  ),
  array(
    'CARA_MASAK'
  )
);

$corpusNeeds = "corpora/korpus_kebutuhan.txt";
$corpusContent = getCorpusContent($corpusNeeds); // mendapatkan smua isi korpus eah yang terpisah oleh newline

for ($i=0; $i<count($conditionWords); $i++) {

  $sentence = getSentences($corpusContent, $conditionWords[$i]);
  $subject = getSubjectClause($sentence, $stopWords); // mendapatkan kata pertama atau subjek

  foreach ($sentence as $keySentence => $valueSentence) {
    $valSentence = explode(" ", str_replace(".", "", strtolower($valueSentence)));
    $countArSentence[] = count($valSentence);
  }

  for ($j=0; $j<max($countArSentence); $j++) {        // var_dump($selectRecClause);die;

    $result3Gram = get3Grams($sentence, $subject, $j, $countArSentence);
    $clause = $result3Gram[0];
    $j = $result3Gram[1];
    $subject = trim($clause);
  }
  $subject .= '.';
  // var_dump($subject);
  foreach ($dietWords as $key => $value) {
    if (strpos($subject, $key) !== false) {
      foreach ($value as $k => $val) {
        if (is_array($val) && $val[$diet]) {
          $subjects[$i][$k] = str_replace($key, $val[$diet], ($subjects[$i][$k]) ? $subjects[$i][$k] : $subject);
        }
        else {
          if ($k == $diet) {
            $subjects[$i] = str_replace($key, $val, ($subjects[$i]) ? $subjects[$i] : $subject);
          }
        }
      }
    }
  }

}
// var_dump($subjects);
foreach ($subjects as $valueSubjects) {
  if (is_array($valueSubjects)) {
    $tempText = '';
    foreach ($valueSubjects as $key => $value) {
      // $tempText .= '<p>'.ucfirst($value).'</p>';
      $tempText .= ucfirst($value)." ";
      // var_dump($tempText);die;
    }
    $text[] = $tempText;
    // var_dump($text);die;
  }else {
    // $text[] = '<p>'.ucfirst($valueSubjects).'</p>';
    $text[] = ucfirst($valueSubjects)." ";
  }
}
// var_dump($text);
for ($i=2; $i<count($text); $i++) {
  $h[] = $text[$i];
}

$hx = explode(". ", implode($h));
// var_dump($hx);
foreach ($hx as $valHx) {
  if ($valHx !== '') {
    $hxx[] = $valHx;
    if (stripos($valHx, 'protein hewani') !== FALSE) {
      $proteinAnx['protein hewani'][] = $valHx;
    }else if (stripos($valHx, 'protein nabati') !== FALSE) {
      $proteinNax['protein nabati'][] = $valHx;
    }else if (stripos($valHx, 'karbohidrat') !== FALSE) {
      $karbohidratx['karbohidrat'][] = $valHx;
    }else if (stripos($valHx, 'lemak') !== FALSE) {
      $lemakx['lemak'][] = $valHx;
    }else if (stripos($valHx, 'buah-buahan') !== FALSE) {
      $buahx['buah-buahan'][] = $valHx;
    }else if (stripos($valHx, 'sayuran') !== FALSE) {
      $sayurx['sayuran'][] = $valHx;
    }else if (stripos($valHx, 'gula') !== FALSE) {
      $gulax['gula'][] = $valHx;
    }else if (stripos($valHx, 'cara') !== FALSE) {
      $olahx['pengolahan makanan'][] = $valHx;
    }else {
      $lainx['lain-lain'][] = $valHx;
    }
  }
}

$menux = array_filter(explode(". ", $text[0]));

foreach ($menux as $valueMenux) {
  $menuxx[] = "<i class='fa fa-check-circle' style='color:#47D45B'></i> ".$valueMenux.".<br />";
}

$menuxx = $text[1]."<br />".implode($menuxx);

$resultHx = array($karbohidratx, $proteinAnx, $proteinNax, $lemakx, $buahx, $sayurx, $gulax, $olahx, $lainx);
foreach ($resultHx as $valueResultHx) {
  foreach ($valueResultHx as $keyValueResultHx => $valValueResultHx) {
    $textHx[] = "<p style='color:black'><b style='color:#47D45B'>".ucwords($keyValueResultHx)."</b><br />".implode(". ", $valValueResultHx).".</p>";
  }
}

$openingText = "Pasien dianjurkan untuk menerapkan Diet $dietName $calory kkal. "; // kalimat pembukanon asites
$textNutri = "<p style='color:black'>".$openingText." ".$menuxx."</p>".implode($textHx);
// var_dump($textNutri);die;

// $protein *= 4;
// $fat *= 9;
// $carbohydrate *= 4;

$nutritionText = "<p style='color:black'>
  Berikut ini rincian kebutuhan energi dan zat gizi pasien dalam sehari.<br />
  1. Kebutuhan energi sebesar $calory kkal/hari.<br />
  2. Kebutuhan protein sebesar $protein g/hari.<br />
  3. Kebutuhan lemak sebesar $fat g/hari.<br />
  4. Kebutuhan karbohidrat sebesar $carbohydrate g/hari.<br />
  </p>
";


?>
