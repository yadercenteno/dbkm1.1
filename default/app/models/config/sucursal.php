<?php
/**
 * Sucursales
 *
 * Clase que se encarga de todo lo relacionado con las Sucursales de la empresa
 *
 * @category
 * @package     Models
 */

Load::models('params/ciudad');
Load::models('personas/persona');

class Sucursal extends ActiveRecord {
    
    /**
     * Constante para definir el id de la oficina principal
     */
    const OFICINA_PRINCIPAL = 1;

    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {
        $this->belongs_to('empresa');
        $this->belongs_to('ciudad');
        $this->has_many('usuario');

        $this->validates_presence_of('sucursal', 'message: Ingresá el nombre de la ciudad GG');        
    }  
    
    /**
     * Método para ver la información de una ciudad GG
     * @param int|string $id
     * @return Sucursal
     */
    public function getInformacionSucursal($id, $isSlug=false) {
        $id = ($isSlug) ? Filter::get($id, 'string') : Filter::get($id, 'numeric');
        $columnas = 'sucursal.*, ciudad.ciudad';
        $join = 'INNER JOIN ciudad ON ciudad.id = sucursal.ciudad_id';
        $condicion = ($isSlug) ? "sucursal.slug = '$id'" : "sucursal.id = '$id'";
        return $this->find_first("columns: $columnas", "join: $join", "conditions: $condicion");
    } 
    
    /**
     * Método que devuelve un listado con las ciudades GG
     * @param string $order
     * @param int $page 
     * @return ActiveRecord
     */
    public function getListadoSucursal($order='order.sucursal.asc', $page='', $empresa=null) {
        $empresa = Filter::get($empresa, 'int');

        // Verifico que el usuario es Staff permanente
        $id_persona_act = Session::get('persona_id');
        $id_ciudad = Session::get('sucursal_id');

        $usuarios = new Persona();

        $resultados_usuarios = $usuarios->find_first("conditions: id='$id_persona_act'");
               
        $columns = 'sucursal.*, ciudad.ciudad';
        $join = 'INNER JOIN ciudad ON ciudad.id = sucursal.ciudad_id';        
        
        if ($resultados_usuarios) {
            $tipo_id_persona = $resultados_usuarios->tipo_nuip_id;
        }

        if ($tipo_id_persona > 1) {
            $conditions = (empty($empresa)) ? 'sucursal.id = '.$id_ciudad : "empresa.id = '$empresa'";
        }
        else {
            $conditions = (empty($empresa)) ? 'sucursal.id > 0' : "empresa.id = '$empresa'";
        }

        $order = $this->get_order($order, 'sucursal', array('sucursal'=>array('ASC'=>' sucursal.id ASC, ciudad.ciudad ASC', 'DESC'=>'sucursal.id DESC, ciudad.ciudad ASC')));

        if ($page) {                
            return $this->paginated("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");
        } else {
            return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");            
        }
    }
    
    /**
     * Método para setear
     * @param string $method Método a ejecutar (create, update, save)
     * @param array $data Array con la data => Input::post('model')
     * @param array $otherData Array con datos adicionales
     * @return Obj
     */
    public static function setSucursal($method, $data, $optData=null) {
        //Se aplica la autocarga
        $obj = new Sucursal($data);
        //Se verifica si contiene una data adicional para autocargar
        if ($optData) {
            $obj->dump_result_self($optData);
        }

        // Creo una nueva ciudad
        if($method=='create') {
            $obj->ciudad_id = Ciudad::setCiudad($obj->sucursal)->id;        
        }
        // Edito el nombre de la ciudad
        if($method=='update') {
            //Edito el registro
            $obj_ciudad = new Ciudad();
            $obj_ciudad->sql("UPDATE ciudad SET ciudad='$obj->sucursal' WHERE id='$obj->ciudad_id'");
        }
        
        $rs = $obj->$method();
        
        return ($rs) ? $obj : FALSE;
    }

    /**
     * Método que se ejecuta antes de guardar y/o modificar     
     */
    public function before_save() {        
        $this->sucursal = Filter::get($this->sucursal, 'string');        
        $this->slug = DwUtils::getSlug($this->sucursal); 
        
        $conditions = "sucursal = '$this->sucursal' AND ciudad_id = $this->ciudad_id";
        $conditions.= (isset($this->id)) ? " AND id != $this->id" : '';
        if($this->count("conditions: $conditions")) {
            Flash::error('Lo sentimos, pero ya existe una ciudad registrada con el mismo nombre de ciudad');
            return 'cancel';
        }
    }
    
    /**
     * Callback que se ejecuta antes de eliminar
     */
    public function before_delete() {
        if($this->id == 1) { //Para no eliminar la información de la ciudad principal
            Flash::warning('Lo sentimos, pero esta ciudad NO se puede eliminar.');
            return 'cancel';
        }
    }
}