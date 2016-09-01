<?php
	$page = "home";

	include("header.php");
?>
		<div class="top">
			<img src="//alexbeals.com/projects/colorize/images/Colorize_Light.png">
			<h1>COLORIZE</h1>
		</div>
		<div class="well">
			<h2>What is Colorize?</h2>
			<p>Colorize is a website that turns any word or phrase into a hex color.  It works by using a search engine to find image results for the word or phrase, and then finding the average color across the approximately 25 image results.  Because of this, there's usually a small delay when a word is searched for the first time.</p>

			<h2>What would I use it for?</h2>
			<p>If you've ever been drawing in Photoshop and thought 'What color is the sky', or have been designing a website and looking for that perfect 'purple' color, or just wanted to know what color sand is, Colorize is the tool for you.</p>

			<div class="cards">
				<a class="card" style="background-color: #6C99C6;" href="search.php?q=sky">
					<div class="center">
						<span class="hex">#6C99C6</span>
						<span class="query">sky</span>
					</div>
				</a>
				<a class="card" style="background-color: #722B92;" href="search.php?q=purple">
					<div class="center">
						<span class="hex">#722B92</span>
						<span class="query">purple</span>
					</div>
				</a>
				<a class="card" style="background-color: #BF9E74;" href="search.php?q=sand">
					<div class="center">
						<span class="hex">#BF9E74</span>
						<span class="query">sand</span>
					</div>
				</a>
			</div>
		</div>
	</body>
</html>