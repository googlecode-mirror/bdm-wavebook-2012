<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('url'))
{
	function url($nom)
	{
		return base_url() . $nom;
	}
}

if ( ! function_exists('css'))
{
	function css($nom)
	{
		return base_url() . 'assets/css/' . $nom . '.css';
	}
}

if ( ! function_exists('js'))
{
	function js($nom)
	{
		return base_url() . 'assets/js/' . $nom . '.js';
	}
}

if ( ! function_exists('img'))
{
	function img($nom)
	{
		return base_url() . 'assets/img/' . $nom;
	}
}

if ( ! function_exists('upload_url'))
{
	function upload_url($nom)
	{
		//...
	}
}


if ( ! function_exists('tags'))
{
	function tags($tags)
	{
		$res = '';
		$tab_tags = explode(',',$tags);
		foreach($tab_tags as $tag)
		{
			if(trim($tag) != '')
			{
				if($res != '')
				{
					$res .= ' , ';
				}
				
				$res .= '<a href="' . base_url() . 'blog/search/' . trim($tag).'">'. trim($tag).'</a>';
			}
		}
		return $res;
	}
}

if ( ! function_exists('img'))
{
	function img($nom, $alt = '')
	{
		//...
	}
}

?>
