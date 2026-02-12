<?php
$mailbox = imap_open("{imap.ionos.es:993/imap/ssl/novalidate-cert}INBOX", "serena@jocarsa.com", "TAME123$");
if (!$mailbox) {
    die("Failed to connect: " . imap_last_error());
}

$emails = imap_search($mailbox, 'ALL');
if ($emails) {
    foreach ($emails as $email_number) {
        $header = imap_headerinfo($mailbox, $email_number);
        echo "From: {$header->fromaddress}\n";
        echo "Subject: {$header->subject}\n";
        echo "Date: {$header->date}\n\n";
    }
}

imap_close($mailbox);
?>

