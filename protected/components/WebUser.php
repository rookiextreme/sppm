<?php

/**
 * Description of WebUser
 *
 * @author laila
 */
// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

    /**
     * Local user 
     * @var type 
     */
    private $_user;

    /**
     * Profile of user
     * @var type 
     */
    private $profile;

    public function getName() {
        $this->loadUser(Yii::app()->user->id);
        return $this->_user->pegawai->nama;
    }
    
    public function getCourseCode() {
        $this->loadUser(Yii::app()->user->id);
        $roles = Yii::app()->user->getState('roles') ? Yii::app()->user->getState('roles') : array();
        if(in_array($roles[0], Pengguna::ROLE_SEKRETARIAT)) {
            return Pengguna::ROLE_SEKRETARIAT;
        } else if($roles[0] == Pengguna::ROLE_PENGANJUR) {
            return substr($this->_user->pegawai->kod_waran, 0, 4);
        } else if($roles[0] == Pengguna::ROLE_KHAS) {
            return substr($this->_user->pegawai->kod_waran, 0, 6);
        }
    }

    public function get($field) {
        $this->loadUser(Yii::app()->user->id);
        return $this->_user->pegawai->$field;
    }

    public function checkAccess($operation, $params = array(), $allowCaching = true) {
        parent::checkAccess($operation, $params, $allowCaching);
        return $this->hasRole($operation);
    }

    public function hasRole($role = '') {
        $roles = Yii::app()->user->getState('roles') ? Yii::app()->user->getState('roles') : array();
        if (!is_array($role)) {
            $role = array($role);
        }

        foreach ($role as $item) {
            if (in_array($item, $roles)) {
                return $item;
            }
        }
        return false;
    }

    /*
     * Load user model 
     */

    protected function loadUser($id = null) {
        if ($this->_user === null) {
            if ($id !== null) {
                $this->_user = Pengguna::model()->with('pegawai')->findByPk($id);
            }
        }
    }

}

?>