@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header">@if (isset($server->name)) Изменить @else Добавить @endif upstream</h4>
						@if (count($errors) > 0)
							@foreach ($errors->all() as $error)
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								{{ $error }}
							</div>
							@endforeach
						@endif
						<form method="POST">
						{{ csrf_field() }}
						<div class="col-lg-6">
							<div class="form-group @if ($errors->has('name')) has-error @endif">
								<p>* Введите алиас upstream (произвольное обозначение upstream, для отображения в списке location)</p>
								<input @if (isset($server->name)) disabled="" @endif class="form-control" placeholder="Upstream1" name="name" @if(old('name')) value="{{ old('name') }}" @elseif (isset($server->name))  value="{{ $server->name }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_enabled" 
									@if(old('is_enabled'))
										checked="checked"
									@elseif(old('name'))
									@else
										@if (isset($server->name))
											@if($server->is_enable)
												checked="checked"
											@elseif (!$server->is_enable)
											@else
											@endif
										@else
											checked="checked"
										@endif
									@endif
									>Включить
								</label>
							</div>
							<div class="form-group @if ($errors->has('ip1')) has-error @endif">
								<p>* Введите IP первого сервера назначения (например, 1.2.3.4:8080)</p>
								<input @if (isset($server->ip1)) @endif class="form-control" placeholder="1.2.3.4:8080" name="ip1" @if(old('ip1')) value="{{ old('ip1') }}" @elseif (isset($server->ip1))  value="{{ $server->ip1 }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_backup_ip1" 
									@if(old('is_backup_ip1'))
										checked="checked"
									@elseif(old('ip1'))
									@else
										@if (isset($server->ip1))
											@if($server->is_backup_ip1)
												checked="checked"
											@elseif (!$server->is_backup_ip1)
											@else
											@endif
										@else
										@endif
									@endif
									>backup
								</label>
							</div>
							<div class="form-group @if ($errors->has('ip2')) has-error @endif">
								<p>* Введите IP второго сервера назначения (например, 1.2.3.4:8080)</p>
								<input @if (isset($server->ip2)) @endif class="form-control" placeholder="1.2.3.4:8080" name="ip2" @if(old('ip2')) value="{{ old('ip2') }}" @elseif (isset($server->ip2))  value="{{ $server->ip2 }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_backup_ip2" 
									@if(old('is_backup_ip2'))
										checked="checked"
									@elseif(old('ip2'))
									@else
										@if (isset($server->ip2))
											@if($server->is_backup_ip2)
												checked="checked"
											@elseif (!$server->is_backup_ip2)
											@else
											@endif
										@else
										@endif
									@endif
									>backup
								</label>
							</div>
							<div class="form-group @if ($errors->has('ip3')) has-error @endif">
								<p>* Введите IP третьего сервера назначения (например, 1.2.3.4:8080)</p>
								<input @if (isset($server->ip3)) @endif class="form-control" placeholder="1.2.3.4:8080" name="ip3" @if(old('ip3')) value="{{ old('ip3') }}" @elseif (isset($server->ip3))  value="{{ $server->ip3 }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_backup_ip3" 
									@if(old('is_backup_ip3'))
										checked="checked"
									@elseif(old('ip3'))
									@else
										@if (isset($server->ip3))
											@if($server->is_backup_ip3)
												checked="checked"
											@elseif (!$server->is_backup_ip3)
											@else
											@endif
										@else
										@endif
									@endif
									>backup
								</label>
							</div>
							<div class="form-group @if ($errors->has('ip4')) has-error @endif">
								<p>* Введите IP четвертого сервера назначения (например, 1.2.3.4:8080)</p>
								<input @if (isset($server->ip4)) @endif class="form-control" placeholder="1.2.3.4:8080" name="ip4" @if(old('ip4')) value="{{ old('ip4') }}" @elseif (isset($server->ip4))  value="{{ $server->ip4 }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_backup_ip4" 
									@if(old('is_backup_ip4'))
										checked="checked"
									@elseif(old('ip4'))
									@else
										@if (isset($server->ip4))
											@if($server->is_backup_ip4)
												checked="checked"
											@elseif (!$server->is_backup_ip4)
											@else
											@endif
										@else
										@endif
									@endif
									>backup
								</label>
							</div>
							<button type="submit" class="btn btn-outline btn-success btn-block">@if (isset($server->name)) Изменить @else Добавить @endif</button>
						</div>
						</form>
                    </div>
                    <!-- /.col-lg-12 -->
					<div class="col-lg-12">&nbsp;</div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
@endsection