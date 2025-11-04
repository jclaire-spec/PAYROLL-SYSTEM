<?php
/*
 * Create links to your pages when you split your data into several pages.
 *
 * PHP versions 4 and 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author 	  Nashruddin Amin <me@nashruddin.com>
 * @copyright Nashruddin Amin 2008
 * @license	  GNU General Public License 3.0
 * @version   1.0
 */
function get_paginate_links($total_rows, $entries_per_page, $current_page, $link_to)
{
	$total_page = ceil($total_rows / $entries_per_page);
	$str_page	= (strpos($link_to, "?") === false) ? "?page" : "&amp;page";
	
	if ($current_page == 1) {
		$paginate_links = "<div>&laquo; Prev</div>";
	} else {
		$paginate_links = "<div><a href=\"$link_to$str_page=" . ($current_page - 1) . 
							"\">&laquo; Prev</a></div>";
	}
	
	for ($i = 1; $i <= $total_page; $i++) {
		if ($i == $current_page) {
			$paginate_links .= "<div class=\"current-page\">$i</div>";
		} else {
			$paginate_links .= "<div><a href=\"$link_to$str_page=$i\">$i</a></div>";
		}
	}
	
	if ($current_page == $total_page) {
		$paginate_links .= "<div>Next &raquo;</div>";
	} else {
		$paginate_links .= "<div><a href=\"$link_to$str_page=" . ($current_page + 1) . 
							"\">Next &raquo;</a></div>";
	}
	
	print $paginate_links;
}
