<?php
$listing_page_url = imic_get_template_url('template-listing.php');
$output = '';
		$output .= '<div class="search-form">
                    <div class="search-form-inner">
					<div class="row parent-category-row">
					<div class="container">
					<div class="listing-header">
                    	<h3>'.__('Browse our categories', 'framework').'</h3>
                    </div><div class="categorty-browse-cols">';
		$list_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
		foreach($list_cats as $cat)
		{
			$listing_sub_cats = array();
			$output .= '<div class="categorty-browse-col"><ul>';
			$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cat->slug,$listing_page_url)).'">'.$cat->name.'</a></li>';
			$listing_sub_cats = get_terms('listing-category',array('parent' => $cat->term_id));
			if(!empty($listing_sub_cats))
			{
				$output .= '<ul>';
				foreach($listing_sub_cats as $cats)
				{
					$listing_sub_cats_third = array();
					$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cats->slug,$listing_page_url)).'">'.$cats->name.'</a></li>';
					$listing_sub_cats_third = get_terms('listing-category',array('parent' => $cats->term_id));
					if(!empty($listing_sub_cats_third))
					{
						$output .= '<ul>';
						foreach($listing_sub_cats_third as $cats_t)
						{
							$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cats_t->slug,$listing_page_url)).'">'.$cats_t->name.'</a></li>';
						}
						$output .= '</ul>';
					}
				}
				
				$output .= '</ul>';
			}
			$output .= '</ul></div>';
		}
		$output .= '</div></div></div></div></div>';
		echo $output;