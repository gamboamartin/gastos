<?php

namespace gamboamartin\gastos\models;

use gamboamartin\errores\errores;
use stdClass;

class _Funciones
{
    public errores $error;

    public function __construct(errores $error)
    {
        $this->error = $error;
    }

    /**
     * Función para aplanar un array de datos y extraer los valores de una columna específica.
     *
     * @param array $datos El array de datos original con filas asociativas.
     * @param string $columna El nombre de la columna cuyos valores se desean extraer.
     *
     * @return array Retorna un array que contiene todos los valores de la columna especificada.
     */
    public static function aplanar(array $datos, string $columna): array
    {
        return array_column(array_filter($datos, function ($fila) use ($columna) {
            return isset($fila[$columna]);
        }), $columna);
    }

    /**
     * Suma los valores numéricos en un array de datos.
     *
     * @param array $datos El array de datos del cual se sumarán los valores numéricos.
     *
     * @return array|float Retorna la suma de los valores numéricos en el array especificado.
     * Si el array contiene elementos que no son números, se retorna un array con un mensaje de error.
     */
    function sumar(array $datos): array|float
    {
        $valores_numericos = array_filter($datos, 'is_numeric');

        if (count($valores_numericos) !== count($datos)) {
            return $this->error->error('El array contiene elementos que no son números.', $valores_numericos);
        }

        return round(array_sum($valores_numericos), 2);
    }

}