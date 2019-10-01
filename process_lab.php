<?php
function checkLabValue($key_lab, $value_lab, $gender) {
  $limit = 0;
  $suggest = "";
  $risk = "";

  if ($key_lab === "glukosa_darah_sewaktu") {
    if ($value_lab < 110) {
      $status = "normal";
    }else if ($value_lab >= 110) {
      $status = "meningkat";
      $risk = "penyakit_diabetes,_serangan_jantung,_stress_parah,_stroke,_sindrom_chusing,_dan_obat-obatan_sejenis_corticosteroid";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_banyak_gula"
      );
      if ($value_lab <= 199) {
        $limit = $value_lab - 99;
      }else {
        $limit = $value_lab - 199;
      }
    }
  }

  if ($key_lab === "glukosa_darah_puasa") {
    if ($value_lab < 110) {
      $status = "normal";
    }else if ($value_lab >= 100) {
      $status = "meningkat";
      $risk = "penyakit_diabetes,_serangan_jantung,_stress_parah,_stroke,_sindrom_chusing,_atau_obat-obatan_sejenis_corticosteroid";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_banyak_gula"
      );
      if ($value_lab > 125) {
        $limit = $value_lab - 125;
      }else {
        $limit = $value_lab - 99;
      }
    }else {
      $status = "menurun";
      $limit = 69 - $value_lab;
    }
  }

  if ($key_lab === "glukosa_darah_2_jam_pp") {
    if ($value_lab < 140) {
      $status = "normal";
    }else if ($value_lab >= 140) {
      $status = "meningkat";
      $limit = $value_lab - 139;
      $risk = "penyakit_diabetes,_serangan_jantung,_stress_parah,_stroke,_sindrom_chusing,_atau_obat-obatan_sejenis_corticosteroid";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_banyak_gula"
      );
    }
  }

  if ($key_lab === "hba1c") {
    if ($value_lab < 6.0){
      $status = "normal";
    }else if ($value_lab >= 6.0) {
        $status = "meningkat";
        $limit = $value_lab - 6.0;
        $risk = "penyakit_diabetes";
    }
  }

  if ($key_lab === "albumin") {
    if ($value_lab >= 3.5 && $value_lab <= 5.0) {
      $status = "normal";
    }else if($value_lab < 3.5){
      $status = "menurun";
      $limit = 3.5 - $value_lab;
      $risk = "malnutrisi,_sindroma_absorpsi,_hipertiroid,_kehamilan,_gangguan_fungsi_hati,_infeksi_kronik,_luka_bakar,_edema,_asites,_sirosis,_nefrotik_sindrom,_SIADH,_atau_perdarahan";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_banyak_protein"
      );
    }else {
      $status = "meningkat";
      $limit = $value_lab - 5.0;
      $risk = "dehidrasi";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"banyak_air_atau_jus_buah_yang_encer"
      );
    }
  }

  if ($key_lab === "sgot") {
    if ($value_lab >= 5.0 && $value_lab <= 35.0) {
      $status = "normal";
    }else if($value_lab < 5.0){
      $status = "menurun";
      $limit = 5.0 - $value_lab;
      $risk = "pasien_asidosis_dengan_diabetes_melitus";
      // $suggest = array(
      //   "anjuran"=>"dianjurkan",
      //   "jenis_makanan"=>"makanan_yang_mengandung_vitamin_b"
      // );
    }else {
      $status = "meningkat";
      $limit = $value_lab - 35.0;
      $risk = "serangan_jantung,_penyakit_hati,_pankreatitis_akut,_trauma,_anemia_hemolitik_akut,_penyakit_ginjal_akut,_luka_bakar_parah_dan_penggunaan_berbagai_obat,_seperti_isoniazid,_eritromisin,_atau_kontrasepsi_oral";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_tinggi_lemak_dan_minuman_beralkohol"
      );
    }
  }

  if ($key_lab === "sgpt") {
    if ($value_lab >= 5.0 && $value_lab <= 35.0) {
      $status = "normal";
    }else if($value_lab < 5.0){
      $status = "menurun";
      $limit = 5.0 - $value_lab;
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_vitamin_b"
      );
    }else {
      $status = "meningkat";
      $limit = $value_lab - 35.0;
      $risk = "penyakit_hepatoseluler,_sirosis_aktif,_obstruksi_bilier_dan_hepatitis,_obesitas,_preeklamsi_berat,_atau_acute_lymphoblastic_leukemia_(ALL)";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_mengandung_tinggi_lemak_dan_minuman_beralkohol"
      );
    }
  }

  if ($key_lab === "bilirubin") {
    $status = "normal";
    if ($value_lab < 0.4) {
      $status = "menurun";

    }else {
      $status = "meningkat";
      $risk = "metastase_hepatik,_hepatitis,_sirosis,_kolestasis_akibat_obat-obatan,_kanker_pankreas_atau_kolelitiasis";
    }
  }

  if ($key_lab === "ggt") {
    if ($gender == 1) {
      if ($value_lab <= 70) {
        $status = "normal";
      }else {
      $status = "meningkat";
      }
    }else {
      if ($value_lab <= 94) {
        $status = "normal";
      }else {
      $status = "meningkat";
      }
    }
    if ($status === "meningkat") {
      $risk = "kolesistitis,_koletiasis,_sirosis,_pankreatitis,_atresia_billier,_obstruksi_bilier,_penyakit_ginjal_kronis,_diabetes_melitus,_pengggunaan_barbiturat,_atau_obat-obat_hepatotoksik";
    }
  }

  if ($key_lab === "alp") {
    if ($value_lab >= 30 && $value_lab <= 130) {
      $status = "normal";
    }else if($value < 30){
      $status = "menurun";
      $limit = 30 - $value_lab;
      $risk = "hipofosfatemia,_malnutrisi_atau_hipotiroidisme.";
    }else {
      $status = "meningkat";
      $limit = $value_lab - 130;
      $risk = "penyakit_hati,_penyakit_tulang,_kehamilan,_ginjal_kronik,_atau_penyakit_jantung";
    }
  }

  if ($key_lab === "trigliserida") {
    if ($gender == 1) {
      if ($value_lab >= 40 && $value_lab <= 160) {
        $status = "normal";
      }else if ($value_lab < 40) {
        $status = "menurun";
        $limit = 40 - $value_lab;
      }else {
        $status = "meningkat";
        $limit = $value_lab - 160;
      }
    }else {
      if ($value_lab >= 35 && $value_lab <= 135) {
        $status = "normal";
      }else if ($value_lab < 35) {
        $status = "menurun";
        $limit = 35 - $value_lab;
      }else {
        $status = "meningkat";
        $limit = $value_lab - 135;
      }
    }
  }

  if ($key_lab === "kolesterol_ldl") {
    if ($value_lab < 130) {
      $status = "normal";
    }else {
      $status = "meningkat";
      $limit = $value_lab - 129;
    }
  }

  if ($key_lab === "kolesterol_hdl") {
    if ($value_lab >= 30 && $value_lab <= 70) {
      $status = "normal";
    }else if ($value_lab < 30) {
      $status = "menurun";
      $risk = "fibrosis_sistik,_sirosis_hati,_DM,_sindrom_nefrotik,_malaria,_beberapa_infeksi akut,_penggunaan_probucol,_hidroklortiazid,_progestin_atau_infus_nutrisi_parenteral";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"makanan_yang_tinggi_lemak_dan_siap_saji"
      );
    }else {
      $status = "meningkat";
      $limit = $value_lab - 70;
      $risk = "alkoholisme,_sirosis_bilier_primer,_tercemar_racun_industri_atau_poliklorin_hidrokarbon,_penggunaan_klofi_brat,_estrogen,_asam_nikotinat,_kontrasepsi_oral_atau_fenitoin.";
    }
  }

  if ($key_lab === "kolesterol_total") {
    if ($value_lab <= 200) {
      $status = "normal";
    }else {
      $status = "meningkat";
      $limit = $value_lab - 200;
    }
  }
  // var_dump($key_lab, $value_lab);
  if ($key_lab === "kreatinin") {
    if ($value_lab >= 0.6 && $value_lab <= 1.3) {
      $status = "normal";
    }else if ($value_lab < 0.6) {
      $status = "menurun";
      $limit = 0.6 - $value_lab;
      $risk = "distropi_otot,_atropi,_malnutrisi_atau_penurunan_masa_otot_akibat_penuaan";
    }else{
      $status = "meningkat";
      $limit = $value_lab - 1.3;
      $risk = "gangguan_fungsi_ginjal_yang_dapat_disebabkan_oleh_nefritis,_penyumbatan_saluran_urine,_penyakit_otot_atau_dehidrasi_akut";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"cukup_serat_dan_minum_air_putih,_batasi_konsumsi_protein,_atau_hindari_suplemen_yang_mengandung_kreatin"
      );
    }
  }

  if ($key_lab === "ureum") {
    if ($value_lab < 50) {
      $status = "normal";
    }else {
      $status = "meningkat";
      $limit = $value_lab - 49;
      $risk = "penyakit_ginjal,_diabetes,_hipertensi,_gagal_jantung,_dehidrasi_berat,_luka_bakar_parah,_kehamilan,_atau_penuaan";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"cukup_air_dan_batasi_makanan_tinggi_protein"
      );
    }
  }

  if ($key_lab === "asam_urat") {
    if ($gender == 1){
      if ($value_lab < 7.0 ) {
        $status = "normal";
      }else {
        $status = "meningkat";
      }
    }else {
      if ($value_lab < 5.7) {
        $status = "normal";
      }else {
        $status = "meningkat";
      }
    }
    if ($status === "meningkat") {
      $risk = "kegagalan_fungsi_ginjal_yang_signifikan_akibat_penurunan_ekskresi_atau_peningkatan_produksi_asam_urat,_leukemia,_limfoma,_syok,_kemoterapi,_atau_metabolit_asidosis";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"cukup_air_dan_batasi_makanan_yang_mengandung_lemak_tinggi,_jeroan,_dan_gorengan"
      );
    }
  }


  if ($key_lab === "natrium") {
    if ($value_lab >= 120 && $value_lab <= 155) {
      $status = "normal";
    }else if ($value_lab < 120) {
      $status = "menurun";
      $risk = "hipovolemia_(kekurangan_cairan_tubuh,_terjadi_pada_penggunaan_diuretik,_defisiensi_mineralokortikoid,_hipoaldosteronism,_luka_bakar,_muntah,_diare,_pankreatitis),_euvolemia_(defisiensi_glukokortikoid,_siadh,_hipotirodism,_dan_penggunaan_manitol)_atau_hipervolemia_(kelebihan_cairan_tubuh,_terjadi_pada_terjadi_pada_gagal_jantung,_penurunan_fungsi_ginjal,_sirosis,_sindrom_nefrotik)";
      $suggest = array(
        "anjuran"=>"dianjurkan",
        "jenis_makanan"=>"bahan_makanan_rendah_natrium,_cairan_isotonik_atau_natrium_peroral_(untuk_hiponatremia_akibat_hipovolemia),_membatasi_cairan_atau_pemberian_furosemid_(untuk_hiponatremia_akibat_hipervolemia)"
      );

    }else {
      $status = "meningkat";
      $risk = "dehidrasi,_aldosteronism,_diabetes_insipidus_dan_diuretik_osmotik,_atau_adanya_gejala_kardiovaskular_dan_ginjal";
      $suggest = array(
        "anjuran"=>"tidak_dianjurkan",
        "jenis_makanan"=>"bahan_makanan_tinggi_natrium_dan_cairan_yang_berlebihan"
      );
    }
  }

  if ($key_lab === "kalium") {
    if ($value_lab >= 3.5 && $value_lab <= 5.0) {
      $status = "normal";
    }else {
      if ($value_lab < 3.5) {
        $status = "menurun";
        $risk = "diare,_muntah,_luka_bakar_parah,_aldosteron_primer,_asidosis_tubular_ginjal,_diuretik,_steroid,_cisplatin,_tikarsilin,_stres_yang_kronik,_penyakit_hati_dengan_asites,_atau_terapi_amfoterisin";
        // $limit = 3.5 - $value_lab;
        $suggest = array(
          "anjuran"=>"dianjurkan",
          "jenis_makanan"=>"garam_kalium_klorida_(KCl)_dan_bahan_makanan_tinggi_kalium"
        );
      }else {
        $status = "meningkat";
        $risk = "gagal_ginjal,_kerusakan_sel_(luka_bakar,_operasi),_asidosis,_penyakit_addison,_diabetes_yang_tidak_terkontrol_dan_transfusi_sel_darah_merah,_serta_penggunaan_obat_seperti_penisilin_natrium,_diuretik_hemat_kalium_(spironolakton),_ACEI,_dan_NSAID";
        // $limit = $value_lab - 5.0;
        $suggest = array(
          "anjuran"=>"tidak_dianjurkan",
          "jenis_makanan"=>"bahan_makanan_tinggi_kalium"
        );
      }
    }
  }

  if ($key_lab === "klorida") {
    if ($value_lab >= 96 && $value_lab <= 106) {
      $status = "normal";
    }else {
      if ($value_lab < 96) {
        $status = "menurun";
        $limit = 96 - $value_lab;
        $risk = "muntah,_gastritis,_diuresis_yang_agresif,_luka_bakar,_kelelahan,_diabetik_asidosis,_infeksi_akut,_atau_bersamaan_dengan_alkalosis_metabolik";
        $suggest = array (
          "anjuran"=>"dianjurkan",
          "jenis_makanan"=>"obat-obatan_yang_mengandung_klorida_seperti_amonium_klorida"
        );
      }else {
        $status = "meningkat";
        $limit = $value_lab - 106;
        $risk = "dehidrasi,_hiperventilasi,_asidosis_metabolik_dan_penyakit_ginjal";
        $suggest = array (
          "anjuran"=>"dianjurkan",
          "jenis_makanan"=>"larutan_ringer_terlaktasi_atau_natrium_bikarbonat"
        );
      }
    }
  }

  if ($key_lab === "kalsium") {
    if ($value_lab >= 8.4 && $value_lab <= 11.0) {
      $status = "normal";
    }else {
      if ($value_lab < 8.4) {
        $status = "menurun";
        $risk = "hiperfosfatemia (gangguan_fungsi_ginjal,_uremia,_kelebihan_asupan_fosfat,_hipoparatiroidisme,_kelebihan_asupan_vitamin_D,_tumor_tulang,_respiratori_asidosis,_asidosis_laktat_dan_terapi_bifosfonat),_alkalosis,_osteomalasia,_penggantian_kalsium_yang_tidak_mencukupi,_penggunaan_laksatif,_furosemide,_pemberian_kalsitonin,_atau_rendahnya_konsentrasi_albumin_karena_adanya_gabungan_kalsium_dengan_albumin";
        // $limit = 8.4 - $value_lab;
      }else {
        $status = "meningkat";
        // $limit = $value_lab - 11.0;
        $risk = "hiperparatiroidisme_atau_neoplasma_(kanker),_paratiroid_adenoma_atau_hiperplasia_(terkait_dengan_hipofosfatemia),_penyakit_hodgkin,_multiple_mieloma,_leukemia,_penyakit_addison,_penyakit_paget,_respiratori_asidosis,_metastase_tulang,_imobilisasi_dan_terapi_dengan_diuretik_tiazid";
      }
    }
  }

    return array("status"=>$status, "suggest"=>$suggest, "risk"=>$risk);
}


function getLabClause($status_value, $lab_corpus, $name_lab, $up, $down, $rec_food, $indicate, $suggest, $risk) {
  if ($status_value !== "normal") {
    foreach ($lab_corpus as $value_lab) {
      $val_lab = str_replace(".", "", strtolower($value_lab));
      if (stripos($val_lab, $name_lab) !== FALSE) {
        $clause_lab[] = $val_lab;
      }
    }
    foreach ($clause_lab as $val_labs) {
      if ($status_value === "meningkat") {
        foreach ($up as $value_up) {
          if (stripos($val_labs, $value_up) !== FALSE ) {
            $result[] = $val_labs;
          }
        }
      }else {
        foreach ($down as $value_down) {
          if (stripos($val_labs, $value_down) !== FALSE ) {
            $result[] = $val_labs;
          }
        }
      }

    }

    if ($indicate !== "") {
      $stcLab = getSentences($lab_corpus, $risk);
      foreach ($stcLab as $valueStcLab) {
        $stcLabs = str_replace(".", "", strtolower($valueStcLab));
        $kadar = $status_value === 'menurun' ? 'penurunan' : 'peningkatan';
        // var_dump($name_lab, $kadar);
        $stc_risk[] = str_replace(
          array(
            'kadar',
            'komponen_lab',
            'resiko'),
            array(
              $kadar,
              $name_lab,
              $indicate
            ),
            $stcLabs
        );
      }
    }

    if ($rec_food !== "") {
      $stcLab = getSentences($lab_corpus, $suggest);
      foreach ($stcLab as $valueStcLab) {
        $stcLabs = str_replace(".", "", strtolower($valueStcLab));
        $stc_suggest[] = str_replace(
          array(
            "komponen_lab",
            "status_lab",
            "anjuran",
            "jenis_makanan"),
            array(
              $name_lab,
              $status_value,
              $rec_food["anjuran"],
              $rec_food["jenis_makanan"]
            ),
            $stcLabs
        );
      }
    }
  }
  // var_dump($result, $stc_risk, $stc_suggest, $status_value);die;
  return array($result, $stc_risk, $stc_suggest, $status_value);
}


function getTextLab($lab_clause, $stop_words, $type, $normal, $key) {

  if (is_array($lab_clause)){
    a:
    $sub = getSubjectClause($lab_clause, $stop_words); // mendapatkan kata pertama atau subjek
    if ($type === 'anjuran') {
      if ($sub !== 'pasien' && $sub !== 'kadar' && $sub !== 'konsumsi') {
        goto a;
      }else if ($sub === 'konsumsi') {
        $count_ar = 8;
      }
    }

    if ($type === 'indikasi') {
      $sub = $normal==='meningkat'? 'peningkatan' : 'penurunan';
    }

    foreach ($lab_clause as $value_lab_clause) {
      $letter_val_lab = explode(" ", $value_lab_clause);
      $count_ar_lab[] = count($letter_val_lab);
    }
    if (!$count_ar) {
      $count_ar = max($count_ar_lab);

    }

    for ($j=0; $j<=$count_ar; $j++) {

      $result_3gram_lab = get3Grams($lab_clause, $sub, $j, $count_ar_lab);
      $clause = $result_3gram_lab[0];
      $j = $result_3gram_lab[1];
      $sub = $clause;

    }
    // var_dump($sub);

  }else {
    $sub = $lab_clause;
  }

  $sub = str_replace(
    array(
      ".",
      "_",
      "pp",
      "hba1c",
      "siadh",
      "all",
      "alp",
      "kcl",
      "ggt",
      "acei",
      "nsaid",
      "vitamin d",
      "dm",
      "sgot",
      "sgpt",
      "vitamin b"
    ),
    array(
      ". ",
      " ",
      "PP",
      "Hb-A1c",
      "SIADH",
      "ALL",
      "alkaline fosfatase (ALP)",
      "KCl",
      "GGT",
      "ACEI",
      "NSAID",
      "Vitamin D",
      "DM",
      "SGOT",
      "SGPT",
      "vitamin B"
    ), $sub);

    if ($sub != NULL) {
      $sub = ucfirst($sub.'. ');
    }
  return $sub;

}

function checkDietNormal($calory) {

}

?>
