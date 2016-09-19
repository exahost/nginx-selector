<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerList;
use App\Http\Requests;
use Validator;
use Redirect;

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
		//var_dump($ServerList);
		return view('dashboard.index', ['ServerLists'=>$ServerLists]);
	}
    public function ServerListAddView()	{
		return view('dashboard.ServerLists.form');
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
		
		//var_dump($request->ipv6_enable);exit();
		//Пишем в БД
		if ($request->is_enabled == 'on') {
			$is_enabled=true;
		}
		else {
			$is_enabled=false;
		}
		if ($request->ipv6_enable == 'on') {
			$ipv6_enable=true;
		}
		else {
			$ipv6_enable=false;
		}
		$server = new ServerList;
			$server->name=$request->name;
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ipv6_enable=$this->_convert_checkbox($request->ipv6_enable);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер добавлен');
//		return view('dashboard.ServerLists.form');
	}
    public function ServerListEditView($id)	{
		$server=ServerList::find($id);
		return view('dashboard.ServerLists.form', [
			'server' => $server,
		]);
	}
	public function ServerListEdit(Request $request, $id) {
		$server=ServerList::find($id);
			$server->is_enable=$this->_convert_checkbox($request->is_enabled);
			$server->ipv6_enable=$this->_convert_checkbox($request->ipv6_enable);
			$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер изменен');
	}
    public function ServerListRemove(Request $request, $id)	{
		$server=ServerList::find($id);
		$server->delete();
		return Redirect::to('/')->with('info_message', 'Сервер удален');
	}
    public function ServerListDisable(Request $request, $id)	{
		$server=ServerList::find($id);
		$server->is_enable="0";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер отключен');
	}
    public function ServerListEnable(Request $request, $id)	{
		$server=ServerList::find($id);
		$server->is_enable="1";
		$server->save();
		return Redirect::to('/')->with('info_message', 'Сервер включен');
	}
}
