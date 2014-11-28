<?php

/**
 * Description of BigContacts_Classes_MetaBox
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContacts_Classes_MetaBox {

    const LANG = '';

    public function __construct() {
        add_action('add_meta_boxes', array(&$this, 'add_BigContacts_MetaBox'));
    }

    public function add_BigContacts_MetaBox() {
        add_meta_box(
                'BigContacts_MetaBox'
                , __('Big Contacts', self::LANG)
                , array(&$this, 'render_BigContacts_MetaBox')
                , 'page'
                , 'advanced'
                , 'high'
        );

        add_meta_box(
                'BigContacts_MetaBox'
                , __('Big Contacts', self::LANG)
                , array(&$this, 'render_BigContacts_MetaBox')
                , 'post'
                , 'advanced'
                , 'high'
        );
    }

    public function render_BigContacts_MetaBox() {
        $str = <<< EOFSTR
<h4>Check items you want to include on the page</h4>
    <ul style="list-style: none;">
        <li style="display: inline;"><label for="bigContact-form"><input type="checkbox" id="bigContact-form" name="form"/> Contact Form</label></li>
        <li style="display: inline;"><label for="bigContact-appoint"><input type="checkbox" id="bigContact-appoint" name="appointment"/> Appointment</label></li>
        <li style="display: inline;"><label for="bigContact-phones"><input type="checkbox" id="bigContact-phones" name="phones"/> Phone List</label></li>
        <li style="display: inline;"><label for="bigContact-emails"><input type="checkbox" id="bigContact-emails" name="emails"/> Email List</label></li>
        <li style="display: inline;"><label for="bigContact-hours"><input type="checkbox" id="bigContact-hours"name="hours"/> Business Hours</label></li>
        <li style="display: inline;"><label for="bigContact-map"><input type="checkbox" id="bigContact-map" name="map"/> Location Map</label></li>
        <li style="display: inline;"></li>
    </ul>
<a id="bigContact-send_to_editor" href="#">Insert into page</a>
EOFSTR;
        echo $str;
    }

}