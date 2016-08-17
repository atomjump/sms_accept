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


    function find_forum($body)
    {
        $words = str_split($body);
        foreach($words as $word) {
            echo $word;
            if(substr($word, -1) == '\@') {
                return rtrim($word, '\@');
            }   
        }
        return false; 

    }




  
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
         $name = "Anon " . substr($_REQUEST['From'], -2);
    }
     
    //Search the Body of the message for the first 'word@' mention - this is the forum to send to
    //$_REQUEST['Body']   - sms body
   if(($forum = find_forum($_REQUEST['Body'])) != false) {

      //We have a forum to post to
  

       $shouted = $title . $summary_description . " " . $guid;		//guid may not be url for some feeds, may need to have link
       $your_name = $name;
       $whisper_to = "";
       $email = "noreply" . $_REQUEST['From'] . "@atomjump.com";
       $ip = "92.27.10.17"; //must be something anything
       $forum_name = $forum;

       //Get the forum id
       $forum_info = $api->get_forum_id($forum_name);
						
      //Send the message
      $api->new_message($your_name, $shouted, $whisper_to, $email, $ip, $forum_info['forum_id'], false);
						
    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $name ?>, thanks, your message has been posted to <?php str_replace("FORUM", $forum_name, $sms_accept_config['domain']); ?>!</Message>
</Response>
<?php  
     } else {

       //No body message
?>
<Response>
    <Message><?php echo $name ?>, thanks, but your message is missing a forum name with an @ at the end. Please try again.</Message>
</Response>
<?php } ?>
