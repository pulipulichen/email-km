<?php/*  Copyright	2010 Juergen Schulze	and 2006 Vincent Prat    This program is free software; you can redistribute it and/or modify    it under the terms of the GNU General Public License as published by    the Free Software Foundation; either version 2 of the License, or    (at your option) any later version.    This program is distributed in the hope that it will be useful,    but WITHOUT ANY WARRANTY; without even the implied warranty of    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    GNU General Public License for more details.    You should have received a copy of the GNU General Public License    along with this program; if not, write to the Free Software    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA	*/?><?phprequire ('../../../wp-config.php');	if (!current_user_can(EMU2_EXPORT_LIST_CAP) ) {			#if (!isset($_REQUEST['check']) || (get_option('EMU2_check')!=$_REQUEST['check']) )	{	wp_die(__("You are not allowed to send emails to users.", EMU2_I18N_DOMAIN));}	header("Content-type: text/csv");	header("Content-Disposition: attachment; filename=data.csv");	header("Pragma: no-cache");	header("Expires: 0");if (isset($_REQUEST['action']))	{# EMU2_ACCEPT_NOTIFICATION_USER_META# EMU2_ACCEPT_MASS_EMAIL_USER_META					if ($_REQUEST['action']=='all') {		$users = EMU2_get_users($user_ID);	} else {		$users = EMU2_get_recipients_from_roles( array($_REQUEST['action']), $exclude_id='', $meta_filter = EMU2_ACCEPT_MASS_EMAIL_USER_META);	}	foreach ($users as $user) {		print $user->id.";";		print $user->display_name.";";		print $user->user_email."\n";	}}	exit();?>