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
$libPath = dirname(__FILE__).'/../library/';
require_once ($libPath . 'common.php');

class ArticleController extends Yaf_Controller_Abstract {
    public function indexAction() {

    }

    /**
     * 新增文章
     * @return bool
     */
    public function addAction($artId = 0) {
        if (!$this->_isAdmin()) {
            echo json(-2000, "需要管理员权限才能操作");
            return false;
        }
        // 防止爬虫模拟操作
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            echo json(-2001, "请通过正确渠道提交");
            return false;
        }

        // 获取参数
        $title = $this->getRequest()->getPost("title", '');
        $contents = $this->getRequest()->getPost("contents", '');
        $author = $this->getRequest()->getPost("author", '');
        $cate = $this->getRequest()->getPost("cate", '');

        if (!$title || !$contents || !$author || !$cate) {
            echo json(-2002, "标题、内容、作者、分类信息不能为空");
            return false;
        }

        $model = new ArticleModel();
        if ($lastId = $model->add(trim($title), trim($contents), trim($author), trim($cate), $artId)) {
            echo json(0, "", array("lastId" => $lastId));
        } else {
            echo json($model->errno, $model->errmsg);
        }
        return true;
    }

    /**
     * 编辑文章
     */
    public function editAction() {
        if( !$this->_isAdmin() ) {
            echo json_encode(array("errno"=>-2000, "errmsg"=>"需要管理员权限才可以操作"));
            return false;
        }
        $artId = $this->getRequest()->getQuery("artId", "0");
        if (is_numeric($artId) && $artId) {
            return $this->addAction($artId);
        } else {
            echo json(-2003, "缺失必要的文章 ID 参数");
        }
        return true;
    }

    /**
     * 删除文章
     * @return bool
     */
    public function delAction() {
        if (!$this->_isAdmin()) {
            echo json(-2000, "需要管理员权限才能操作");
            return false;
        }
        $artId = $this->getRequest()->getQuery("artId", "0");
        if( is_numeric($artId) && $artId ) {
            $model = new ArticleModel();
            if( $model->del( $artId ) ) {
                echo json(0, "删除成功");
            } else {
                echo json($model->errno, $model->errmsg);
            }
        } else {
            echo json(-2003, "缺失必要的文章 ID 参数");
        }
        return true;
    }

    /**
     * 修改文章状态
     * @return bool
     */
    public function statusAction(){
        if( !$this->_isAdmin() ) {
            echo json(-2000, "需要管理员权限才能操作");
            return false;
        }

        $artId = $this->getRequest()->getQuery( "artId", "0" );
        $status = $this->getRequest()->getQuery( "status", "offline" );

        if( is_numeric($artId) && $artId ) {
            $model = new ArticleModel();
            if( $model->status( $artId, $status ) ) {
                echo json(0, "修改成功");
            } else {
                echo json($model->errno, $model->errmsg);
            }
        } else {
            echo json(-2003, "缺失必要的文章 ID 参数");
        }
        return true;
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
                echo json(0, "", $data);
            } else {
                echo json(-2009, "获取文章信息失败");
            }
        } else {
            echo json(-2003, "缺失必要的文章 ID 参数");
        }
        return true;
    }
    public function listAction(){
        $pageNo = $this->getRequest()->getQuery( "pageNo", "0" );
        $pageSize = $this->getRequest()->getQuery( "pageSize", "10" );
        $cate = $this->getRequest()->getQuery( "cate", "0" );
        $status = $this->getRequest()->getQuery( "status", "online" );

        $model = new ArticleModel();
        if( $data=$model->artList( $pageNo, $pageSize, $cate, $status ) ) {
            echo json(0, "", $data);
        } else {
            echo json($model->errno, $model->errmsg);
        }
        return true;
    }
    private function _isAdmin(){
        return true;
    }
}