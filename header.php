<!DOCTYPE html>
<html>
	<head>
		<link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-touch-icon-180x180.png">
		<link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="images/favicons/favicon-194x194.png" sizes="194x194">
		<link rel="icon" type="image/png" href="images/favicons/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="images/favicons/android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="images/favicons/manifest.json">
		<link rel="mask-icon" href="images/favicons/safari-pinned-tab.svg" color="#5bbad5">
		<link rel="shortcut icon" href="images/favicons/favicon.ico">
		<meta name="apple-mobile-web-app-title" content="Colorize">
		<meta name="application-name" content="Colorize">
		<meta name="msapplication-TileColor" content="#373a42">
		<meta name="msapplication-TileImage" content="images/favicons/mstile-144x144.png">
		<meta name="msapplication-config" content="images/favicons/browserconfig.xml">
		<meta name="theme-color" content="#373a42">

		<!-- SEO and Semantic Markup -->
		<meta name="robots" content="index, follow, archive">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="Cache-control" content="public">

		<meta name="twitter:card" content="summary">
		<meta name="twitter:creator" content="@alex_beals">

		<meta property="og:type" content="website">
		<meta property="og:site_name" content="AlexBeals.com">

		<link href="https://fonts.googleapis.com/css?family=Oswald:300,400|Open+Sans" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/nav.css">
		<?php
			// Respects 'Request Desktop Site'
			if (preg_match("/(iPhone|iPod|iPad|Android|BlackBerry)/i", $_SERVER["HTTP_USER_AGENT"])) {
				?><meta name="viewport" content="width=400"><?php
			}

			// Handle home page stylesheet/title
			if ($page == "home") { ?>
				<meta property="og:title" content="Colorize">
				<meta property="og:image" content="http://alexbeals.com/projects/colorize/images/cover.jpg">
				<meta property="og:url" content="http://alexbeals.com/projects/colorize/">
				<meta property="og:description" content="Turn any word into a hex color.  This site uses Google Images to get the average color from the first page of image results, and converts it into hex.">

				<meta name="description" content="Turn any word into a hex color.  This site uses Google Images to get the average color from the first page of image results, and converts it into hex.">
				<title>Colorize</title>
				<link rel="stylesheet" type="text/css" href="css/main.css">	
			</head>
			<body>
				
			<?php
			// Handle search page stylesheet/title/background-color
			} else if ($page == "search") { ?>
				<meta property="og:title" content="Colorize | <?php echo $query; ?>">
				<meta property="og:image" content="http://alexbeals.com/projects/colorize/images/cover.jpg">
				<meta property="og:url" content="http://alexbeals.com<?php echo $_SERVER['REQUEST_URI']; ?>">
				<meta property="og:description" content="Turn any word into a hex color.  In this case, '<?php echo $query; ?>' becomes <?php echo $color; ?>.">

				<meta name="description" content="Turn any word into a hex color.  In this case, '<?php echo $query; ?>' becomes <?php echo $color; ?>.">
				<title>Colorize | <?php echo $query; ?></title>
				<link rel="stylesheet" type="text/css" href="css/page.css">

			</head>
			<body style="background-color: <?php echo $color; ?>">
			<?php } ?>

		<div class="nav">
			<img src="//alexbeals.com/projects/colorize/images/Colorize_Light.png">
			<a href="//alexbeals.com/projects/colorize/">HOME</a>
			<form id="search" action="search.php">
				<input type="search" placeholder="SEARCH..." name="q" />
			</form>
		</div>