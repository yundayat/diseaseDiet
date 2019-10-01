<option value="0" selected>[Pilih salah satu]</option>
<?php
include('../../connect.php');
$dict =  [
  'DM' => 3,
  'HDKE' => 1,
  'GK' => 2,
  'G' => 4
];
$diagnoseID = $dict[$_GET['diagnose']];
$pasien = mysqli_query($conn, "SELECT * FROM laboratory WHERE diagnose_id=$diagnoseID");
while ($row = mysqli_fetch_assoc($pasien)) { ?>
  <option value="<?php echo $row['patient_id'];?>"><?php echo "Pasien ".$row['patient_id'];?></option>
<?php }?>
