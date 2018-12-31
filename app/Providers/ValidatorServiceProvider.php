<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use DB;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register validations directives.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * validacion por expresion regular de un RUT.
         */
        Validator::extend('id', function($attribute, $value)
        {
            return preg_match('/[0-9]{8}[-]{1}[0-9K]{1}/', $value);
        }, 'El formato debe ser xxxxxxxx-K');

        /**
         * validacion por expresion regular de un Pasaporte.
         */
        Validator::extend('pass', function($attribute, $value)
        {
            return true;
            return preg_match('/[0-9]{8}[-]{1}[0-9K]{1}/', $value);
        }, 'El formato debe ser xxxxxxxx-K');

        /**
         * validacion por expresion regular de un Telefono.
         */
        Validator::extend('phone', function($attribute, $value)
        {
            return preg_match('/[+]{1}[0-9]{10}/', $value);
        }, 'El formato debe ser +xxxxxxxxxx');

        /**
         * Comprueba que sea la contraseña actual del usuario autentificado.
         */
        Validator::extend('current_password', function($attribute, $value)
        {
            return Hash::check($value, Auth::user()->password);
        }, 'El campo :attribute no coincide con su contraseña actual.');

        /**
         * Verifica si existe el email que se registrara en una lista blanca.
         */
        Validator::extend('DomainValid', function($attribute, $value)
        {
            if (str_contains($value, '@')) {
                $domain = explode('@', $value)[1];
                $domains = [
                    'sahum.gob.ve', 'gmail.com',
                    'hotmail.com', 'outlook.com',
                    'yahoo.com', 'mail.com',
                    'smoothtalkers.com'
                ];
                return in_array($domain, $domains);
            }
        }, 'El dominio de tu email no es permitido.');

        /**
         * Verifiva que la hora este dentro del rango correcto.
         */
        Validator::extend('hour_corret', function($attribute, $value)
        {
            $sections = explode(':', $value);

            if (count($sections) === 2)
                if ($sections[0] >= 0 && $sections[0] <= 23)
                    if ($sections[1] >= 0 && $sections[1] <= 59) return true;
                        // if ($sections[2] >= 0 && $sections[2] <= 59)
                return false;
            }, 'El formato debe poseer un formato "00:00" - "23:59".');

        /**
         * Verifiva el campo solo tenga letras y espacios.
         */
        Validator::extend('alpha_space', function($attribute, $value)
        {
            if ($value[0] == '') return false;
            return preg_match('/.([a-zA-Z])$/', $value);
            return false;
        }, 'No debe poseer caracteres especiales ni números.');

        /**
         * Verifiva que el valor a ingrasar solo este 1 vez en la bd.
         */
        Validator::extend('unique1', function($attribute, $value, $parameters)
        {
            $match = DB::table($parameters[0])->where($attribute, '=', $value)->count();
            if ($match > 1) {
                return false;
            }
            return true;
        }, 'El elemento :attribute ya está en uso.');

        /**
         * Verifiva el usuario tenga un rol alumno
         */
        Validator::extend('is_student', function($attribute, $value, $parameters)
        {
            $count = \App\User::findOrFail($value)->roles()
            ->where('slug', '=', 'alumno')->count();
            if ($count) {
                return true;
            }
            return false;
        }, 'El usuario agregado no es un alumno.');

        /**
         * Verifiva que los horarios del curso sean correctos
         */
        Validator::extend('is_hour_correct_array', function($attribute, $value, $parameters)
        {
            $test = true;
            foreach ($value as $v) {
                if (date($v['hour_start']) > date($v['hour_end'])) {
                    return false;
                }
                $hour_start = explode(':', $v['hour_start']);
                if (count($hour_start) == 2) {
                    if (!($hour_start[0] >= 0 && $hour_start[0] <= 23)) $test = false;
                    if (!($hour_start[1] >= 0 && $hour_start[1] <= 59)) $test = false;
                } else {$test = false;}
                $hour_end = explode(':', $v['hour_end']);
                if (count($hour_end) == 2) {
                    if (!($hour_end[0] >= 0 && $hour_end[0] <= 23)) $test = false;
                    if (!($hour_end[1] >= 0 && $hour_end[1] <= 59)) $test = false;
                } else {$test = false;}
            }
            return $test;
        }, 'Las horas asignadas no son correctas.');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
