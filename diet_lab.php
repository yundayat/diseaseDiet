<?php

$corpusLab = "corpora/korpus_lab.txt";
$labKim = getCorpusContent($corpusLab); // mendapatkan smua isi korpus stopwords yang terpisah oleh newline
// var_dump(json_decode($labKim));die;
$up = [
  'atas batas',
  'peningkatan',
  'meningkat'
];

$down = [
  'bawah batas',
  'penurunan',
  'menurun'
];

$suggest = [
  'KOMPONEN_LAB',
  'STATUS_LAB',
  'MAKANAN'
];

$risk = [
  'KADAR',
  'KOMPONEN_LAB',
  'RESIKO'
];
$hiperK = 0;
// var_dump(json_encode($labResult));
foreach ($labResult as $keyLabResult => $valueLabResult) {
  $labValue[$keyLabResult] = $valueLabResult;
  $valueLab[$keyLabResult] = checkLabValue($keyLabResult, $valueLabResult, $gender);

  // var_dump(json_encode($valueLab));
  foreach ($valueLab as $keyValueLab => $valueValueLab) {
    if ($keyValueLab === 'kalium'){
      if ($valueValueLab["status"] === 'meningkat') {
        $hiperK = 1;
      }
    }

    $clauseValLab[$keyLabResult] = getLabClause($valueValueLab['status'], $labKim, $keyLabResult, $up, $down, $valueValueLab['suggest'], $valueValueLab['risk'], $suggest, $risk);
    foreach ($clauseValLab as $keyClauseLab => $valueClauseLab) {
      $selectClauseLab = getTextLab($valueClauseLab[0], $stopWords, 'kenormalan', $valueClauseLab[3], $keyClauseLab);
      $selectRiskClause = getTextLab($valueClauseLab[1], $stopWords, 'indikasi', $valueClauseLab[3], $keyClauseLab);
      $selectRecClause = getTextLab($valueClauseLab[2], $stopWords, 'anjuran', $valueClauseLab[3], $keyClauseLab);
      $clauseResult = array($selectClauseLab, $selectRiskClause, $selectRecClause);
      $clauseResult = array_filter($clauseResult);

    }
  }
  $cls[] = implode($clauseResult);
  $clss = array_filter($cls);
}
// var_dump(json_encode($clss));
foreach ($clss as $valClss) {
  $valCls[] = "<i class='fa fa-check-circle' style='color:#47D45B'></i> ".$valClss."<br /><br />";
}

$textLab = implode($valCls);





?>
