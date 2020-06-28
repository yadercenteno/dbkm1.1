<?php
/**
 * Cuentas de gastos
 *
 * Descripcion: Controlador que se encarga de la visualización de los reportes del Catalogo de Cuentas
 *
 * @category    
 * @package     Controllers 
 * @author      Yader V. Centeno Matus (yader_centeno@yahoo.com)
 */

Load::models('ejemplos/acuentas');

class AcuentasController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        $this->page_title = 'Listado de cuentas de gastos';
        //Se cambia el nombre del módulo actual        
        $this->page_module = 'Catalogo de Cuentas';
    }
       

    /**
     * Método para listar
     */
    public function listar($formato='html') {       
        $acuentas = new Acuentas();
        $this->acuentaspag = $acuentas->getExportarAcuentas();

        $this->page_format = $formato;
        $this->page_module = 'Catalogo de Cuentas';
        $this->page_title = 'Listado de cuentas';
    } 
        
}

