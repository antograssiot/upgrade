<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Upgrade\Console\Command\Task;

use Cake\Upgrade\Console\Command\Task\BaseTask;

/**
 * Move files around as directories have changed in 3.0
 */
class LocationsTask extends BaseTask {

	use ChangeTrait;

	public $tasks = ['Stage'];

/**
 * Check all moves, and stage moving the file to new location
 *
 * @param mixed $path
 * @return boolean
 */
	protected function _process($path) {
		$new = $path;
		foreach ($this->_moves() as $from => $to) {
			$new = str_replace(DS . $from, DS . $to, $new);
		}

		if ($new === $path) {
			return false;
		}

		return $this->Stage->move($path, $new);
	}

/**
 * _shouldProcess
 *
 * Is the current path within the scope of any move?
 *
 * @param string $path
 * @return boolean
 */
	protected function _shouldProcess($path) {
		foreach (array_keys($this->_moves()) as $substr) {
			if (strpos($path, $substr) !== false) {
				return true;
			}
		}

		return false;
	}

/**
 * Key value map of from and to
 *
 * @return array
 */
	protected function _moves() {
		return array(
			'Config' => '..' . DS . 'config',
			'Console' . DS . 'Command' => 'Shell',
			'Console' . DS . 'Command' . DS . 'Task' => 'Shell' . DS . 'Task',
			'Controller' . DS . 'Component' . DS . 'Auth' => 'Auth',
			'Lib' . DS => '',
			'Test' . DS . 'Case' => 'Test' . DS . 'TestCase',
			'View' . DS . 'Elements' => 'Template' . DS . 'Element',
			'View' . DS . 'Emails' => 'Template' . DS . 'Email',
			'View' . DS . 'Layouts' => 'Template' . DS . 'Layout',
			'Template' . DS . 'Layout' . DS . 'Emails' => 'Template' . DS . 'Layout' . DS . 'Email',
			'View' . DS . 'Scaffolds' => 'Template' . DS . 'Scaffold',
			'View' . DS . 'Errors' => 'Template' . DS . 'Error',
			'View' . DS . 'Themed' => 'Template' . DS . 'Themed',
		);
	}
}
