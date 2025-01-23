<?php
defined('BASEPATH') or exit('No direct script access allowed');

function pageination_builder($liveFormData , $table_name , $current_page_opened , $limit){

    $CI =& get_instance();

    // This code is creating dynamic pagination 
    foreach($liveFormData as $key=>$value){
        $CI->db->like($key , $value );
    }
    $total_records = $CI->db->count_all_results($table_name);

    // Number of pages 
    $pages = ceil($total_records / $limit);

    // trying new pagination

    // Calculate the range of pages to show
    $max_visible_pages = 3; // Maximum number of pages to display
    $start_page = max(1, $current_page_opened - 1); // Ensure that the page doesn't go below 1
    $end_page = min($pages, $current_page_opened + 1); // Ensure that the page doesn't exceed the total number of pages

    // If there are fewer than $max_visible_pages, adjust the start and end pages
    if ($pages <= $max_visible_pages) {
        $start_page = 1;
        $end_page = $pages;
    } else {
        // Ensure that the range includes at least 3 pages, adjusting for edge cases
        if ($current_page_opened == 1) {
            $end_page = min($max_visible_pages, $pages);
        } elseif ($current_page_opened == $pages) {
            $start_page = max(1, $pages - $max_visible_pages + 1);
        }
    }

    // Generate pagination buttons with a range of 3 pages
    $ulData = " <nav aria-label='Page navigation example'  >
                    <ul class='pagination my-pagination mb-0' id='{$pages}'>
                        <li class='page-item'>
                            <a class='page-link prev'  aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span>
                            </a>
                        </li>";

 // Show previous pages and current page
    for ($k = $start_page; $k <= $end_page; $k++) {
        $class = ($k == $current_page_opened) ? 'active' : '';
        $ulData .= "    <li id='{$k}' class='page-item li $class'>
                            <a class='page-link'>$k</a>
                        </li>";
    }

    // Show next pages if there are more
    $ulData .= "        <li class='page-item'>
                            <a class='page-link next' aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>";

                return $ulData;
}