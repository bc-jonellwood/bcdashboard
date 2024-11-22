<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/15 15:27:04

include "dbheader.php";

$data = [];

$sql = "SELECT fr.id 
      ,fr.sRequestId
      ,fr.dtRequestSubmitted
      ,CONCAT(fr.sIssueTitle, ' - ', fr.sIssueDescription) as request_details
      ,fr.sIssueDescription
      ,fr.iIssueType
      ,rt.sType as request_type
      ,fr.sIssueLocation
      ,fl.sName as location
      ,fr.sIssueSubLocation as location_detailed
      ,fr.sRequestorName
      ,fr.sRequestorUserID
      ,au.sEmail as sRequestorsEmail
      ,dd.sDepartmentName as sRequestorsDepartment
      ,fr.sPrimaryContact as contact_first
      ,fr.sPhoneNumber as contact_phone
      ,fr.iDesiredResponse as response_time
  FROM bcg_intranet.dbo.app_facilities_requests fr
  JOIN data_facilities_locations fl on fl.sUid = fr.sIssueLocation
  JOIN data_facilities_request_types rt on rt.id = fr.iIssueType
  JOIN app_users au on au.id = fr.sRequestorUserID
  JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber 
  ORDER BY dtRequestSubmitted ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    $data = $result;
}
header('Content-Type: application/json');
echo json_encode($data);
