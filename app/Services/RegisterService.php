<?php
namespace App\Services;

use App\Http\Tools\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class RegisterService
{
	/**
	 * 手机号码注册
	 *
	 * @param string $phone
	 * @param string $password
	 * @return bool
	 */
	public static function phoneInsert(String $phone, String $password)
	{
		$time = date('Y-m-d H:i:s');
		$password = bcrypt($password);
		$id = DB::table('users')->insertGetId([
			'phone' => $phone,
			'password' => $password,
		]);
		$result = DB::table('users')
						->select(
							'id',
							'is_admin',
						)
						->where('id', '=', $id)
						->first();
		return $result;
	}
	
	/**
	 * 邮箱注册
	 * 
	 * @param string $email
	 * @param string $password
	 * @return object
	 */
	public static function emailInsert(String $email, String $password): array
	{
		$time = date('Y-m-d H:i:s');
		$password = bcrypt($password);
		$id = DB::table('users')
					->insertGetId([
					'phone' => $email,
					'password' => $password,
				]);
		$result = DB::table('users')
						->select(
							'id',
							'is_admin',
						)
						->where('id', '=', $id)
						->first();
		return $result;
	}
}
