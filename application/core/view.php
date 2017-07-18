<?php

class View
{
	/**
	 * $content_file - виды, отображающие контент страниц;
     * $template_file - шаблон;
     * $data - массив контента страницы.
	 */

	function generate($content_view, $template_view, $data = null)
	{
		include 'application/views/'.$template_view;
	}
}
?>
