<?php

/**
 * Description of BigContacts_Classes_Form
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
class BigContact_Classes_Form {

    protected $_form;
    protected $_phones;
    protected $_emails;
    protected $_hours;
    protected $_map;
    protected $_address;
    protected $_appointment;
    protected $_subject;

    public function __construct($form = FALSE, $appointment = FALSE, $phones = FALSE, $emails = FALSE, $hours = FALSE, $map = FALSE, $address = FALSE, $subject = FALSE) {
        if ($appointment)
            $this->setAppointment($appointment);
        if ($form) {
            $this->setSubject($subject);
            $this->setForm();
        }
        if ($phones)
            $this->setPhones();
        if ($emails)
            $this->setEmails();
        if ($hours)
            $this->setHours();
        if ($map)
            $this->setMap();
        if ($address)
            $this->setAddress();
    }

    public function getForm() {
        return $this->_form;
    }

    public function setForm() {
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        if (!$bigSettings = $bigSettingsMapper->fetchAll())
            $bigSettings = new BigContact_Models_Settings();
        else
            $bigSettings = $bigSettings[0];
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $cust_subject = isset($_GET['sbj']) ? strip_tags(trim($_GET['sbj'])) : $this->getSubject();
        $this->_form = '<div id="bigContact-results"></div>';
        $this->_form .= $form->getForm_title() ? '<h3>' . $form->getForm_title() . '</h3>' : '';
        $this->_form .= '<form id="bigContact-form" action="' .
                BIGCONTACT_URL . 'include/contact-json.php' .
                '" method="post">' .
                '<input type="hidden" id="token" name="token" value="" />' .
                '<ul class="bigContact-halfSize">' .
                '<li><label for="bigContact-fullname">' . $form->getName_label() . '</label>' .
                '<span><input type="text" name="bigContact-fullname" ' .
                'id="bigContact-fullname" class="BigContact-input" required tabindex="1" /></span></li>' .
                '<li><label for="bigContact-email">' . $form->getEmail_label() . '</label>' .
                '<span><input type="email" name="bigContact-email" ' .
                'id="bigContact-email" class="BigContact-input" required tabindex="2" /></span></li>' .
                '<li><label for="bigContact-phone">' . $form->getPhone_label() . '</label>' .
                '<span><input type="text" name="bigContact-phone" ' .
                'id="bigContact-phone" class="BigContact-input" tabindex="3" /></span></li>' .
                '<li><label for="bigContact-extra">' . $form->getExtra_label() . '</label>' .
                '<span><input type="text" name="bigContact-extra" ' .
                'id="bigContact-extra" class="BigContact-input" tabindex="4"/></span></li>';
        if ($cust_subject)
            $this->_form .= '<li><label for="bigContact-subject">Subject</label>' .
                    '<span><input type="text" name="bigContact-subject" ' .
                    'id="bigContact-subject" class="BigContact-input" ' .
                    'value="' . $cust_subject . '" readonly="readonly" /></span></li>';
        $this->_form .= ' <li class="bigContact-hidden"><label for="bigContact-john-doe">If you are serious about sending this message you better leave the following field empty.</label>' .
                '<input type="text" name="bigContact-john-doe" id="bigContact-john-doe" value="" /></li>' .
                '</ul>';
        if ($this->getAppointment()) {
            $this->_form .= '<ul class="bigContact-halfSize">' .
                    '<li><label for="bigContact-appointment">' .
                    '<input type="checkbox" id="bigContact-appointment" ' .
                    'name="bigContact-appointment" tabindex="5"/> ' .
                    $form->getAppointment_text() . '</label></li>' .
                    '<li><div id="datepicker"></div></li>' .
                    '<li><input type="hidden" id="bigContact-date" name="bigContact-date"></li>';
            $this->_form .= '</ul>';
            $this->_form .= '<script>' . PHP_EOL;
            $this->_form .= 'bigDatePicker = ' . '"' . $bigSettings->getCalendarType() . '";' . PHP_EOL;
            $this->_form .= 'bigDateFormat = ' . '"' . $bigSettings->getDateFormat() . '";' . PHP_EOL;
            $this->_form .= 'bigTimeFormat = ' . '"' . $bigSettings->getTimeFormat() . '";' . PHP_EOL;
            $this->_form .= 'bigAmpm = ' . $bigSettings->getAmpm() . ';' . PHP_EOL;
            $this->_form .= 'bigShowMinute = ' . $bigSettings->getShowMinute() . ';' . PHP_EOL;
            $this->_form .= '</script>' . PHP_EOL;
        }
        $this->_form .= '<ul class="bigContact-fullSize">' .
                '<li><label for="bigContact-message">' .
                $form->getMessage_label() . '</label>' .
                '<textarea name="bigContact-message" id="bigContact-message" rows="5" required tabindex="4"></textarea></li>' .
                '<li><input id="bigContact-submit" type="submit" value="' .
                $form->getSend_mail() . '" /><span id="bigContact-loading"></span></li>' .
                '<li class="clearfix"></li>' .
                '</ul>' .
                '</form>';
    }

    public function getAppointment() {
        return $this->_appointment;
    }

    public function setAppointment($appointment) {
        $this->_appointment = $appointment;
    }

    public function getPhones() {
        return $this->_phones;
    }

    public function setPhones() {
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $this->_phones = '<div class="bigContact-phone">';
        $this->_phones .= $form->getTel_title() ? '<h3>' . $form->getTel_title() . '</h3>' : '';
        $this->_phones .= '<ul>';
        $phonesMapper = new BigContact_Models_PhoneMapper();
        $phones = $phonesMapper->fetchAll();
        foreach ($phones as $phone) {
            $this->_phones .= '<li><span class="bigContact-label">' .
                    $phone->getLabel() . '</span><span class="bigContact-value">' .
                    $phone->getNumber() . '</span></li>';
        }
        $this->_phones .= '</ul>';
        $this->_phones .= '</div>';
    }

    public function getEmails() {
        return $this->_emails;
    }

    public function setEmails() {
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $this->_emails = '<div class="bigContact-emails">';
        $this->_emails .= $form->getEmail_title() ? '<h3>' . $form->getEmail_title() . '</h3>' : '';
        $this->_emails .= '<ul>';
        $emailMapper = new BigContact_Models_EmailMapper();
        $emails = $emailMapper->fetchAll();
        foreach ($emails as $email) {
            $this->_emails .= '<li><span class="bigContact-label">' .
                    $email->getLabel() . '</span><span class="bigContact-value">' .
                    '<a href="mailto:' . $email->getEncodedAddress() . '">' .
                    $email->getAddress() . '</a></span></li>';
        }
        $this->_emails .= '</ul>';
        $this->_emails .= '</div>';
    }

    public function getHours() {
        return $this->_hours;
    }

    public function setHours() {
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $this->_hours = '<div class="bigContact-hours">';
        $this->_hours .= $form->getHours_title() ? '<h3>' . $form->getHours_title() . '</h3>' : '';
        $this->_hours .= '<ul class="bigContact-days">' .
                '<li><span class="bigContact-day-label big-mon">Monday: </span><span class="bigContact-value">' . $form->getMon_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-tue">Tuesday: </span><span class="bigContact-value">' . $form->getTue_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-wed">Wednesday: </span><span class="bigContact-value">' . $form->getWed_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-thu">Thursday: </span><span class="bigContact-value">' . $form->getThu_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-fri">Friday: </span><span class="bigContact-value">' . $form->getFri_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-sat">Saturday: </span><span class="bigContact-value">' . $form->getSat_from() . '</span></li>' .
                '<li><span class="bigContact-day-label big-sun">Sunday: </span><span class="bigContact-value">' . $form->getSun_from() . '</span></li>' .
                '</ul>';
        $this->_hours .= '</div>';
    }

    public function getMap() {
        return $this->_map;
    }

    public function setMap() {
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        if (!$bigSettings = $bigSettingsMapper->fetchAll())
            $bigSettings = new BigContact_Models_Settings();
        else
            $bigSettings = $bigSettings[0];

        $this->_map = '<div class="bigContact-map">';
        if ($bigSettings->getGapiKey()) {

            $this->_map .= "\n\n" . '<script src="http://maps.googleapis.com/maps/api/js?key=' .
                    $bigSettings->getGapiKey() . '&amp;sensor=true"></script>' . "\n";
            $this->_map .= "\n<script>";
            $this->_map .= "\nvar map_address = '" . $form->getAddress() . "';";
            $this->_map .= "\n</script>";
        }
        $this->_map .= $form->getMap_title() ? '<h3>' . $form->getMap_title() . '</h3>' : '';
        $this->_map .= '<ul>';
        if ($form->getMap_description()) {
            $this->_map .= '<li><p>' . $form->getMap_description() . '</p></li>';
        }
        if ($bigSettings->getGapiKey())
            $this->_map .= '<li><div id="bigContact_map_canvas"></div></li>';

        $this->_map .= '<li><a href="http://maps.google.com/maps?daddr=' .
                str_replace(" ", "+", $form->getAddress()) . '">' .
                $form->getAddress() . '</a></li>';
        $this->_map .= '</ul>';
        $this->_map .= '</div>';
    }

    public function getAddress() {
        return $this->_address;
    }

    public function setAddress() {
        $this->_address = '';
        $formMapper = new BigContact_Models_FormMapper();
        $forms = $formMapper->fetchAll();
        $form = $forms[0];
        $bigSettingsMapper = new BigContact_Models_SettingsMapper();
        if (!$bigSettings = $bigSettingsMapper->fetchAll())
            $bigSettings = new BigContact_Models_Settings();
        else
            $bigSettings = $bigSettings[0];
        $this->_address .= '<div class="bigContact-address">';
        $this->_address .= $form->getMap_title() ? '<h3>' . $form->getMap_title() . '</h3>' : '';
        $this->_address .= '<p>' . $form->getAddress() . '</p>';
        $this->_address .= '</div>';
    }

    public function getSubject() {
        return $this->_subject;
    }

    public function setSubject($subject) {
        $this->_subject = $subject;
        return $this;
    }

    function generateForm() {
        $divide = false;
        $form = '';
        $form .= '<div class="bigContact">';
        if ($this->getForm()) {
            $form .= $this->getForm();
        }
        if ($this->getPhones() || $this->getEmails() || $this->getHours()) {
            if ($this->getMap()) {
                $divide = TRUE;
                $form .= '<div class="bigContact-halfSize">';
            }
            if ($this->getPhones())
                $form .= $this->getPhones();
            if ($this->getEmails())
                $form .= $this->getEmails();
            if ($this->getHours())
                $form .= $this->getHours();
            if ($divide)
                $form .= '</div><div class="bigContact-halfSize">';
        }
        if ($this->getMap()) {
            $form .= $this->getMap();
            if ($divide)
                $form .= '</div>';
        }
        if ($this->getAddress()) {
            $form .= $this->getAddress();
        }
        $form .= '</div>';
        return $form;
    }

}