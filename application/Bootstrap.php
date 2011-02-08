<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload() {
        $objAutoloader = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'Application',
                'basePath'  => dirname(__FILE__),
            )
        );
        
        $objFc = Zend_Controller_Front::getInstance();
		$objFc->addModuleDirectory(APPLICATION_PATH . '/modules');
		$objFc->setDefaultModule('frontend');

		$objFc->registerPlugin(new Application_Plugin_AdminSetup());
        $objFc->throwExceptions(false);
        return $objAutoloader;
    }
	
	protected function _initSession()
	{
		//may add default session values from ini here
		Zend_Session::start();
	}

}

function dump($vars)
{
    if (APPLICATION_ENV != 'local') return;
    static $dumps = 0;

    echo '<div class="dump" style="font-size:10px;background:#f2f4f6;color:#333;padding:0px;border:2px solid #777;position:absolute;top:' . ($dumps * 40 + 4) . 'px;left:4px;z-index:2000;" onclick="var dumps=document.getElementsByClassName(\'dump\');for(var i=0,l=dumps.length;i<l;i++){dumps[i].style.zIndex=2000;}this.style.zIndex=2001;">';
    echo '<div style="padding:4px;background:#ccc;font-weight:bold;">Debug Dump<span style="text-decoration:underline;cursor:pointer;color:red;float:right;" onclick="this.parentNode.parentNode.style.display=\'none\'">CLOSE</span></div>';
    echo '<div style="padding:4px;">';
    $vars = func_get_args();
    foreach ($vars as $var) {
        Zend_Debug::dump($var);
    }

    $trace = debug_backtrace();
    echo '<ul class="trace" style="font-size:10px;list-style-type:none;margin:8px 0 0 0;padding:8px 0 0 0;line-height:1.0;border-top:1px solid #ccc;">';
    echo '<li style="margin:0 0 5px;padding:0;"><strong>Dump Trace:</strong></li>';
    foreach ($trace as $t) {
        $call = (isset($t['class']) ? "{$t['class']}->{$t['function']}" : $t['function']);
        $call .= '(';

        if (isset($t['args'])) {
            $tArgs = array();
            foreach ($t['args'] as $a) {
                switch (gettype($a)) {
                    case 'boolean':
                        $tArgs[] = '<span style="color:#f00;">' . ($a ? 'true' : 'false') . '</span>';
                        break;

                    case 'integer':
                    case 'double':
                        $tArgs[] = "<span style=\"color:#090;\">{$a}</span>";
                        break;

                    case 'string':
                        $tArgs[] = '<acronym title="' . htmlentities($a) . '" style="color:#090;">"' . (strlen($a) > 16 ? substr($a, 0, 16) . '...' : $a ) . '"</acronym>';
                        break;

                    case 'object':
                        $tArgs[] = '<span style="color:#03f;">' . get_class($a) . '</span>';
                        break;

                    default:
                        $tArgs[] = '<span style="color:#f00;">' . gettype($a) . '</span>';
                }
            }
            $call .= implode(', ', $tArgs);
        }

        $call .= ')';
        echo "<li style=\"margin:0 0 5px;padding:0;\"><strong>{$call}</strong><br /><span style=\"color:#999;\">{$t['file']}:{$t['line']}</span></li>";
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    ++$dumps;
}
