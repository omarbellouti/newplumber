<?php

class Visitors_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'visitors_widget', // Base ID
            'Live Counter', // Name
            array('description' => __('This widget display the Live Counter. Choose which style you want below', 'wvw'),) // Args
        );
        add_action('widgets_init', function () {
            register_widget("Visitors_Widget");
        });
    }

    public function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', @$instance['title']);
        $select_style = apply_filters('widget_title', @$instance['select_style']);
        $colors = apply_filters('colors', @$instance['colors']);
        $data_row_1 = apply_filters('widget_title', @$instance['data_row_1']);
        $data_row_2 = apply_filters('widget_title', @$instance['data_row_2']);
        $data_row_3 = apply_filters('widget_title', @$instance['data_row_3']);
        $shadow = apply_filters('widget_title', @$instance['shadow']);
        $initial_value = apply_filters('widget_title', @$instance['initial_value']);

        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $out = do_shortcode('[visitors_widget type="' . $select_style . '" shadow="' . $shadow . '" data_1="' . $data_row_1 . '" data_2="' . $data_row_2 . '" data_3="' . $data_row_3 . '" colors="' . $colors . '" initial_value="' . $initial_value . '"]');

        echo $out;
        echo $after_widget;
    }

    public function update($new_instance, $old_instance)
    {

        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['select_style'] = strip_tags($new_instance['select_style']);
        $instance['colors'] = strip_tags($new_instance['colors']);
        $instance['data_row_1'] = strip_tags($new_instance['data_row_1']);
        $instance['data_row_2'] = strip_tags($new_instance['data_row_2']);
        $instance['data_row_3'] = strip_tags($new_instance['data_row_3']);
        $instance['shadow'] = strip_tags($new_instance['shadow']);

        $instance['initial_value'] = strip_tags($new_instance['initial_value']);

        return $instance;
    }

    public function form($instance)
    {
        $select_style = null;
        $colors = null;
        $data_row_1 = null;
        $data_row_2 = null;
        $data_row_3 = null;
        $shadow = null;
        $initial_value = null;

        if (isset($instance['title'])) {
            $title = $instance['title'];
            $select_style = $instance['select_style'];
            $colors = $instance['colors'];

            $data_row_1 = $instance['data_row_1'];
            $data_row_2 = $instance['data_row_2'];
            $data_row_3 = $instance['data_row_3'];
            $shadow = $instance['shadow'];

            $initial_value = $instance['initial_value'];

        } else {
            $title = __('New title', 'wvw');
        }
        ?>
        <div class="widget_top_cont">
            <p>
                <label for=" "><?php _e('Select which style and data you want to display. Go to the plugin page to see examples of the different styles.'); ?></label>

            </p>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>"/>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('select_style'); ?>"><?php _e('Select Style:'); ?></label>
            <div>

                <select class="widefat type_selector" name="<?php echo $this->get_field_name('select_style'); ?>">
                    <option value="1" data-params="1" <?php if ($select_style == '1') echo ' selected '; ?> >Simple 01
                    <option value="2" data-params="1|2" <?php if ($select_style == '2') echo ' selected '; ?> >Simple 02
                    <option value="3" data-params="1" <?php if ($select_style == '3') echo ' selected '; ?> >Simple 03
                    <option value="4" data-params="1|2|3" <?php if ($select_style == '4') echo ' selected '; ?> >
                        Detailed
                    <option value="5" data-params="1|2" <?php if ($select_style == '5') echo ' selected '; ?> >Detailed
                        02
                    <option value="6" data-params="1" <?php if ($select_style == '6') echo ' selected '; ?> >Mini

                </select>
            </div>
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('colors'); ?>"><?php _e('Colors:'); ?></label>
            <div>

                <select class="widefat color_selector" name="<?php echo $this->get_field_name('colors'); ?>">
                    <option value="light" <?php if ($colors == 'light') echo ' selected '; ?> ><?php echo __('Light'); ?>
                    <option value="light_transparent" <?php if ($colors == 'light_transparent') echo ' selected '; ?> ><?php echo __('Light Transparent'); ?>
                    <option value="dark_transparent" <?php if ($colors == 'dark_transparent') echo ' selected '; ?> ><?php echo __('Dark Transparent'); ?>
                </select>
            </div>
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('data_row_1'); ?>"><?php _e('Row 1:', 'wvw'); ?></label>
            <div>
                <select class="widefat class_picker_1 class_single_picker"
                        name="<?php echo $this->get_field_name('data_row_1'); ?>">
                    <option value="visit_total" <?php if ($data_row_1 == 'visit_total') echo ' selected '; ?> ><?php _e('Visitors Total', 'wvw'); ?>
                    <option value="visit_today" <?php if ($data_row_1 == 'visit_today') echo ' selected '; ?> ><?php _e('Visitors Today', 'wvw'); ?>
                    <option value="visit_live" <?php if ($data_row_1 == 'visit_live') echo ' selected '; ?> ><?php _e('Visitors Live', 'wvw'); ?>
                </select>
            </div>
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('data_row_2'); ?>"><?php _e('Row 2:'); ?></label>


                <select <?php if (in_array($select_style, array('1', '3', '6'))) {
                    echo ' disabled ';
                } ?> class="widefat class_picker_2 class_single_picker"
                     name="<?php echo $this->get_field_name('data_row_2'); ?>">
                    <option value="visit_total" <?php if ($data_row_2 == 'visit_total') echo ' selected '; ?> ><?php _e('Visitors Total', 'wvw'); ?>
                    <option value="visit_today" <?php if ($data_row_2 == 'visit_today') echo ' selected '; ?> ><?php _e('Visitors Today', 'wvw'); ?>
                    <option value="visit_live" <?php if ($data_row_2 == 'visit_live') echo ' selected '; ?> ><?php _e('Visitors Live', 'wvw'); ?>
                </select>

            </p>


            <p>
                <label for="<?php echo $this->get_field_id('data_row_3'); ?>"><?php _e('Row 3:'); ?></label>
            <div>
                <select <?php if (in_array($select_style, array('1', '2', '3', '5', '6'))) {
                    echo ' disabled ';
                } ?> class="widefat class_picker_3 class_single_picker"
                     name="<?php echo $this->get_field_name('data_row_3'); ?>">
                    <option value="visit_total" <?php if ($data_row_3 == 'visit_total') echo ' selected '; ?> ><?php _e('Visitors Total', 'wvw'); ?>
                    <option value="visit_today" <?php if ($data_row_3 == 'visit_today') echo ' selected '; ?> ><?php _e('Visitors Today', 'wvw'); ?>
                    <option value="visit_live" <?php if ($data_row_3 == 'visit_live') echo ' selected '; ?> ><?php _e('Visitors Live', 'wvw'); ?>
                </select>
            </div>
            </p>


            <p>
                <input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id('shadow'); ?>" name="<?php echo $this->get_field_name('shadow'); ?>"
                       value="on" <?php if ($shadow == 'on') echo ' checked '; ?> />
                <label for="<?php echo $this->get_field_id('shadow'); ?>"><?php _e('Shadow'); ?></label>

            </p>

            <p>
                <label for="<?php echo $this->get_field_id('initial_value'); ?>"><?php _e('Initial Value:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('initial_value'); ?>"
                       name="<?php echo $this->get_field_name('initial_value'); ?>" type="text"
                       value="<?php echo (int)esc_attr($initial_value); ?>"/>
            </p>

        </div>
        <?php
    }

}
$visitors_widget = new Visitors_Widget();
?>