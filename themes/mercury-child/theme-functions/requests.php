<?php


function zlots_get_related_casino_bonus( $casino_id ) {
	$post_id_related = '"' . $casino_id . '"';
	$query_args = [
		'post_type'      => 'bonus',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 1,
		'meta_query'     => [
			[
				'key'   => 'bonus_parent_casino',
				'value' => $post_id_related,
				'compare' => 'LIKE'
			],
		],
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query[0];
	}

	return null;
}

function zlots_get_recommended_casinos( $number_casinos = 5 ) {
	$query_args = [
		'post_type'      => 'casino',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => $number_casinos,
		'meta_query'     => [
			[
				'key'   => 'zlots_is_recommended_casinos',
				'value' => 'on',
			],
		],
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_slots_for_tab( $tab_name ) {
	$query_args = [
		'post_type'      => 'game',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 8,
		'meta_query'     => [
			[
				'key'   => 'zlots_slots_show_in_tab',
				'value' => $tab_name,
			],
		],
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_top_rated_casinos() {
	$query_args = [
		'post_type'      => 'casino',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 8,
		'meta_key'       => 'casino_overall_rating',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_news_for_front_page() {
	$query_args = [
		'post_type'      => 'news',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 2,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_slots_filter_archive_query($offset = 0, $tax = null, $debug = false, $sort_by = null) {
    // Adjusted post type to 'slot'
    $slot_query_args = [
        'post_type' => 'game', // Assuming 'slot' is the correct post type for slots
        'post_status' => 'publish',
        'fields' => 'ids',
        'no_found_rows' => true,
        'posts_per_page' => 12, // Assuming you want to paginate results
        'orderby' => 'date',
        'order' => 'DESC',
    ];
	
    // Debug information initialization
    $debug_info = ['processing' => [], 'filtered_out' => [], 'initial_count' => 0, 'filtered_count' => 0,'offset' => 0, 'tax' => []];

    // Apply offset if provided
    if ($offset) {
        $slot_query_args['offset'] = $offset;
    }

    // Construct tax_query if taxonomy filters are provided
    if (is_array($tax) && !empty($tax)) {
        $slot_query_args['tax_query'] = ['relation' => 'AND'];
        foreach ($tax as $tax_name => $tax_val) {
            $slot_query_args['tax_query'][] = [
                'taxonomy' => $tax_name,
                'field' => 'slug',
                'terms' => $tax_val,
            ];
        }
    }

    // Fetch slots using the constructed query arguments
    $slots = get_posts($slot_query_args);
    // Assuming sort_by requires custom handling, adjust as needed
    if ($sort_by) {
        // Sorting logic here
        // Note: This example does not include specific sorting logic as it depends on your setup
    }

    // Debug information update
    if ($debug) {
		$debug_info['tax'] = $tax;
		$debug_info['offset'] = $offset;
        $debug_info['initial_count'] = count($slots);
        $debug_info['filtered_count'] = count($slots); // Adjust based on actual filtering applied
    }

    // Return results
    if ($debug) {
        return ['slots' => $slots, 'debug_info' => $debug_info];
    } else {
        return $slots;
    }
}


function zlots_get_casinos_archive_query_with_bonus($offset = 0, $tax = null, $debug = false, $sort_by = null) {
    $casino_query_args = [
        'post_type' => 'casino',
        'post_status' => 'publish',
        'fields' => 'ids',
        'no_found_rows' => true,
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
$debug_info = ['processing' => [], 'filtered_out' => [], 'initial_count' => 0, 'filtered_count' => 0, 'filtered_bonus_found' => [], 'found_casino' => [], 'found_bonus' => [], 'bonus_details' => [], 'panic' => []];
    if ($offset) {
        $casino_query_args['offset'] = $offset;
    }

    if (is_array($tax) && !empty($tax)) {
        $casino_query_args['tax_query'] = ['relation' => 'AND'];
        foreach ($tax as $tax_name => $tax_val) {
            if (!in_array($tax_name, ['amount', 'wager', 'percentage', 'free_spins'])) {
                $casino_query_args['tax_query'][] = [
                    'taxonomy' => $tax_name,
                    'field' => 'slug',
                    'terms' => $tax_val,
                ];
            }
        }
    }

    $casinos = get_posts($casino_query_args);
	
	
	// Initialize the sorting mechanism if 'sort_by' is provided
// Assuming the $sort_by variable is correctly passed and you have access to a method get_terms on a Casino object
if ($sort_by) {
    $priority_casinos = [];
    $other_casinos = [];

    foreach ($casinos as $casino_id) {
        // Instantiate the Casino object for the current $casino_id
        $casino = new Zlots\Casinos\Casino($casino_id);
        
        // Correctly fetch casino categories. Assuming get_terms() returns an array of term objects
        $casino_categories = $casino->get_terms('casino-category');
        $is_priority_casino = false;
        
        // Check if any of the casino's categories match the sort_by parameter
        foreach ($casino_categories as $category) {
            if ($category->slug === $sort_by || $category->name === $sort_by) {
                $is_priority_casino = true;
                break; // Break the loop once a match is found
            }
        }
        
        if ($is_priority_casino) {
            $priority_casinos[] = $casino_id;
        } else {
            $other_casinos[] = $casino_id;
        }
    }

    // Combine arrays, with priority casinos first
    $casinos = array_merge($priority_casinos, $other_casinos);
}

// Continue with the filtering logic...

	$debug_info['panic'][] = "broke";
	$debug_info['panic2'][] = $sort_by;
	
	
    $filtered_casinos = [];
    

    foreach ($casinos as $casino_id) {
		if ($debug) {
     		$debug_info['found_casino'][] = $casino_id;
        }
        
        $casino = new Zlots\Casinos\Casino($casino_id);
        $bonus_id = $casino->get_related_bonus_id();
		
		if ($debug) {
     		$debug_info['found_bonus'][] = $bonus_id;
        }
		
		
        $bonus_meets_criteria = true;
		
        if ($bonus_id) {
			
			if ($debug) {
				$debug_info['filtered_bonus_id'][] = $bonus_id;
			}
            $bonus = new Zlots\Casinos\Bonus($bonus_id);

			if ($debug) {
				$debug_info['bonus_details'][] = $bonus;
			}
			
            $bonus_amount = $bonus->get_amount();
            $bonus_wager = $bonus->get_wager();
            $bonus_percentage = $bonus->get_percentage();
            $bonus_free_spins = $bonus->get_spins();
			
			if ($debug) {
				$debug_info['bonus_amount'][] = $bonus_amount;
			}
			if ($debug) {
				$debug_info['bonus_wager'][] = $bonus_wager;
			}
			if ($debug) {
				$debug_info['bonus_percentage'][] = $bonus_percentage;
			}
			if ($debug) {
				$debug_info['bonus_free_spins'][] = $bonus_free_spins;
			}
			
			
            if (isset($tax['amount'])) {
                $amount_min = $tax['amount']['min'];
                $amount_max = $tax['amount']['max'];

                if (($amount_min != 0 && $bonus_amount < $amount_min) || $bonus_amount > $amount_max) {
					if($amount_min != null){
                    $bonus_meets_criteria = false;
					if ($debug) {
						$debug_info['broke_amount'][] = $bonus_free_spins;
						$debug_info['broke_amount_by_min'][] = $amount_min;
						$debug_info['broke_amount_by_max'][] = $amount_max;
					}
					}
                }
            }

            if (isset($tax['wager'])) {
                $wager_min = $tax['wager']['min'];
                $wager_max = $tax['wager']['max'];

                if (($wager_min != 0 && $bonus_wager < $wager_min) || $bonus_wager > $wager_max) {
					if($wager_min != null){
                    $bonus_meets_criteria = false;
					if ($debug) {
						$debug_info['broke_wager'][] = $bonus_free_spins;
					}
					}
                }
            }

            if (isset($tax['percentage'])) {
                $percentage_min = $tax['percentage']['min'];
                $percentage_max = $tax['percentage']['max'];

                if (($percentage_min != 0 && $bonus_percentage < $percentage_min) || $bonus_percentage > $percentage_max) {
					if($percentage_min != null){
                    $bonus_meets_criteria = false;
					if ($debug) {
						$debug_info['broke_percentage'][] = $bonus_free_spins;
					}
					}
                }
            }

            if (isset($tax['free_spins'])) {
                $free_spins_min = $tax['free_spins']['min'];
                $free_spins_max = $tax['free_spins']['max'];

                if (($free_spins_min != 0 && $bonus_free_spins < $free_spins_min) || $bonus_free_spins > $free_spins_max) {
					if($free_spins_min != null){
                    $bonus_meets_criteria = false;
					if ($debug) {
						$debug_info['broke_free_spins'][] = $bonus_free_spins;
					}
					}
                }
            }
        } else {
            if ((isset($tax['amount']) && $tax['amount']['min'] != 0) ||
                (isset($tax['wager']) && $tax['wager']['min'] != 0) ||
                (isset($tax['percentage']) && $tax['percentage']['min'] != 0) ||
                (isset($tax['free_spins']) && $tax['free_spins']['min'] != 0)) {
                $bonus_meets_criteria = false;
				if ($debug) {
						$debug_info['broke_invalid'][] = $bonus_free_spins;
					}
            }
        }

        if ($bonus_meets_criteria) {
            $filtered_casinos[] = $casino_id;
        } else {
            if ($debug) {
                $debug_info['filtered_out'][] = $casino_id;
            }
        }
    }

    if ($debug) {
        $debug_info['initial_count'] = count($casinos);
        $debug_info['filtered_count'] = count($filtered_casinos);
        $debug_info['filtered_casinos'] = array_slice($filtered_casinos, $offset, 12);
        return ['filtered_casinos' => array_slice($filtered_casinos, $offset, 12), 'debug_info' => $debug_info];
    } else {
        return array_slice($filtered_casinos, $offset, 12);
    }
}






function zlots_get_casinos_archive_query( $offset = 0, $tax = null ) {
	$query_args = [
		'post_type'      => 'casino',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 12,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	if ( $offset ) {
		$query_args['offset'] = $offset;
	}

	if ( is_array( $tax ) && ! empty( $tax ) ) {
		$query_args['tax_query'] = [ 'relation' => 'AND' ];

		foreach ( $tax as $tax_name => $tax_val ) {
			$query_args['tax_query'][] = [
				'taxonomy' => $tax_name,
				'field'    => 'slug',
				'terms'    => $tax_val,
			];
		}
	}

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_bonuses_archive_query($current_page = 1, $offset = 0) {
	$query_args = [
		'post_type'      => 'bonus',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 12,
		'paged'          => $current_page,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}
/*
function zlots_get_casinos_archive_html($casinos_ids) {

	if ( ! is_array( $casinos_ids ) ) {
		return null;
	}

	$html = '';

	ob_start();
	foreach ( $casinos_ids as $casino_id ) {
		get_template_part( 'theme-parts/item-archive-casino', null, [ 'casino_id' => $casino_id ] );
	}
	$html .= ob_get_clean();

	return $html;
}*/

function zlots_get_casinos_archive_html($casinos_ids, $debug = false) {
    if (!is_array($casinos_ids)) {
        return null;
    }

    $html = '';
    $debug_info = [];

	if ($debug) {
            $debug_info['casinos_list'][] = $casinos_ids;
        }
	
    ob_start();
    foreach ($casinos_ids as $casino_id) {
        if ($debug) {
            $debug_info['processing'][] = "Processing casino ID: $casino_id";
        }
        get_template_part('theme-parts/item-archive-casino', null, ['casino_id' => $casino_id]);
    }
    $html .= ob_get_clean();

    if ($debug) {
        $debug_info['total_processed'] = count($casinos_ids);
        $debug_info['html_length'] = strlen($html);
        // Optionally, you can print the debug information directly to the browser
        // echo '<pre>' . print_r($debug_info, true) . '</pre>';
        
        // Or return it along with the HTML
        return ['html' => $html, 'debug_info' => $debug_info];
    }

    return $html;
}


function zlots_get_bonuses_archive_html($bonuses_ids) {

	if ( ! is_array( $bonuses_ids ) ) {
		return null;
	}

	$html = '';

	ob_start();
	foreach ( $bonuses_ids as $bonus_id ) {
		get_template_part( 'theme-parts/item-archive-bonus', null, [ 'bonus_id' => $bonus_id ] );
	}
	$html .= ob_get_clean();

	return $html;
}

function zlots_get_slots_archive_filter_query($offset = 0, $debug = false, $categories, $vendors) {
    $debug_info = [
        'query_args' => [],
        'slot_ids' => [],
        'count' => 0,
        'errors' => [],
        'slot_categories' => [],
        'slot_vendors' => [],
        'debug_messages' => [] // Collect debug messages here
    ];

    $query_args = [
        'post_type'      => 'game',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $tax_query = ['relation' => 'AND'];

    if (!empty($categories)) {
        $tax_query[] = [
            'taxonomy' => 'game-category',
            'field'    => 'slug',
            'terms'    => $categories,
            'operator' => 'IN',
        ];
    }

    if (!empty($vendors)) {
        $tax_query[] = [
            'taxonomy' => 'vendor',
            'field'    => 'slug',
            'terms'    => $vendors,
            'operator' => 'IN',
        ];
    }

    if (count($tax_query) === 2) {
        unset($tax_query['relation']);
    }

    $query_args['tax_query'] = $tax_query;

    // Debugging tax_query
    $debug_info['debug_messages'][] = 'Tax Query: ' . print_r($tax_query, true);

    $query = get_posts($query_args);

    // Debugging total number of fetched posts
    $debug_info['debug_messages'][] = 'Total fetched posts: ' . count($query);

    $posts_per_page = 15;
    $sliced_query = array_slice($query, $offset, $posts_per_page);

    if ($debug) {
        $debug_info['query_args'] = $query_args;
        $debug_info['slot_ids'] = $sliced_query;
        $debug_info['count'] = count($sliced_query);

    foreach ($query as $post_id) {
        $post_categories = wp_get_post_terms($post_id, 'game-category', ['fields' => 'slugs']);
        $post_vendors = wp_get_post_terms($post_id, 'vendor', ['fields' => 'slugs']);
        $debug_info['debug_messages'][] = "Post ID $post_id Categories: " . implode(', ', $post_categories);
        $debug_info['debug_messages'][] = "Post ID $post_id Vendors: " . implode(', ', $post_vendors);
    }


		
        foreach ($sliced_query as $slot_id) {
            $slot_categories = wp_get_post_terms($slot_id, 'game-category', ['fields' => 'slugs']);
            $debug_info['slot_categories'][$slot_id] = is_wp_error($slot_categories) ? [] : $slot_categories;

            $slot_vendors = wp_get_post_terms($slot_id, 'vendor', ['fields' => 'slugs']);
            $debug_info['slot_vendors'][$slot_id] = is_wp_error($slot_vendors) ? [] : $slot_vendors;
        }

        // Logging detailed debug information
        foreach ($debug_info['debug_messages'] as $message) {
            error_log($message);
        }

        return ['slots' => $sliced_query, 'debug_info' => $debug_info];
    } else {
        return $sliced_query;
    }
}


/* v2
function zlots_get_slots_archive_filter_query($offset = 0, $debug = false, $categories) {
    // Debug information initialization
    $debug_info = [
        'query_args' => [],
        'slot_ids' => [],
        'count' => 0,
        'errors' => [],
        'slot_categories' => [] // Initialize slot categories for debugging
    ];

    // The number of posts per page is fixed at 15 for the slice operation later.
    $posts_per_page = 15;

    $query_args = [
        'post_type'      => 'game',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'no_found_rows'  => true, // Pagination not required for total count
        'posts_per_page' => -1, // Fetch all matching slots initially
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    // Construct the taxonomy query if categories are provided
    if (!empty($categories)) {
        $query_args['tax_query'] = [
            [
                'taxonomy' => 'game-category',
                'field'    => 'slug',
                'terms'    => $categories,
                'operator' => 'IN',
            ]
        ];
    }

    // Execute the query
    $query = get_posts($query_args);

    // Slice the result according to the offset and posts per page after fetching all matching slots
    $sliced_query = array_slice($query, $offset, $posts_per_page);

    // Update debug information post-query
    if ($debug) {
        $debug_info['query_args'] = $query_args;
        $debug_info['slot_ids'] = $sliced_query; // Use sliced_query to show the result within the debug limit
        $debug_info['count'] = count($sliced_query);

        // Fetch categories for each slot ID in the sliced query for debugging
        foreach ($sliced_query as $slot_id) {
            $slot_categories = wp_get_post_terms($slot_id, 'game-category', ['fields' => 'names']);
            $debug_info['slot_categories'][$slot_id] = is_wp_error($slot_categories) ? [] : $slot_categories;
        }

        return ['slots' => $sliced_query, 'debug_info' => $debug_info];
    } else {
        return $sliced_query;
    }
}
*/
/*
function zlots_get_slots_archive_query( $current_page = 1, $offset = 0, $debug = false ) {
    // Debug information initialization
    $debug_info = [
        'query_args' => [],
        'slot_ids' => [],
        'count' => 0,
        'errors' => []
    ];

    $query_args = [
        'post_type'      => 'game',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'posts_per_page' => 15,
        'paged'          => $current_page,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];

    // Update debug_info with the query arguments
    if ($debug) {
        $debug_info['query_args'] = $query_args;
    }

    $query = get_posts( $query_args );

    if ($debug) {
        if ($query && is_array($query)) {
            $debug_info['slot_ids'] = $query;
            $debug_info['count'] = count($query);
        } else {
            $debug_info['errors'][] = "No slots found or query failed.";
        }
    }

    // Return slots and debug information if debugging is enabled
    if ($debug) {
        return ['slots' => $query, 'debug_info' => $debug_info];
    }

    // Return just the slots if debugging is not requested
    return $query ? $query : null;
}*/


function zlots_get_slots_archive_query( $current_page = 1, $offset = 0 ) {
	$query_args = [
		'post_type'      => 'game',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 15,
		'paged'          => $current_page,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_slots_archive_html( $slots_ids ) {

	if ( ! is_array( $slots_ids ) ) {
		return null;
	}

	$html = '';

	ob_start();
	foreach ( $slots_ids as $slot_id ) {
		get_template_part( 'theme-parts/slot-item', null, [ 'slot_id' => $slot_id ] );
	}
	$html .= ob_get_clean();

	return $html;
}

function zlots_get_slots_for_front_page() {
	$current_slot = null;

	if ( is_singular( 'game' ) ) {
		$current_slot = get_the_ID();
	}

	$query_args = [
		'post_type'      => 'game',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	if ( $current_slot ) {
		$query_args['post__not_in'] = [ $current_slot ];
	}

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_vendor_archive_query( $offset = 0 ) {
	$query_args = [
		'taxonomy' => 'vendor',
		'fields'   => 'ids',
		'number'   => 12,
		'orderby'  => 'name',
		'order'    => 'ASC'
	];

	$query = get_terms( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_vendor_archive_html( $vendor_ids ) {

	if ( ! is_array( $vendor_ids ) ) {
		return null;
	}

	$html = '';

	ob_start();
	foreach ( $vendor_ids as $vendor_id ) {
		get_template_part( 'theme-parts/item-archive-vendor', null, [ 'vendor_id' => $vendor_id ] );
	}
	$html .= ob_get_clean();

	return $html;
}

function zlots_get_top_providers(){
	$query_args = [
		'taxonomy' => 'vendor',
		'fields'   => 'ids',
		'number'   => 10,
		'orderby'  => 'name',
		'order'    => 'ASC'
	];

	$query = get_terms( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_provider_casinos_ids( $provider_id ) {
	$query_args = [
		'post_type'      => 'casino',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 5,
		'tax_query'      => [
			[
				'taxonomy' => 'vendor',
				'field'    => 'id',
				'terms'    => $provider_id
			]
		],
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_post_count_for_term( $term_slug, $post_type = 'game', $taxonomy = 'vendor' ) {
	global $wpdb;

	$sql = $wpdb->prepare( "
    SELECT COUNT(p.ID)
    FROM {$wpdb->posts} p
    INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
    INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
    WHERE tt.taxonomy = %s
    AND t.slug = %s
    AND p.post_type = %s
    AND p.post_status = 'publish'
", $taxonomy, $term_slug, $post_type );

	return $wpdb->get_var( $sql );
}

function zlots_get_provider_recent_slots_ids( $provider_id ) {
	$query_args = [
		'post_type'      => 'game',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 8,
		'tax_query'      => [
			[
				'taxonomy' => 'vendor',
				'field'    => 'id',
				'terms'    => $provider_id
			]
		],
		'orderby'        => 'date',
		'order'          => 'DESC'
	];

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_provider_all_slots_ids($provider_id, $exclude_id = null){
	$query_args = [
		'post_type'      => 'game',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'posts_per_page' => 20,
		'tax_query'      => [
			[
				'taxonomy' => 'vendor',
				'field'    => 'id',
				'terms'    => $provider_id
			]
		],
		'orderby'        => 'name',
		'order'          => 'ASC'
	];

	if ( ! empty( $exclude_id ) ) {
		$query_args['post__not_in'] = $exclude_id;
	}

	$query = get_posts( $query_args );

	if ( $query && is_array( $query ) ) {
		return $query;
	}

	return null;
}

function zlots_get_terms_by_post_type( $taxonomies, $post_types ) {

	global $wpdb;

	$query = $wpdb->prepare("
SELECT t.*, COUNT(*) from $wpdb->terms AS t
INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id
INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id
WHERE p.post_type IN('%s') AND tt.taxonomy IN('%s')
GROUP BY t.term_id", $post_types, $taxonomies );

	$results = $wpdb->get_results( $query );

	return $results;
}
function zlots_get_filter_slots_tax() {
	$tax = null;

	$categories         = filter_input( INPUT_POST, 'casino-category', FILTER_UNSAFE_RAW );
	$providers          = filter_input( INPUT_POST, 'vendor', FILTER_UNSAFE_RAW );

		//Slider based inputs
	$slots_amount_min         = filter_input( INPUT_POST, 'slots_amount_min', FILTER_SANITIZE_NUMBER_INT );
	$slots_amount_min         = filter_input( INPUT_POST, 'slots_amount_max', FILTER_SANITIZE_NUMBER_INT );

	
	

	if ( $categories ) {
		$tax['casino-category'] = $categories;
	}
	if ( $providers ) {
		$tax['vendor'] = $providers;
	}

	
		//Slider Based Tax

	if ($slots_amount_min !== false && $slots_amount_max !== false) {
		$tax['slots_amount'] = ['min' => $slots_amount_min, 'max' => $slots_amount_max];
	}

	return $tax;
}
function zlots_get_slider_filter_casinos_tax() {
	$tax = null;

	$categories         = filter_input( INPUT_POST, 'casino-category', FILTER_UNSAFE_RAW );
	$providers          = filter_input( INPUT_POST, 'vendor', FILTER_UNSAFE_RAW );
	$deposit_method     = filter_input( INPUT_POST, 'deposit-method', FILTER_UNSAFE_RAW );
	$withdrawal_method  = filter_input( INPUT_POST, 'withdrawal-method', FILTER_UNSAFE_RAW );
	$withdrawal_limit   = filter_input( INPUT_POST, 'withdrawal-limit', FILTER_UNSAFE_RAW );
	$restricted_country = filter_input( INPUT_POST, 'restricted-country', FILTER_UNSAFE_RAW );
	$licence            = filter_input( INPUT_POST, 'licence', FILTER_UNSAFE_RAW );
	$casino_language    = filter_input( INPUT_POST, 'casino-language', FILTER_UNSAFE_RAW );
	$currency           = filter_input( INPUT_POST, 'currency', FILTER_UNSAFE_RAW );
	$device             = filter_input( INPUT_POST, 'device', FILTER_UNSAFE_RAW );
	$owner              = filter_input( INPUT_POST, 'owner', FILTER_UNSAFE_RAW );
	$casino_est         = filter_input( INPUT_POST, 'casino-est', FILTER_UNSAFE_RAW );

	
	
			//Skortkoden är korrekt registrerad
	
	function setup_zlots_recommended_casinos() {
    add_shortcode('zlots-recommended-casinos-block', 'zlots_display_recommended_casinos');
}
add_action('init', 'setup_zlots_recommended_casinos');

			//kortkoden är korrekt registrerad
	
	
		//Slider based inputs
	$amount_min         = filter_input( INPUT_POST, 'amount_min', FILTER_SANITIZE_NUMBER_INT );
    $amount_max         = filter_input( INPUT_POST, 'amount_max', FILTER_SANITIZE_NUMBER_INT );
    $wager_min          = filter_input( INPUT_POST, 'wager_min', FILTER_SANITIZE_NUMBER_INT );
    $wager_max          = filter_input( INPUT_POST, 'wager_max', FILTER_SANITIZE_NUMBER_INT );
    $percentage_min     = filter_input( INPUT_POST, 'percentage_min', FILTER_SANITIZE_NUMBER_INT );
    $percentage_max     = filter_input( INPUT_POST, 'percentage_max', FILTER_SANITIZE_NUMBER_INT );
    $free_spins_min     = filter_input( INPUT_POST, 'free_spins_min', FILTER_SANITIZE_NUMBER_INT );
    $free_spins_max     = filter_input( INPUT_POST, 'free_spins_max', FILTER_SANITIZE_NUMBER_INT );

	
	

	if ( $categories ) {
		$tax['casino-category'] = $categories;
	}
	if ( $providers ) {
		$tax['vendor'] = $providers;
	}
	if ( $deposit_method ) {
		$tax['deposit-method'] = $deposit_method;
	}
	if ( $withdrawal_method ) {
		$tax['withdrawal-method'] = $withdrawal_method;
	}
	if ( $withdrawal_limit ) {
		$tax['withdrawal-limit'] = $withdrawal_limit;
	}
	if ( $restricted_country ) {
		$tax['restricted-country'] = $restricted_country;
	}
	if ( $licence ) {
		$tax['licence'] = $licence;
	}
	if ( $casino_language ) {
		$tax['casino-language'] = $casino_language;
	}
	if ( $currency ) {
		$tax['currency'] = $currency;
	}
	if ( $device ) {
		$tax['device'] = $device;
	}
	if ( $owner ) {
		$tax['owner'] = $owner;
	}
	if ( $casino_est ) {
		$tax['casino-est'] = $casino_est;
	}

	
		//Slider Based Tax

	if ($amount_min !== false && $amount_max !== false) {
		$tax['amount'] = ['min' => $amount_min, 'max' => $amount_max];
	}
	if ($wager_min !== false && $wager_max !== false) {
		$tax['wager'] = ['min' => $wager_min, 'max' => $wager_max];
	}
	if ($percentage_min !== false && $percentage_max !== false) {
		$tax['percentage'] = ['min' => $percentage_min, 'max' => $percentage_max];
	}
	if ($free_spins_min !== false && $free_spins_max !== false) {
		$tax['free_spins'] = ['min' => $free_spins_min, 'max' => $free_spins_max];
	}


	return $tax;
}

/*OLD*/
function zlots_get_filter_casinos_tax() {
	$tax = null;

	$categories         = filter_input( INPUT_POST, 'casino-category', FILTER_UNSAFE_RAW );
	$providers          = filter_input( INPUT_POST, 'vendor', FILTER_UNSAFE_RAW );
	$deposit_method     = filter_input( INPUT_POST, 'deposit-method', FILTER_UNSAFE_RAW );
	$withdrawal_method  = filter_input( INPUT_POST, 'withdrawal-method', FILTER_UNSAFE_RAW );
	$withdrawal_limit   = filter_input( INPUT_POST, 'withdrawal-limit', FILTER_UNSAFE_RAW );
	$restricted_country = filter_input( INPUT_POST, 'restricted-country', FILTER_UNSAFE_RAW );
	$licence            = filter_input( INPUT_POST, 'licence', FILTER_UNSAFE_RAW );
	$casino_language    = filter_input( INPUT_POST, 'casino-language', FILTER_UNSAFE_RAW );
	$currency           = filter_input( INPUT_POST, 'currency', FILTER_UNSAFE_RAW );
	$device             = filter_input( INPUT_POST, 'device', FILTER_UNSAFE_RAW );
	$owner              = filter_input( INPUT_POST, 'owner', FILTER_UNSAFE_RAW );
	$casino_est         = filter_input( INPUT_POST, 'casino-est', FILTER_UNSAFE_RAW );

	

	if ( $categories ) {
		$tax['casino-category'] = $categories;
	}
	if ( $providers ) {
		$tax['vendor'] = $providers;
	}
	if ( $deposit_method ) {
		$tax['deposit-method'] = $deposit_method;
	}
	if ( $withdrawal_method ) {
		$tax['withdrawal-method'] = $withdrawal_method;
	}
	if ( $withdrawal_limit ) {
		$tax['withdrawal-limit'] = $withdrawal_limit;
	}
	if ( $restricted_country ) {
		$tax['restricted-country'] = $restricted_country;
	}
	if ( $licence ) {
		$tax['licence'] = $licence;
	}
	if ( $casino_language ) {
		$tax['casino-language'] = $casino_language;
	}
	if ( $currency ) {
		$tax['currency'] = $currency;
	}
	if ( $device ) {
		$tax['device'] = $device;
	}
	if ( $owner ) {
		$tax['owner'] = $owner;
	}
	if ( $casino_est ) {
		$tax['casino-est'] = $casino_est;
	}


	return $tax;
}

