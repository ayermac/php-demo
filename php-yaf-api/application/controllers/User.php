<?php
/**
 * @name userController
 * @author Jason
 * @desc 用户控制器
 */

class UserController extends Yaf_Controller_Abstract {


	public function indexAction() {
        $this->loginAction();
	}

    /**
     * 用户登录
     * @return bool
     */
	public function loginAction() {
	    // 防止爬虫模拟登录
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            return Response::json(-1001, "请通过正确渠道提交");
        }

        // 获取参数
        $uname = $this->getRequest()->getPost("uname", '');
        $pwd = $this->getRequest()->getPost("pwd", '');
        if (!$uname || !$pwd) {
            return Response::json(-1002, "用户名和密码不能为空");
        }
        // 调用Model，做登录验证
        $model = new UserModel();
        $uid = $model->login(trim($uname), trim($pwd));
        if ($uid) {
            // 存入 session
            session_start();
            $_SESSION['user_token'] = md5("salt".$_SERVER['REQUEST_TIME'].$uid);
            $_SESSION['user_token_time'] = $_SERVER['REQUEST_TIME'];
            $_SESSION['user_id'] = $uid;
            return Response::json(0, "", array("name" => $uname));
        } else {
            return Response::json($model->code, $model->message);
        }
    }
    /**
     * 用户注册
     * @return bool
     */
	public function registerAction() {
	    // 获取参数
        $uname = $this->getRequest()->getPost("uname", '');
        $pwd = $this->getRequest()->getPost("pwd", '');

	    if (!$uname || !$pwd) {
            return Response::json(-1002, "用户名和密码不能为空");
        }
        // 调用Model，做注册验证
        $model = new UserModel();
	    if ($model->register(trim($uname), trim($pwd))) {
            return Response::json(0, "", array("name" => $uname));
        } else {
            return Response::json($model->code, $model->message);
        }
    }
}
