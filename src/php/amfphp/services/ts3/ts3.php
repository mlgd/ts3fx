<?php
  class ts3 {

    public function __construct() {
      require_once("config.php");
      require_once("functions.php");
      require_once(ROOT_PATH."libraries/TeamSpeak3/TeamSpeak3.php");
    }
    
    public function __destruct() {
    }
    
    public function login($param) {
      $serverquery_host = $param["serverquery_host"];
      $serverquery_port = $param["serverquery_port"];
      $username = $param["username"];
      $password = $param["password"];
      
      try {
        $uri = "serverquery://".$username.":".$password."@".$serverquery_host.":".$serverquery_port."/";
        $ts3 = TeamSpeak3::factory($uri);
        $_SESSION["serverquery_uri"] = $uri;
        $_SESSION["serverquery_host"] = $serverquery_host;
        $_SESSION["serverquery_port"] = $serverquery_port;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        return true;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }
    
    public function logout() {
      unset($_SESSION["username"]);
      unset($_SESSION["password"]);
    }
    
    public function adapter_info() {
      try {
        $ts3 = TeamSpeak3::factory($_SESSION["serverquery_uri"]);
        $ret = array();
        $ret["host"] = "".$ts3->getAdapterHost();
        $ret["port"] = $ts3->getAdapterPort();
        $ret["user"] = $_SESSION["username"];
        $version = $ts3->version();
        $ret["version"] = "".$version[version]->toString();
        $ret["build"] = "".$version[build];
        $ret["platform"] = "".$version[platform]->toString();
        //debug(print_r($ts3->getHost(),true));
        return $ret;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }

    public function adapter_traffic() {
      try {
        $ts3 = TeamSpeak3::factory($_SESSION["serverquery_uri"]);
        $traffic = $ts3->getInfo();
        return $traffic;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }

    public function list_servers() {
      try {
        $ts3 = TeamSpeak3::factory($_SESSION["serverquery_uri"]);
        $list = $ts3->serverList();
        $res = array();
        foreach ($list as $server) {
          $res[] = array(id => $server[virtualserver_id],
                         name => $server[virtualserver_name]->toString(),
                         port => $server[virtualserver_port],
                         status => $server[virtualserver_status]->toString(),
                         uptime => $server[virtualserver_uptime],
                         clients_connected => $server[virtualserver_clientsonline],
                         clients_total => $server[virtualserver_maxclients]);
        }
        return $res;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }
    
    public function start_server($param) {
      try {
        $ts3 = TeamSpeak3::factory($_SESSION["serverquery_uri"]);
        $ts3->serverStart($param["id"]);
        
        $server = $ts3->serverGetById($param["id"]);
        $res = array(id => $server[virtualserver_id],
                         name => $server[virtualserver_name]->toString(),
                         port => $server[virtualserver_port],
                         status => $server[virtualserver_status]->toString(),
                         uptime => $server[virtualserver_uptime],
                         clients_connected => $server[virtualserver_clientsonline],
                         clients_total => $server[virtualserver_maxclients]);
        return $res;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }

    public function stop_server($param) {
      try {
        $ts3 = TeamSpeak3::factory($_SESSION["serverquery_uri"]);
        $ts3->serverStop($param["id"]);
        
        $server = $ts3->serverGetById($param["id"]);
        $res = array(id => $server[virtualserver_id],
                         name => $server[virtualserver_name]->toString(),
                         port => $server[virtualserver_port],
                         status => $server[virtualserver_status]->toString(),
                         uptime => $server[virtualserver_uptime],
                         clients_connected => $server[virtualserver_clientsonline],
                         clients_total => $server[virtualserver_maxclients]);
        return $res;
      }
      catch (TeamSpeak3_Exception $e) {
        
      }
      return false;
    }

    public function test() {
      
      try {
        $uri = "serverquery://serveradmin:ph00xLQQ@127.0.0.1:10011/";
        //$uri = "serverquery://:@127.0.0.1:10011/";
        $ts3 = TeamSpeak3::factory($uri);
        
        $list = $ts3->serverList();
        $res = array();
        foreach ($list as $server) {
          $res[] = array(id => $server[virtualserver_id],
                         name => $server[virtualserver_name]->toString(),
                         port => $server[virtualserver_port],
                         status => $server[virtualserver_status]->toString(),
                         uptime => $server[virtualserver_uptime],
                         clients_connected => $server[virtualserver_queryclientsonline],
                         clients_total => $server[virtualserver_maxclients]);
        }
        return $res;
      }
      catch (TeamSpeak3_Exception $e) {
        echo "Error (ID " . $e->getCode() . ") <b>" . $e->getMessage() . "</b>";
      }
    }
    
  }
?>