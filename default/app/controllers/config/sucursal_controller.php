<?php
/**
 * Sucursales
 *
 * Descripcion: Controlador que se encarga de la gestión de las sucursales
 *
 * @category    
 * @package     Controllers 
 */

Load::models('config/sucursal');

class SucursalController extends BackendController {
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
        //Se cambia el nombre del módulo actual
        $this->page_module = 'Configuraciones';
    }
    
    /**
     * Método principal
     */
    public function index() {
        Redirect::toAction('listar');
    }
    
    /**
     * Método para listar
     */
    public function listar($order='order.sucursal.asc', $page='pag.1') { 
        $page = (Filter::get($page, 'page') > 0) ? Filter::get($page, 'page') : 1;
        $sucursal = new Sucursal();        
        $this->sucursales = $sucursal->getListadoSucursal($order, $page);
        $this->order = $order;        
        $this->page_title = 'Listado de Sucursales';
    }
    
    /**
     * Método para agregar
     */
    public function agregar() {
        $empresa = Session::get('empresa', 'config');
        
        if(Input::hasPost('sucursal')) {
            if(Sucursal::setSucursal('create', Input::post('sucursal'), array('empresa_id'=>$empresa->id, 'ciudad'=>Input::post('ciudad')))) {
                Flash::valid('La Surcursal se ha registrado correctamente!');
                return Redirect::toAction('listar');
            }            
        } 
        $this->ciudades = Load::model('params/ciudad')->getCiudadesToJson();
        $this->page_title = 'Agregar Sucursal';
    }
    
    /**
     * Método para editar
     */
    public function editar($key) {        
        if(!$id = Security::getKey($key, 'upd_sucursal', 'int')) {
            return Redirect::toAction('listar');
        }        
        
        $sucursal = new Sucursal();
        if(!$sucursal->getInformacionSucursal($id)) {            
            Flash::get('id_no_found');
            return Redirect::toAction('listar');
        }
        
        if(Input::hasPost('sucursal')) {
            if(Sucursal::setSucursal('update', Input::post('sucursal'), array('id'=>$id, 'empresa_id'=>$sucursal->empresa_id, 'ciudad'=>Input::post('ciudad')))) {
                Flash::valid('La Sucursal se ha actualizado correctamente!');
                return Redirect::toAction('listar');
            }
        } 
        $this->ciudades = Load::model('params/ciudad')->getCiudadesToJson();
        $this->sucursal = $sucursal;
        $this->page_title = 'Actualizar Sucursal';        
    }
    
    /**
     * Método para eliminar
     */
    public function eliminar($key) {         
        if(!$id = Security::getKey($key, 'del_sucursal', 'int')) {
            return Redirect::toAction('listar');
        }        
        
        $sucursal = new Sucursal();
        if(!$sucursal->getInformacionSucursal($id)) {            
            Flash::get('id_no_found');
            return Redirect::toAction('listar');
        }                
        try {
            if(Sucursal::setSucursal('delete', array('id'=>$sucursal->id))) {
                Flash::valid('La Sucursal se ha eliminado correctamente!');
            }
        } catch(KumbiaException $e) {
            Flash::error('Esta Sucursal NO se puede eliminar porque se encuentra relacionada con otro registro.');
        }
        
        return Redirect::toAction('listar');
    }
    
}
