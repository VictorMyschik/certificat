@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('layouts.mr_nav')
    <div class="container m-t-10">
      <div id="accordion" class="mr-border-radius-5">
        <a class="mr-bold" data-toggle="collapse" href="#menu_info"
           aria-expanded="true" aria-controls="menu_info">
          <h4 class="row card-header margin-horizontal-0"><i class="fa fa-angle-double-down"> {{$page_title}}</i></h4>
        </a>

        <div id="menu_info" class="collapse card-body mr-auto-size">
          <table>
            <tr class="align-text-top">
              <td class="p-b-15">Группа информационных ресурсов</td>
              <td class="padding-horizontal p-b-15">{{$reference_info['classifier_group']}}</td>
            </tr>
            <tr class="align-text-top">
              <td class="p-b-15">Описание</td>
              <td class="padding-horizontal p-b-15">{{$reference_info['description']}}</td>
            </tr>
            <tr class="align-text-top">
              <td class="p-b-15">Дата последнего обновления</td>
              <td class="padding-horizontal p-b-15">{{$reference_info['date']}}</td>
            </tr>
            <tr class="align-text-top">
              <td class="p-b-15">Документ-основание</td>
              <td class="padding-horizontal">
                <a target="_blank" href="{{$reference_info['doc_link']}}">{{$reference_info['document']}}</a>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <mr-table :mr_route="'{{ route($route_name) }}'"></mr-table>
    </div>
  </div>
@endsection