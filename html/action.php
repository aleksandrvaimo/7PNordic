<?php
/**
 * Copyright © ...
 */

session_start();

require_once __DIR__ . '/autoload.php';
use Customer\Controller\Create;
use Customer\Controller\Update;
use Customer\Controller\Delete;
use Customer\Controller\Search;
use Customer\Model\Validation;
use Customer\Model\Resource\Customer;
use Message\Model\Message;

$request = $_POST['crud'] ?? false;

if ($request === 'create' || $request === 'update' || $request === 'delete' || $request === 'search') {
    $action = '';

    if ($request === 'create') {
        $action = new Create(new Customer((new Message)), new Validation(), new Message());
    }

    if ($request === 'update') {
        $action = new Update(new Customer((new Message)), new Validation(), new Message());
    }

    if ($request === 'delete') {
        $action = new Delete(new Customer((new Message)), new Validation(), new Message());
    }

    if ($request === 'search') {
        $search = new Search(new Validation());
        $username = $search->execute();

        header('Location: /?q=' . $username);
        return;
    }

    $data = $action->execute();
} else {
    $data = [
        'status' => 'error',
        'msg' => 'Unknown Action'
    ];
}

echo json_encode($data);
