 * Copyright (c) 2005-2014 Leo Feyer
 * @copyright Leo Feyer 2005-2014
		if (\Config::get('ftpHost') == '')
		elseif (\Config::get('ftpUser') == '')
		elseif (\Config::get('ftpPass') == '')
		$ftp_connect = (\Config::get('ftpSSL') && function_exists('ftp_ssl_connect')) ? 'ftp_ssl_connect' : 'ftp_connect';
		if (($resConnection = $ftp_connect(\Config::get('ftpHost'), \Config::get('ftpPort'), 5)) == false)
		elseif (ftp_login($resConnection, \Config::get('ftpUser'), \Config::get('ftpPass')) == false)
		$return = @ftp_mkdir($this->resConnection, \Config::get('ftpPath') . $strDirectory) ? true : false;
		$this->chmod($strDirectory, \Config::get('defaultFolderChmod'));
		return @ftp_rmdir($this->resConnection, \Config::get('ftpPath') . $strDirectory);
			if (!@ftp_fput($this->resConnection, \Config::get('ftpPath') . $strFile, $resFile, FTP_BINARY))
			return @ftp_rename($this->resConnection, \Config::get('ftpPath') . $strOldName, \Config::get('ftpPath') . $strNewName);
			@ftp_rename($this->resConnection, \Config::get('ftpPath') . $strOldName, \Config::get('ftpPath') . $strOldName . '__');
		$return = @ftp_put($this->resConnection, \Config::get('ftpPath') . $strDestination, TL_ROOT . '/' . $strSource, FTP_BINARY);
			$this->chmod($strDestination, \Config::get('defaultFolderChmod'));
			$this->chmod($strDestination, \Config::get('defaultFileChmod'));
		return @ftp_delete($this->resConnection, \Config::get('ftpPath') . $strFile);
		return @ftp_chmod($this->resConnection, $varMode, \Config::get('ftpPath') . $strFile);
		return @ftp_put($this->resConnection, \Config::get('ftpPath') . $strDestination, $strSource, FTP_BINARY);