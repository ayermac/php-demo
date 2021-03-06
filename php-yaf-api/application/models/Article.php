<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/4
 * Time: 19:16
 */
/**
 * 文章 Model 类
 * Class ArticleModel
 */
require __DIR__.'/../../vendor/autoload.php';

class ArticleModel
{
    public $code = 0;
    public $message = "";
    private $_db = null;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
        /**
         * 不设置下面这行的话，PDO 会在拼 SQL 的时候，把 int 0 转成 string 0
         */
        $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }


    /**
     * 新增文章
     * @param string $title 标题
     * @param string $contents 内容
     * @param string $author 作者
     * @param int $cate 分类
     * @param int $artId 文章 id
     * @return bool|int
     */
    public function add($title, $contents, $author, $cate, $artId = 0) {
        // 是否是编辑操作
        $isEdit = false;
        if ($artId !=0 && is_numeric($artId)) {
            $query = $this->_db->prepare("select count(*) from `art` where `id`= ? ");
            $query->execute(array($artId));
            $ret = $query->fetchAll();
            if (!$ret || count($ret)!=1) {
                $this->code = -2004;
                $this->message = "找不到你要编辑的文章！";
                return false;
            }
            $isEdit = true;
        } else {
            /**
             * 检测分类 cate 是否存在
             * 如果是编辑文章，分类之前创建过，此处可不必再做校验
             */
            $redis = new Predis\Client();
            $redisKey = 'cateExists-'.$cate;
            $redisValue = 1;
            if (!$redis->get($redisKey)) {
                $query = $this->_db->prepare("select count(*) from `cate` where `id`= ? ");
                $query->execute(array($cate));
                $ret = $query->fetchAll();
                if (!$ret || $ret[0][0] == 0) {
                    $this->code = -2005;
                    $this->message = "找不到对应ID的分类信息，cate id:" . $cate . ", 请先创建该分类。";
                    return false;
                } else {
                    $redis->set($redisKey, $redisValue);
                }
            }
        }

        /**
         * 插入或更新文章内容
         */
        $data = array($title, $contents, $author, intval($cate));
        if (!$isEdit) {
            $query = $this->_db->prepare("insert into `art` (`title`, `contents`, `author`, `cate`) VALUES (?, ?, ?, ?)");
        } else {
            $query = $this->_db->prepare("update `art` set `title`=?, `contents`=?, `author`=?, `cate`=? where `id`= ?");
            $data[] = $artId;
        }
        $ret = $query->execute($data);
        if (!$ret) {
            $this->code = -2006;
            $this->message = "操作文章数据表失败, ErrInfo:".end($query->errorInfo());
            return false;
        }
        /**
         * 返回文章最后的ID值
         */
        if(!$isEdit) {
            return intval($this->_db->lastInsertId());
        } else {
            return intval($artId);
        }
    }

    /**
     * 删除文章
     * @param int $artId
     * @return bool
     */
    public function del( $artId ){
        $query = $this->_db->prepare("delete from `art` where `id`=? ");
        $ret = $query->execute( array(intval($artId)) );
        if( !$ret ) {
            $this->code = -2007;
            $this->message = "删除失败, ErrInfo:".end($query->errorInfo());
            return false;
        }
        return true;
    }

    /**
     * 修改状态
     * @param int $artId
     * @param string $status
     * @return bool
     */
    public function status( $artId, $status="offline" ){
        $query = $this->_db->prepare("update `art` set `status`=? where `id`=? ");
        $ret = $query->execute( array( $status, intval($artId)) );
        if( !$ret ) {
            $this->code = -2008;
            $this->message = "更新文章状态失败, ErrInfo:".end($query->errorInfo());
            return false;
        }
        return true;
    }

    /**
     * 获取文章信息
     * @param int $artId
     * @return array|bool
     */
    public function get( $artId ){
        $query = $this->_db->prepare("select `title`,`contents`,`author`,`cate`,`ctime`,`mtime`,`status` from `art` where `id`=? ");
        $status = $query->execute( array( intval($artId)) );
        $ret = $query->fetchAll();
        if( !$status || !$ret ) {
            $this->code = -2009;
            $this->message = "查询失败, ErrInfo:".end($query->errorInfo());
            return false;
        }
        $artInfo = $ret[0];
        /**
         * 获取分类信息
         */
        $query = $this->_db->prepare("select `name` from `cate` where `id`=?");
        $query->execute( array( $artInfo['cate']) );
        $ret = $query->fetchAll();
        if( !$ret ) {
            $this->code = -2010;
            $this->message = "获取分类信息失败, ErrInfo:".end($query->errorInfo());
            return false;
        }
        $artInfo['cateName'] = $ret[0]['name'];

        $data = array(
            'id' => intval($artId),
            'title'=> $artInfo['title'],
            'contents'=> $artInfo['contents'],
            'author'=> $artInfo['author'],
            'cateName'=> $artInfo['cateName'],
            'cateId'=> intval($artInfo['cate']),
            'ctime'=> $artInfo['ctime'],
            'mtime'=> $artInfo['mtime'],
            'status'=> $artInfo['status'],
        );
        return $data;
    }

    /**
     * 获取文章列表
     * @param int $pageNo
     * @param int $pageSize
     * @param int $cate
     * @param string $status
     * @return array|bool
     */
    public function artList( $pageNo=0, $pageSize=10, $cate=0, $status='online' ){
        $start = $pageNo * $pageSize + ($pageNo==0?0:1);
        if( $cate == 0 ) {
            $filter = array( $status, intval($start), intval($pageSize) );
            $query = $this->_db->prepare("select `id`, `title`,`contents`,`author`,`cate`,`ctime`,`mtime`,`status` from `art` where `status`=? order by `ctime` desc limit ?,?  ");
        } else {
            $filter = array( intval($cate), $status, intval($start), intval($pageSize) );
            $query = $this->_db->prepare("select `id`, `title`,`contents`,`author`,`cate`,`ctime`,`mtime`,`status` from `art` where `cate`=? and `status`=? order by `ctime` desc limit ?,?  ");
        }
        $stat = $query->execute( $filter );
        $ret = $query->fetchAll();
//        if( !$ret ) {
//            $this->code = -2011;
//            $this->message = "获取文章列表失败, ErrInfo:".end($query->errorInfo());
//            return false;
//        }

        $data = array();
        $cateInfo = array();

        foreach( $ret as $item ) {
            /**
             * 获取分类信息
             */
            if( isset($cateInfo[$item['cate']]) ){
                $cateName = $cateInfo[$item['cate']];
            } else {
                $query = $this->_db->prepare("select `name` from `cate` where `id`=?");
                $query->execute( array( $item['cate']) );
                $retCate = $query->fetchAll();
                if( !$retCate ) {
                    $this->code = -2010;
                    $this->message = "获取分类信息失败, ErrInfo:".end($query->errorInfo());
                    return false;
                }
                $cateName = $cateInfo[$item['cate']] = $retCate[0]['name'];
            }

            /**
             * 正文太长则剪切
             */
            $contents = mb_strlen($item['contents'])>30 ? mb_substr($item['contents'], 0, 30)."..." : $item['contents'];

            $data[] = array(
                'id' => intval($item['id']),
                'title'=> $item['title'],
                'contents'=> $contents,
                'author'=> $item['author'],
                'cateName'=> $cateName,
                'cateId'=> intval($item['cate']),
                'ctime'=> $item['ctime'],
                'mtime'=> $item['mtime'],
                'status'=> $item['status'],
            );
        }
        return $data;
    }
}