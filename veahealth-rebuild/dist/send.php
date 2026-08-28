<?php
/**
 * VeaHealth enquiry handler.
 *
 * The form posts JSON here. Every enquiry is (1) appended to a local CSV so a
 * lead is never lost even if mail fails, and (2) emailed to the coordinator.
 *
 * BEFORE GOING LIVE:
 *   - set $TO to the mailbox that should receive enquiries
 *   - set $FROM to an address on this domain (Hostinger requires this)
 *   - move $LOG outside the public folder if your hosting allows it
 */

declare(strict_types=1);

$TO   = 'info@veahealthturkey.com';
$FROM = 'website@veahealthturkey.com';
$LOG  = __DIR__ . '/../enquiries.csv';   // outside public_html where possible

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'bad_request']);
    exit;
}

function field(array $d, string $k, int $max = 400): string {
    $v = isset($d[$k]) ? (is_array($d[$k]) ? implode(', ', $d[$k]) : (string) $d[$k]) : '';
    $v = trim(preg_replace('/[\r\n]+/', ' ', $v));
    return mb_substr($v, 0, $max);
}

$first   = field($data, 'firstName', 80);
$last    = field($data, 'lastName', 80);
$email   = field($data, 'email', 160);
$phone   = field($data, 'phone', 40);
$country = field($data, 'country', 80);
$timing  = field($data, 'timing', 80);
$treat   = field($data, 'treatments', 400);
$message = field($data, 'message', 4000);
$page    = field($data, 'page', 200);

if ($first === '' || $email === '' || $phone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'validation_failed']);
    exit;
}

/* 1. never lose the lead --------------------------------------------------- */
$row = [gmdate('c'), $first, $last, $email, $phone, $country, $treat, $timing, $message, $page,
        $_SERVER['REMOTE_ADDR'] ?? ''];
$fh = @fopen($LOG, 'a');
if ($fh !== false) {
    @flock($fh, LOCK_EX);
    @fputcsv($fh, $row);
    @flock($fh, LOCK_UN);
    @fclose($fh);
}

/* 2. notify the coordinator ------------------------------------------------ */
$subject = sprintf('Website enquiry — %s %s (%s)', $first, $last, $country);
$body = "New enquiry from veahealthturkey.com\n\n"
      . "Name:       $first $last\n"
      . "Email:      $email\n"
      . "Phone:      $phone\n"
      . "Country:    $country\n"
      . "Treatments: $treat\n"
      . "Timing:     $timing\n"
      . "Page:       $page\n\n"
      . "Message:\n$message\n";

$headers  = "From: VeaHealth Website <$FROM>\r\n";
$headers .= "Reply-To: $first $last <$email>\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$sent = @mail($TO, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

echo json_encode(['ok' => true, 'mailed' => (bool) $sent]);
