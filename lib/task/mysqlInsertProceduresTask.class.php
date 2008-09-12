<?php

class mysqlInsertProceduresTask extends sfBaseTask {
	protected function configure() {
		$this->namespace = 'mysql';
		$this->name = 'insert-procedures';
		$this->briefDescription = '';
		$this->detailedDescription = <<<EOF
The [insert-procedures|INFO] task does things.
Call it with:

  [php symfony insert-procedures|INFO]
EOF;
		// add arguments here, like the following:
		$this->addArgument ( 'user', sfCommandArgument::REQUIRED, 'User' );
		$this->addArgument ( 'password', sfCommandArgument::REQUIRED, 'Password' );
		$this->addArgument ( 'server', sfCommandArgument::REQUIRED, 'Server' );
		$this->addArgument ( 'database', sfCommandArgument::REQUIRED, 'Database' );
	}
	
	protected function execute($arguments = array(), $options = array()) {
		
		$file = sfConfig::get ( 'sf_data_dir' ) . '/sql/procedures.sql';
		if (! is_file ( $file )) {
			throw new Exception ( $file . ' does not exist' );
		}
		
		// start 
		$this->logSection ( 'mysql-triggers', 'start' );
		
		// make the good import command
		$command = 'mysql -u' . $arguments ['user'] . ' -p' . $arguments ['password'] . ' -h' . $arguments ['server'] . ' -D' . $arguments ['database'] . ' < ' . $file;
		
		// run
		$this->logSection ( 'mysql-triggers', 'run: ' . $command );
		
		//TODO Try to catch the mysql return on error
		exec ( $command );
		
		//end
		$this->logSection ( 'mysql-triggers', 'end' );
	}
}