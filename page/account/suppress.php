<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\system\removeAccount($_SESSION["accountId"]);
\cardback\utility\redirect();