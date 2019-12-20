<?php
namespace app\index\controller;

use app\index\model\Student;
use app\index\model\Teacher;
use think\View;

//这个Index与php命名与这个html的文件夹要相同，一样大写
class Index {

	public function index() {
		$view = new View();
		//直接数据
		$view->name = 'I love ThinkPHP';
		$view->person = array("name" => "Tom", "age" => "23");

		//根据key值,一般是id。
		$student_key = Student::get(2);
		$student_key = json_encode($student_key);
		echo "<h5>key值：", $student_key, "</h5>";

		// 单查询。
		$student_onefind = Student::where('id', '=', '2')
			->field('name')
			->find();
		$student_onefind = json_encode($student_onefind);
		echo "<h5>单查询：", $student_onefind, "</h5>";

		//多查询
		$student_morefind = Student::all('91, 153, 120');
		$student_morefind = json_encode($student_morefind);
		echo "<h5>多查询：", $student_morefind, "</h5>";

		//字段查询
		$student_ziduan = Student::where('id', '>=', '2')
			->value('name');
		$student_ziduan = json_encode($student_ziduan);
		echo "<h5>字段查询：", $student_ziduan, "</h5>";

		//数量查询
		$student_count = Student::count();
		$student_count = Student::where('id', '>', 1)
			->count();
		$student_count = json_encode($student_count);
		echo "<h5>数量查询：", $student_count, "</h5>";

		//数据添加
		$student_add = Student::create([
			'name' => 'hahaha',
			'age' => 23,
		]);
		$student_add = json_encode($student_add);
		echo "<h5>数据添加:", $student_add, "</h5>";

		//单数据更新
		$student_upload = Student::where(['id' => 120])
			->update([
				'name' => 'Jack',
			]);
		$student_upload = json_encode($student_upload);
		echo "<h5>单数据更新:", $student_upload, "</h5>";

		//多数据更新,这个没数据
		$student_moreupload = new Student;
		$student_moreupload->saveAll([
			['id' => 100, 'name' => 'MIMI'],
			['id' => 101, 'name' => 'jiji'],
		]);
		$student_moreupload = json_encode($student_moreupload);

		echo "<h5>多数据更新:", $student_moreupload, "</h5>";

		//数据删除
		$student_del = Student::destroy(158);
		$student_del = json_encode($student_del);
		echo "<h5>数据删除:", $student_del, "</h5>";

		//数据删除
		$student_del2 = Student::destroy(['id' => 5]);
		$student_del2 = json_encode($student_del2);
		echo "<h5>数据删除:", $student_del2, "</h5>";
		//全数据查询
		$student_all = Student::select();
		// $student_all = json_encode($student_all);
		// echo "<h5>全数据查询:", $student_all, "</h5>";

		//第二个表实验
		$teacher_all = Teacher::select();
		// $teacher_all = json_encode($teacher_all);
		// echo "<h5>第二个表实验:", $teacher_all, "</h5>";

		//第一种，test存数据
		// $test_save = new Student;
		// $test_save->name = 'thinkphp';
		// $test_save->age = '12';
		// $test_save->save();
		// $test_save = json_encode($test_save);
		// echo "<h5>第一种，test存数据:", $test_save, "</h5>";

		//第二种方法
		// $user1 = new Student;
		// $user1->data([
		// 	'name' => 'chen1',
		// 	'age' => '1',
		// ]);
		// $user1->save();
		// $user1 = json_encode($user1);
		// echo "<h5>第二种方法:", $user1, "</h5>";

		//第三种方法
		// $user2 = new Student([
		// 	'name' => 'chen2',
		// 	'age' => '2',
		// ]);
		// $user2->save();
		// $user2 = json_encode($user2);
		// echo "<h5>第三种方法:", $user2, "</h5>";

		//student表
		$view->student_key = $student_key;
		$view->student_onefind = $student_onefind;
		$view->student_morefind = $student_morefind;
		$view->student_ziduan = $student_ziduan;
		$view->student_add = $student_add;
		$view->student_upload = $student_upload;
		$view->student_moreupload = $student_moreupload;
		$view->student_del = $student_del;
		$view->student_all = $student_all;

		//teacher表
		$view->teacher_all = $teacher_all;
		//把视图给呈现出来
		// return $view->fetch('index');
		return $view->fetch();

	}

	//student_all
	public function student_all() {
		$student_all = Student::select();
		return json($student_all);

	}

	//teacher_all
	public function teacher_all() {
		$teacher_all = Teacher::select();
		return json($teacher_all);
	}

	//d
	public function student_del($id) {
		$student_del2 = Student::destroy(['id' => $id]);
		if ($id == 477) {
			return json("ajax成功！" . $student_del2);
		} else {
			return json("ajax失败！" . $student_del2);
		}

	}

	public function reg($account, $passwd) {
		if ($account == '123') {
			return json("ajax成功！" . $account . "---" . $passwd);
		} else {
			return json("你输出的是其他值：" . $account . "---" . $passwd);
		}
	}

	public function student_add($name, $age) {
		$student_add = new Student;
		$student_add->data([
			'name' => $name,
			'age' => $age,
		]);
		$student_add->save();
		return json("ajax成功！" . $student_add);
	}

	public function teacher_add($name, $age) {
		$teacher_add = new Teacher;
		$teacher_add->data([
			'name' => $name,
			'age' => $age,
		]);
		$teacher_add->save();
		return json("ajax成功！" . $teacher_add);
	}
//
	public function student_upload($id, $name, $age) {
		$student_upload = Student::where(['id' => $id])
			->update([
				'name' => $name,
				'age' => $age,
			]);
		return json("ajax成功！" . $student_upload);
	}
//
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
