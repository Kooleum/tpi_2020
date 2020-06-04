<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

 $requests = getOpenUnownedRequest();
$status = ["waiting"=>"En attente de traitement", "handling"=>"Traitement en cours", "done"=>"Terminé"];
$emergencyLevel = ["low"=>"Faible", "medium"=>"Modéré", "high"=>"Haut"];
$emergencyLevelColors = ["low"=>"", "medium"=>"bg-warning", "high"=>"bg-danger"];

$datas = "";

//displaying datas on table
foreach($requests as $request){
    $userOpen = getUserInfoFromId($request['idUserFrom']);

    $datas.="<tr>";
    $datas.="<td class=\"align-middle\">".$request['titleRequest']."</td>";
    $datas.="<td class=\"align-middle\"><div style='max-height:20vh;overflow:auto;'>".$request['descriptionRequest']."</div></td>";
    $datas.="<td class=\"align-middle\">".$request['datetimeRequest']."</td>";
    $datas.="<td class=\"align-middle\">".$userOpen['lastName']." ".$userOpen['firstName']." - ".$userOpen['email']."</td>";
    $datas.="<td class=\"align-middle\" class='".$emergencyLevelColors[$request['levelRequest']]."'>".$emergencyLevel[$request['levelRequest']]."</td>";
    $datas.="<td class=\"align-middle\">".$status[$request['statusRequest']]."</td>";
    $datas.="<td class=\"align-middle\"><a href='?action=requestDetails&idRequest=".$request['idRequest']."'><button class='btn btn-success'>Voir les détails</button></a>";
    $datas.="<a href='?action=changeRequestManager&idRequest=".$request['idRequest']."'><button class='btn btn-primary mt-md-1'>Assigner</button></a></td>";
    $datas.="</tr>";

}