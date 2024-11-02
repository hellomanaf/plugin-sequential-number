<?php
/*
* Add new Column header for page.
*/
if(!function_exists('wpspn_sequential_page_columns_head')) {
    function wpspn_sequential_page_columns_head($defaults) {
        $defaults['page_d'] = 'Page ID';
        return $defaults;
    }
}

/*
* Add sorting feature.
*/
if(!function_exists('wpspn_sequential_page_sortable_columns_head')) {
    function wpspn_sequential_page_sortable_columns_head( $columns ) {
        $columns['page_d'] = 'Page ID';
        return $columns;
    }
}

/*
* Define the content into new column added.
*/
if(!function_exists('wpspn_sequential_page_columns_content')) {
    function wpspn_sequential_page_columns_content($column_name, $post_ID) {
        if ($column_name == 'page_d') {
            $page_number = wpspn_get_current_post_id( $post_ID );
            echo $page_number;
        }   
    }   
}

/*
* Get the meta value of created page number, if not exist will return the actual id also will update page number.
*/
if(!function_exists('wpspn_get_current_post_id')) {
    function wpspn_get_current_post_id( $actual_post_id ) {
        $post_id = get_post_meta( $actual_post_id, 'page_id_number',true);
        if( !$post_id  ) {
            update_post_meta( $actual_post_id,'page_id_number', $actual_post_id );
            return $actual_post_id;
        }
        return $post_id;
    }
}


/*
* Update the Page number into meta on new page added.
*/
if(!function_exists('wpspn_set_sequential_page_id')) {
    function wpspn_set_sequential_page_id( $post_id, $post ){
        if ( 'page' === $post->post_type && 'auto-draft' !== $post->post_status){
            global $wpdb;

            $previous_post = $wpdb->get_row("SELECT `ID` FROM $wpdb->posts WHERE ID = 
            (SELECT MAX(ID) FROM $wpdb->posts WHERE ID < 
            (SELECT MAX(ID) FROM $wpdb->posts WHERE post_type='page' AND post_status !='auto-draft') 
            AND post_type='page' AND post_status !='auto-draft')");

            $previous_post = $previous_post->ID;

            if( $previous_post ){
                $previous_post_number = get_post_meta( $previous_post,'page_id_number',true);
                if( ! $previous_post_number ){
                    $started_id = $post_id;
                }else {
                    $started_id = $previous_post_number;
                }
            } else {
                $started_id = 1;
            }
            // Check meta already updated.
            $get_page_number = get_post_meta($post_id,'page_id_number',true);

            if ( '' === $get_page_number ) {
                if( $previous_post && ! $previous_post_number ){
                    update_post_meta( $post_id,'page_id_number', $previous_post + 1 );
                } else {
                    update_post_meta( $post_id,'page_id_number', $previous_post_number + 1 );
                }
     
            }

        }
    }
}
?>