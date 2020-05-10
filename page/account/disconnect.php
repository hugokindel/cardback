<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\disconnectAccount;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);
disconnectAccount();
redirect();