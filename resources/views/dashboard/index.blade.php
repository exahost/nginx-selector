@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
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
								<tr class="odd gradeX">
									<td><div class="col-md-6 vcenter"><h4>bases.konstanta.ru</h4></div>
									<div class="col-md-6 text-right vcenter tooltip-button">
										<button type="button" class="btn btn-danger btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Выключить"><i class="glyphicon glyphicon-off"></i>
										<button type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
										<button type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
									</div>
									</td>
								</tr>
							</tbody>
						</table>
						<a class="btn btn-success btn-outline btn-block" target="_blank" href="https://datatables.net/">Добавить сервер</a>
					</div>
					<div class="col-md-6">
						<h3 class="page-header">Список серверов назначения</br>
							<small>Указываются сервера, на которые будут приходить HTTP-запросы</small>
						</h3>
						<table width="100%" class="table table-striped table-bordered table-hover" id="server-list-table">
							<thead>
								<tr>
									<th>Сервер</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd gradeX">
									<td><div class="col-md-6 vcenter"><h4>work</h4></div>
									<div class="col-md-6 text-right vcenter tooltip-button">
										<button type="button" class="btn btn-danger btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Выключить"><i class="glyphicon glyphicon-off"></i>
										<button type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
										<button type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
									</div>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td><div class="col-md-6 vcenter"><h4>srv-dev</h4></div>
									<div class="col-md-6 text-right vcenter tooltip-button">
										<button type="button" class="btn btn-success btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Включить"><i class="glyphicon glyphicon-off"></i>
										<button type="button" class="btn btn-warning btn-circle btn-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Редактировать"><i class="glyphicon glyphicon-edit"></i>
										<button type="button" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Удалить"><i class="glyphicon glyphicon-remove"></i>
									</div>
									</td>
								</tr>
							</tbody>
						</table>
						<a class="btn btn-success btn-outline btn-block" target="_blank" href="https://datatables.net/">Добавить сервер</a>
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
                                        <th>Сервер</th>
                                        <th>Активно</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>work</td>
                                        <td>1cwork</td>
                                        <td>yes</td>
                                    <tr class="odd gradeX">
                                        <td>work</td>
                                        <td>1cwork</td>
                                        <td>yes</td>
                                    <tr class="odd gradeX">
                                        <td>work</td>
                                        <td>1cwork</td>
                                        <td>yes</td>
                                    <tr class="odd gradeX">
                                        <td>work</td>
                                        <td>1cwork</td>
                                        <td>yes</td>
                                    </tr>
                                </tbody>
                            </table>
							<a class="btn btn-success btn-outline btn-block" target="_blank" href="https://datatables.net/">Добавить сервер</a>
                <!-- /.col-lg-12 -->
            </div>
            </div>
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Применение значений</br>
						<small>Для генерации конфигурационного файла и применения нажмите кнопку</small>
					</h3>
					<a class="btn btn-warning btn-outline btn-block" target="_blank" href="https://datatables.net/">Применить</a>
					<div class="col-lg-12">&nbsp;</div>
				</div>
			</div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    </div>


@endsection