<?php

class mysqlInsertAllTask extends sfBaseTask {
	protected function configure() {
		$this->namespace = 'mysql';
		$this->name = 'insert-all';
		$this->briefDescription = 'Insert all MySQL stuff :D';
		$this->detailedDescription = <<<EOF
The [insert-all|INFO] task does things.
Call it with:

  [php symfony insert-all|INFO]
EOF;
		// add arguments here, like the following:
		$this->addArgument ( 'user', sfCommandArgument::REQUIRED, 'User' );
		$this->addArgument ( 'password', sfCommandArgument::REQUIRED, 'Password' );
		$this->addArgument ( 'server', sfCommandArgument::REQUIRED, 'Server' );
		$this->addArgument ( 'database', sfCommandArgument::REQUIRED, 'Database' );
	}
	
	protected function execute($arguments = array(), $options = array()) {
		
		// RUN TRIGGERS
		$triggersTaskArgs = array ('user' => $arguments ['user'], 'password' => $arguments ['password'], 'server' => $arguments ['server'], 'database' => $arguments ['database'] );
		$mysqlInsertTriggersTask = new mysqlInsertTriggersTask ( $this->dispatcher, $this->formatter );
		$mysqlInsertTriggersTask->run ( $triggersTaskArgs );
		
		// RUN EVENTS
		$eventsTaskArgs = array ('user' => $arguments ['user'], 'password' => $arguments ['password'], 'server' => $arguments ['server'], 'database' => $arguments ['database'] );
		$mysqlInsertEventsTask = new mysqlInsertEventsTask ( $this->dispatcher, $this->formatter );
		$mysqlInsertEventsTask->run ( $eventsTaskArgs );
		
		// RUN PROCEDURES
		$proceduresTaskArgs = array ('user' => $arguments ['user'], 'password' => $arguments ['password'], 'server' => $arguments ['server'], 'database' => $arguments ['database'] );
		$mysqlInsertProceduresTask = new mysqlInsertProceduresTask ( $this->dispatcher, $this->formatter );
		$mysqlInsertProceduresTask->run ( $proceduresTaskArgs );
	
	}
}