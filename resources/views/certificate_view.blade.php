@include('layouts.Elements.certificate_admin_action')
<div>
  <span class="m-r-5 mr-bold mr_cert_status_{{$certificate->getStatus()}}">
    {{mb_strtoupper($certificate->getStatusName())}}</span>
  <span
      title="{{$certificate->getCertificateKind()->getName()}}">{{$certificate->getCertificateKind()->getShortName()}}</span>
</div>
<div>
  <h5 class="mr-bold" style="color: #090d2f">
    <img style='height: 22px; border-radius: 4px;'
         src="https://img.geonames.org/flags/m/{{mb_strtolower($certificate->getCountry()->getISO3166alpha2())}}.png"
         alt="{{$certificate->getCountry()->getName()}}">
    {{$certificate->getNumber()}}
  </h5>
</div>

<div class="">
  <mr-certificate-details :certificate_json='{!! json_encode($certificate_json) !!}'></mr-certificate-details>
</div>

