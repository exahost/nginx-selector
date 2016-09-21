@extends('layouts.app')
@include('dashboard.menu')

@section('content')
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="page-header">@if (isset($server->name)) Изменить @else Добавить @endif сервер</h4>
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
								<p>* Введите имя сервера без http/https:</p>
								<input @if (isset($server->name)) disabled="" @endif class="form-control" placeholder="example.com" name="name" @if(old('name')) value="{{ old('name') }}" @elseif (isset($server->name))  value="{{ $server->name }}" @else @endif>
							</div>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="is_enabled" 
									@if(old('is_enabled'))
										checked="checked"
									@elseif(old('_token'))
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
								<label class="checkbox-inline">
									<input type="checkbox" name="ipv6_enable"
									@if(old('ipv6_enable'))
										checked="checked"
									@elseif(old('_token'))
									@else
										@if (isset($server->name))
											@if($server->ipv6_enable)
												checked="checked"
											@elseif (!$server->ipv6_enable)
											@else
											@endif
										@else
											checked="checked"
										@endif
									@endif
									>IPv6
								</label>
							</div>
							<button type="submit" class="btn btn-outline btn-success btn-block">@if (isset($server->name)) Изменить @else Добавить @endif</button>
						</div>
						</form>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
@endsection