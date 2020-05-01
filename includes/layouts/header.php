<?php if(!isset($layout_context))
{
	$layout_context="public";
}	?>

<html>
<head>
<title>
Primia Technologies<?php if($layout_context=="admin"){echo " Admin";} ?>
</title>
<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header"> <h1> Primia Technologies<?php if($layout_context=="admin"){echo " Admin";} ?> </h1> </div>