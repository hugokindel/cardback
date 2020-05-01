<?php
require_once "core/core.php";

cardback\configure();
cardback\database\connect();

print_r(cardback\database\select("users", "id, email"));
echo "<br>";
print_r(cardback\database\selectMaxId("users"));
echo "<br>";
//cardback\system\createFeedback(1, "test", FALSE);
print_r(cardback\system\connectAccount("kindelhugo.per@gmail.com", "Root123@"));

cardback\database\disconnect();
