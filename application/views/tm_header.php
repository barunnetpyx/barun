<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
	$pagetitle = "TuneMedia :: ";	
	if(isset($title) && !empty($title)){
		$pagetitle .= $title; 
	}	
	?>
    <title><?php echo $pagetitle; ?></title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo HTTP_CSS_PATH; ?>sb-admin.css" rel="stylesheet">
	<link href="<?php echo HTTP_CSS_PATH; ?>plugins/timeline/timeline.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	
</head>
<body>