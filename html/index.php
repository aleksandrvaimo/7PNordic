<?php
/**
 * Copyright © ...
 */

session_start();
require_once __DIR__ . '/autoload.php';

use Message\Model\Message;
use Block\Page;

$message = new Message();
$block = new Page();
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= $block->getTitle(); ?></title>
        <?php include 'page/content/head.html'; ?>
    </head>
    <body>
        <?php if ($message->isMessageExists()): ?>
            <div class="alert alert-success" role="alert"><?= $message->getMessage(); ?></div>
        <?php endif; ?>
        <div class="container h-100">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <?php include 'page/content/search.phtml'; ?>
                    <?php include 'page/content/create.phtml'; ?>
                    <?php include 'page/content/update.phtml'; ?>
                </div>
            </div>
        </div>
        <?php include 'page/content/loader.html'; ?>
    </body>
</html>