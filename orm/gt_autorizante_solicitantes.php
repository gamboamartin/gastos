<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_autorizante_solicitantes extends _base_auto_soli
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_autorizante_solicitantes';
        $columnas = array($tabla => false, 'gt_autorizante' => $tabla, 'gt_solicitante' => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    protected function inicializa_campos(array $registros): array
    {
        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }

        $registros['descripcion'] = $registros['codigo'];

        return $registros;
    }

    public function get_relaciones(int $gt_autorizante_id, int $gt_solicitante_id): array|stdClass
    {
        $filtro['gt_autorizante_solicitantes.gt_autorizante_id'] = $gt_autorizante_id;
        $filtro['gt_autorizante_solicitantes.gt_solicitante_id'] = $gt_solicitante_id;
        $resultado = $this->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar permisos', data: $resultado);
        }

        return $resultado;
    }

    public function valida_permisos(int $gt_autorizante_id, int $gt_solicitante_id): array|stdClass|bool
    {
        $registro = $this->get_relaciones(gt_autorizante_id: $gt_autorizante_id, gt_solicitante_id: $gt_solicitante_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener permisos', data: $registro);
        }

        if ($registro->n_registros <= 0) {
            return $this->error->error(mensaje: 'El autorizante no tiene permisos para aprobar la solicitud de este soliciante',
                data: $registro);
        }

        return $registro;
    }


}