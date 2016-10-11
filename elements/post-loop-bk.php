<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wpsb_Post_Loop extends WP_Widget{

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'wpsb_post_loop', // Base ID
            __( 'Post Loop', 'wp-sitebuilder' ), // Name
            array( 'description' => __( 'Post Loop', 'wp-sitebuilder' ), ) // Args
        );
    }


    function form($i){
        if( empty($i) ) {
            $i = array();
        }
        ?>
        <div class="wpsb_widget_form">
            <input type="hidden" v-model="instance.settings.slider_id" name="<?php echo $this->get_field_name('settings');?>[slider_id]" >
            <div class="mb10">
                <a href="javascript:" data-target="slides" class="btn btn-default br0" @click="selected_tab = 'slides'"><?php _e('Slides','wpsb'); ?></a>
                <a href="javascript:" data-target="settings" class="btn btn-default br0" @click="selected_tab = 'settings'"><?php _e('Settings','wpsb'); ?></a>
            </div>
            <!--Slides-->
            <div v-show="selected_tab == 'slides'" style="border: 1px solid #ccc; padding: 5px;">
                <div class="container-fluid">
                    <div class="row wpsb_element_panel">
                        <div class="col-sm-8">
                            <div class="mb10">
                                <?php
                                $post_types = get_post_types();
                                $taxonomies = array();
                                ?>
                                <div class="mb10">
                                    <select class="form-control" v-model="instance.data.post_type" name="<?php echo $this->get_field_name('data');?>[post_type]">
                                        <?php
                                        foreach ( $post_types as $post_type => $post_type_label ) {
                                            ?>
                                            <option value="<?php echo $post_type?>"><?php echo $post_type_label; ?></option>
                                            <?php
                                            $all_taxes = get_object_taxonomies($post_type);

                                            foreach ( $all_taxes as $tax ){
                                                $taxonomies[$post_type][$tax] = get_terms( $tax );
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div v-for="( post_type , taxonomies ) in post_taxonomies" v-if="post_type == instance.data.post_type" class="mb10">
                                    <div class="mb10" v-for="(taxonomy, terms) in taxonomies">
                                        <select class="form-control mb10" v-model="instance.data.taxonomies[taxonomy]" name="<?php echo $this->get_field_name('data');?>[taxonomies][{{ taxonomy }}][]" multiple >
                                            <option value=""></option>
                                            <option v-for="(key, each_term) in terms" value="{{ each_term.term_id }}">
                                                {{ each_term.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb10">
                                    <label><?php _e('Data to show :','wpsb');?></label>
                                    <div>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.thumbnail" name="<?php echo $this->get_field_name('data');?>[slide_content][thumbnail]" value="true">
                                            <?php _e('Thumbnail','wpsb');?>
                                        </label>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.title" name="<?php echo $this->get_field_name('data');?>[slide_content][title]" value="true">
                                            <?php _e('Title','wpsb');?>
                                        </label>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.content" name="<?php echo $this->get_field_name('data');?>[slide_content][content]" value="true">
                                            <?php _e('Content','wpsb');?>
                                        </label>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.author" name="<?php echo $this->get_field_name('data');?>[slide_content][author]" value="true">
                                            <?php _e('Author','wpsb');?>
                                        </label>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.date" name="<?php echo $this->get_field_name('data');?>[slide_content][date]" value="true">
                                            <?php _e('Date','wpsb');?>
                                        </label>
                                        <label>
                                            <input type="checkbox" v-model="instance.data.slide_content.excerpt" name="<?php echo $this->get_field_name('data');?>[slide_content][excerpt]" value="true">
                                            <?php _e('Excerpt','wpsb');?>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb10">
                                    <label><?php _e('Number of posts (leave blank to grab all posts) '); ?></label>
                                    <input type="number" class="form-control" v-model="instance.data.slide_content.numposts" name="<?php echo $this->get_field_name('data');?>[slide_content][numposts]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Settings-->
            <div v-show="selected_tab == 'settings'" style="border: 1px solid #ccc; padding: 5px;">
                <div>
                    <label><?php _e('Slider width (leave blank to cover the entire area of parent)','wpsb'); ?></label>
                    <input class="form-control" type="number" v-model="instance.settings.width" name="<?php echo $this->get_field_name('settings');?>[width]" /><?php _e('px','wpsb');?>
                </div>
                <div>
                    <label><?php _e('Slider height','wpsb'); ?></label>
                    <input class="form-control" type="number" v-model="instance.settings.height" name="<?php echo $this->get_field_name('settings');?>[height]" /><?php _e('px','wpsb');?>
                </div>
                <div>
                    <label><?php _e('Slider interval','wpsb'); ?></label>
                    <input type="number" class="form-control" v-model="instance.settings.interval" name="<?php echo $this->get_field_name('settings');?>[interval]">
                </div>
                <div>
                    <label>
                        <input type="checkbox" v-model="instance.settings.show_nav" name="<?php echo $this->get_field_name('settings');?>[show_nav]" value="true">
                        <?php _e('Show navigation','wpsb'); ?>
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" v-model="instance.settings.pause" name="<?php echo $this->get_field_name('settings');?>[pause]" value="hover">
                        <?php _e('Pause on hover','wpsb'); ?>
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" v-model="instance.settings.keyboard" name="<?php echo $this->get_field_name('settings');?>[keyboard]" value="true">
                        <?php _e('Enable keyboard navigation','wpsb'); ?>
                    </label>
                </div>
            </div>
        </div>
        <script>
            var formapp = new Vue({
                el: '.wpsb_widget_form',
                data : {
                    instance : JSON.parse('<?php echo json_encode($i)?>'),
                    default_data : {
                        settings : {
                            width : '',
                            height : '',
                            nav_position : '',
                            show_nav : '',
                            interval : 5000,
                            pause : 'hover',
                            wrap : true,
                            keyboard : true,
                            slider_id : 'wpsb_post_carousel_' + new Date().getTime(),
                        },
                        data : {
                            post_type : 'post',
                            taxonomies : {},
                            slide_content : {
                                'thumbnail' : true,
                                'title' : true,
                                'content' : false,
                                'author' : false,
                                'date' : false,
                                'excerpt' : true,
                                'numposts' : 5
                            }
                        }
                    },
                    post_taxonomies : JSON.parse('<?php echo json_encode($taxonomies); ?>'),
                    selected_tab : 'slides'
                },
                methods : {

                },

                ready : function () {
                    if( Object.keys(this.instance).length == 0 ) {
                        this.instance = JSON.parse(JSON.stringify(this.default_data));
                    }

                }
            });
        </script>
        <?php
    }

    function widget($args, $i) {
        echo $args['before_widget'];

        $tax_query = array();

        if( !empty($i['data']['taxonomies']) ) {
            $tax_query['relation'] = 'OR';
            foreach ( $i['data']['taxonomies'] as $tax => $terms ) {
                if( isset( $terms[0]) && empty($terms[0]) ) continue;
                $tax_query[] = array(
                    'taxonomy' => $tax,
                    'terms' => $terms,
                    'include_children' => true,
                    'operator' => 'IN'
                );
            }
        }
        $query_args =  array(
            'numposts' => $i['data']['slide_content']['numposts'] ? $i['data']['slide_content']['numposts'] : -1,
            'post_type' => $i['data']['post_type'],
            'tax_query' => $tax_query,
        );

        $slider_posts = new WP_Query($query_args);
        ?>
        <div class="Wpsb_Post_Loop">
        <?php if ( $slider_posts->have_posts() ) : ?>
            <?php
            // Start the Loop.
            while ( $slider_posts->have_posts() ) : $slider_posts->the_post();

                /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                // End the loop.
                include WPSB_ROOT.'/templates/post/content.php';
            endwhile;
            // Previous/next page navigation.
            the_posts_pagination( array(
                'prev_text'          => __( 'Previous page', 'wpsb' ),
                'next_text'          => __( 'Next page', 'wpsb' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'wpsb' ) . ' </span>',
            ) );
            wp_reset_query();

        // If no content, include the "No posts found" template.

        else :
            include WPSB_ROOT.'/templates/post/content-none.php';
        endif;
        ?>
        </div>
        <?php
        echo $args['after_widget'];
    }
}

add_action( 'widgets_init', function () {
    wpsb_register_widget( array(
        'label' => 'Post Loop',
        'name' => 'Wpsb_Post_Loop',
        'id_base' => 'wpsb_post_loop'
    ) );
} );