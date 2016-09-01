<?php
	include("secret.php");

	// Scrapes request from Google Images for the first supply of images
	function getImagesFromWord($string) {
		// Google Images base url
		$base_url = "https://www.google.com/search?as_st=y&tbm=isch&as_q=";

		$raw_search = file_get_contents($base_url . urlencode($string));

		/* Process to extract images
		   Sample chunk:
		 
			<a href="/url?q=http://www.phillymag.com/foobooz/2015/12/30/what-mattered-to-you-in-2015-cheese-idiots-beer-and-tacos/&amp;sa=U&amp;ved=0ahUKEwj7x4ruptfKAhVMPhQKHRcNB_8QwW4IFjAA&amp;usg=AFQjCNGtvTvPed49pKooC9SJHUhQJMrQXw">
				<img height="104" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkiWGXvE-52FlEELbxQ1guyFbkDcB2LS234i0JClQzFk5-BMX_WVJHWvI" width="150" alt="Image result for cheese">
			</a>
		*/
		preg_match_all("/<a href=\"\/url\?q=.*?\"><img.*?src=\"(.*?)\".*?><\/a>/s", $raw_search, $images);

		return $images[1];
	}

	// Takes in an array of image URLs, and returns a single color
	function getColorFromImages($images) {
		$colors = [
			"red" => 0,
			"green" => 0,
			"blue" => 0
		];

		$num = 0;

		foreach ($images as $image) {
			$color = getColorFromImage($image);

			// if it's null, don't include the data (warps results)
			if (!is_null($color)) {
				$num += 1;
			}

			$colors["red"] += $color["red"];
			$colors["green"] += $color["green"];
			$colors["blue"] += $color["blue"];
		}

		$colors["red"] = (int)($colors["red"]/$num);
		$colors["green"] = (int)($colors["green"]/$num);
		$colors["blue"] = (int)($colors["blue"]/$num);

		return colorToHexString($colors);
	}

	// Takes in an array returned from imagecolorsforindex, and turns it into hex
	function colorToHexString($color) {
		return strtoupper("#" . substr("00" . dechex($color["red"]), -2) . substr("00" . dechex($color["green"]), -2) . substr("00" . dechex($color["blue"]), -2));
	}

	// Takes in a single image url, scales it to one pixel, and returns that color (the average)
	function getColorFromImage($image_url) {
		$image_data = getimagesize($image_url);
		$width = $image_data[0];
		$height = $image_data[1];

		$pixel = imagecreatetruecolor(1, 1);

		if ($image_data["mime"] == "image/jpeg") {
			$image = imagecreatefromjpeg($image_url);
		} else if ($image_data["mime"] == "image/png") {
			$image = imagecreatefrompng($image_url);			
			imagealphablending($pixel, false);
			imagesavealpha($pixel, true);
			$transparent = imagecolorallocatealpha($pixel, 255, 255, 255, 127);
			imagefilledrectangle($pixel, 0, 0, 1, 1, $transparent);
		} else {
			// echo $image_data['mime'];
		}

		imagecopyresampled($pixel, $image, 0, 0, 0, 0, 1, 1, $width, $height);
		$color = imagecolorsforindex($pixel, imagecolorat($pixel, 0, 0));

		return $color;
	}

	// Uses relative luminance to determine font color
	function getTextColor($hex) {
		$color = substr($hex, 1); // strip #
		$rgb = intval($color, 16);
		$r = ($rgb >> 16) & 0xff;
		$g = ($rgb >> 8) & 0xff;
		$b = ($rgb >> 0) & 0xff;

		$luma = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;

		if ($luma > 215) { // too bright for white text
			return "#333";
		} else {
			return "white";
		}
	}

	// If there's no query, redirect
	if (!isset($_GET["q"]) || $_GET["q"] == "") {
		header('Location: //alexbeals.com/projects/colorize/');
	}

	// Otherwise, this is the query
	$query = $_GET["q"];

	// Check if the query has been made, and is thus in the database
	$PDO = getDatabase();
	$stmt = $PDO->prepare("SELECT * FROM associations WHERE query=:query");
	$stmt->bindValue(":query", $query, PDO::PARAM_STR);
	$stmt->execute();

	$color = "";

	if ($stmt->rowCount() == 1) {
		$color = $stmt->fetch()["color"];

		// Increment count of times viewed by one
		$stmt = $PDO->prepare("UPDATE associations SET count = count + 1 WHERE query=:query");
		$stmt->bindValue(":query", $query, PDO::PARAM_STR);
		$stmt->execute();
	} else {
		// Query is new, generate it
		$color = getColorFromImages(getImagesFromWord($query));

		// Check to make sure that someone didn't JUST add it
		$stmt = $PDO->prepare("SELECT * FROM associations WHERE query=:query");
		$stmt->bindValue(":query", $query, PDO::PARAM_STR);
		$stmt->execute();

		if ($stmt->rowCount() == 0) {
			// Add it to the database
			$add = $PDO->prepare("INSERT INTO associations (query, color) VALUES (:query, :color)");
			$add->bindValue(":query", $query, PDO::PARAM_STR);
			$add->bindValue(":color", $color, PDO::PARAM_STR);
			$add->execute();
		} else {
			$color = $stmt->fetch()["color"];

			// Increment count of times viewed by one
			$stmt = $PDO->prepare("UPDATE associations SET count = count + 1 WHERE query=:query");
			$stmt->bindValue(":query", $query, PDO::PARAM_STR);
			$stmt->execute();
		}
	}

	// Ouput the page with the color
	$page = "search";

	include("header.php"); 
?>
		<div class="display" style="color: <?php echo getTextColor($color); ?>;">
			<div class="center">
				<span class="hex"><?php echo $color; ?></span>
				<span class="query"><?php echo strtolower($query); ?></span>
			</div>
		</div>
	</body>
</html>