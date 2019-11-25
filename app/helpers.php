<?php


/**
 * 返回成功请求
 *
 * @param string $data
 * @param string $msg
 * @param string $header
 * @param string $value
 * @return mixed
 */
function responseSuccess($data = '', $msg = 'success', $url = '', $header = 'Content-Type', $value = 'application/json')
{
    $res['status']  = ['errorCode' => 0, 'msg' => $msg];
    $res['data']    = $data;
    $res['url']     = $url;
    return response($content = $res, $status = 200)->header($header, $value);
}

/**
 * 返回错误的请求
 *
 * @param string $msg
 * @param int $code
 * @param string $data
 * @param string $header
 * @param string $value
 * @return mixed
 */
function responseWrong($data = '', $msg = 'error', $code = 1, $url = '', $header = 'Content-Type', $value = 'application/json')
{
    $res['status']  = ['errorCode' => $code, 'msg' => $msg];
    $res['data']    = $data;
    $res['url']  = $url;
    return response($content = $res, $status = 200)->header($header, $value);
}

/**
 * 成功跳转
 * @param string $msg
 * @param string $route
 * @return \Illuminate\Http\RedirectResponse
 */
function respS($msg = '', $route = '')
{
    $msg = trans($msg)?trans($msg):trans('res.success');
    return $route?redirect($route)->with('msg_ok', $msg):redirect()->back()->with('msg_ok', $msg);
}

/**
 * 失败跳转
 * @param string $msg
 * @param string $route
 * @return \Illuminate\Http\RedirectResponse
 */
function respF($msg = '', $route = '')
{
    $msg = trans($msg)?trans($msg):trans('res.fail');
    return $route?redirect($route)->with('msg_no', $msg):redirect()->back()->with('msg_no', $msg);
}

function getBillNo()
{
    return date('YmdHis').str_random(5);
}

/**
 * curl方法拖数据
 *
 */
function curl_data($url = '', $method = 0 , $param='')
{
    $postUrl    = $url;
    $curlPost   = $param;
    $ch         = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, $method);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}

function getIp(){
    $onlineip='';
    if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){
        $onlineip=getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
        $onlineip=getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
        $onlineip=getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
        $onlineip=$_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

function getRandom($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function is_Mobile()
{
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

function mobileType() {
    $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
    $Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
    
    if($iPod || $iPhone || $iPad ){
        return 'iphone';
    } else if ($Android){    
        return 'android';
    }
}