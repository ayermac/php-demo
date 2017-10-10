<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/9
 * Time: 21:11
 */
class Response{

    /**
     * 综合方式输出通信数据
     * @param $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * @param $type 输出数据格式
     */
    public static function show($code, $message = '', $data = array(), $type = 'json')
    {
        if (!is_numeric($code)) {
            return '';
        }

        $type = in_array($_GET['format'], array('xml', 'json', 'array')) ? $_GET['format'] : 'json';

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        switch ($type) {
            case 'json':
                self::json($code, $message, $data);
                break;
            case 'xml':
                self::xmlEncode($code, $message, $data);
                break;
            case 'array':
                echo '<pre>';
                var_dump($result);
                echo '</pre>';
                break;
            default:
                // TODO
        }
    }

    /**
     * 按 json 方式输出通信数据
     * @param $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * return string
     */
    public static function json($code, $message = '', $data = array())
    {
        header('Content-type: application/json');
        if (!is_numeric($code)) {
            return '';
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    /**
     * 按 xml 方式输出通信数据
     * @param $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * return string
     */
    public static function xmlEncode($code, $message, $data=array())
    {
        header("Content-Type: text/xml");
        if (!is_numeric($code)) {
            return '';
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml.= "<root>";
        $xml.= self::xmlToEncode($result);
        $xml.= "</root>";

        echo $xml;
        exit();
    }

    /**
     * 编码数据为 XML 格式
     * @param $data 数据
     * @return string
     */
    protected static function xmlToEncode($data)
    {
        $xml = "";
        foreach ($data as $key => $value) {
            $attr = "";
            if (is_numeric($key)) {
                $attr = " id='{$key}'";
                $key = "item";
            }
            $xml.= "<{$key}{$attr}>";
            $xml.= is_array($value) ? self::xmlToEncode($value) : $value;
            $xml.= "</{$key}>";
        }

        return $xml;
    }
}