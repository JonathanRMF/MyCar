<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class Home extends BaseController
{
    public function index(): string
    {
        // Instanciar el modelo de vehículos
        $vehiculoModel = new VehiculoModel();
        
        // Obtener datos
        $vehiculos = $vehiculoModel->getDisponibles();
        $categorias = $vehiculoModel->getCategorias();
        
        // Preparar datos para la vista
        $data = [
            'vehiculos' => $vehiculos,
            'categorias' => $categorias,
            'categoriaActual' => null
        ];
        
        // Cargar welcome_message con los datos
        return view('welcome_message', $data);
    }
}