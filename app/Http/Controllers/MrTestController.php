<?php

namespace App\Http\Controllers;


class MrTestController extends Controller
{
  public function index()
  {
    $out = array();
    $arrContextOptions = array(
      "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => true,
      ),
    );
    $arrContextOptions = array(
      'headers' => [
        'method' => "GET",
        'Content-Type' => 'application/json',
        'Host' => 'portal.eaeunion.org',
      ],
      'verify' => false,
      'body' => '{"processCode":"P.TS.01","resourceName":"conformity-docs","disableValidityPeriodDetailsFilter":false,"isHistory":false,"onDateValue":null,"top":100,"skip":80,"orderby":"_id asc"}',
    );
    $url = 'https://portal.eaeunion.org/sites/commonprocesses/ru-ru/_vti_bin/Portal.EEC.CDBProxy/Data.svc/GetDocuments';
    $data = file_get_contents($url, false, stream_context_create($arrContextOptions));

    $decoded = json_decode($data, true);

    dd($decoded);
  }
}