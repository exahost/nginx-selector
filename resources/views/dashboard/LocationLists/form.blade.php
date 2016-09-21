@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header">@if (isset($location->location)) Изменить @else Добавить @endif location</h4>
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
							<div class="form-group @if ($errors->has('location')) has-error @endif">
								<p>* Введите location (обязательно начать с /):</p>
								<input class="form-control" placeholder="/location" name="location" @if(old('location')) value="{{ old('location') }}" @elseif (isset($location->location))  value="{{ $location->location }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_enabled" 
									@if(old('is_enabled'))
										checked="checked"
									@elseif(old('_token'))
									@else
										@if (isset($location->location))
											@if($location->is_enable)
												checked="checked"
											@elseif (!$location->is_enable)
											@else
											@endif
										@else
											checked="checked"
										@endif
									@endif
									>Включить
								</label>
							</div>
							<div class="form-group @if ($errors->has('upstream')) has-error @endif">
							<p>* Выберите upstream:</p>
								<select class="form-control" name="upstream">
								@foreach ($UpstreamLists as $upstream)
									<option
									@if($upstream->id == old('upstream'))
										selected
									@elseif(!old('upstream'))
										@if (isset($location->location))
											@if($location->upstream_lists_id == $upstream->id)
												selected
											@endif
										@endif
									@else
									@endif
										value="{{$upstream->id}}">{{$upstream->name}}</option>
								@endforeach
								</select>
							</div>
							<div class="form-group @if ($errors->has('serverlist')) has-error @endif">
							<p>* Выберите доменное имя:</p>
								<select class="form-control" name="serverlist">
								@foreach ($ServerLists as $server)
									<option 
									@if($server->id == old('serverlist'))
										selected
									@elseif(!old('serverlist'))
										@if (isset($location->location))
											@if($location->server_lists_id == $server->id)
												selected
											@endif
										@endif
									@else
									@endif
										value="{{$server->id}}">{{$server->name}}</option>
								@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-outline btn-success btn-block">@if (isset($location->location)) Изменить @else Добавить @endif</button>
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