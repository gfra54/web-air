<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'web-air');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N'y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@;TFq2j(%cb;Ll)Q Oj]p`NJUsPyo(!&fIfeF]-J-Eoa7B-!*wo(@5Fs<=jsy}U*');
define('SECURE_AUTH_KEY',  'h{42;O}k;k&28xu%XPRell1DjIYst,d`F;YS0he`O<|/bn5MI N6_QCm0lV^u+2e');
define('LOGGED_IN_KEY',    'G9jLwGtDuH%iu@E3[pLfvre=+)?kx?<-<lU*y7L6=+esMC-IwR>_Z_fBXd-Hbs)*');
define('NONCE_KEY',        '+rP1D 7UKET!`e$zf^agFk0jp&zOe!gU+-X-[TFPuZ*U+:,P33jvw|5Y<1q<QB3L');
define('AUTH_SALT',        'nJyl]83{4},_Qw|y&_+;c+JR2K{YexaY0/x=X^@=!~fP5OczDz+u>|/|YSd*B}qu');
define('SECURE_AUTH_SALT', '`; [o^e|%q#?y+dn]l/9mD>3|L__{,:`fst%P>[t8>5 aNJg^w!4u+!xIj4JvX-*');
define('LOGGED_IN_SALT',   'Vr.A#]d>RDt CPTy{-R1*#j=qu(bL(otbOS!o3|]vguLRE<[l4MEavC*u8;J%(eH');
define('NONCE_SALT',       'Y(0cxe4O4#_tO(3>Xb?GMb9S2Epcrb6nA=61Nm7j<uE`sz-P+S>NHrJ;B^!; pjG');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 */
define('WP_DEBUG', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');