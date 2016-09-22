<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerList;
use App\Models\UpstreamList;
use App\Models\LocationList;
use App\Http\Requests;
use Validator;
use Redirect;
use DB;
use Storage;

class Dashboard extends Controller
{
	protected function _convert_checkbox($value) {
		if ($value == 'on') {
			return true;
		}
		else {
			return false;
		}
	}
    public function index()	{
		$ServerLists=ServerList::all();
		$UpstreamLists=UpstreamList::all();
		$LocationLists=LocationList::all();
		//var_dump($ServerList);
		return view('dashboard.index', ['ServerLists'=>$ServerLists, 'UpstreamLists'=>$UpstreamLists, 'LocationLists'=>$LocationLists]);
	}
    public function ServerListAddView()	{
		return view('dashboard.ServerLists.form');
	}
    public function UpstreamListAddView()	{
		return view('dashboard.UpstreamLists.form');
	}
    public function LocationListAddView()	{
		$ServerLists=ServerList::all();
		$UpstreamLists=UpstreamList::all();
		return view('dashboard.LocationLists.form', ['ServerLists'=>$ServerLists, 'UpstreamLists'=>$UpstreamLists]);
	}
    public function ServerListAdd(Request $request)	{
		//Валидация введенных данных
		$this->validate($request, [
			'name' => 'required|max:255|min:3|unique:server_lists', 
		],[
			'required' => 'Ввод имени сервера обязателен',
			'max' => 'Максимальное количество символов имени сервера 255',
			'min' => 'Очень маленькое имя сервера',
			'unique' => 'Такое имя сервера уже используется',
		]);
		
		//Пишем в БД
		$server = new ServerList;
			$server->name=$request->name;
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ipv6_enable=$this->_convert_checkbox($request->ipv6_enable);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер добавлен');
	}
    public function UpstreamListAdd(Request $request)	{
		//Валидация введенных данных
		$this->validate($request, [
			'name' => 'required|max:255|min:3|unique:upstream_lists', 
			'ip1' => array('required', 'regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip2' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip3' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip4' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
		],[
			'regex' => 'Неправильный формат IP',
			'required' => 'Ввод обязателен',
			'max' => 'Максимальное количество символов алиаса сервера 255',
			'min' => 'Очень маленький алиаса сервера',
			'unique' => 'Такой алиас уже используется',
		]);
		
		//Пишем в БД
		$server = new UpstreamList;
			$server->name=$request->name;
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ip1=$request->ip1;
			$server->ip2=$request->ip2;
			$server->is_backup_ip2=$this->_convert_checkbox($request->is_backup_ip2);
			$server->ip3=$request->ip3;
			$server->is_backup_ip3=$this->_convert_checkbox($request->is_backup_ip3);
			$server->ip4=$request->ip4;
			$server->is_backup_ip4=$this->_convert_checkbox($request->is_backup_ip4);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Upstream добавлен');
	}
    public function LocationListAdd(Request $request)	{
		//Валидация введенных данных
		$this->validate($request, [
			'location' => array('required', 'unique:location_lists,location,NULL,id,server_lists_id,'.$request->serverlist.'', 'max:255', 'regex:/^\//'), 
			'upstream' => 'required', 
			'serverlist' => 'required', 
		],[
			'regex' => 'Неправильный формат ввода, начните с /',
			'required' => 'Ввод обязателен',
			'max' => 'Максимальное количество символов - 255',
		]);
		
		//Пишем в БД
		$server = new LocationList;
			$server->location=$request->location;
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->server_lists_id=$request->serverlist;
			$server->upstream_lists_id=$request->upstream;
			$server->save();
		return Redirect::to('/')->with('info_message', 'Location добавлен');
	}
    public function ServerListEditView($id)	{
		$server=ServerList::find($id);
		return view('dashboard.ServerLists.form', [
			'server' => $server,
		]);
	}
    public function UpstreamListEditView($id)	{
		$server=UpstreamList::find($id);
		return view('dashboard.UpstreamLists.form', [
			'server' => $server,
		]);
	}
    public function LocationListEditView($id)	{
		$LocationLists=LocationList::find($id);
		$UpstreamLists=UpstreamList::all();
		$ServerLists=ServerList::all();
		return view('dashboard.LocationLists.form', [
			'ServerLists' => $ServerLists,
			'UpstreamLists' => $UpstreamLists,
			'location' => $LocationLists,
		]);
	}
	public function ServerListEdit(Request $request, $id) {
		$server=ServerList::find($id);
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ipv6_enable=$this->_convert_checkbox($request->ipv6_enable);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер изменен');
	}
	public function UpstreamListEdit(Request $request, $id) {
		//Валидация введенных данных
		$this->validate($request, [
			'ip1' => array('required', 'regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip2' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip3' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
			'ip4' => array('regex:/^(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)(:[0-9]{2,5})?$/'), 
		],[
			'regex' => 'Неправильный формат IP',
			'required' => 'Ввод обязателен',
			'max' => 'Максимальное количество символов алиаса сервера 255',
			'min' => 'Очень маленький алиаса сервера',
			'unique' => 'Такой алиас уже используется',
		]);
		
		$server=UpstreamList::find($id);
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ip1=$request->ip1;
			$server->ip2=$request->ip2;
			$server->is_backup_ip2=$this->_convert_checkbox($request->is_backup_ip2);
			$server->ip3=$request->ip3;
			$server->is_backup_ip3=$this->_convert_checkbox($request->is_backup_ip3);
			$server->ip4=$request->ip4;
			$server->is_backup_ip4=$this->_convert_checkbox($request->is_backup_ip4);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер изменен');
	}
	public function LocationListEdit(Request $request, $id) {
		//Валидация введенных данных
		$this->validate($request, [
			'location' => array('required', 'unique:location_lists,location,'.$id.',id,server_lists_id,'.$request->serverlist.'', 'max:255', 'regex:/^\//'), 
			'upstream' => 'required', 
			'serverlist' => 'required', 
		],[
			'regex' => 'Неправильный формат ввода, начните с /',
			'required' => 'Ввод обязателен',
			'max' => 'Максимальное количество символов - 255',
		]);
		
		//Пишем в БД
		$server = LocationList::find($id);
			$server->location=$request->location;
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->server_lists_id=$request->serverlist;
			$server->upstream_lists_id=$request->upstream;
			$server->save();
		return Redirect::to('/')->with('info_message', 'Location изменен');
	}
    public function ServerListRemove(Request $request, $id)	{
		if (LocationList::where('server_lists_id','=',$id)->first()) {
			return Redirect::to('/')->with('warning_message', 'Невозможно удалить сервер, к нему привязан location');
		}
		$server=ServerList::find($id);
		$server->delete();
		return Redirect::to('/')->with('info_message', 'Сервер удален');
	}
    public function UpstreamListRemove(Request $request, $id)	{
		if (LocationList::where('upstream_lists_id','=',$id)->first()) {
			return Redirect::to('/')->with('warning_message', 'Невозможно удалить upstream, к нему привязан location');
		}
		$server=UpstreamList::find($id);
		$server->delete();
		return Redirect::to('/')->with('info_message', 'Upstream удален');
	}
    public function LocationListRemove(Request $request, $id)	{
		$server=LocationList::find($id);
		$server->delete();
		return Redirect::to('/')->with('info_message', 'Location удален');
	}
    public function ServerListDisable(Request $request, $id)	{
		$server=ServerList::find($id);
		$server->is_enable="0";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер отключен');
	}
    public function UpstreamListDisable(Request $request, $id)	{
		$server=UpstreamList::find($id);
		$server->is_enable="0";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Upstream отключен');
	}
    public function LocationListDisable(Request $request, $id)	{
		$server=LocationList::find($id);
		$server->is_enable="0";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Location отключен');
	}
    public function ServerListEnable(Request $request, $id)	{
		$server=ServerList::find($id);
		$server->is_enable="1";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер включен');
	}
    public function UpstreamListEnable(Request $request, $id)	{
		$server=UpstreamList::find($id);
		$server->is_enable="1";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Upstream включен');
	}
    public function LocationListEnable(Request $request, $id)	{
		$server=LocationList::find($id);
		$server->is_enable="1";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Location включен');
	}
	public function GenerateAndApply() {
		$ServerLists=ServerList::all();
		$UpstreamLists=UpstreamList::all();
		$LocationLists=LocationList::all();

		if($ServerLists->count() == 0 || $ServerLists->where('is_enable','=',1)->count() == 0) {
			return Redirect::to('/')->with('error_message', 'Ошибка, отсутсвуют включенные сервера');
		}
		if($UpstreamLists->count() == 0 || $UpstreamLists->where('is_enable','=',1)->count() == 0) {
			return Redirect::to('/')->with('error_message', 'Ошибка, отсутсвуют включенные upstream');
		}
		if($LocationLists->count() == 0 || $LocationLists->where('is_enable','=',1)->count() == 0) {
			return Redirect::to('/')->with('error_message', 'Ошибка, отсутсвуют включенные location');
		}
		
		$disk = Storage::disk('nginx');
		$upstream_conf_file = '000-upstream.conf';
		$server_conf_file = '001-servers.conf';
		
		Storage::disk('nginx')->makeDirectory('backup');
		if (Storage::disk('nginx')->exists($upstream_conf_file)) {
			Storage::disk('nginx')->move($upstream_conf_file, 'backup/'.date('d.m.Y-H.i.s').'_'.$upstream_conf_file);
		}
		
		Storage::disk('nginx')->put($upstream_conf_file, '');
		foreach ($UpstreamLists as $upstream) {
			if (!empty($upstream->ip2)) {
				if ($upstream->is_backup_ip2) {
					$ip2 = '
	server '.$upstream->ip2.' backup;';
				}
				else {
					$ip2 = '
	server '.$upstream->ip2.';';
				}
			}
			else {
				$ip2 = '';
			}
			if (!empty($upstream->ip3)) {
				if ($upstream->is_backup_ip3) {
					$ip3 = '
	server '.$upstream->ip3.' backup;';
				}
				else {
					$ip3 = '
	server '.$upstream->ip3.';';
				}
			}
			else {
				$ip3 = '';
			}
			if (!empty($upstream->ip4)) {
				if ($upstream->is_backup_ip4) {
					$ip4 = '
	server '.$upstream->ip4.' backup;';
				}
				else {
					$ip4 = '
	server '.$upstream->ip4.';';
				}
			}
			else {
				$ip4 = '';
			}
$content_upstream = "upstream $upstream->name {
	server $upstream->ip1 fail_timeout=5s; $ip2 $ip3 $ip4
}
";
			Storage::disk('nginx')->append($upstream_conf_file, $content_upstream);
		}

		if (Storage::disk('nginx')->exists($server_conf_file)) {
			Storage::disk('nginx')->move($server_conf_file, 'backup/'.date('d.m.Y-H.i.s').'_'.$server_conf_file);
		}
		
		Storage::disk('nginx')->put($server_conf_file, '');
		
		foreach ($ServerLists as $server_list) {
			$LocationsForThisServer=LocationList::where('server_lists_id','=',$server_list->id);
			if ($server_list->is_enable and $LocationsForThisServer->count() > 0) {
				if ($server_list->ipv6_enable) {
					$ipv6 = '
	listen       [::]:80;';
				}
				else {
					$ipv6 = '';
				}

				$location = '';
				$location_proxy = '';
				foreach ($LocationsForThisServer->get() as $LocationForThisServer) {
					$upstream_for_this = UpstreamList::where('id','=',$LocationForThisServer->upstream_lists_id)->first();
					$location .= "	location $LocationForThisServer->location {
        try_files \$uri @$upstream_for_this->name;
    }
";
				}
				
				foreach ($LocationsForThisServer->select('upstream_lists_id')->distinct()->get() as $LocationForThisServer) {
					$upstream_uniq_for_this = UpstreamList::where('id','=',$LocationForThisServer->upstream_lists_id)->first();
					$location_proxy .= "location @$upstream_uniq_for_this->name {
		proxy_pass http://$upstream_uniq_for_this->name;
		proxy_set_header Host \$host;
		proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
		proxy_set_header X-Forwarded-Proto \$scheme;
		proxy_set_header X-Real-IP \$remote_addr;
	}";
				}
				
				$content_server = "server {
    listen       80; $ipv6
    server_name  $server_list->name www.$server_list->name;

$location

	$location_proxy
}";
				Storage::disk('nginx')->append($server_conf_file, $content_server);
			}
		}

		// Тут релоадим конфиг
		
		return Redirect::to('/')->with('success_message', 'Конфигурационный файл сгенерирован, nginx перезапущен');
	}
}
