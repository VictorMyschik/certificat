<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Sufee Admin - HTML5 Admin Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/public/images/Admin/favicon.ico">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="/public/vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/vendors/themify-icons/css/themify-icons.css">
<link rel="stylesheet" href="/public/vendors/flag-icon-css/css/flag-icon.min.css">
<link rel="stylesheet" href="/public/vendors/selectFX/css/cs-skin-elastic.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/public/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="/public/css/mr-admin-page.css">
<link rel="stylesheet" href="/public/css/mr-style.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

@extends('Admin.layouts.app')

@section('content')
	<div id="right-panel" class="right-panel">
		<div class="breadcrumbs">
			<div class="col-sm-4">
				<div class="page-header float-left">
					<div class="page-title">
						<h1>Пользователи {!!  \App\Http\Controllers\Forms\MrForm::loadForm('user_edit', 'MrUserEditForm', ['id' => '0'], 'Новый') !!}</h1>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="page-header float-right">
					<div class="page-title">
						<ol class="breadcrumb text-right">
							<li><a href="/admin">Главная</a></li>
							<li class="active">Пользователи</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="content mt-3">
			<div class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">
						<h4 class="margin-t-20">Зарегистрированные пользователи</h4>
						<div class="card-body">
							<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
								<thead>
								<tr>
									<td class="padding-horizontal">№</td>
									<td class="padding-horizontal">Login</td>
									<td class="padding-horizontal">ФИО</td>
									<td class="padding-horizontal">Контакты</td>
									<td class="padding-horizontal">Регистрация</td>
									<td class="padding-horizontal">Старт сессии</td>
									<td class="padding-horizontal">Конец сессии</td>
									<td class="padding-horizontal">Подписка</td>
									<td class="padding-horizontal">Блок</td>
									<td class="padding-horizontal">Изменить</td>
									<td class="padding-horizontal">Del</td>
								</tr>
								</thead>
								<tbody>
								@foreach($users as $user)
									<tr>
										<td class="padding-horizontal small">{{ $user->id() }}</td>
										<td class="padding-horizontal small">{{ $user->getName() }}</td>
										<td class="padding-horizontal small">{{ $user->GetFullName() }}</td>
										<td class="padding-horizontal small">
											{{ $user->getPhone() }}
											{{ $user->getEmail() }}
											@if($user->getProfile())
												<a href="{{ $user->getProfile() }}" target="_blank">профиль</a>
											@endif
										</td>
										<td class="padding-horizontal small">{{ $user->getDateFirstVisit()->format('d M Y H:i') }}</td>
										<td class="padding-horizontal small">{{ $user->getDateLogin()->format('d M Y H:i') }}</td>
										<td class="padding-horizontal small">{{ $user->getDateLastVisit()->format('d M Y H:i') }}</td>
										<td class="padding-horizontal small">
											{!!  $user->getIsSubscription()?'да <a class="mr-border-radius-10" href="/unsubscription/'.\App\Models\MrSubscription::loadBy($user->getEmail(),'Email')->getToken().'?return=true">отписать</a>':'нет <a class="mr-border-radius-10" href="/subscription?return=true&email='.$user->getEmail().'">подписать</a>' !!}
										</td>
										<td
											class="padding-horizontal small">{{ $user->getBlock() ? 'да' : 'нет' }}</td>
										<td class="padding-horizontal small">

											{!!  \App\Http\Controllers\Forms\MrForm::loadForm('user_edit', 'MrUserEditForm', ['id' => $user->id()]) !!}


										</td>
										<td class="padding-horizontal small">
											<a href="/admin/users/delete/{{ $user->id() }}"
											   onclick="return confirm('Уверены? Пользователь будет удалён полностью из системы');">Удалить</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!-- .animated -->
			<hr>
		</div><!-- .content -->
		<div class="content mt-3">
			<div class="animated fadeIn">
				<div class="row">
					<div class="col-md-12">
						<div class="card-body">
							<div class="row col-md-12 d-inline-block">
								<h4>Блокировка пользователя</h4>
								{{ Form::open(['url'=>'/admin/users/block','method' => 'get', 'enctype'=>'multipart/form-data', 'files' => false]) }}
								{{ Form::token() }}
								<select class="mr-border-radius-10" name="user">
									<option value=0>[не выбрано]</option>
									@foreach($users as $user)
										<option value="{{ $user->id() }}">{{ $user->getName().' ('.$user->getEmail().')' }}</option>
									@endforeach
								</select>

								<input type="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" name="date_to" class="mr-border-radius-10">
								<input type="time" min="{{  date('H:i') }}" value="{{  date('H:i') }}" name="date_time" class="mr-border-radius-10">

								<input name="description" type="text" placeholder="причина..." class="mr-border-radius-10">
								<button type="submit" class="btn btn-sm top btn-primary mr-border-radius-10">Блокировать</button>
								{!! Form::close() !!}
							</div>

							<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
								<thead>
								<tr>
									<td class="padding-horizontal">№</td>
									<td class="padding-horizontal">Имя</td>
									<td class="padding-horizontal">Email</td>
									<td class="padding-horizontal">Профиль</td>
									<td class="padding-horizontal">Конец блокировки</td>
									<td class="padding-horizontal">Описание</td>
									<td class="padding-horizontal">Разблокировать</td>
								</tr>
								</thead>
								<tbody>
								@foreach($users_blocked as $user_b)
									<tr>
										<td class="padding-horizontal small">{{ $user_b->id() }}</td>
										<td class="padding-horizontal small">{{ $user_b->getUser()->getName() }}</td>
										<td class="padding-horizontal small">{{ $user_b->getUser()->getEmail() }}</td>
										<td class="padding-horizontal small">
											@if($user_b->getUser()->getProfile())
												<a href="{{ $user_b->getUser()->getProfile() }}" target="_blank">профиль</a>
											@endif
										</td>
										<td class="padding-horizontal small">{{ $user_b->getDateTo()->format('d M Y H:i') }}</td>
										<td class="padding-horizontal small">{{ $user_b->getDescription() }}</td>
										<td class="padding-horizontal small"><a href="/admin/users/unblock/{{ $user_b->id() }}">
												Разблокировать</a></td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!-- .animated -->
		</div><!-- .content -->

	</div><!-- /#right-panel -->
@endsection

