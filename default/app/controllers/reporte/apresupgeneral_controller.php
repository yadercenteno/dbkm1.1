<?php
/**
 * Presupuesto general
 *
 * Descripcion: Controlador que se encarga de la visualización de los reportes del Presupuesto general
 *
 * @category    
 * @package     Controllers 
 * @author      Yader V. Centeno Matus (yader_centeno@yahoo.com)
 */

Load::models('ejemplos/apresupgeneral');

class ApresupgeneralController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        $this->page_title = 'Detalle de cuentas presupuestadas';
        //Se cambia el nombre del módulo actual        
        $this->page_module = 'Presupuesto';
    }
       

    /**
     * Método para listar
     */
    public function listar($formato='html') {       
        $apresupgeneral = new Apresupgeneral();
        $this->apresupgeneralpag = $apresupgeneral->getExportarApresupgeneral();

        $this->page_format = $formato;
        $this->page_module = 'Presupuesto';
        $this->page_title = 'Detalle de cuentas presupuestadas';
    }     
}