<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\removeAccount;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);
removeAccount($_SESSION["accountId"]);
redirect();