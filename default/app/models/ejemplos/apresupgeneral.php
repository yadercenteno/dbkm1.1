<?php
/**
 * Presupuesto General
 *
 * Clase que se encarga de todo lo relacionado con el Presupuesto general del período
 *
 * @category
 * @package     Models
 * @subpackage
 * @author      Yader V. Centeno Matus (yader_centeno@yahoo.com)
 */

Load::models('ejemplos/acuentas');

class Apresupgeneral extends ActiveRecord {
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {
		$this->belongs_to('acuentas');
		
        $this->validates_presence_of('cuenta_id', 'message: Seleccioná la Cuenta');
        $this->validates_numericality_of('mes1', 'message: Ingresá una cantidad válida en el presupuesto del Mes 1.');
        $this->validates_numericality_of('mes2', 'message: Ingresá una cantidad válida en el presupuesto del Mes 2.');
        $this->validates_numericality_of('mes3', 'message: Ingresá una cantidad válida en el presupuesto del Mes 3.');
        $this->validates_numericality_of('mes4', 'message: Ingresá una cantidad válida en el presupuesto del Mes 4.');
        $this->validates_numericality_of('mes5', 'message: Ingresá una cantidad válida en el presupuesto del Mes 5.');
        $this->validates_numericality_of('mes6', 'message: Ingresá una cantidad válida en el presupuesto del Mes 6.');
        $this->validates_numericality_of('mes7', 'message: Ingresá una cantidad válida en el presupuesto del Mes 7.');
        $this->validates_numericality_of('mes8', 'message: Ingresá una cantidad válida en el presupuesto del Mes 8.');
        $this->validates_numericality_of('mes9', 'message: Ingresá una cantidad válida en el presupuesto del Mes 9.');
        $this->validates_numericality_of('mes10', 'message: Ingresá una cantidad válida en el presupuesto del Mes 10.');
        $this->validates_numericality_of('mes11', 'message: Ingresá una cantidad válida en el presupuesto del Mes 11.');
        $this->validates_numericality_of('mes12', 'message: Ingresá una cantidad válida en el presupuesto del Mes 12.');
    }

    /**
     * Método para obtener la información de los presupuestos
     * @return obj
     */
    public function getInformacionApresupgeneral($id) {
        $id = Filter::get($id, 'numeric');
        $columnas = 'apresupgeneral.*, acuentas.codigo_cta, acuentas.nombre_cta, apresupgeneral.mes1, apresupgeneral.mes2, apresupgeneral.mes3, apresupgeneral.mes4, apresupgeneral.mes5, apresupgeneral.mes6, apresupgeneral.mes7, apresupgeneral.mes8, apresupgeneral.mes9, apresupgeneral.mes10, apresupgeneral.mes11, apresupgeneral.mes12';
        $join = 'INNER JOIN acuentas ON acuentas.id = apresupgeneral.cuenta_id';
        $condicion = "apresupgeneral.id = '$id'";
        return $this->find_first("columns: $columnas", "join: $join", "conditions: $condicion");
    }  
    
    /**
     * Método que devuelve el listado de los presupuestos 
     * @param string $order
     * @param int $page 
     * @return ActiveRecord
     */
    public function getListadoApresupgeneral($order='order.codigo_cta.asc', $page='1') {
        
        $columns = 'apresupgeneral.*, acuentas.codigo_cta, acuentas.nombre_cta, apresupgeneral.mes1, apresupgeneral.mes2, apresupgeneral.mes3, apresupgeneral.mes4, apresupgeneral.mes5, apresupgeneral.mes6, apresupgeneral.mes7, apresupgeneral.mes8, apresupgeneral.mes9, apresupgeneral.mes10, apresupgeneral.mes11, apresupgeneral.mes12';
        $join = 'INNER JOIN acuentas ON acuentas.id = apresupgeneral.cuenta_id';     
        $conditions = 'apresupgeneral.id > 0';           

        $order = $this->get_order($order, 'codigo_cta',  array('codigo_cta'=>array('ASC'=>'acuentas.codigo_cta ASC', 'DESC'=>'acuentas.codigo_cta DESC')));

        return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");            
    }

    /**
     * Método que devuelve el listado para exportar el presupuesto general 
     * @param string $order
     * @param int $page 
     * @return ActiveRecord
     */
    public function getExportarApresupgeneral($order='order.codigo_cta.asc') {
        
        $columns = 'apresupgeneral.*, acuentas.codigo_cta, acuentas.nombre_cta, apresupgeneral.mes1, apresupgeneral.mes2, apresupgeneral.mes3, apresupgeneral.mes4, apresupgeneral.mes5, apresupgeneral.mes6, apresupgeneral.mes7, apresupgeneral.mes8, apresupgeneral.mes9, apresupgeneral.mes10, apresupgeneral.mes11, apresupgeneral.mes12';
        $join = 'INNER JOIN acuentas ON acuentas.id = apresupgeneral.cuenta_id';     
        $conditions = 'apresupgeneral.id > 0';           

        $order = $this->get_order($order, 'codigo_cta', array('codigo_cta'=>array('ASC'=>'acuentas.codigo_cta ASC', 'DESC'=>'acuentas.codigo_cta DESC')));
        return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order");            
    }
   
    /**
     * Método para setear
     * @param string $method Método a ejecutar (create, update, save)
     * @param array $data Array con la data => Input::post('model')
     * @param array $otherData Array con datos adicionales
     * @return Obj
     */
    public static function setApresupgeneral($method, $data, $optData=null) {
        //Se aplica la autocarga
        $obj = new Apresupgeneral($data);
        //Se verifica si contiene una data adicional para autocargar
        if ($optData) {
            $obj->dump_result_self($optData);
        }   
        $rs = $obj->$method();
        
        return ($rs) ? $obj : FALSE;
    }

    /**
    * Método pra agregar presupuesto con AJAX 
    */
    public static function setAgregarpresup($cuenta_id, $mes1, $mes2, $mes3, $mes4, $mes5, $mes6, $mes7, $mes8, $mes9, $mes10, $mes11, $mes12, $observaciones=NULL) {
    	$cuenta_id = Filter::get($cuenta_id, 'int');
        
		// Verifico que no exista esta cuenta en el presupuesto general
        $obj = new Apresupgeneral();
        if($obj->find_all_by_sql("Select * from apresupgeneral where cuenta_id='$cuenta_id'")) {
            Flash::error('Esta cuenta ya existe en el presupuesto, por tanto, NO se puede volver a agregar');
            return FALSE;
        }

    	//Agrego el registro
        $obj1 = new Apresupgeneral();
        $data = array ("cuenta_id" => $cuenta_id, "mes1" => $mes1, "mes2" => $mes2, "mes3" => $mes3, "mes4" => $mes4, "mes5" => $mes5, "mes6" => $mes6, "mes7" => $mes7, "mes8" => $mes8, "mes9" => $mes9, "mes10" => $mes10, "mes11" => $mes11, "mes12" => $mes12, "observaciones" => $observaciones);
        
        return $obj1->create( $data );
	}

    /**
     * Método que se ejecuta antes de guardar y/o modificar     
     */
    public function before_save() {        
        $this->cuenta_id = Filter::get($this->cuenta_id, 'numeric');           
    }
}
?>