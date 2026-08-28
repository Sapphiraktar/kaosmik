<?php

if ($user != null) {

    $player = $user->getPlayer();

    if ($player != null) {
        echo $player->credits;
    } else {
        echo "Aucun joueur associé à cet utilisateur.";
    }

} else {
    echo "Va te connecter";
}
