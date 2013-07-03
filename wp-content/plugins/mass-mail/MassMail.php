<?php
/*
Plugin Name: Mass Mail 
Plugin URI: http://www.codestips.com/wordpress-plugin-mass-mail
Description: Send mass mail to a group. Use this plugin to send mass mail to a group of users. See more on <a href="http://www.codestips.com">CodesTips.com</a>
Author: codestips
Author URI: http://www.codestips.com
Version: 1.0
 
*/

/*
Copyright (C) 2009 codestips.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
add_action('admin_menu', 'MassMail_adminmenu');
register_activation_hook(__FILE__,'MassMail_activate'); 
define("MassPage", "options-general.php?page=MassMail.php");

function MassMail_activate()
{
global $wpdb;
	
//make the massmail table
$masstablename = $wpdb->prefix . "mm_massmail";
if($wpdb->get_var("SHOW TABLES LIKE '$masstablename'") != $masstablename) {
	$query = "CREATE TABLE ".$masstablename." (
	ID int(10) NOT NULL AUTO_INCREMENT,
	tablename varchar(25) NOT NULL,
	emailfield varchar(35) NOT NULL,
	frommail varchar(35) NOT NULL,
	UNIQUE KEY ID (ID));";
	$wpdb->query($query);
	$results = $wpdb->get_results("SELECT * FROM wp_users WHERE ID=1");
    $result=$results[0]; 
	$query = "INSERT INTO ".$masstablename."(ID,tablename,emailfield,frommail) VALUES(0,'wp_users','user_email','".$result->user_email."');";
	$wpdb->query($query);	

	}
}

function MassMail_adminmenu(){

	add_options_page('Mass Mail option page', 'Mass Mail', 'manage_options', __FILE__,"MassMail_menu");
}


function MassMail_menu(){
 global $wpdb;
 $masstablename = $wpdb->prefix . "mm_massmail";
 $query="SELECT * FROM $masstablename";
  
  $results = $wpdb->get_results($query);
  
  if ($results)
  {
    $result=$results[0];
    $table=$result->tablename;
	$emailfield = $result->emailfield;
	$fromadmin=$result->frommail;	  	
  }
 if(isset($_POST['submit']))
  {
  	
  $seconds=$_POST['seconds'];
  $subject=$_POST['subj'];
  $messagesend=$_POST['message'];
   echo ' <center><h2>Mass Mail Setup</h2><br>';
	$results = $wpdb->get_results("SELECT * FROM $table");
	foreach ($results as $result) {  	
    	$mailto=$result->$emailfield;
        mail($mailto, $subject, $messagesend , "From:".$fromadmin."\nReply-To:".$fromadmin."\n");
        
		echo '<center>Mail sent to '.$mailto.'</center><br>';
        sleep($seconds);
    }
    echo ' <center>Mails sent.Go <a href="'.MassPage.'&SendMails=1">back</a>.</center>';
  }
  else 
  {
   if (isset($_GET['SendMails']) || isset($_POST['savesubmit']))
   {
   	if ( isset($_POST['savesubmit']))
   	{
			$tablename=$_POST['tablename'];
			$tableemail=$_POST['tableemail'];
			$fromemail=$_POST['fromemail'];
			$query = "UPDATE ".$masstablename." SET tablename='$tablename',emailfield='$tableemail',frommail='$fromemail'  WHERE ID=1;";
		    $wpdb->query($query);
	}
     ?>
      <center><h2>Send Mass Mail</h2><br><a href="<?=MassPage;?>"> Setup >></a></center><br><form method="POST">
              <div align="center"> 
              <table cellpadding="0" border="0" align="center" class="form-table">
              <tr>
              <td>
              Subject:
              </td>
              <td>
              <input type="text" align="left" name="subj" size="60">
              </td>
              </tr>
              <tr><td align="left" valign="top">
                Message Text:</td><td align="left"> <textarea name="message" rows="15" cols="60"				></textarea></td></tr>
				<tr>
                <tr><td  align="left">
				Seconds between messages:</td><td><input type="text" size="10" name="seconds" value="0.1"> (seconds)
					</td></tr>
				<tr><td colspan="2" align="center">	
                <input type="submit" value="Send mass mails" name="submit" class="button">
                </Td>
                </tr>
				
                </table>
              </div>
     <?
     }
       else{
			
			
			?>
      <center><h2>Mass Mail Setup</h2><br>
	  <a href="<?=MassPage;?>&SendMails=1">Send Emails Now >> </a><br></center>
	  <form method="POST">

        <div align="center"> 
           <table cellpadding="0" border="0" align="center" class="form-table">
              <tr>
              <td>
              Table name:
              </td>
              <td>
              <input type="text" align="left" name="tablename" size="30" value="<?=$table;?>">
              </td>     
              </tr>
              <tr>
              <td>
              Table email field:
              </td>
              <td>
              <input type="text" align="left" name="tableemail" size="30" value="<?=$emailfield;?>">
              </td>     
              </tr>
              
              <tr>
              <td>
              Sender email:
              </td>
              <td>
              <input type="text" align="left" name="fromemail" size="30" value="<?=$fromadmin;?>">
              </td>     
              </tr>
              
              
         		<tr><td colspan="2" align="center">	
                <input type="submit" value="Save & Send Mails -> " name="savesubmit" class="button">
                </td>
                </tr>
            </table>
        </div>
              
        <?      
	   }
  }
   echo ' <center>Powered by <a href="http://www.codestips.com">CodesTips.com</a></center>';
}

?>