<?php

$errors = array(
    'john-doe' => 'If you are human try again',
    'name-empty' => 'Please enter your full name',
    'name-short' => 'The name you entered is too short',
    'email-empty' => 'You must provide a valid email address',
    'email-invalid' => 'Please make sure the email you provided is valid',
    'phone-invalid' => 'Please make sure the phone number you provided is valid',
    'invalid-form' => 'Critical error: invalid form',
    'date-empty' => 'You have specified an appointment request without a date',
    'unexpected' => 'Epic Failure: could not send the message please try again',
    'two-sec' => 'It would take a super human to fill this form in less than 5 seconds',
    'hour-past' => 'The form has expired please try again',
    'coockie-not-set' => 'Please enable cookies to be able to send a message. Nothing personal, only spam prevention.'
);

$messages = array();
if (isset($_COOKIE['bigcontact-email-flag'])) {

    $flag = strip_tags(trim($_COOKIE['bigcontact-email-flag']));
    $flagTooSoon = time() - 2;
    $flagExpired = time() - 3600;
    if ($flag >= $flagTooSoon) {
        $messages[] = $errors['two-sec'];
    }
    if ($flag <= $flagExpired) {
        $messages[] = $errors['hour-past'];
    }
    // 'Expires' in the past
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    // Always modified
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);

    // HTTP/1.0
    header("Pragma: no-cache");
} else
    $messages[] = $errors['coockie-not-set'];


if ($messages) {
    $messages['status'] = 'error';
    echo json_encode($messages);
    exit();
}

// validate fields
$fullName = (!empty($_POST['bigContact-fullname']) ? strip_tags(trim($_POST['bigContact-fullname'])) : '');
$email = (!empty($_POST['bigContact-email']) ? strip_tags(trim($_POST['bigContact-email'])) : '');
$phone = (!empty($_POST['bigContact-phone']) ? strip_tags(trim($_POST['bigContact-phone'])) : '');
$extra = (!empty($_POST['bigContact-extra']) ? strip_tags(trim($_POST['bigContact-extra'])) : '');
$subject = (!empty($_POST['bigContact-subject']) ? strip_tags(trim($_POST['bigContact-subject'])) : '');
$message = (!empty($_POST['bigContact-message']) ? strip_tags(trim($_POST['bigContact-message'])) : '');
$johnDoe = (!empty($_POST['bigContact-john-doe']) ? strip_tags(trim($_POST['bigContact-john-doe'])) : '');
$appointment = (!empty($_POST['bigContact-appointment']) ? strip_tags(trim($_POST['bigContact-appointment'])) : '');
$date = '';

if ($appointment) {
    $date = strip_tags(trim($_POST['bigContact-date']));
}
// validate name
if (!$fullName)
    $messages[] = $errors['name-empty'];
elseif (strlen($fullName) < 3)
    $messages[] = $errors['name-short'];
// validate email
if (!$email)
    $messages[] = $errors['email-empty'];
elseif (!validEmail($email))
    $messages[] = $errors['email-invalid'];
if($phone && substr($phone, 0, 3) === '123'){
    $messages[] = $errors['phone-invalid'];
}
//vadidate date
if ($appointment) {
    if (!$date) {
        $messages[] = $errors['date-empty'];
    }
}

// validate john
if ($johnDoe)
    $messages[] = $errors['john-doe'];

if ($messages) {
    $messages['status'] = 'error';
    echo json_encode($messages);
    exit();
}
define('WP_USE_THEMES', false);
/**
 * @todo change hard coded path to dynamic based on install path
 */
require_once('../../../../wp-load.php');
require_once('../models/settings.php');
require_once('../models/settingsMapper.php');

$settingsMapper = new BigContact_Models_SettingsMapper();
$settings = $settingsMapper->fetchAll();
if ($settings)
    $settings = $settings[0];
// construct email message
$emailTo = '';
if ($appointment) {
    $emailTo = $settings->getAppointTo();
    if (!$subject)
        $subject = $settings->getAppointSubject() . " :: $fullName";
}

if (!$emailTo)
    $emailTo = $settings->getEmailTo();
if (!$subject)
    $subject = $settings->getEmailSubject() . " :: $fullName";

$headers = array(
    'X-Mailer: PHP/' . phpversion() . PHP_EOL,
    'From: ' . $fullName . ' <' . $email . '>' . PHP_EOL,
    'Reply-To: ' . $fullName . ' <' . $email . '>' . PHP_EOL,);
if($bcc = $settings->getBcc()){
    $headers[] = 'BCC: ' . str_replace(PHP_EOL, ', ', $bcc);
}
$emailMessage = "\n$message\n";
if ($appointment)
    $emailMessage .= "\nAppointment request for $date\n";
if ($extra) {
    $emailMessage .= "\nAdditional info: $extra\n";
}
$emailMessage .= "\n--\n";
$emailMessage .= "$fullName\n";
$emailMessage .= "$email\n";
if ($phone) {
    $emailMessage .= "$phone\n";
}
$emailMessage .= "\nhttp://www.ip2location.com/" . $_SERVER['REMOTE_ADDR'];

// send message
add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
if (!wp_mail(str_replace(PHP_EOL, ', ', $emailTo), $subject, nl2br($emailMessage), $headers)) {
    $messages[] = $errors['unexpected'];
    $messages['status'] = 'error';
    echo json_encode($messages);
    exit();
}

// send confirmation email
if ($appointment == 'on' && $settings->getResponse() == 'on') {
    $emailTo = $email;
    $subject = $settings->getReplySubject();
    $headers = 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
//    $headers .= 'To: ' . $emailTo . PHP_EOL;
    $headers .= 'From: "' . $_SERVER['SERVER_NAME'] . '" <' . $settings->getReplyEmail() . '>' . PHP_EOL;
    $headers .= 'Reply-To: "' . $_SERVER['SERVER_NAME'] . '" <' . $settings->getReplyEmail() . '>' . PHP_EOL;
    $emailMessage = $settings->getReplyMessage();
    $message_codes = array(
        '[name]' => $fullName,
        '[email]' => $email,
        '[phone]' => $phone,
        '[extra]' => $extra,
        '[message]' => $message,
        '[date]' => $date
    );
    foreach ($message_codes as $key => $value) {
        $emailMessage = str_replace($key, $value, $emailMessage);
    }
    add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
    wp_mail($emailTo, $subject, nl2br($emailMessage), $headers);
}

$messages[] = 'Message Successfully delivered';
$messages['status'] = 'success';
echo json_encode($messages);
exit();
?>

<?php

function validEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if
        (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}
