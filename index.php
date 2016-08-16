<?php

  if(!isset($sms_accept_config)) {
        //Get global plugin config - but only once
		$data = file_get_contents (dirname(__FILE__) . "/config/config.json");
        if($data) {
            $sms_accept_config = json_decode($data, true);
            if(!isset($sms_accept_config)) {
                echo "Error: sms_accept config/config.json is not valid JSON.";
                exit(0);
            }
     
        } else {
            echo "Error: Missing config/config.json in sms_accept plugin.";
            exit(0);
     
        }
  
  
    }
    $agent = $sms_accept_config['agent'];
	ini_set("user_agent",$agent);
	$_SERVER['HTTP_USER_AGENT'] = $agent;
	$start_path = $sms_accept_config['serverPath'];
	
	
	$notify = false;
	include_once($start_path . 'config/db_connect.php');	
	
	$define_classes_path = $start_path;     //This flag ensures we have access to the typical classes, before the cls.pluginapi.php is included
	require($start_path . "classes/cls.pluginapi.php");
	
	$api = new cls_plugin_api();



  
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
         $name = "Anon " . substr($_REQUEST['From'], -2);
    }
     
    //$_REQUEST['Body']   - sms body

    //print_r($_REQUEST);

    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $name ?>, thanks for the message!</Message>
</Response>
