<?php
	$section = '';

	foreach ( $tags as $tag ) 
	{
		$title = $tag->title;
		
		$first_letter = strtoupper($title{0});

		if ( preg_match('/^[0-9]+$/', $first_letter) )
		{
			$first_letter = '#';
		}

		if ( $section != $first_letter )
		{
			$section = $first_letter;
			
			echo "<h2>$first_letter</h2>";
		}
	

		echo "<a class=\"tag\" href=\"" . site_url() . "/tags/view/{$tag->id}\">{$tag->title}</a> ";
	}
