<?php
namespace app\index\controller;

use app\index\model\Login;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Token {

	public function checkToken() {
		$user = new Login;
		$res = $user->field('time_out')->where('token', $token)->select();
		$res = $user->where('token', $token)->find();
		return $res;
		if (!empty($res)) {
			//dump(time() - $res[0]['time_out']);
			if (time() - $res[0]['time_out'] > 0) {

				return 90003; //token长时间未使用而过期，需重新登陆
			}
			$new_time_out = time() + 604800; //604800是七天
			$res = $user->isUpdate(true)
				->where('token', $token)
				->update(['time_out' => $new_time_out]);
			if ($res) {

				return 90001; //token验证成功，time_out刷新成功，可以获取接口信息

			}
		}
		return 90002; //token错误验证失败
	}

	public function douserLogin($username, $password) {
		$user = new Login;
		$userisset = $user->where('username', $username)->find();

		if ($userisset == null) {
			return json('{"user":"' . $username . '","code":"400","msg":"用户不存在"}');
		} else {
			$userpsisset = $user
				->where('username', $username)
				->where('password', $password)->find();
			if ($userpsisset == null) {
				return ('{"user":"' . $username . '","code":"401","msg":"密码错误"}');
			} else {
				//session('user', $username);
				$token = $this->makeToken();
				$time_out = strtotime("+7 days");
				// $new_time_out = time() + 604800; //604800是七天
				$new_time_out = date("Y-m-d H:i:s", (time() + 604800));
				$userinfo = ['time_out' => $new_time_out,
					'token' => $token];
				$res = $user->isUpdate(true)
					->where('username', $username)
					->update($userinfo);
				if ($res) {
					return json('{"user":"' . $username . '","token":"' . $token . '","code":"0","msg":"登录成功"}');
				}
			}
		}
	}

	public function makeToken() {
		$str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
		$str = sha1($str); //加密
		return $str;
	}

	public function tryToken($token) {
		$user = new Login;
		$res = $user->field('time_out')->where('token', $token)->select();
		// return date("Y-m-d H:i:s");
		$time_out = $res[0]['time_out'];
		$time = strtotime($time_out);
		// return json(time()-$time);
		// return json(time());
		if (!empty($res)) {
			// return json(time() - $time);
			if (time() - $time > 0) {
				return 90003; //token长时间未使用而过期，需重新登陆
			}
			// $new_time_out = time() + 604800; //604800是七天
			$new_time_out = date("Y-m-d H:i:s", (time() + 604800));
			$res = $user->isUpdate(true)
				->where('token', $token)
				->update(['time_out' => $new_time_out]);
			if ($res) {
				return 90001; //token验证成功，time_out刷新成功，可以获取接口信息
			}
		}
		return 90002; //token错误验证失败

	}

}