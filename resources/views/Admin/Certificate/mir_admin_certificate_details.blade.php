@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container col-md-10 m-t-10">
      @include('Admin.layouts.page_title')
      <h4 class="mr_cert_status_{{$certificate->getStatus()}}">{{$certificate->getStatusName()}}</h4>
      {!! MrMessage::GetMessage() !!}
      <div class="margin-b-15 m-b-10">
        <a href="{{$certificate->getLinkOut() }}" target="_blank" title="Ссылка на XML"
           class="text-nowrap btn btn-success btn-sm fa fa-sm"> XML</a>
        <a class="text-nowrap btn btn-success btn-sm fa fa-link fa-sm"
           href="https://portal.eaeunion.org/sites/commonprocesses/ru-ru/Pages/CardView.aspx?documentId={{$certificate->getHash()}}&codeId=P.TS.01"
           title="Ссылка на картоку сертификата на сайте ЕАЭС" target="_blank"> EAEU</a>
        {!! MrLink::open('admin_certificate_update', ['id' => $certificate->id()], ' UPDATE', 'btn border-dark bold btn-sm fa fa-sm',
        'Обновить с сайта ЕАЭС',['onclick'=>"return confirm('Обновить?');"]) !!}
        <table class="m-t-10">
          <tr>
            <td class="mr-bold">Загружен/обновлён в {{ MrBaseHelper::MR_SITE_NAME }}:</td>
            <td class="p-l-15">{{$certificate->getWriteDate()->getMysqlDateTime()}}</td>
          </tr>
          <tr>
            <td class="mr-bold">Обновления записи общего ресурса ЕАЭС:</td>
            <td class="p-l-15">{{$certificate->getDateUpdateEAES()->getMysqlDateTime()}}</td>
          </tr>
        </table>
      </div>
      <hr>
      <div class="row col-md-12">
        <div class="col-md-6 padding-horizontal-0">
          <h4>Сведения о документе</h4>
          <table class="table table-sm">
            <tr>
              <td>Дата начала срока действия</td>
              <td>{{$certificate->getDateFrom()?$certificate->getDateFrom()->getShortDate():null}}</td>
            </tr>
            <tr>
              <td>Дата окончания срока действия</td>
              <td>{{$certificate->getDateTo()?$certificate->getDateTo()->getShortDate():null}}</td>
            </tr>
            <tr>
              <td>Эксперт - аудитор</td>
              <td>{{$certificate->getAuditor()?$certificate->getAuditor()->GetFullName():null}}</td>
            </tr>
            <tr>
              <td>Номер бланка</td>
              <td>{{$certificate->getBlankNumber()}}</td>
            </tr>
            <tr>
              <td>Срок действия статуса</td>
              <td>{{$certificate->GetStatusPeriod()}}</td>
            </tr>
            <tr>
              <td>Документ, на основании которого установлен статус</td>
              <td>{{$certificate->GetChangeStatusString()}}</td>
            </tr>
            <tr>
              <td>Причина изменения статуса</td>
              <td>{{$certificate->getWhyChange()}}</td>
            </tr>
            <tr>
              <td>Приложения к документу</td>
              <td></td>
            </tr>
            <tr>
              <td>Схема сертификации (декларирования)</td>
              <td>{{$certificate->getSchemaCertificate()}}</td>
            </tr>
            <tr>
              <td>Дополнительная информация</td>
              <td>{{$certificate->getDescription()}}</td>
            </tr>
          </table>
        </div>
        <div class="col-md-6 padding-horizontal-0">
          <h4>Сведения об органе по оценке соответствия</h4>
          <table class="table table-sm">
            <tr>
              <td>Орган по сертификации</td>
              <td>{{$certificate->getDateFrom()?$certificate->getDateFrom()->getShortDate():null}}</td>
            </tr>
            <tr>
              <td>Дата окончания срока действия</td>
              <td>{{$certificate->getDateTo()?$certificate->getDateTo()->getShortDate():null}}</td>
            </tr>
            <tr>
              <td>Эксперт - аудитор</td>
              <td>{{$certificate->getAuditor()?$certificate->getAuditor()->GetFullName():null}}</td>
            </tr>
            <tr>
              <td>Номер бланка</td>
              <td>{{$certificate->getBlankNumber()}}</td>
            </tr>
            <tr>
              <td>Срок действия статуса</td>
              <td>{{$certificate->GetStatusPeriod()}}</td>
            </tr>
            <tr>
              <td>Документ, на основании которого установлен статус</td>
              <td>{{$certificate->GetChangeStatusString()}}</td>
            </tr>
            <tr>
              <td>Причина изменения статуса</td>
              <td>{{$certificate->getWhyChange()}}</td>
            </tr>
            <tr>
              <td>Приложения к документу</td>
              <td></td>
            </tr>
            <tr>
              <td>Схема сертификации (декларирования)</td>
              <td>{{$certificate->getSchemaCertificate()}}</td>
            </tr>
            <tr>
              <td>Дополнительная информация</td>
              <td>{{$certificate->getDescription()}}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection