<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/4
 * Time: 19:16
 */

/**
 * @name ArticleController
 * @author Jason
 * @desc 文章控制器
 */

class ArticleController extends Yaf_Controller_Abstract {
    public function indexAction() {

    }

    /**
     * 新增文章
     * @param int $artId 文章Id
     * @return bool
     */
    public function addAction($artId = 0) {
        if (!Admin_Object::isAdmin()) {
            return Response::json(-2000, "需要管理员权限才能操作");
        }
        // 防止爬虫模拟操作
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            return Response::json(-2001, "请通过正确渠道提交");
        }

        // 获取参数
        $title = $this->getRequest()->getPost("title", '');
        $contents = $this->getRequest()->getPost("contents", '');
        $author = $this->getRequest()->getPost("author", '');
        $cate = $this->getRequest()->getPost("cate", '');

        if (!$title || !$contents || !$author || !$cate) {
            return Response::json(-2002, "标题、内容、作者、分类信息不能为空");
        }

        $model = new ArticleModel();
        if ($lastId = $model->add(trim($title), trim($contents), trim($author), trim($cate), $artId)) {
            return Response::json(0, "", array("lastId" => $lastId));
        } else {
            return Response::json($model->code, $model->message);
        }
    }

    /**
     * 编辑文章
     */
    public function editAction() {
        if( !Admin_Object::isAdmin() ) {
            return Response::json(-2000, "需要管理员权限才能操作");
        }
        $artId = $this->getRequest()->getQuery("artId", "0");
        if (is_numeric($artId) && $artId) {
            return $this->addAction($artId);
        } else {
            return Response::json(-2003, "缺失必要的文章 ID 参数");
        }
    }

    /**
     * 删除文章
     * @return bool
     */
    public function delAction() {
        if (!Admin_Object::isAdmin()) {
            return Response::json(-2000, "需要管理员权限才能操作");
        }
        $artId = $this->getRequest()->getQuery("artId", "0");
        if( is_numeric($artId) && $artId ) {
            $model = new ArticleModel();
            if( $model->del( $artId ) ) {
                return Response::json(0, "删除成功");
            } else {
                return Response::json($model->code, $model->message);
            }
        } else {
            return Response::json(-2003, "缺失必要的文章 ID 参数");
        }
    }

    /**
     * 修改文章状态
     * @return bool
     */
    public function statusAction(){
        if( !Admin_Object::isAdmin() ) {
            return Response::json(-2000, "需要管理员权限才能操作");
        }

        $artId = $this->getRequest()->getQuery( "artId", "0" );
        $status = $this->getRequest()->getQuery( "status", "offline" );

        if( is_numeric($artId) && $artId ) {
            $model = new ArticleModel();
            if( $model->status( $artId, $status ) ) {
                return Response::json(0, "修改成功");
            } else {
                return Response::json($model->code, $model->message);
            }
        } else {
            return Response::json(-2003, "缺失必要的文章 ID 参数");
        }
    }

    /**
     * 获取文章信息
     * @return bool
     */
    public function getAction(){
        $artId = $this->getRequest()->getQuery( "artId", "0" );

        if( is_numeric($artId) && $artId ) {
            $model = new ArticleModel();
            if( $data=$model->get( $artId ) ) {
                return Response::json(0, "", $data);
            } else {
                return Response::json(-2009, "获取文章信息失败");
            }
        } else {
            return Response::json(-2003, "缺失必要的文章 ID 参数");
        }
    }

    /**
     * 获取文章列表
     * @return string
     */
    public function listAction(){
        $pageNo = $this->getRequest()->getQuery( "pageNo", "0" );
        $pageSize = $this->getRequest()->getQuery( "pageSize", "10" );
        $cate = $this->getRequest()->getQuery( "cate", "0" );
        $status = $this->getRequest()->getQuery( "status", "online" );

        $model = new ArticleModel();
        if( $data=$model->artList( $pageNo, $pageSize, $cate, $status ) ) {
            return Response::json(0, "", $data);
        } else {
            return Response::json($model->code, $model->message);
        }
    }
}