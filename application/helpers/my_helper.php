<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Helpers
 *
 */

// ------------------------------------------------------------------------

if ( ! function_exists('check_login'))
{
    /**
     * Checking if user login.
     *
     * @return bool
     */
	function check_login()
	{
		return  isset($_SESSION['id']);
	}
}


// ------------------------------------------------------------------------

if ( ! function_exists('back'))
{
    /**
     * Redirect on the previous page.
     *
     * @return bool
     */
    function back()
    {
        redirect($_SERVER['HTTP_REFERER']);
    }
}


// ------------------------------------------------------------------------

if ( ! function_exists('set_active'))
{
    /**
     * Set active class.
     *
     * @param string $uri
     * @return bool
     */
    function set_active($uri)
    {
        return ( uri_string() == $uri ) ? "class='active'" : '';
    }
}


// ------------------------------------------------------------------------