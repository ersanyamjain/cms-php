<?php

function attempt_login($username,$password)
{
	$admin=find_admin_by_username($username);
	if($admin)
	{
		//check pwd
		if(password_check($password,$admin["hashed_password"]))
		{
			return $admin;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function confirm_logged_in()
{
	if(!logged_in())
	{
		$_SESSION["message"]="Error! Please Log in to continue.";
		redirect_to("login.php");
		
	}
}

function confirm_query($result_set)
{ 
global $connection;
	if(!$result_set)
	{
		die("Database Query Failed.".mysqli_error($connection));
	}
	
}

function find_admin_by_id($admin_id)
{
	global $connection;
$admin_id=mysqli_real_escape_string($connection,$admin_id);
$query="Select * ";
$query.="From admins ";
$query.="where id={$admin_id} ";
$query.="limit 1 ";
$admin_set=mysqli_query($connection,$query);
confirm_query($admin_set);
if($admin=mysqli_fetch_assoc($admin_set))
{
	return $admin;
}
else
{
	return null;
}
}

function find_admin_by_username($username)
{
	global $connection;
$safe_username=mysqli_real_escape_string($connection,$username);
$query="Select * ";
$query.="From admins ";
$query.="where username='{$safe_username}' ";
$query.="limit 1 ";
$admin_set=mysqli_query($connection,$query);
confirm_query($admin_set);
if($admin=mysqli_fetch_assoc($admin_set))
{
	return $admin;
}
else
{
	return null;
}
}

function find_all_admins()
{
	global $connection;
$query="Select * ";
$query.="From admins ";
$query.="order by username asc ";
$admin_set=mysqli_query($connection,$query);
confirm_query($admin_set);
return $admin_set;	
}

function find_all_pages($subject_id,$public=true)
{
	global $connection;
$query="Select * ";
$query.="From pages ";
$query.="where subject_id={$subject_id} ";
if($public)
{
$query.="and visible=1 ";
}
$query.="order by position asc ";
$page_set=mysqli_query($connection,$query);
confirm_query($page_set);
return $page_set;	
}

function find_all_subjects($public=true)
{
	global $connection;
	$query="Select * ";
$query.="From subjects ";
if($public)
{
$query.="where visible=1 ";
}
$query.="order by position asc ";
$subject_set=mysqli_query($connection,$query);
confirm_query($subject_set);
return $subject_set;	
}

function find_default_page_for_subject($subject_id)
{
	$page_set=find_all_pages($subject_id);
	if($first_page=mysqli_fetch_assoc($page_set))
	{
		return $first_page;
	}
	else
	{
		return null;
	}
}

function find_page_by_id($page_id,$public=true)
{
	global $connection;
	$page_id=mysqli_real_escape_string($connection,$page_id);
$query="Select * ";
$query.="From pages ";
$query.="where id={$page_id} ";
if($public)
{
	$query.="and visible=1 ";
}
$query.="limit 1 ";
$page_set=mysqli_query($connection,$query);
confirm_query($page_set);
if($page=mysqli_fetch_assoc($page_set))
{
	return $page;
}
else
{
	return null;
}
}

function find_subject_by_id($subject_id,$public=true)
{
	global $connection;
	$subject_id=mysqli_real_escape_string($connection,$subject_id);
$query="Select * ";
$query.="From subjects ";
$query.="where id={$subject_id} ";
if($public)
{
	$query.="and visible=1 ";
}
$query.="limit 1 ";
$subject_set=mysqli_query($connection,$query);
confirm_query($subject_set);
if($subject=mysqli_fetch_assoc($subject_set))
{
	return $subject;
}
else
{
	return null;
}
}

function find_selected_page($public=false)
{
global $current_subject;
global $current_page;
if(isset($_GET["subject"]))
{
	$current_subject=find_subject_by_id($_GET["subject"],$public);
	if($current_subject && $public)
	{
		$current_page=find_default_page_for_subject($current_subject["id"]);
	}
	else
	{
	$current_page=null;
	}
}
elseif(isset($_GET["page"]))
{
	$current_page=find_page_by_id($_GET["page"],$public);
	$current_subject=null;	
}
else
{
	$current_subject=null;	
	$current_page=null;
}
}

function form_errors($errors=array())
{
	$output="";
	if(!empty ($errors))
	{
		$output="<div class=\"error\">";
		$output.="Please fix the following errors:";
		$output.="<ul>";
		foreach($errors as $key => $error){
			
			$output.="<li>";
			$output.=htmlentities($error);
			$output.="</li>";
		}
		$output.="</ul>";
		$output.="</div>";
	}
	return $output;
}

function generate_salt($length)
{
	$unique_random_string=md5(uniqid(mt_rand(),true));
	$base64_string=base64_encode($unique_random_string);
	$modified_base64_string=str_replace('+','.',$base64_string);
	$salt=substr($modified_base64_string,0,$length);
	return $salt;
}

function logged_in()
{
	return isset($_SESSION['admin_id']);
}

function mysql_prep($string)
{
	global $connection;
	$escaped_string=mysqli_real_escape_string($connection,$string);
	return $escaped_string;
}

function navigation($subject_array,$page_array)
{
	$output="<br>";
	$output.="<ul class=\"subjects\">";

$subject_set=find_all_subjects(false);

while($subject=mysqli_fetch_assoc($subject_set))
{
	$output.= "<li";
	if($subject_array && $subject["id"]==$subject_array["id"])
	{
		$output.=" class=\"selected\"";
	}
	$output.= ">";
	
	$output.="<a href=\"manage-content.php?subject=";
	$output.= urlencode($subject["id"]); 
	$output.="\">&nbsp;&nbsp;";
	$output.= htmlentities($subject["menu_name"]);
	$output.="</a>";
	
$page_set=find_all_pages($subject["id"],false);

		$output.="<ul class=\"pages\">";
		while($page=mysqli_fetch_assoc($page_set))
{
	$output.= "<li";
	if($page_array && $page["id"]==$page_array["id"])
	{
		$output.= " class=\"selected\"";
	}
	$output.= ">";
	
	$output.="<a href=\"manage-content.php?page=";
	$output.= urlencode($page["id"]); 
	$output.="\">";  
	$output.= htmlentities($page["menu_name"]);
	
	$output.="</a>";
	$output.="</li>";

 } 

mysqli_free_result($page_set); 
	$output.="</ul>";
	$output.="</li>";
	$output.="<br>";
	
}


mysqli_free_result($subject_set);

$output.="</ul>";
return $output;
}

function page_list_by_subject($subject_array)
{
	
	$output="<b>Pages in this Subject:</b><br>";
	$page_set=find_all_pages($subject_array["id"]);
	$output.="<ul>";
	while($page=mysqli_fetch_assoc($page_set))
{
	$output.= "<li>";
	$output.= htmlentities($page["menu_name"]);
	$output.="</li>";
} 
mysqli_free_result($page_set); 
$output.="</ul>";
return $output;
}

function password_check($password,$existing_hash)
{
	$hash=crypt($password,$existing_hash);
	if($hash===$existing_hash)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function password_encrypt($password)
{
$hash_format="$2y$10$";
$salt_length=22;
$salt=generate_salt($salt_length);
$format_and_salt=$hash_format.$salt;
$hash=crypt($password,$format_and_salt);
return $hash;
}

function public_navigation($subject_array,$page_array)
{
	$output="<br>";
	$output.="<ul class=\"subjects\">";

$subject_set=find_all_subjects();

while($subject=mysqli_fetch_assoc($subject_set))
{
	$output.= "<li";
	if($subject_array && $subject["id"]==$subject_array["id"])
	{
		$output.=" class=\"selected\"";
	}
	$output.= ">";
	
	$output.="<a href=\"index.php?subject=";
	$output.= urlencode($subject["id"]); 
	$output.="\">&nbsp;&nbsp;";
	$output.= htmlentities($subject["menu_name"]);
	$output.="</a>";
	if($subject["id"]==$subject_array["id"] || $page_array["subject_id"]==$subject["id"]) 
	{
		
$page_set=find_all_pages($subject["id"]);

		$output.="<ul class=\"pages\">";
		while($page=mysqli_fetch_assoc($page_set))
{
	$output.= "<li";
	if($page_array && $page["id"]==$page_array["id"])
	{
		$output.= " class=\"selected\"";
	}
	$output.= ">";
	
	$output.="<a href=\"index.php?page=";
	$output.= urlencode($page["id"]); 
	$output.="\">";  
	$output.= htmlentities($page["menu_name"]);
	
	$output.="</a>";
	$output.="</li>";

 } 
$output.="</ul>";
mysqli_free_result($page_set); 
	}
	
	$output.="</li>";
	$output.="<br>";
	
}


mysqli_free_result($subject_set);

$output.="</ul>";
return $output;
}

function redirect_to($new_location)
{
	header("Location: ".$new_location);
	exit;
}

function verify_new_admin($username)
{
	global $errors;
	$admin=find_admin_by_username($username);
	if($admin)
	{
	$errors["username"]="Username already exists, Please try another one. "; 
	}	
	
}


?>