<?php
/**
 * Created by IntelliJ IDEA.
 * User: 谢哲超
 * Date: 15/11/30
 * Time: 18:03
 */
class sms {

    private $api_urls   = 'http://222.76.210.200:9999/sms.aspx';

    private $config = array(
        'userid'    => 490,
        'account'   => 'tzl',
        'password'  => '123456',
        'mobile'    => '',
        'content'   => '',
        'sendTime'  => '',
        'action'    => 'send',
        'extno'     => '',
    );

    private $link = '';

    public $msg;

    private $db;

    private $ecs;

    function __construct()
    {
        /* 由于要包含init.php，所以这两个对象一定是存在的，因此直接赋值 */
        $this->db = $GLOBALS['db'];
        $this->ecs = $GLOBALS['ecs'];
        $this->msg = array(
            'order_pay' => '尊敬的客户：'.chr(10).'您的订单已经提交成功，我们将尽快帮您安排发货，如遇任何疑问及需求请拨打400-101-5208可直接点击链接 http://www.tzili.com/guanzhu.html 关注我们的公众平台，或手动搜索微信公众号：天姿丽点尚 微博：点尚天姿丽 QQ交流群：136907999，将有资深的痘博士为您指导专业的养肤知识，感谢您对天姿丽的支持',
            'order_send'=> '尊敬的客户：'.chr(10).'您的订单已发货，您可登陆会员号查看物流信息，为了避免给您带来不必要的损失，收货时请务必查验确保无误后再签收哦，如遇任何疑问及需求请拨打400-101-5208可直接点击链接 http://www.tzili.com/guanzhu.html 关注我们的公众平台，或手动搜索微信公众号：天姿丽点尚 微博：点尚天姿丽 QQ交流群：136907999，将有资深的痘博士为您指导专业的养肤知识，感谢您对天姿丽的支持！',
            'order_unconfirmed'    => '尊敬的客户：'.chr(10).'系统提示您的订单还未完成，请您在10分钟内确认购买，以免订单失效，订单过程中如遇任何疑问及需求请拨打400-101-5208可直接点击链接 http://www.tzili.com/guanzhu.html 关注我们的公众平台，或手动搜索微信公众号：天姿丽点尚 微博：点尚天姿丽 QQ交流群：136907999，将有资深的痘博士为您指导专业的养肤知识，感谢您对天姿丽的支持！',
            'order_cancel'  => '尊敬的客户：'.chr(10).'系统提示您的订单已取消，未能得到您的肯定我们深表遗憾，后期将有更多的产品不断上市，总有一款适合您，遇任何疑问及需求请拨打400-101-5208可直接点击链接 http://www.tzili.com/guanzhu.html 关注我们的公众平台，或手动搜索微信公众号：天姿丽点尚 微博：点尚天姿丽 QQ交流群：136907999，将有资深的痘博士为您指导专业的养肤知识，感谢您对天姿丽的支持！',
            'registered'    => '尊敬的客户：'.chr(10).'您好！您的会员信息已注册成功，欢迎您的加入，在购物过程中如遇任何疑问及需求请拨打400-101-5208可直接点直接击链接 http://www.tzili.com/guanzhu.html 关注我们的公众平台，或手动搜索微信公众号：天姿丽点尚 微博：点尚天姿丽 QQ交流群：136907999，将有资深的痘博士为您指导专业的养肤知识，感谢您对天姿丽的支持！',
        );
    }

    /**
     * 检测手机号码是否正确
     *
     */
    function is_moblie($moblie)
    {
        return  preg_match("/^0?1((3|8|7)[0-9]|5[0-35-9]|4[57])\d{8}$/", $moblie);
    }

    function send ($mobile, $content, $sendTime = '') {
        $this->config['mobile'] = is_array($mobile) ? join(',',$mobile) : $mobile;
        $this->config['content'] = $content;
        if ($sendTime) {
            $this->config['sendTime'] = date('Y-m-d H:i:s',$sendTime);
        }
        return $this->curl_post($this->api_urls,$this->config);
    }

    function curl_post($url, $fields = array()) {
        // 初始化一个 cURL 对象
        $ch = curl_init();
        // 设置你需要抓取的URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_INFILESIZE,2);
        // 运行cURL，请求网页
        $return_data = curl_exec($ch);
        // 关闭URL请求
        curl_close($ch);
        return $return_data;
    }

    function salt ($len) {
        $arr = array(0,1,2,3,4,5,6,7,8,9);
        $salt = '';
        for($i = 0; $i < $len; $i++) {
            $salt .= $arr[rand(0,count($arr) - 1)];
        }
        return $salt;
    }

    function log ($tel, $type = "",$user_id = 0, $order_id = 0) {
        $time = time();
        $dt = date("Y-m-d H:i:s",$time);
        $sql = "INSERT INTO ecs_sys_sms_log (order_id,user_id,tel,send_time,send_date,`type`) VALUES($order_id,$user_id,'".$tel."',$time,'".$dt."','".$type."')";
        $GLOBALS['db']->query($sql);
    }

}