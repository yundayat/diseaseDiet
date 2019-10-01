<?php
include('../../connect.php');
$patientID = $_GET['id'];
$query = mysqli_query($conn, "select * from laboratory where patient_id=$patientID");
$data = mysqli_fetch_object($query);
echo json_encode($data);
