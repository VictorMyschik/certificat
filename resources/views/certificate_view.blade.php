@include('layouts.Elements.certificate_admin_action')
<div><span class="m-r-10 mr_cert_status_{{$certificate->getStatus()}}">{{mb_strtoupper($certificate->getStatusName())}}</span>{{$certificate->getCertificateKind()->getShortName()}}</div>
<div><h5 class="mr-bold" style="color: #090d2f">{{$certificate->getNumber()}}</h5></div>

<div class="">
  <mr-certificate-details :certificate="{{json_encode($certificate)}}"></mr-certificate-details>
</div>

