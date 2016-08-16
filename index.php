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


     $start_path = $sms_accept_config['serverPath'];
	
	
	$notify = false;
	include_once($start_path . 'config/db_connect.php');	
	
	$define_classes_path = $start_path;     //This flag ensures we have access to the typical classes, before the cls.pluginapi.php is included
	require($start_path . "classes/cls.pluginapi.php");
	
	$api = new cls_plugin_api();


    function find_layer($body)
    {
        $words = str_split($body);
        foreach($words as $word) {
            if(substr($word, -1) == '@') {
                return rtrim($word, '@');
            }   
        }
        return false; 

    }




  
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
         $name = "Anon " . substr($_REQUEST['From'], -2);
    }
     
    //Search the Body of the message for the first 'word@' mention - this is the layer to send to
    //$_REQUEST['Body']   - sms body
 

   $shouted = $title . $summary_description . " " . $guid;		//guid may not be url for some feeds, may need to have link
    $your_name = $name;
    $whisper_to = "";
    $email = $feed['email'];
    $ip = "92.27.10.17"; //must be something anything
    $forum_name = $feed['aj'];

    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $name ?>, thanks for the message!</Message>
</Response>
