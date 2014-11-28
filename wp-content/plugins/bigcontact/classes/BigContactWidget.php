<?php

/**
 * Description of BCWidget
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContactWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'BCWidget', 'BigContact', array('description' => __('Display your contact information', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        extract($args);
        $contact_field = strip_tags($instance['contact_field']);
        if ($contact_field == 1)
            $bigContactForm = new BigContact_Classes_Form(false, false, false, true, false, false, false);
        elseif ($contact_field == 2)
            $bigContactForm = new BigContact_Classes_Form(false, false, true, false, false, false, false);
        elseif ($contact_field == 3)
            $bigContactForm = new BigContact_Classes_Form(false, false, false, false, true, false, false);
        elseif ($contact_field == 4)
            $bigContactForm = new BigContact_Classes_Form(false, false, false, false, false, false, true);
        if ($bigContactForm)
            echo $bigContactForm->generateForm();
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $field_id = strip_tags($new_instance['contact_field']);
        $instance['contact_field'] = $field_id;
        if ($field_id == 1)
            $instance['title'] = 'Email';
        elseif ($field_id == 2)
            $instance['title'] = 'Phone';
        elseif ($field_id == 3)
            $instance['title'] = 'Business Hours';
        elseif ($field_id == 4)
            $instance['title'] = 'Address';
        return $instance;
    }

    public function form($instance) {
        $contact_field = isset($instance['contact_field']) ? $instance['contact_field'] : -1;
        $description = isset($instance['description']) ? $instance['description'] : __('', 'text_domain');
        $title = isset($instance['title']) ? $instance['title'] : __('New Contact Block', 'text_domain');

        $str = '';
        $str .= '<input id = "' . $this->get_field_id('title') . '" name = "' . $this->get_field_name('title') .
                '" type = "hidden" value = "' . esc_attr($title) . '" />';
        $str .= '<p>Select a Component</p>';
        $str .= '<p><select name="' . $this->get_field_name('contact_field') . '">';
        $str .= '<option value="">Select one...</option>';
        $str .= '<option value="1" ' . ($contact_field == 1 ? 'selected="selected" ' : '') . '>Email</option>';
        $str .= '<option value="2" ' . ($contact_field == 2 ? 'selected="selected" ' : '') . '>Phone</option>';
        $str .= '<option value="3" ' . ($contact_field == 3 ? 'selected="selected" ' : '') . '>Business Hours</option>';
        $str .= '<option value="4" ' . ($contact_field == 4 ? 'selected="selected" ' : '') . '>Address</option>';
        $str .= '</select></p>';
        echo $str;
    }

}