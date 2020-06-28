<?php
/**
 * Cuentas
 *
 * Clase que se encarga de todo lo relacionado con las Cuentas de gastos del período
 *
 * @category
 * @package     Models
 * @subpackage
 * @author      Yader V. Centeno Matus (yader_centeno@yahoo.com)
 */

class Acuentas extends ActiveRecord {

    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {
        $this->has_many('apresupgeneral');
	
        $this->validates_presence_of('codigo_cta', 'message: Ingresá el Código de la cuenta.');
        $this->validates_presence_of('nombre_cta', 'message: Ingresá el Nombre de la cuenta.');
    }

    /**
     * Método para obtener la información de las cuentas
     * @return obj
     */
    public function getInformacionAcuentas($id) {
        $id = Filter::get($id, 'numeric');
        $columnas = 'acuentas.*, acuentas.codigo_cta, acuentas.nombre_cta';
        $join = '';
        $condicion = "acuentas.id = '$id'";
        return $this->find_first("columns: $columnas", "join: $join", "conditions: $condicion");
    }  
    
    /**
     * Método que devuelve las cuentas
     * @param string $order
     * @param int $page 
     * @return ActiveRecord
     */
    public function getListadoAcuentas($order='order.codigo_cta.asc') {
        // Periodo actual
        $id_periodo_act = Session::get('id_periodo');

        $columns = "acuentas.*, acuentas.codigo_cta, acuentas.nombre_cta";
        $join = '';        
        $conditions = 'acuentas.id > 0';
        
		    $order = $this->get_order($order, 'codigo_cta',  array('codigo_cta'=>array('ASC'=>'acuentas.codigo_cta ASC', 'DESC'=>'acuentas.codigo_cta DESC')));
        
        return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order");
    }


    // Lista para cargar en los combobox
    public function getListaCtas($cta0='Si') {        
        if (Session::get('perfil_id')==1 or Session::get('perfil_id')==4 or Session::get('perfil_id')==5) {
            return $this->find_all_by_sql("Select *, concat_ws(' - ', codigo_cta, nombre_cta) as nombreespecial from acuentas where id > 0 order by codigo_cta ASC");
        }
        else {
            return $this->find_all_by_sql("Select *, concat_ws(' - ', codigo_cta, nombre_cta) as nombreespecial from acuentas where id > 0 and codigo_cta != 0 order by codigo_cta ASC");
        }    
    }

    /**
     * Método que devuelve el listado para exportar el catalogo de cuentas 
     * @param string $order
     * @param int $page 
     * @return ActiveRecord
     */
    public function getExportarAcuentas($order='order.codigo_cta.asc') {
        // Periodo actual
        $id_periodo_act = Session::get('id_periodo');
        
        $columns = 'acuentas.*, acuentas.codigo_cta, acuentas.nombre_cta';
        $join = '';        
        $conditions = 'acuentas.id > 0';           

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
    public static function setAcuentas($method, $data, $optData=null) {
        //Se aplica la autocarga
        $obj = new Acuentas($data);
        //Se verifica si contiene una data adicional para autocargar
        if ($optData) {
            $obj->dump_result_self($optData);
        }   
        $rs = $obj->$method();
        
        return ($rs) ? $obj : FALSE;
    }

    /**
    * Método pra agregar cuentas con AJAX 
    */
    public static function setAgregarcuenta($codigo_cta, $nombre_cta) {
    	$codigo_cta = Filter::get($codigo_cta, 'int');
  		$nombre_cta = Filter::get($nombre_cta, 'string');
		
	    // Verifico que no exista esta cuenta en el presupuesto general
      $obj = new Acuentas();
      if($obj->find('conditions: codigo_cta='.$codigo_cta, 'order: codigo_cta asc')) {
          Flash::error('Esta cuenta ya existe en el Catalogo de cuentas, por tanto, NO se puede volver a agregar');
          return FALSE;
      }

    	//Agrego el registro
      $obj1 = new Acuentas();
      $obj1->sql("INSERT INTO `acuentas` (`codigo_cta`,`nombre_cta`) VALUES ('$codigo_cta', '$nombre_cta')");
		  
      return FALSE;
  	}

    /**
     * Método que se ejecuta antes de guardar y/o modificar     
     */
    public function before_save() {            
        $this->codigo_cta = Filter::get($this->codigo_cta, 'string');
        $this->nombre_cta = Filter::get($this->nombre_cta, 'string');
        
        $conditions = "codigo_cta = '$this->codigo_cta'";
        $conditions.= (isset($this->id)) ? " AND id != $this->id" : '';
        if($this->count("conditions: $conditions")) {
            Flash::error('Lo sentimos, pero ya existe una cuenta registrada con el mismo código.');
            return 'cancel';
        }        
    }
}
?>