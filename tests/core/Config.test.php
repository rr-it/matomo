<?php
if(!defined("PIWIK_PATH_TEST_TO_ROOT")) {
	define('PIWIK_PATH_TEST_TO_ROOT', getcwd().'/../..');
}
if(!defined('PIWIK_CONFIG_TEST_INCLUDED'))
{
	require_once PIWIK_PATH_TEST_TO_ROOT . "/tests/config_test.php";
}

class Test_Piwik_Config extends UnitTestCase
{
    public function testUserConfigOverwritesSectionGlobalConfigValue()
    {
    	$userFile = 'tests/resources/Config/config.ini.php';
    	$globalFile = 'tests/resources/Config/global.ini.php';
    	
    	$config = new Piwik_Config($userFile, $globalFile);
    	$config->init();
    	$this->assertEqual($config->Category->key1, "value_overwritten");
    	$this->assertEqual($config->Category->key2, "value2");
    	$this->assertEqual($config->General->login, 'tes"t');
    	$this->assertEqual($config->CategoryOnlyInGlobalFile->key3, "value3");
    	$this->assertEqual($config->CategoryOnlyInGlobalFile->key4, "value4");
    	
    	$expectedArray = array('plugin"1', 'plugin2', 'plugin3');
    	$array = $config->TestArray->toArray();
    	$this->assertEqual($array['installed'], $expectedArray);
    	
    	$expectedArray = array('value1', 'value2');
    	$array = $config->TestArrayOnlyInGlobalFile->toArray();
    	$this->assertEqual($array['my_array'], $expectedArray);
    }
    
}

