<div><a href="{{$certificate->getLinkOut() }}" target="_blank" title="Ссылка на XML"
        class="text-nowrap btn btn-success btn-sm fa fa-sm"> XML</a>
  <a class="text-nowrap btn btn-success btn-sm fa fa-link fa-sm"
     href="https://portal.eaeunion.org/sites/commonprocesses/ru-ru/Pages/CardView.aspx?documentId={{$certificate->getHash()}}&codeId=P.TS.01"
     title="Ссылка на картоку сертификата на сайте ЕАЭС" target="_blank"> EAEU</a>
  {!! MrLink::open('admin_certificate_update', ['id' => $certificate->id()], ' UPDATE', 'btn border-dark bold btn-sm fa fa-sm',
  'Обновить с сайта ЕАЭС',['onclick'=>"return confirm('Обновить?');"]) !!}
</div>