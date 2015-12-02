<?php

return [

    // front
    // routes
    "login"       => [
        "index" => "espace-connexion",
        "login" => "espace-connexion/connexion",
    ],
    "account"     => [
        "create"     => "mon-compte/creation",
        "store"      => "mon-compte/enregistrement",
        "email"      => "mon-compte/email-activation",
        "activation" => "mon-compte/activation",
    ],
    "password"    => [
        "index"  => "mot-de-passe/oublie",
        "update" => "mot-de-passe/mise-a-jour",
        "email"  => "mot-de-passe/email-reinitialisation",
        "reset"  => "mot-de-passe/reinitialisation",
    ],

    // back
    // routes
    "dashboard"   => [
        "index" => "admin/tableau-de-bord",
    ],
    "settings"    => [
        "index"  => "admin/parametres",
        "update" => "admin/parametres/mise-a-jour",
    ],
    "permissions" => [
        "index"   => "admin/permissions",
        "create"  => "admin/permissions/creation",
        "store"   => "admin/permissions/enregistrement",
        "edit"    => "admin/permissions/edition/{id}",
        "update"  => "admin/permissions/mise-a-jour",
        "destroy" => "admin/permissions/suppression",
    ],
    "users"       => [
        "index"    => "admin/utilisateurs",
        "create"   => "admin/utilisateurs/creation",
        "store"    => "admin/utilisateurs/enregistrement",
        "edit"     => "admin/utilisateurs/edition/{id}",
        "update"   => "admin/utilisateurs/mise-a-jour",
        "destroy"  => "admin/utilisateurs/suppression",
        "profile"  => "admin/mon-profil",
        "activate" => "admin/utilisateurs/activer",
    ],
    "home"        => [
        "edit"   => "admin/contenus/page-accueil/edition",
        "update" => "admin/contenus/page-accueil/mise-a-jour",
    ],
    "slides"       => [
        "create"  => "admin/contenus/page-accueil/diapo/creation",
        "store"   => "admin/contenus/page-accueil/diapo/enregistrement",
        "edit"    => "admin/contenus/page-accueil/diapo/edition/{id}",
        "update"  => "admin/contenus/page-accueil/diapo/mise-a-jour",
        "destroy" => "admin/contenus/page-accueil/diapo/suppression",
    ],
    "logout"      => "admin/deconnexion",
];