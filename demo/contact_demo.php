<?php
declare(strict_types=1);

use App\Domain\Contact;

require_once __DIR__ . '/../src/Domain/Contact.php';
require_once __DIR__ . '/../src/Domain/ContactBuilder.php';

$contact = Contact::make()
    ->phone('000-555-000')
    ->name('John')
    ->surname('Surname')
    ->email('john@email.com')
    ->address('Some address')
    ->build();

var_dump([
    'name'    => $contact->name(),
    'surname' => $contact->surname(),
    'email'   => $contact->email(),
    'phone'   => $contact->phone(),
    'address' => $contact->address(),
]);
