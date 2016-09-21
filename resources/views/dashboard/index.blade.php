@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
			@if(Session::has('info_message'))
				<div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{!!Session::get('info_message')!!}
				</div>
			@endif
			@if(Session::has('warning_message'))
				<div class="alert alert-warning alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{!!Session::get('warning_message')!!}
				</div>
			@endif
				<div class="row">
					<div class="col-md-6">
						<h3 class="page-header">Список доменных имен</br>
							<small>Указываются доменные имена, которые будут проксировать запросы к серверам назначения</small>
						</h3>
						<table width="100%" class="table table-striped table-bordered table-hover" id="server-list-table">
							<thead>
								<tr>
									<th>Сервер</th>
								</tr>
							</thead>
							<tbody>
							@foreach($ServerLists as $server)
								<tr class="odd gradeX">
									<td><div class="col-md-6 vcenter"><h4>{{$server->name}}</h4></div>
									<div class="col-md-6 text-right vcenter tooltip-button">
										@if ($server->is_enable)
												<button onclick="location.href='/server_list/disable/{{$server->id}}'" type="button" class="btn btn-danger btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Выключить"><i class="glyphicon glyphicon-off"></i>
										@else
												<button onclick="location.href='/server_list/enable/{{$server->id}}'" type="button" class="btn btn-success btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Включить"><i class="glyphicon glyphicon-off"></i>
										@endif
											<button onclick="location.href='/server_list/edit/{{$server->id}}'" type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
											<button onclick="location.href='/server_list/remove/{{$server->id}}'" type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
									</div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						<a class="btn btn-success btn-outline btn-block" href="/server_list/add">Добавить сервер</a>
					</div>
					<div class="col-md-6">
						<h3 class="page-header">Список upstream</br>
							<small>Указываются сервера, на которые будут приходить HTTP-запросы</small>
						</h3>
						<table width="100%" class="table table-striped table-bordered table-hover" id="server-list-table">
							<thead>
								<tr>
									<th>Сервер</th>
								</tr>
							</thead>
							<tbody>
							@foreach($UpstreamLists as $upstream)
								<tr class="odd gradeX">
									<td><div class="col-md-6 vcenter"><h4>{{$upstream->name}}</h4></div>
									<div class="col-md-6 text-right vcenter tooltip-button">
										@if ($upstream->is_enable)
												<button onclick="location.href='/upstream_list/disable/{{$upstream->id}}'" type="button" class="btn btn-danger btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Выключить"><i class="glyphicon glyphicon-off"></i>
										@else
												<button onclick="location.href='/upstream_list/enable/{{$upstream->id}}'" type="button" class="btn btn-success btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Включить"><i class="glyphicon glyphicon-off"></i>
										@endif
											<button onclick="location.href='/upstream_list/edit/{{$upstream->id}}'" type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
											<button onclick="location.href='/upstream_list/remove/{{$upstream->id}}'" type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
									</div>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
						<a class="btn btn-success btn-outline btn-block" href="/upstream_list/add">Добавить upstream</a>
					</div>
				</div>			
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Список location</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				
				            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="location-table">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Upstream</th>
                                        <th>URL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
								@foreach($LocationLists as $location)
                                    <tr class="odd gradeX">
                                        <td>{{$location->location}}</td>
                                        <td>
											@foreach($UpstreamLists as $upstream)
												@if ($upstream->id == $location->upstream_lists_id)
													{{$upstream->name}}
												@endif
											@endforeach
										</td>
                                        <td>
											@foreach($ServerLists as $server)
												@if ($server->id == $location->server_lists_id)
													 <?php $url_server = $server->name; ?>
												@endif
											@endforeach
											<a target="_blank" href="http://<?php echo $url_server; ?>{{$location->location}}" >http://<?php echo $url_server; ?>{{$location->location}}</a>
										</td>
                                        <td>
											<div class="text-right vcenter tooltip-button">
										@if ($location->is_enable)
												<button onclick="location.href='/location_list/disable/{{$location->id}}'" type="button" class="btn btn-danger btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Выключить"><i class="glyphicon glyphicon-off"></i>
										@else
												<button onclick="location.href='/location_list/enable/{{$location->id}}'" type="button" class="btn btn-success btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Включить"><i class="glyphicon glyphicon-off"></i>
										@endif
											<button onclick="location.href='/location_list/edit/{{$location->id}}'" type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
											<button onclick="location.href='/location_list/remove/{{$location->id}}'" type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
											</div>
										</td>
                                    </tr>
								@endforeach
                                </tbody>
                            </table>
							<a class="btn btn-success btn-outline btn-block" href="/location_list/add">Добавить location</a>
                <!-- /.col-lg-12 -->
            </div>
            </div>
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Применение значений</br>
						<small>Для генерации конфигурационного файла и применения нажмите кнопку</small>
					</h3>
					<a class="btn btn-warning btn-outline btn-block" href="/">Применить</a>
					<div class="col-lg-12">&nbsp;</div>
				</div>
			</div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    </div>


@endsection