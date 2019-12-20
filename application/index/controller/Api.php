<?php
namespace app\index\controller;

use app\index\model\Student;
use app\index\model\Teacher;

class Api {
	//student列表
	public function student_all() {
		$student_all = Student::select();
		return json($student_all);
	}

	//teacher列表
	public function teacher_all() {
		$teacher_all = Teacher::select();
		return json($teacher_all);
	}

	//student删除（id）
	public function student_del($id) {
		$student_del2 = Student::destroy(['id' => $id]);
		if ($id == 477) {
			return json("ajax成功！" . $student_del2);
		} else {
			return json("ajax失败！" . $student_del2);
		}

	}

	//不使用数据库
	public function reg($account, $passwd) {
		if ($account == '123') {
			return json("ajax成功！" . $account . "---" . $passwd);
		} else {
			return json("你输出的是其他值：" . $account . "---" . $passwd);
		}
	}

	//student添加
	public function student_add($name, $age) {
		$student_add = new Student;
		$student_add->data([
			'name' => $name,
			'age' => $age,
		]);
		$student_add->save();
		return json("ajax成功！" . $student_add);
	}

	//teacher添加
	public function teacher_add($name, $age) {
		$teacher_add = new Teacher;
		$teacher_add->data([
			'name' => $name,
			'age' => $age,
		]);
		$teacher_add->save();
		return json("ajax成功！" . $teacher_add);
	}

	//student更新
	public function student_upload($id, $name, $age) {
		$student_upload = Student::where(['id' => $id])
			->update([
				'name' => $name,
				'age' => $age,
			]);
		return json("ajax成功！" . $student_upload);
	}
	
	//student查找（name）
	public function student_find($name) {
		$student_find = Student::where('name', '=', $name)
		// ->field('name')
			->find();
		if ($student_find == null) {
			return json("没这个人！" . $student_find);
		} else {
			return json("有这个人！" . $student_find);
		}
	}
}