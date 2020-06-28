<?php
/**
 * Cuentas de gastos
 *
 * Descripcion: Controlador que se encarga de la gestión de las cuentas de gasto del período
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
    public function listar($order='order.codigo_cta.asc') { 
        $acuentas = new Acuentas();        
        
        $this->acuentaspag = $acuentas->getListadoAcuentas($order);
        $this->order = $order;        
        $this->page_title = 'Catálogo de Cuentas';
    }

    /**
     * Método para Exportar los datos a excel
     */
    public function exportar(){
        $acuentas = new Acuentas();
        $this->acuentaspag = $acuentas->getExportarAcuentas();
        
        View::select(NULL, 'exportar/acuentas');
    }
    
    /**
     * Método para agregar
     */
    public function agregar() {
        if(Input::hasPost('acuentas')) {
            if(Acuentas::setAcuentas('create', Input::post('acuentas'))) {
                Flash::valid('¡La cuenta se ha registrado correctamente!');
                return Redirect::toAction('listar');
            }            
        } 
        $this->page_title = 'Agregar Cuenta';
    }
    
    /**
     * Método para editar
     */
    public function editar($key) {        
        if(!$id = Security::getKey($key, 'upd_acuentas', 'int')) {
            return Redirect::toAction('listar');
        }        
        
        $acuentas = new Acuentas();
        if(!$acuentas->getInformacionAcuentas($id)) {            
            Flash::get('id_no_found');
            return Redirect::toAction('listar');
        }
        
        if(Input::hasPost('acuentas')) {
            if(Acuentas::setAcuentas('update', Input::post('acuentas'), array('id'=>$id))) {
                Flash::valid('¡La cuenta se ha actualizado correctamente!');
                return Redirect::toAction('listar');
            }
        } 

        $this->acuentas = $acuentas;
        $this->page_title = 'Actualizar Cuenta';        
    }
    
    /**
     * Método para eliminar
     */
    public function eliminar($key) {         
        if(!$id = Security::getKey($key, 'del_acuentas', 'int')) {
            return Redirect::toAction('listar');
        }        
        
        $acuentas = new Acuentas();
        if(!$acuentas->getInformacionAcuentas($id)) {            
            Flash::get('id_no_found');
            return Redirect::toAction('listar');
        }                
        try {
            if(Acuentas::setAcuentas('delete', array('id'=>$acuentas->id))) {
                Flash::valid('¡La Cuenta se ha eliminado correctamente!');
            }
        } catch(KumbiaException $e) {
            Flash::error('Esta Cuenta no se puede eliminar porque se encuentra relacionada con otro registro.');
        }
        
        return Redirect::toAction('listar');
    }

    // Accion posterior al upload
    public function subir() {
        $this->page_title = 'Importar datos desde Excel';

        if(Input::hasPost('archivo')) {
            //Aqui proceso el archivo subido     
            Load::lib('PHPExcel');
            Load::lib('Excel/reader');

            $archivo_xls = Session::get('ruta_xls')."/".Input::post('archivo');
            
            if (!empty($archivo_xls)) {
                // Comienzo a cargar los datos a la BD
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding("UTF-8");

                $para_subir = $archivo_xls;
                $data->read($para_subir);
                for ($i = 1; $i <= $data->sheets[0]["numRows"]; $i++) {
                    for ($j = 1; $j <= $data->sheets[0]["numCols"]; $j++) {
                        switch ($j) {
                            case 1:
                                $codigo_cta=$data->sheets[0]["cells"][$i][$j];
                                break;
                            case 2:
                                $nombre_cta=$data->sheets[0]["cells"][$i][$j];
                                break;                                                   
                        }

                        if ($j==$data->sheets[0]["numCols"]){
                            if ($i!=1){
                                if ($codigo_cta<>"" or $nombre_cta<>"") {
                                    $agregardato = Acuentas::setAgregarcuenta($codigo_cta, $nombre_cta);
                                 }
                            }
                        }           
                    }        
                }

                foreach (glob(Session::get('ruta_xls')."/*.xls") as $nombre_archivo1) {
                    $borrar1 = unlink($nombre_archivo1);
                    if($borrar1){
                          //echo "El archivo " . $nombre_archivo1 . " se eliminó correctamente <br>";
                    }
                    else{
                          Flash::error("Error al eliminar " . $nombre_archivo1);
                    }
                }

                Redirect::toAction('listar', 'order.codigo_cta.asc');
                
                Flash::valid('Se han importado satisfactoriamente los datos al Catalogo de Cuentas');
            }
        }
    }

    /**
     * Método para subir archivos de excel
     */
    public function upload() {
        $upload = new DwUpload('logo', 'temp');
        $upload->setAllowedTypes('xls');
        $upload->setEncryptName(TRUE);
        //$upload->setSize('8MB', 170, 200, TRUE);        
        if(!$data = $upload->save()) { //retorna un array('path'=>'ruta', 'name'=>'nombre.ext');
            $data = array('error'=>true, 'message'=>$upload->getError());
        }
        Session::set('ruta_xls', $upload->path);

        sleep(1);//Por la velocidad del script no permite que se actualize el archivo
        $this->data = $data;
        View::json_especial();
    }
}