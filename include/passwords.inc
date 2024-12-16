<?php

/**
 * Hash le mot de passe utilisateur.
 *
 * @param $passwd string Mot de passe utilisateur.
 * @return string Hash du mot de passe.
 */
function hash_password($passwd) {
    return hash('sha256', $passwd);
}

/**
 * Vérifie que le mot de passe utilisateur correspond au hash fourni.
 *
 * @param $passwd string Mot de passe utilisateur.
 * @param $hash string Hash stocké en base de données.
 * @return bool `true` si le mot de passe correspond au hash, `false` sinon.
 */
function verify_password($passwd, $hash) {
    return hash_password($passwd) === $hash;
}
