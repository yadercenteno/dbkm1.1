<?php
/**
 *
 * Clase que gestiona todos los estados de los usuarios
 *
 * @category
 * @package     Models
 * @subpackage 
 */

class EstadoUsuario extends ActiveRecord {

        /**
     * Constante para definir el estado Activo
     */
    const COD_ACTIVO = 1;
    /**
     * Constante para definir el estado Bloqueado
     */
    const COD_BLOQUEADO = 2;
    /**
     * Constante para describir el estado Activo
     */
    const ACTIVO = 'Activo';
    /**
     * Constante para describir el estado Bloqueado
     */
    const BLOQUEADO = 'Bloqueado';
    
    /**
     * Método para definir las relaciones y validaciones
     */
    protected function initialize() {
        $this->belongs_to('usuario');        
    }

    /**
     * Método para obtener el estado de un usuarios
     * @param int $usuario
     * @return string
     */
    public function getEstadoUsuario($usuario) {
        $usuario    = Filter::get($usuario, 'numeric');
        $condicion  = "usuario_id = '$usuario'";
        $sql = $this->find_first("conditions: $condicion", 'order: id DESC');
        return ($sql) ? $sql : FALSE;      
    }

    /**
     * Método para listar todos los estados del usuario
     * @param int $usuario 
     * @param int $pag Número de la página. Si es mayor que 0 se utiliza el paginador
     * @return EstadoUsuario
     */
    public function getListadoEstadoUsuario($usuario, $page=0) {
        $usuario = Filter::get($usuario,'numeric');
        $sql = "SELECT id, IF(estado_usuario=1,'".self::ACTIVO."','".self::BLOQUEADO."') AS estado_usuario, descripcion, fecha_estado_at FROM estado_usuario WHERE usuario_id = '$usuario' ORDER BY id DESC";
        return ($page) ? $this->paginated_by_sql($sql, "page: $page") : $this->find_all_by_sql($sql);        
        return false;                
    } 
    
    /**
     * Método para registrar un estado a un usuario
     */
    public static function setEstadoUsuario($accion, $data, $optData=NULL) {
        $accion = strtolower($accion);
        $obj = new EstadoUsuario($data);
        if($optData) {            
            $obj->dump_result_self($optData);
        }
        //Verifico el estado actual        
        $old    = new EstadoUsuario();        
        $estado = $old->getEstadoUsuario($obj->usuario_id);

        //Verifico las acciones
        if($accion == 'registrar') {
            $obj->estado_usuario = self::COD_ACTIVO;        
        } else if( ($accion == 'bloquear') && (empty($estado) OR $estado->estado_usuario == self::COD_ACTIVO ) ) {                        
            $obj->estado_usuario = self::COD_BLOQUEADO;                    
        } else if( ($accion == 'reactivar') && ($estado->estado_usuario != self::COD_ACTIVO) ) {            
            $obj->estado_usuario = self::COD_ACTIVO;                            
        } 
        else {                     
            return FALSE;
        } 
        return $obj->create();
    }
    
    /**
     * Callback que se ejecuta antes de crear un registro
     */
    public function before_create() {
        $this->descripcion = Filter::get($this->descripcion, 'string');
    }
    
    /**
     * Callback que se ejecuta desupés de crear un registro
     */
    public function after_create() {
        //Obtengo el usuario por la relación definida en el initialize
        $usuario = $this->getUsuario();
        if($this->estado_usuario == self::COD_ACTIVO) {
            DwAudit::debug("Se activa el acceso al usuario $usuario->login. Motivo: $this->descripcion");
        } else if($this->estado_usuario == self::COD_BLOQUEADO) {
            DwAudit::debug("Se bloquea el acceso al sistema al usuario $usuario->login. Motivo: $this->descripcion");
        }
        
    }
      
}
