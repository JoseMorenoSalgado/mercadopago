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
 * Language strings for the MercadoPago Checkout Pro enrolment plugin.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud <soporte@elearningcloud.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'MercadoPago Checkout Pro';
$string['pluginname_desc'] = 'The Mercado Pago module allows you to set up paid courses. If the cost for any course is zero, then students are not asked to pay for entry. There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';
$string['owner'] = 'Elearning Cloud';
$string['descriptionower'] = 'Mercado Pago is developed and maintained by Elearning Cloud.';
$string['nocost'] = 'No cost defined, please update the value or change the enrolment method.';
$string['pkey'] = 'Merchant pkey.';
$string['publickey'] = 'Merchant public key.';
$string['accesstoken'] = 'Merchant access token.';
$string['deskaccesstoken'] = 'Access token from production API & paste here';
$string['deskpublickey'] = 'Public key from production API & paste here';
$string['merchantid'] = 'Merchant ID';
$string['accountid'] = 'Account ID';
$string['tax'] = 'Tax $';
$string['taxerror'] = 'Error in tax definition';
$string['paycourse'] = 'This course requires a payment for entry.';
$string['merchantapi'] = 'Merchant API';
$string['merchantkey'] = 'Merchant key';
$string['merchantsalt'] = 'Transaction salt';
$string['urlprod'] = 'MercadoPago webcheckout URL';
$string['mailadmins'] = 'Notify admin';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from the course during course unenrolment.';
$string['cost'] = 'Enrol cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['currency'] = 'Currency';
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during MercadoPago enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['mpcheckoutpro:config'] = 'Configure MercadoPago enrol instances';
$string['mpcheckoutpro:manage'] = 'Manage enrolled users';
$string['mpcheckoutpro:unenrol'] = 'Unenrol users from course';
$string['mpcheckoutpro:unenrolself'] = 'Unenrol self from the course';
$string['mpcheckoutpro:receivemessages'] = 'Receive MercadoPago messages';
$string['status'] = 'Allow MercadoPago enrolments';
$string['status_desc'] = 'Allow users to use MercadoPago to enrol into a course by default.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';
$string['errorinsert'] = 'Unable to insert payment record. Reason: transaction information not found. Please contact the site administrator to validate your payment and enrol you in the course.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago'] = 'The MercadoPago enrolment plugin transmits user data from Moodle to the MercadoPago website.';
$string['verifypayment'] = '<div id="idpagomercadopago"><br>Transaction has been received. We are in the process of verification. Please try to access the course in 45 minutes. If you still cannot access it, contact the administrator.</div>';
$string['paymentconfirm'] = 'Course paid. Summary: <div id="resume"><br>Payment ID: "{$a->payment_id}"<br>Payment Status: "{$a->payment_status}"<br>User ID: "{$a->userid}"<br></div>';
$string['paymentreject'] = 'Thank you for your interest! Unfortunately, your payment was not successful.<br><br>Reason: "{$a->payment_status}"<br>';
$string['paymentsorry'] = 'Thank you for your interest! Unfortunately, your payment has not been confirmed at this time. Once you make the payment, please try to access the course in 45 minutes. If you continue to have problems, please contact the site administrator, attaching the payment receipt and your Moodle username to your request to review the transaction.<br>Payment status: "{$a->payment_status}"<br>';
$string['sdkerr'] = 'The MercadoPago SDK path cannot be found. You must install the SDK following the instructions at: https://www.mercadopago.com/developers/en/docs/checkout-pro/integrate-preferences and https://getcomposer.org/download/ <br><br>Valid paths are, for example: /var/www/ C:/xampp/ C:/wamp/. The vendor directory of the SDK and the autoload.php file must exist inside.';
$string['sdkdescription'] = 'Automatic enrolment. Install the MercadoPago SDK in a directory that is not accessible from the web and indicate the full path of the SDK. Some valid paths are: /var/www/vendor/autoload.php, C:/xampp/vendor/autoload.php, C:/wamp/vendor/autoload.php, etc.';
$string['sdk'] = 'Automatic enrolment';
$string['paymentthanks'] = '<div id="idpagomercadopago"><br>We are in the process of verification. Please try to access the course in 45 minutes. If you still cannot access it, contact the administrator.<br><br>"{$a->payment_status}"<br></div>';
$string['ipn'] = 'Enter your URL for webhook calls on new payment events.';
$string['mplangerr'] = 'An additional currency has been added but there is no code to reference it, a rewrite is necessary.';
$string['messageprovider:mpcheckoutpro_enrolment'] = 'Notifications related to MercadoPago enrolments';
$string['notiferr'] = 'Payment failed on MercadoPago';
$string['notifdetailerror'] = 'There was a problem with your MercadoPago payment. Please review the details.';
$string['transactions'] = 'Transactions';
$string['errnoparameters'] = 'MercadoPago callback received with missing parameters. Message: failed payment';
$string['msgpending'] = 'Message: pending confirmation';

// New strings for Ventor and Country
$string['ventor'] = 'Ventor';
$string['ventordesc'] = 'Enter the value for the Ventor configuration.';
$string['country'] = 'Country';
$string['country_desc'] = 'Select the country where you will operate with Mercado Pago.';

// NOTE: The extra closing brace '}' at the end of the original file was removed to fix a fatal PHP error.