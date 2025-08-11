<?php

// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * This page handles the creation of the MercadoPago payment preference.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud <soporte@elearningcloud.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_login();

if (!isset($_SESSION['mpcheckoutpro_token'])) {
    $_SESSION['mpcheckoutpro_token'] = bin2hex(random_bytes(32));
}

global $DB, $USER, $CFG;

// Get plugin configuration
$accesstoken = $this->get_config('accesstoken');
$publickey = $this->get_config('publickey');
$sdk = $this->get_config('sdk');
$ipn = $this->get_config('ipn');
$country = $this->get_config('country'); // Get the selected country

$productinfo = $coursefullname;
$referencecode = $instance->courseid . $USER->id . rand();
$locale = 'es-CO'; // Default locale
$_SESSION['timestamp'] = $timestamp = time();
$extra1 = $instance->courseid . '-' . $USER->id . '-' . $instance->id . '-' . $context->id;

// Load MercadoPago SDK
if (!class_exists('MercadoPago\SDK')) {
    if (file_exists('/var/www/vendor/autoload.php')) {
        include_once('/var/www/vendor/autoload.php');
    }
    if (!class_exists('MercadoPago\SDK') && !empty($sdk) && file_exists($sdk)) {
        include_once($sdk); // Fallback on custom sdk path
    }
    if (!class_exists('MercadoPago\SDK')) {
        throw new Exception(get_string('sdkerr', 'enrol_mpcheckoutpro'));
    }
}

MercadoPago\SDK::setAccessToken($accesstoken);

// Create Payer object
$payer = new MercadoPago\Payer();
$payer->name = $USER->firstname;
$payer->surname = $USER->lastname;
$payer->email = $USER->email;
$payer->date_created = date("Y-m-d H:i:s");

// Create Item object
$item = new MercadoPago\Item();
$item->id = random_int(1000, 9999);
$item->title = $referencecode;
$item->description = $productinfo;
$item->quantity = 1;
$item->unit_price = (float) $instance->cost;
$item->currency_id = $instance->currency;

// Set locale based on the selected country
switch ($country) {
    case 'ar':
        $locale = 'es-AR';
        break;
    case 'br':
        $locale = 'pt-BR';
        break;
    case 'cl':
        $locale = 'es-CL';
        break;
    case 'co':
        $locale = 'es-CO';
        break;
    case 'mx':
        $locale = 'es-MX';
        break;
    case 'pe':
        $locale = 'es-PE';
        break;
    case 'uy':
        $locale = 'es-UY';
        break;
    case 'ec':
        $locale = 'es-EC';
        break;
    // For other countries, Mercado Pago might use a generic locale or default to the language of the site.
    // We default to es-CO but this can be adjusted.
    default:
        $locale = 'es-CO';
        break;
}


// Create Preference object
$preference = new MercadoPago\Preference();
$preference->external_reference = $extra1;
$preference->notification_url = $ipn;

$token = $_SESSION['mpcheckoutpro_token'];
$preference->back_urls = array(
    "success" => $CFG->wwwroot . '/enrol/mpcheckoutpro/response.php?token=' . $token,
    "failure" => $CFG->wwwroot . '/enrol/mpcheckoutpro/failure.php?token=' . $token,
    "pending" => $CFG->wwwroot . '/enrol/mpcheckoutpro/pending.php?token=' . $token,
);

$preference->auto_return = "approved";
$preference->items = array($item);
$preference->payer = $payer;

// You can customize payment methods if needed, otherwise, you can comment this section.
$preference->payment_methods = array(
   "excluded_payment_methods" => array(),
    "excluded_payment_types" => array(),
    "installments" => 1
);

$preference->expires = true;
$preference->expiration_date_from = date('Y-m-d\TH:i:s.vP');
$preference->expiration_date_to = date('Y-m-d\TH:i:s.vP', strtotime('+3 days'));

$preference->save();
?>

<div align="center">
    <p><?php echo get_string('paycourse', 'enrol_mpcheckoutpro'); ?></p>
    <p><b><?php echo $instancename; ?></b></p>
    <p><b><?php echo get_string("cost") . ": {$instance->currency} {$localisedcost}"; ?></b></p>
    <p><img alt="mercadopago"
            src="<?php echo $CFG->wwwroot; ?>/enrol/mpcheckoutpro/pix/pagos_procesados_por_mercadopago.gif"
            style="width:30%" /></p>
    <p>&nbsp;</p>
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <div class="cho-container" />
</div>

<script>
    const mp = new MercadoPago('<?php echo $publickey; ?>', {
        locale: '<?php echo $locale; ?>'
    });

    mp.checkout({
        preference: {
            id: '<?php echo $preference->id; ?>'
        },
        autoOpen: true, // Set to true to open the checkout automatically
        render: {
            container: '.cho-container',
            label: 'Pagar ahora',
        },
        theme: {
            elementsColor: '#c0392b',
            headerColor: '#c0392b',
        }
    });
</script>