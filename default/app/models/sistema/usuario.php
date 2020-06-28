<?php
/**
 *
 * Descripcion: Modelo para el manejo de usuarios
 *
 * @category
 * @package     Models
 */

Load::models('sistema/estado_usuario', 'sistema/perfil', 'sistema/recurso', 'sistema/recurso_perfil', 'sistema/acceso');

class Usuario extends ActiveRecord {

    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {
        $this->belongs_to('persona');
        $this->belongs_to('perfil');
        $this->has_many('estado_usuario');      
    }

    /**
     * Método que devuelve el inner join con el estado_usuario
     * @return string
     */
    public static function getInnerEstado() {
        // Original del DBKM
        //return "INNER JOIN (SELECT usuario_id, estado_usuario, descripcion, fecha_estado_at FROM (SELECT * FROM estado_usuario ORDER BY fecha_estado_at desc, id desc) AS estado_usuario GROUP BY usuario_id) AS estado_usuario ON estado_usuario.usuario_id = usuario.id ";

        return "JOIN estado_usuario ON (usuario.id = estado_usuario.usuario_id) LEFT OUTER JOIN estado_usuario AS p2 ON (usuario.id = p2.usuario_id AND (estado_usuario.fecha_estado_at < p2.fecha_estado_at OR (estado_usuario.fecha_estado_at = p2.fecha_estado_at AND estado_usuario.id < p2.id))) ";
    }

    /**
     * Método para abrir y cerrar sesión
     * @param type $opt
     * @return boolean
     */
    public static function setSession($opt='open', $user=NULL, $pass=NULL, $mode=NULL) {
        if($opt=='close') { //Cerrar Sesión
            $usuario = Session::get('id');
            if(DwAuth::logout()) {
                //Registro la salida
                Acceso::setAcceso(Acceso::SALIDA, $usuario);
                return TRUE;
            }
            Flash::error(DwAuth::getError());
        } else if($opt=='open') { //Abrir Sesión
            if(DwAuth::isLogged()) {
                return TRUE;
            } else {
                if(DwForm::isValidToken()) { //Si el formulario es válido

                    if(DwAuth::login(array('login'=>$user), array('password'=>$pass), $mode)) {
                        $usuario = self::getUsuarioLogueado();
                        
                        if (($usuario->id!=2) && ($usuario->estado_usuario != EstadoUsuario::COD_ACTIVO)) {                             
                            DwAuth::logout();
                            return Redirect::to('sistema/login/error/1');
                        } 
                        
                        // Establezco las variables de sesión a usar en toda la aplicación
                        Session::set('persona_id', $usuario->persona_id);
                        Session::set('sucursal_id', $usuario->sucursal_id);
                        Session::set('fotografia', $usuario->fotografia);
                        Session::set('nombre', $usuario->nombre);
                        Session::set('apellido', $usuario->apellido);  
                        Session::set('email', $usuario->email);                                              
                        Session::set("ip", DwUtils::getIp());
                        Session::set('perfil', $usuario->perfil);
                        Session::set('perfil_id', $usuario->perfil_id);
                        Session::set('tema', $usuario->tema);
                        Session::set('app_ajax', $usuario->app_ajax);
                        Session::set('tipo_nuip_id_usuario', $usuario->tipo_nuip_id);
                                                
                        //Registro el acceso
                        Acceso::setAcceso(Acceso::ENTRADA, $usuario->id);
                        Flash::info("¡ Bienvenido <strong>$usuario->nombre $usuario->apellido</strong> !.");
                        return TRUE;

                    } 
                    else {
                        Flash::error(DwAuth::getError());
                    }
                } 
                else {
                    Flash::info('La llave de acceso ha vencido. <br />Por favor, recargá la página');
                }
            }
        } 
        else {
            Flash::error('No se ha podido establecer la sesión actual.');
        }
        return FALSE;
    }

    /**
     * Método para obtener la información de un usuario logueado
     * @return object Usuario
     */
    public static function getUsuarioLogueado() {
        $columnas = 'usuario.*, p2.id AS temp_id, perfil.perfil, persona.nombre, persona.apellido, estado_usuario.estado_usuario, persona.fotografia, persona.tipo_nuip_id';
        $join = "INNER JOIN persona ON persona.id = usuario.persona_id ";
        $join.= "INNER JOIN perfil ON perfil.id = usuario.perfil_id ";
        $join.= self::getInnerEstado();
        $condicion = "usuario.id = '".Session::get('id')."' AND p2.id IS NULL";
        $obj = new Usuario();
        return $obj->find_first("columns: $columnas", "join: $join", "conditions: $condicion");
    }


    /**
     * Método para listar los usuarios por perfil
     */
    public function getUsuarioPorPerfil($perfil, $order='order.nombre.asc', $page=0) {
        $perfil = Filter::get($perfil, 'int');
        if(empty($perfil)) {
            return NULL;
        }
        
        $columns = 'usuario.*, persona.nombre, persona.apellido, perfil.perfil, sucursal.sucursal';
        $join = 'INNER JOIN persona ON persona.id = usuario.persona_id ';
        $join.= 'INNER JOIN perfil ON perfil.id = usuario.perfil_id ';
        $join.= 'LEFT JOIN sucursal ON sucursal.id = usuario.sucursal_id ';
        $conditions = "perfil.id = $perfil";
        
        $order = $this->get_order($order, 'nombre', array(                        
            'login' => array(
                'ASC'=>'usuario.login ASC, persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'usuario.login DESC, persona.nombre DESC, persona.apellido DESC'
            ),
            'nombre' => array(
                'ASC'=>'persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'persona.nombre DESC, persona.apellido DESC'
            ),
            'apellido' => array(
                'ASC'=>'persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'persona.apellido DESC, persona.nombre DESC'
            ),
            'email' => array(
                'ASC'=>'usuario.email ASC, persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'usuario.email DESC, persona.apellido DESC, persona.nombre DESC'
            ),
            'estado_usuario' => array(
                'ASC'=>'estado_usuario.estado_usuario ASC, persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'estado_usuario.estado_usuario DESC, persona.apellido DESC, persona.nombre DESC'
            )
        ));
        
        if($page) {
            return $this->paginated("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");
        } 
        return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order");
    }

    /**
     * Método para buscar usuarios
     */
    public function getAjaxUsuario($field, $value, $order='', $page=0) {
        $value = Filter::get($value, 'string');
        if( strlen($value) <= 2 OR ($value=='none') ) {
            return NULL;
        }
        
        $columns = 'usuario.*, p2.id AS temp_id, perfil.perfil, persona.nombre, persona.apellido, estado_usuario.estado_usuario, estado_usuario.descripcion, sucursal.sucursal';
        $join = self::getInnerEstado();
        $join.= 'INNER JOIN perfil ON perfil.id = usuario.perfil_id ';
        $join.= 'INNER JOIN persona ON persona.id = usuario.persona_id ';    
        $join.= 'LEFT JOIN sucursal ON sucursal.id = usuario.sucursal_id ';
        $conditions = "usuario.id > '2' ";//Por el super usuario
        
        $order = $this->get_order($order, 'nombre', array(
            'login' => array(
                'ASC'=>'usuario.login ASC, persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'usuario.login DESC, persona.nombre DESC, persona.apellido DESC'
            ),
            'nombre' => array(
                'ASC'=>'persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'persona.nombre DESC, persona.apellido DESC'
            ),
            'apellido' => array(
                'ASC'=>'persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'persona.apellido DESC, persona.nombre DESC'
            ),
            'email' => array(
                'ASC'=>'usuario.email ASC, persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'usuario.email DESC, persona.apellido DESC, persona.nombre DESC'
            ),
            'estado_usuario' => array(
                'ASC'=>'estado_usuario.estado_usuario ASC, persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'estado_usuario.estado_usuario DESC, persona.apellido DESC, persona.nombre DESC'
            )
        ));
        
        //Defino los campos habilitados para la búsqueda
        $fields = array('login', 'nombre', 'apellido', 'email', 'perfil', 'estado_usuario');
        if(!in_array($field, $fields)) {
            $field = 'nombre';
        }

        $conditions.= " AND p2.id IS NULL";        

        if($page) {
            return $this->paginated("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");
        } else {
            return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order");
        }
    }

    public function getListadoUsuario($estado, $order='', $page=0) {
        $columns = 'usuario.*, p2.id AS temp_id, perfil.perfil, persona.nombre, persona.apellido, estado_usuario.estado_usuario, estado_usuario.descripcion, sucursal.sucursal';
        $join = self::getInnerEstado();
        $join.= 'INNER JOIN perfil ON perfil.id = usuario.perfil_id ';
        $join.= 'INNER JOIN persona ON persona.id = usuario.persona_id ';
        $join.= 'LEFT JOIN sucursal ON sucursal.id = usuario.sucursal_id ';
        $conditions  = "usuario.id > '2'";//Por el super usuario
                
        $order = $this->get_order($order, 'nombre', array(
            'login' => array(
                'ASC'=>'usuario.login ASC, persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'usuario.login DESC, persona.nombre DESC, persona.apellido DESC'
            ),
            'nombre' => array(
                'ASC'=>'persona.nombre ASC, persona.apellido DESC', 
                'DESC'=>'persona.nombre DESC, persona.apellido DESC'
            ),
            'apellido' => array(
                'ASC'=>'persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'persona.apellido DESC, persona.nombre DESC'
            ),
            'email' => array(
                'ASC'=>'usuario.email ASC, persona.apellido ASC, persona.nombre ASC', 
                'DESC'=>'usuario.email DESC, persona.apellido DESC, persona.nombre DESC'
            ),
            'estado_usuario' => array(
                'ASC'=>'estado_usuario.estado_usuario ASC, persona.nombre ASC', 
                'DESC'=>'estado_usuario.estado_usuario DESC, persona.nombre DESC'
            )
        ));
        
        if($estado == 'activos') {
            $conditions.= " AND estado_usuario.estado_usuario = '".EstadoUsuario::COD_ACTIVO."'";
        } else if($estado == 'bloqueados') {
            $conditions.= " AND estado_usuario.estado_usuario = '".EstadoUsuario::COD_BLOQUEADO."'";
        }          
        
        $conditions.= " AND p2.id IS NULL";

        if($page) {
            return $this->paginated("columns: $columns", "join: $join", "conditions: $conditions", "order: $order", "page: $page");
        } else {
            return $this->find("columns: $columns", "join: $join", "conditions: $conditions", "order: $order");
        }
    }

    // Este lo hice yo
    public function getListadoUsuariosActivos() {
        $columns = 'persona.id, p2.id AS temp_id, persona.nombre, persona.apellido, estado_usuario.estado_usuario, estado_usuario.descripcion, sucursal.sucursal';
        $join = self::getInnerEstado();
        $join.= 'INNER JOIN perfil ON perfil.id = usuario.perfil_id ';
        $join.= 'INNER JOIN persona ON persona.id = usuario.persona_id ';        
        $join.= 'LEFT JOIN sucursal ON sucursal.id = usuario.sucursal_id ';

        $conditions = "usuario.id > '2'";//Por el super usuario    
        $conditions.= " AND estado_usuario.estado_usuario = 1 AND p2.id IS NULL";
        
        return $this->find("columns: $columns", "join: $join", "conditions: $conditions");
    }

    /**
     * Método para crear/modificar un objeto de base de datos
     *
     * @param string $medthod: create, update
     * @param array $data: Data para autocargar el modelo
     * @param array $otherData: Data adicional para autocargar
     *
     * @return object ActiveRecord
     */
    public static function setUsuario($method, $data, $optData=null) {
        $obj = new Usuario($data);
        if($optData) {
            $obj->dump_result_self($optData);
        }
        if(!empty($obj->id)) { //Si va a actualizar
            $old = new Usuario();
            $old->find_first($obj->id);
            if(!empty($obj->oldpassword)) { //Si cambia de claves
                if(empty($obj->password) OR empty($obj->repassword)) {
                    Flash::error("Indica la nueva contraseña");
                    return false;
                }
                $obj->oldpassword = sha1($obj->oldpassword);
                if($obj->oldpassword !== $old->password) {
                    Flash::error("La contraseña anterior no coincide con la registrada. Verificá los datos e intente nuevamente");
                    return false;
                }
            }
        }
        //Verifico si las contraseñas coinciden (password y repassword)
        if( (!empty($obj->password) && !empty($obj->repassword) ) OR ($method=='create')  ) {
            if($method=='create' && (empty($obj->password))) {
                Flash::error("Indicá la contraseña para el inicio de sesión");
                return false;
            }
            $obj->password = sha1($obj->password);
            $obj->repassword = sha1($obj->repassword);
            if($obj->password !== $obj->repassword) {
                Flash::error('Las contraseñas no coinciden. Verificá los datos e intenta nuevamente.');
                return 'cancel';
            }

        } else {
            if(isset($obj->id)) { //Mantengo la contraseña anterior
                $obj->password = $old->password;
            }
        }
        $rs = $obj->$method();
        if($rs) {
            ($method == 'create') ? DwAudit::debug("Se ha registrado el usuario $obj->login en el sistema") : DwAudit::debug("Se ha modificado la información del usuario $obj->login");
        }
        return ($rs) ? $obj : FALSE;
    }

    /**
     * Método para verificar si existe un campo registrado
     */
    protected function _getRegisteredField($field, $value, $id=NULL) {
        $conditions = "$field = '$value'";
        $conditions.= (!empty($id)) ? " AND id != $id" : '';
        return $this->count("conditions: $conditions");
    }

    /**
     * Callback que se ejecuta antes de guardar/modificar
     */
    protected function before_save() {
        //Verifico la sucursal al crear el usuario        
        if(APP_OFFICE) {                                
            $this->sucursal_id = ($this->sucursal_id=='todas') ? NULL : Filter::get($this->sucursal_id, 'int');                
        } else {
            $this->sucursal_id = Sucursal::OFICINA_PRINCIPAL;
        }
        if(Session::get('perfil_id') != Perfil::SUPER_USUARIO) { //Solo el super usuario puede hacer esto
            //Verifico las exclusiones de los nombres de usuarios del config.ini
            $exclusion = DwConfig::read('config', array('custom'=>'login_exclusion') );
            $exclusion = explode(',', $exclusion);
            if(!empty($exclusion)) {
                if(in_array($this->login, $exclusion)) {
                    Flash::error('El nombre de usuario indicado NO se encuentra disponible.');
                    return 'cancel';
                }
            }
        }
        //Verifico si el login está disponible
        if($this->_getRegisteredField('login', $this->login, $this->id)) {
            Flash::error('El nombre de usuario NO se encuentra disponible.');
            return 'cancel';
        }
        //Verifico si la persona ya se encuentra registrada
        if($this->_getRegisteredField('persona_id', $this->persona_id, $this->id)) {
            Flash::error('La persona registrada ya posee una cuenta de usuario.');
            return 'cancel';
        }

        $this->datagrid = Filter::get($this->datagrid, 'int');
    }

    /**
     * Callback que se ejecuta despues de insertar un usuario
     */
    protected function after_create() {
        if(!EstadoUsuario::setEstadoUsuario('registrar', array('usuario_id'=>$this->id, 'descripcion'=>'Activado por registro inicial'))){
            Flash::error('Se ha producido un error interno al activar el usuario. Por favor intentá nuevamente.');
            return 'cancel';
        }
    }

    /**
     * Método para obtener la información de un usuario
     * @return type
     */
    public function getInformacionUsuario($usuario) {
        $usuario = Filter::get($usuario, 'int');
        if(!$usuario) {
            return NULL;
        }
        
        $columnas = 'usuario.*, p2.id AS temp_id, perfil.perfil, persona.nombre, persona.apellido, persona.nuip, persona.tipo_nuip_id, persona.fotografia, tipo_nuip.tipo_nuip, estado_usuario.estado_usuario, estado_usuario.descripcion, sucursal.sucursal';
        
        $join = self::getInnerEstado();
        $join.= 'INNER JOIN perfil ON perfil.id = usuario.perfil_id ';
        $join.= 'INNER JOIN persona ON persona.id = usuario.persona_id ';        
        $join.= 'INNER JOIN tipo_nuip ON tipo_nuip.id = persona.tipo_nuip_id ';      
        $join.= 'LEFT JOIN sucursal ON sucursal.id = usuario.sucursal_id ';
        
        $condicion = "usuario.id = $usuario AND p2.id IS NULL";        

        return $this->find_first("columns: $columnas", "join: $join", "conditions: $condicion");
    }
}
?>
