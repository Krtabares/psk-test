<?php

namespace App\Validators;

class Empresa {
    public static function validate(array $d) {
        $errors = [];
        if(empty($d['rif'])) {
            $errors[] = "El campo rif es obligatorio.";
        }elseif(!preg_match('/^[VEJPG]-[0-9]{8}-[0-9]$/i', $d['rif'])) {
            $errors[] = "El campo rif debe comenzar con V, E, J, P o G seguido de 8 dígitos numéricos.";
        }

        if(empty($d['razon_social'])) {
            $errors[] = "El campo razón social es obligatorio.";
        }

         if(empty($d['direccion'])) {
            $errors[] = "El campo dirección es obligatorio.";
        }

         if(empty($d['telefono'])) {
            $errors[] = "El campo teléfono es obligatorio.";
        }

        return count($errors) > 0 ? $errors : false;
    }
}