<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'db' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'tO`^K0W}(hR$|,*fX.wURt8[~I7kBf7dQ3SG$Ry3?6@/f!-gQoxJzjkzY{8>.{,U' );
define( 'SECURE_AUTH_KEY',  'iR~v4p_f1m}RNhA&_z/Zv1Fc=st^qMV#Rnn@FuD:Y]c NpGtJ{N9^9WY{hhd<n$U' );
define( 'LOGGED_IN_KEY',    '|~R([MkEv9g|LKX <@ns=FJNHxu5p@rCyb)l:Oot8Lz+TI,DWaA-*U}gD4]{+<-w' );
define( 'NONCE_KEY',        'UU{2$ef2yL+eltw%C[/+IMIF.o)f?2xtmR33pKLn.X`2<b2]{mz9htqiIv7OBufi' );
define( 'AUTH_SALT',        'ekmf)(=Af[uM|jh>)$KkL{}fvjQQy+`y^2KZ:@B ?g!wU[kh]Pa@>-ThZ0d,f|)D' );
define( 'SECURE_AUTH_SALT', 'KH(zj-xEv_IqeTjlKX-_+v1?%AB-yhv%>WXl#D8FmlTUr{>qiYV`vf=A~At]N]a:' );
define( 'LOGGED_IN_SALT',   '}Y?sI4>jX}_FH9B|~G:#}-Grx6`_qz;y4K<$n-NG1{?*imtO)LJfNHFR?goszI0R' );
define( 'NONCE_SALT',       'pkSTW1XxX5J@[3;;6- -0{SC60{MK>FJ|FU@:;OG^]JAZ;GA=.Rfvuw]:e& =g*V' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );


@ini_set('upload_max_filesize', '64M');
@ini_set('post_max_size', '64M');
@ini_set('memory_limit', '128M');

// Afficher les erreurs PHP
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', false);
// define('WP_DEBUG_DISPLAY', false);
// @ini_set('display_errors', 0);