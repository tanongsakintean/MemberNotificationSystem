<?php

class Havesms
{
    protected $token;
    protected $msisdn;
    protected $sender;
    protected $message;
    public $show = "hello world!";

    protected $endpoint = 'https://havesms.com/api/';

    public function __construct($token = false)
    {
        if ($token) {
            $this->token = $token;
        }
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
        return $this;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    protected function request($path, $params = array(), $method = 'GET')
    {
        $url = $this->endpoint . $path;
        $curl = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ),
        );

        if (count($params)) {
            if ('POST' === strtoupper($method)) {
                $opt[CURLOPT_POSTFIELDS] = json_encode($params);
            } else {
                $url .= implode('&', $params);
            }
        }

        curl_setopt_array($curl, $opt);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function checkBalance()
    {
        return $this->request('sms/balance', array(), 'GET');
    }

    public function send()
    {
        return $this->request('sms/send', array(
            'sender' => $this->sender,
            'message' => $this->message,
            'msisdn' => $this->msisdn,
        ), 'POST');
    }

    public function otpSend()
    {
        return $this->request('otp/send', array(
            'sender' => $this->sender,
            'msisdn' => $this->msisdn,
        ), 'POST');
    }

    public function otpVerify($otp, $transaction_id)
    {
        return $this->request('otp/verify', array(
            'msisdn' => $this->msisdn,
            'otp' => $otp,
            'transaction_id' => $transaction_id,
        ), 'POST');
    }
}

/*
อธิบายการใช้งานตัวอย่าง

แก้ไขข้อมูลภายในเครื่องหมายปีกกาตามด้านล่าง ก่อนใช้งาน
- {{token}} token ยืนยันตัว สร้างได้จาก https://havesms.com/user/api-tokens
- {{msisdn}} เบอร์โทรศัพท์ที่ต้องการส่งข้อความไป

จากนั้น uncomment ส่วนที่ต้องการทดสอบ
*/


//$sms = new Havesms();

/** ส่ง sms **/
// $response = $sms
//     ->setSender('OTP')
//     ->setMsisdn('0927817466')
//     ->setMessage('OTP is 123456')
//     ->send();
// var_dump($response);

/** ส่ง เช็คยอดคงเหลือ **/
//$response = $sms->checkBalance();
//var_dump($response);

/** ส่ง otp **/
// $response = $sms
//     ->setSender('OTP')
//     ->setMsisdn('0927817466')
//     ->otpSend();
// var_dump($response);

/** ยืนยัน otp **/
// $response = $sms
//     ->setMsisdn('{{msisdn}}')
//     ->otpVerify('999999', '20220101-EFGH-234567');
// var_dump($response);