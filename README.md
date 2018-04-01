# yii2-alipay
yii2支付宝支付扩展

[CHANGE LOG](CHANGELOG.md)

Installation
--------------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require xplalipay/alipay
```

or add

```json
"xplalipay/alipay": "*"
```

to the `require` section of your composer.json.


Configuration
--------------------

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
		'alipay'=>[
            'class'=>'xplalipay\alipay\Alipay',
            'back_url'=> '回调地址',
            'gateway_url' => 'https://openapi.alipay.com/gateway.do',
            'app_id' => 'APPID',
            'rsa_private_key' => '私钥',
            'format' => 'json',
            'charset'=>'UTF-8',
            'sign_type'=>"RSA2",
            'alipayrsa_public_key' => "公钥"
        ],
    ],
];
```


[获取支付密钥]
--------------------
```
$token = \Yii::$app->alipay->sdkExecute([
                'body'=>'商品描述',
                'subject'=>'商品名称',
                'out_trade_no'=>'订单号',
                'timeout_express'=>'1h',
                'total_amount'=>'金额(元)',
                'product_code'=>'QUICK_MSECURITY_PAY',
            ]);
将获取到的密钥给客户端返回即可
```

[回调代码]
--------------------
```
$resultNotify = \Yii::$app->alipay->notify();
        $result = false;
        if($resultNotify){
            $notifyData = \Yii::$app->request->post();
            $result = "回调逻辑";
        }
        if($result){
            echo 'SUCCESS';
        }else{
            echo 'ERROR';
        }
将获取到的密钥给客户端返回即可
```

