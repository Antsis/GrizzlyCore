<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class RegisterService
{
	/**
	 * 手机号码注册
	 *
	 * @param string $phone
	 * @param string $password
	 * @return bool
	 */
	public static function phoneInsert(string $phone, string $password)
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
	public static function emailInsert(string $email, string $password)
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
