
<div><span class="m-r-10 mr-bold mr_cert_status_{{$certificate->getStatus()}}">{{mb_strtoupper($certificate->getStatusName())}}</span>{{$certificate->getCertificateKind()->getShortName()}}</div>
<div><h5 class="mr-bold" style="color: #090d2f">{{$certificate->getNumber()}}</h5></div>

<div class="">
  <mr-certificate-details :certificate_json='{!! json_encode($certificate_json) !!}'></mr-certificate-details>
</div>

