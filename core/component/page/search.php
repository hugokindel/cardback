<?php
$getSearchBar = function($value = "") {
    global $getTextbox;

    ?>
    <div
            id="search-main">
        <?php
        $getTextbox(
                "search",
                "text",
                "Chercher un paquet, un thème ou un utilisateur...",
                "􀊫",
                $value);
        ?>
    </div>
    <?php
};