<?php
namespace xplalipay\alipay;
use xplalipay\alipay\request\AlipayTradeAppPayRequest;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;

class Alipay extends Component {

    public $aop;
    public $gateway_url;
    public $app_id;
    public $format;
    public $rsa_private_key;
    public $back_url;
    public $charset;
    public $sign_type;
    public $alipayrsa_public_key;

    public function init()
    {
        parent::init();
        if (!isset($this->gateway_url)) {
            throw new InvalidConfigException('请先配置gateway_url');
        }
        if (!isset($this->app_id)) {
            throw new InvalidConfigException('请先配置app_id');
        }
        if (!isset($this->format)) {
            throw new InvalidConfigException('请先配置format');
        }
        if (!isset($this->rsa_private_key)) {
            throw new InvalidConfigException('请先配置rsa_private_key');
        }
        if (!isset($this->charset)) {
            throw new InvalidConfigException('请先配置charset');
        }
        if (!isset($this->sign_type)) {
            throw new InvalidConfigException('请先配置使用的sign_type');
        }
        if (!isset($this->alipayrsa_public_key)) {
            throw new InvalidConfigException('请先配置使用的alipayrsa_public_key');
        }
        if (!isset($this->back_url)) {
            throw new InvalidConfigException('请先配置使用的back_url');
        }

        $this->aop = new AopClient();
        $this->aop->gatewayUrl = $this->gateway_url;
        $this->aop->appId = $this->app_id;
        $this->aop->rsaPrivateKey = $this->rsa_private_key;
        $this->aop->format = $this->format;
        $this->aop->charset = $this->charset;
        $this->aop->signType = $this->sign_type;
        $this->aop->alipayrsaPublicKey = $this->alipayrsa_public_key;
    }

    public function notify(){
        $aop = new AopClient;
        $aop->alipayrsaPublicKey = $this->alipayrsa_public_key;
        return $aop->rsaCheckV1($_POST, NULL, "RSA2");
    }

    public function sdkExecute($bizcontent){
        if(is_array($bizcontent)){
            $bizcontent = json_encode($bizcontent);
        }
        $request = new AlipayTradeAppPayRequest();
        $request->setNotifyUrl($this->back_url);
        $request->setBizContent($bizcontent);
        try{
            return $this->aop->sdkExecute($request);
        }catch (Exception $e){
            return false;
        }
    }
}