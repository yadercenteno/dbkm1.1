<?php
/**
 * Empresa
 *
 * Descripcion: Controlador que se encarga de la gestión de la Organización
 *
 * @category    
 * @package     Controllers 
 */

Load::models('config/empresa', 'config/sucursal');

class EmpresaController extends BackendController {

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

        if(Input::hasPost('empresa')) {
            if(Empresa::setEmpresa('save', Input::post('empresa'))) {
                Flash::valid('Los datos se han actualizado correctamente');
            } else {
                Flash::get('error_form');
            }
        }

        $empresa = new Empresa();
        if(!$empresa->getInformacionEmpresa()) {
            Flash::get('id_no_found');
            return Redirect::toRoute('module: dashboard', 'controller: index');
        }

        if(!APP_OFFICE) {
            $sucursal = new Sucursal();
            $this->sucursal = $sucursal->getInformacionSucursal(1);
            $this->ciudades = Load::model('params/ciudad')->getCiudadesToJson();
        }

        $this->empresa = $empresa;
        $this->page_title = 'Información de la Empresa';
    }

    /**
     * Método para subir imágenes
     */
    public function upload() {     
        $upload = new DwUpload('logo', 'img/upload/empresa/');
        $upload->setAllowedTypes('png|jpg|gif|jpeg');
        $upload->setEncryptName(TRUE);
        $upload->setSize('3MB', 170, 200, TRUE);
        if(!$data = $upload->save()) { //retorna un array('path'=>'ruta', 'name'=>'nombre.ext');
            $data = array('error'=>TRUE, 'message'=>$upload->getError());
        }
        sleep(1);//Por la velocidad del script no permite que se actualize el archivo
        $this->data = $data;
        View::json_especial();
    }

}

