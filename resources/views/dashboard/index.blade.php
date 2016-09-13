@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Список location</h1>
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
							<div class="panel panel-info">
								<div class="panel-heading">
                                <h4>Применение значений</h4>
								</div>
								<div class="panel-body">
                                <p>Для генерации конфигурационного файла и применения его нажмите кнопку</p>
                                <a class="btn btn-info btn-outline btn-block" target="_blank" href="https://datatables.net/">Применить</a>
								</div>
                            </div>
                <!-- /.col-lg-12 -->
            </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    </div>


@endsection