<?php

    
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    if(isset($_REQUEST['From'])) {
         $name = "Anon " . substr($_REQUEST['From'], -2);
    }


    //print_r($_REQUEST);

    // now greet the sender
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Message><?php echo $name ?>, thanks for the message!</Message>
</Response>
