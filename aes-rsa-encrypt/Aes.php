<?php
/**
 * 
 */
class Aes
{
    /**
     * 加解密方法
     * @var string
     */
    protected $method;

    /**
     * 加解密密钥
     * @var string
     */
    protected $secret_key;

    /**
     * 加解密的向量
     * @var string
     */
    protected $iv;

    /**
     * @var int
     */
    protected $options;

    /**
     * 构造函数
     * @param string $key     密钥
     * @param string $method  加密方式
     * @param string $iv      向量
     * @param int $options $options
     */
    public function __construct($key = '', $method = 'AES-128-CBC', $iv = '', $options = OPENSSL_RAW_DATA)
    {
        $this->secret_key = isset($key) ? $key : '!678uihjytyiu.*8';
        $this->method = in_array($method, openssl_get_cipher_methods()) ? $method : 'AES-128-CBC';
        $ivlen = openssl_cipher_iv_length($this->method);
        $this->iv = openssl_random_pseudo_bytes($ivlen);
        $this->options = in_array($options, [OPENSSL_RAW_DATA, OPENSSL_ZERO_PADDING]) ? $options : OPENSSL_RAW_DATA;
    }

    /**
     * encrypt aes加密
     * @param string $input 需要加密的字符串
     * @author chenchao@2345.com
     * @return string
     */
    public function encrypt($input)
    {
        return base64_encode(openssl_encrypt($input, $this->method, $this->secret_key, $this->options, $this->iv));
    }

    /**
     * decrypt aes解密
     * @param string $sStr 需要解密的字符串
     * @author chenchao@2345.com
     * @return string
     */
    public function decrypt($sStr)
    {
        return openssl_decrypt(base64_decode($sStr), $this->method, $this->secret_key, $this->options, $this->iv);
    }
}

/*$aes = new Aes();
$encrypted = $aes->encrypt('锄禾日当午');
echo "加密前：锄禾日当午<br>加密后：" , $encrypted, "<hr>";

$decrypted = $aes->decrypt($encrypted);
echo "加密后：", $encrypted, "<br>解密后：" , $decrypted, "<hr>";*/