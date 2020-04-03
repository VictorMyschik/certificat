@extends('layouts.app')
@section('content')
  <div class="mr-main-div">
    @include('Admin.layouts.nav_bar')
    <div class="container m-t-10">
      @include('Admin.layouts.page_title')
      <div class="margin-b-15 margin-t-10">
        <a href="{{ route('admin_article_edit',['id'=>'0']) }}" title="Создать новую запись"
           class="btn btn-primary btn-xs mr-border-radius-5">
          new
        </a>
      </div>
      <table class="table table-hover table-striped table-bordered mr-middle">
        <thead>
        <tr class="mr-bold">
          <td>Тип</td>
          <td>Язык</td>
          <td>Public</td>
          <td>#</td>
        </tr>
        <thead>
        <tbody>
        @foreach($list as $article)
          <tr>
            <td>{{ $article->getKindName() }}</td>
            <td>{{ $article->getLanguage()?$article->getLanguage()->getName():'RU' }}</td>
            <td>{!! $article->getIsPublic()?'<span class="mr-color-green">public</span>':'<span class="mr-color-red">no</span>' !!}</td>
            <td>
              <a href="{{ route('admin_article_edit',['id'=>$article->id()]) }}" title="Редактировать"
                 class="btn btn-primary btn-xs mr-border-radius-5">
                <i class="fa fa-edit"></i>
              </a>
              <a href="{{ route('admin_article_delete',['id'=>$article->id()]) }}" title="Создать новую запись"
                 class="btn btn-danger btn-xs mr-border-radius-5"
                 onclick="return confirm('Будет удалена статья. Продолжить?');">
                <span class="fa fa-trash"></span>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
