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
 * This page handles responses from MercadoPago for failed payments.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'mpcheckoutpro';
$string['pluginname_desc'] = 'El m&oacute;dulo Mercadopago le permite configurar cursos gestionando su matriculaci&oacute;n mediante un pago, si el costo de cualquier curso es cero, no se les pedir&aacute; a los estudiantes realizar pago por la entrada, en general para todo el sitio se puede establecer&aacute;n valor como predeterminado, tenga en cuenta que la configuraci&oacute;n en cada curso anula el costo definido para el sitio.';
$string['owner'] = 'innovandoweb';
$string['descriptionower'] = 'Mercadopago es desarrolado y mantenido por jonathan.lopez.garcia@gmail.com';
$string['nocost'] = 'No hay un valor definido, debe actualizar el costo o cambiar el m&eacute;todo de inscripci&oacute;n';
$string['tax'] = 'Impuesto $';
$string['taxerror'] = 'Error en la configuraci&oacute;n del impuesto';
$string['pkey'] = 'Llave del Integrador de comerciante.';
$string['publickey'] = 'Llave publica de comerciante.';
$string['accesstoken'] = 'Llave de acceso al api del comercio.';
$string['deskaccesstoken'] = 'Token de acceso de la API de producci&oacute;n y pegar aqu&iacute;';
$string['deskpublickey'] = 'Clave p&uacute;blica de la API de producci&oacute;n y pegar aqu&iacute;';
$string['paycourse'] = 'Este curso requiere pago de matricula.';
$string['merchantsalt'] = 'salto de transacci&oacute;n';
$string['mailadmins'] = 'Notificar al administador';
$string['mailstudents'] = 'Notificar a estudiantes';
$string['mailteachers'] = 'Notificar a docentes';
$string['cost'] = 'Costo de inscripci&oacute;n al curso';
$string['costerror'] = 'El costo es num&eacute;rico';
$string['costorkey'] = 'Seleccione uno de los métodos de matriculac&oacute;n';
$string['currency'] = 'Moneda';
$string['assignrole'] = 'Asignar role';
$string['defaultrole'] = 'Rol asignado por defecto';
$string['defaultrole_desc'] = 'Seleccione el rol que ser&aacute; asignado a los usuarios durante el pago de matriculaci&oacute;n';
$string['enrolenddate'] = 'Fecha de cierre';
$string['enrolenddate_help'] = 'Si se activa, los usuarios pueden matricularse hasta esta fecha';
$string['enrolenddaterror'] = 'La fecha de finalizaci&oacute;n de matricula no puede ser anterior a la fecha de inicio';
$string['enrolperiod'] = 'Duraci&oacute;n de matricula';
$string['enrolperiod_desc'] = 'Duraci&oacute;n de la matricula por defecto el valor 0 es ilimitado';
$string['enrolperiod_help'] = 'Si se desactiva la matricula ser&aacute; por tiempo ilimitado';
$string['enrolstartdate'] = 'Fecha de inicio';
$string['enrolstartdate_help'] = 'Si se activa los usuarios pueden matricularse desde esta fecha solamente';
$string['expiredaction'] = 'Acciones sobre la expiraci&oacute;n de la matricula';
$string['expiredaction_help'] = 'Durante la desmatriculaci&oacute;n se borrar&aacute;n los aportes de los usuarios';
$string['mpcheckoutpro:config'] = 'Configure la instancia de matriculaci&oacute;n mercadopago';
$string['mpcheckoutpro:manage'] = 'Administrar usuarios matriculados';
$string['mpcheckoutpro:unenrol'] = 'Desmatricular usuarios del curso';
$string['mpcheckoutpro:unenrolself'] = 'Darse de baja de baja del curso';
$string['mpcheckoutpro:receivemessages'] = 'Recibir mensajes de MercadoPago';
$string['status_desc'] = 'Permitir a los usuarios matricularse en un curso mediante mercadopago';
$string['unenrolselfconfirm'] = '¿Realmente desea desmtricularse del curso "{$a}"?';
$string['status'] = 'Permitir Matriculaci&oacute;n mercadopago';
$string['errorinsert'] = 'Error al cargar el registro del pago <br><br> razon: no hay informacion de la transaccion <br><br> En este caso debes comunicarte con el administrador del sitio para que valide tu pago y proceda con una matriculacion manual';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:preference_id'] = 'Descripcion.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:courseid'] = 'Identificador de curso.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:userid'] = 'Identificador de usuario.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:instanceid'] = 'Identificador de instancia.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:amount'] = 'Valor del curso.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:contextid'] = 'Identificador de contexto.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:external_reference'] = 'Referencia externa.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:paymen_status'] = 'Estado de la transaccion.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:payment_status_detail'] = 'Detalle del estado de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:payment_id'] = 'Identificador de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:auth_json'] = 'Cadena completa de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:timeupdated'] = 'Momento en el que se registro el pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro'] = 'Informacion para inscripciones mercadopago.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:preference_id'] = 'Descripcion.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:courseid'] = 'Identificador de curso.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:userid'] = 'Identificador de usuario.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:instanceid'] = 'Identificador de instancia.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:amount'] = 'Valor del curso.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:contextid'] = 'Identificador de contexto.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:external_reference'] = 'Referencia externa.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_status'] = 'Estado de la transaccion.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_status_detail'] = 'Detalle del estado de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_id'] = 'Identificador de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:auth_json'] = 'Cadena completa de pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:timeupdated'] = 'Momento en el que se registro el pago.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago'] = 'El plugin de Inscripcion mercadopago transmite datos del usuario de Moodle hacia el sitio web mercadopago.';
$string['paymentconfirm'] = 'Curso pagado, resumen: <div id="idpagomercadopago"><br>Id de pago: "{$a->payment_id}"<br>Estado del pago: "{$a->payment_status}"<br>Userid: "{$a->userid}"<br></div>';
$string['verifypayment'] = '<div id="idpagomercadopago"><br>La transacci&oacute;n se ha recibido. Estamos en proceso de verificaci&oacute;n, prueba el ingreso al curso, si pasados 45 minutos no se ha matriculado contacta al administrador adjuntando el comprobante de pago en su solicitud y username de moodle para revisar la transacci&oacute;n</div>';
$string['paymentreject'] = '¡Gracias por su inter&eacute;s! Lastimosamente, el pago no fue aceptado.<br><br> raz&oacute;n: "{$a->payment_status}"<br>';
$string['paymentsorry'] = '¡Gracias por su inter&eacute;s! Lastimosamente, su pago no se ha confirmado en este momento, una vez realice el pago, pruebe el ingreso al curso en 45 minutos, si continua teniendo problemas, por favor contacte al administrador del sitio, adjuntando el comprobante de pago en su solicitud y username de moodle para revisar la transacci&oacute;n<br><br>Estado del pago: "{$a->payment_status}"<br>';
$string['sdkerr'] = 'No se encuentra la ruta del sdk de mercado pago, debes instalar el sdk siguiendo las siguientes instrucciones:  https://www.mercadopago.com.co/developers/en/docs/checkout-pro/integrate-preferences y https://getcomposer.org/download/ <br><br>   Las rutas validas son:  /var/www/  C:/xampp/  C:/wampp/ Dentro debe existir el directorio vendor del sdk y el archivo autoload.php';
$string['messageprovider:mercadopago_enrolment'] = 'Usuario matriculado';
$string['syncenrolmentstask'] = 'Trabajo de sincronizar inscripciones mercadopago';
$string['processexpirationstask'] = 'Trabajo de enviar notificaci&oacute;n de caducidades de inscripiones para Mercado Pago';
$string['sdkdescription'] = 'Matriculaci&oacute;n autom&aacute;tica, instale el sdk de mercadopago en un directorio que no sea accesible desde la web e indique la ruta completa del sdk, algunas rutas validas son: /var/www/vendor/autoload.php C:/xampp/vendor/autoload.php C:/wampp/vendor/autoload.php etc';
$string['sdk'] = 'Matriculaci&oacute;n autom&aacute;tica';
$string['paymentthanks'] = '<div id="idpagomercadopago"><br>Estamos en proceso de verificaci&oacute;n, prueba el ingreso al curso, si pasados 45 minutos no se ha matriculado contacta al administrador adjuntando el comprobante de pago en su solicitud y username de moodle para revisar la transacci&oacute;n<br><br>"{$a->payment_status}"<br></div>';
$string['ipn'] = 'Ingrese la url para llamadas por eventos generados en nuevos pagos (webhoot)';
$string['mplangerr'] = 'Una moneda adicional se ha sumado pero no hay codigo para referenciar, es necesaria una reescritura';
$string['messageprovider:mpcheckoutpro_enrolment'] = 'Notificaciones relacionadas con inscripciones de MercadoPago';
$string['notiferr'] = 'Pago fallido en MercadoPago';
$string['notifdetailerror'] = 'Hubo un problema con tu pago en MercadoPago. Por favor, revisa los detalles.';
$string['transactions'] = 'Transacciones';
$string['errnoparameters'] = 'Se recibi&oacute; una devoluci&oacute;n de llamada de MercadoPago con par&aacute;metros faltantes. Mensaje: pago fallido';
$string['msgpending'] = 'Mensaje: pendiente de confirmaci&oacute;n';