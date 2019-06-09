## 前后端通信密钥加密 demo

* 包含PHP AES 和 RSA2 加密代码示例
* 前端生成 RSA 代码示例

## 服务端创建公钥和私钥：
```
openssl genrsa -out private_key.pem 2048
openssl rsa -in private_key.pem -pubout -out public_key.pem
```

