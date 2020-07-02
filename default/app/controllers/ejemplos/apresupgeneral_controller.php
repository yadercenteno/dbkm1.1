<?php
/**
 * Presupuesto general
 *
 * Descripcion: Controlador que se encarga de la gestión del Presupuesto general del período
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
        //Se cambia el nombre del módulo actual
        $this->page_module = 'Ejemplos';
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
    public function listar($order='order.codigo_cta.asc', $page='pag.1') {       
        $page = (Filter::get($page, 'page') > 0) ? Filter::get($page, 'page') : 1;

        // Envío los datos para cargar el Select de Cuentas
        $acuentas = new Acuentas();
        $todas_las_cuentas = $acuentas->getListaCtas();   

        $array_cuentas['_0'] = "Seleccioná";
        foreach($todas_las_cuentas as $cada_cuenta):
            $array_cuentas["_".$cada_cuenta->id] = $cada_cuenta->nombreespecial; 
        
            $cada_cuenta->counter++; 
        endforeach;

        $listado_cuentas = json_encode($array_cuentas);

        $apresupgeneral = new Apresupgeneral();
        $this->apresupgeneralpag = $apresupgeneral->getListadoApresupgeneral($order, $page);
        $this->page = $page;
        $this->order = $order;
        $this->listado_cuentas = $listado_cuentas;
        $this->nombre_mes1 = "Mes 1";
        $this->nombre_mes2 = "Mes 2";
        $this->nombre_mes3 = "Mes 3";
        $this->nombre_mes4 = "Mes 4";
        $this->nombre_mes5 = "Mes 5";
        $this->nombre_mes6 = "Mes 6";
        $this->nombre_mes7 = "Mes 7";
        $this->nombre_mes8 = "Mes 8";
        $this->nombre_mes9 = "Mes 9";
        $this->nombre_mes10 = "Mes 10";
        $this->nombre_mes11 = "Mes 11";
        $this->nombre_mes12 = "Mes 12";
        $this->page_title = 'Presupuesto General';
    }

    /**
     * Método para Exportar los datos a excel
     */
    public function exportar(){
        $apresupgeneral = new Apresupgeneral();
        $this->apresupgeneralpag = $apresupgeneral->getExportarApresupgeneral();
        
        View::select(NULL, 'exportar/apresupgeneral');
    }
    
    /**
     * Método para eliminar
     */
    public function eliminar($key) {         
        if(!$id = Security::getKey($key, 'del_apresupgeneral', 'int')) {
            return Redirect::toAction('listar');
        }        
        
        $apresupgeneral = new Apresupgeneral();
        if(!$apresupgeneral->getInformacionApresupgeneral($id)) {            
            Flash::get('id_no_found');
            return Redirect::toAction('listar');
        }                
        try {
            if(Apresupgeneral::setApresupgeneral('delete', array('id'=>$apresupgeneral->id))) {
                Flash::valid('El presupuesto general de esa cuenta se ha eliminado correctamente!');
            }
        } catch(KumbiaException $e) {
            Flash::error('Este presupuesto general de la cuenta no se puede eliminar porque se encuentra relacionada con otro registro.');
        }
        
        return Redirect::toAction('listar');
    }

    /**
     * Método para Agregar presupuesto con AJAX
     */
    public function agregarpresup() {                  
        if(!Input::isAjax()) {
            Flash::error('Método incorrecto para agregar la cuenta al presupuesto general.');
            return Redirect::toAction('listar');
        }
           
        $cuenta_id = Input::post('cuenta_id');
        $mes1 = Input::post('mes1');
        $mes2 = Input::post('mes2');
        $mes3 = Input::post('mes3');
        $mes4 = Input::post('mes4');
        $mes5 = Input::post('mes5');
        $mes6 = Input::post('mes6');
        $mes7 = Input::post('mes7');
        $mes8 = Input::post('mes8');
        $mes9 = Input::post('mes9');
        $mes10 = Input::post('mes10');
        $mes11 = Input::post('mes11');
        $mes12 = Input::post('mes12');
        $observaciones = Input::post('observaciones');

        if ($agregardato = Apresupgeneral::setAgregarpresup($cuenta_id, $mes1, $mes2, $mes3, $mes4, $mes5, $mes6, $mes7, $mes8, $mes9, $mes10, $mes11, $mes12, $observaciones)) {  
            //si se envia el formulario
            Flash::valid('Se ha agregado satisfactoriamente la cuenta en el presupuesto general');
        }
           
        return Redirect::toAction('listar');
    }

    // Metodo para editar SOLO un campo de una fila del presupuesto
    public function guardarDato(){        
        $id_presup_campo = Input::post('id');
        $valor = Input::post('value');

        $separados = explode("@", $id_presup_campo);

        $id_presup = $separados[0];
        $campo = $separados[1];

        $apresupgeneral = new Apresupgeneral();
        if(!$apresupgeneral->find_first($id_presup)) {
            Flash::get('id_no_found');            
            $mensaje = "error";
        } 
        else {
            switch ($campo) {
                case "cuenta_id":             
                    $antes_valor = explode("_", $valor);
                    $valor = $antes_valor[1];     

                    if (Apresupgeneral::setApresupgeneral('update', $apresupgeneral->to_array(), array('id'=>$id_presup, $campo=>$valor))) {
                        $obj = new Acuentas();
                        $acuentas = $obj->find_first($valor);
                        
                        $mensaje = $acuentas->codigo_cta.' - '.$acuentas->nombre_cta;
                    }
                    break; 

                case "observaciones":
                    $valor = str_replace(":", "", $valor);
                    $valor = str_replace(";", "", $valor);
                    $valor = str_replace("'", "", $valor);

                    if (Apresupgeneral::setApresupgeneral('update', $apresupgeneral->to_array(), array('id'=>$id_presup, $campo=>$valor))) { 
                        $mensaje = $valor;
                    }
                    break;                       

                // Aplica a los demás campos (presupuestos mes por mes)
                // NO especificados arriba
                default:
                    if (Apresupgeneral::setApresupgeneral('update', $apresupgeneral->to_array(), array('id'=>$id_presup, $campo=>$valor))) { 
                        $mensaje = $valor;
                    }
            }
        } 

        $this->mensaje = $mensaje;

        echo $mensaje;

        return $mensaje;
    }
}