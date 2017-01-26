<?php
/**
 * Created by JetBrains PhpStorm.
 * User: semih
 * Date: 1/26/17
 * Time: 9:39 AM
 * To change this template use File | Settings | File Templates.
 */
namespace assistant;
class curl {
    private $ch;//Curl Handler
    private $response;
    private $opt_list;
    private $ch_info;
    private $beforeRunFunctionList=[];
    private $afterRunFunctionList=[];
    private $ch_error_no;
    private $ch_error_message;
    private $http_header;

    function __construct(){
        $this->ch=curl_init();
    }
    public function setOpt($CURLOPT,$value){
        $this->opt_list[$CURLOPT]=$value;
        curl_setopt($this->ch,$CURLOPT,$value);
        return $this;
    }
    public function getOpt($CURLOPT){
        return $this->opt_list[$CURLOPT];
    }
    public function setUrl($Url){
        $this->setOpt(CURLOPT_URL,$Url);
        return $this;
    }
    public function getUrl(){
        return $this->getOpt(CURLOPT_URL);
    }
    public function exec(){
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);

        if(count($this->beforeRunFunctionList)>0){
            foreach($this->beforeRunFunctionList as $function){
                call_user_func($function);
            }
        }

        $this->response=curl_exec($this->ch);
        $this->ch_info=curl_getinfo($this->ch);
        $this->ch_error_no=curl_errno($this->ch);
        $this->ch_error_message=curl_error($this->ch);

        if(count($this->afterRunFunctionList)>0){
            foreach($this->afterRunFunctionList as $function){
                call_user_func($function);
            }
        }

        return $this->response;
    }
    public function request($type=null,$url=null,$params=null){
        switch(trim(strtolower($type))){
            case 'get':{
                return $this->get($url,$params);
            }
                break;
            case 'post':{
                return $this->post($url,$params);
            }
                break;
            default:{
            throw new \Exception('Unsupported request type:"'.$type.'"');
            }
        }
    }
    public function get($url=null,$params=null){
        $this->setUrl($url);
        $this->setOpt(CURLOPT_POST,false);
        $this->setOpt(CURLOPT_HTTPGET,true);
        return $this->exec();
    }
    public function post($url=null,$params=null){
        $this->setUrl($url);
        $this->setOpt(CURLOPT_POST,true);
        $this->setOpt(CURLOPT_POSTFIELDS,$params);
        return $this->exec();
    }
    public function getInfo($key=null){
        if(is_null($key)){
            return $this->ch_info;
        }else{
            return $this->ch_info[$key];
        }
    }
    public function getErrorMessage(){
        return $this->ch_error_message;
    }
    public function getErrorNo(){
        return $this->ch_error_no;
    }
    public function getResponse(){
        return $this->response;
    }
    public function isSuccess(){
        return preg_match("#2[0-9]{2}#",$this->getInfo('http_code'))?true:false;
    }
    public function setHeaders($headers=[]){
        $this->setOpt(CURLOPT_HTTPHEADER,$headers);
        return $this;
    }
    public function getHeaders(){
        return $this->getOpt(CURLOPT_HTTPHEADER);
    }
    public function setHeader($key,$value){
        $this->http_header[$key]=$key.': '.$value;
        $this->setHeaders($this->http_header);
        return $this;
    }
    public function getHeader($key){
        return $this->http_header[$key];
    }
    public function curl2string(){

        $str='curl ';
        if(!empty($this->http_header)){
            foreach($this->http_header as $header){
                $str.='-H "'.$header.'" ';
            }
        }
        if($this->getOpt(CURLOPT_POST)){
            $str.='-X POST -d \''.str_replace(["\n","\r"],'',$this->getOpt(CURLOPT_POSTFIELDS)).'\' ';
        }
        $str.='"'.$this->getUrl().'"';

        return $str;
    }
    public function log(){
        $log[]='URL';
        $log[]=$this->getUrl();
        $log[]="\n";
        $log[]='REQUEST';
        $log[]=$this->getOpt(CURLOPT_POSTFIELDS);
        $log[]="\n";
        $log[]='RESPONSE';
        $log[]=$this->response;
        $log[]="\n";
        $log[]='curlRequest';
        $log[]=$this->curl2string();
        return implode("\n",$log);
    }
    public function beforeRunFunction($function){
        if(function_exists($function)){
            $this->beforeRunFunctionList[]=$function;
        }
        return $this;
    }
    public function afterRunFunction($function){
        if(function_exists($function)){
            $this->afterRunFunctionList[]=$function;
        }
        return $this;
    }
    public function setUserAgent($UserAgent){
        $this->setOpt(CURLOPT_USERAGENT,$UserAgent);
        return $this;
    }
    public function getUserAgent(){
        return $this->getOpt(CURLOPT_USERAGENT);
    }
    public function setTimeOut($TimeOut=0){
        $this->setOpt(CURLOPT_CONNECTTIMEOUT,$TimeOut);
        $this->setOpt(CURLOPT_TIMEOUT,$TimeOut);
        return $this;
    }
    public function getTimeOut(){
        return $this->getOpt(CURLOPT_TIMEOUT);
    }
    function __destruct(){
        curl_close($this->ch);
    }
}