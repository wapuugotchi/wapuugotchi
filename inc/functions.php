<?php

function wapuugotchi_first_post_active() {
	return true;
}
function wapuugotchi_first_post_completed() {
    return (wp_count_posts()->publish > 1); 
}