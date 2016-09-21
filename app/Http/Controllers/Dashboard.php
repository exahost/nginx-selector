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
		

		return Redirect::to('/')->with('success_message', 'Конфигурационный файл сгенерирован, nginx перезапущен');
	}
}
