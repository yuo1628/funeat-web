<?php defined('BASEPATH') or die('No direct script access allowed');

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\ClassLoader;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Logging\EchoSqlLogger;
use Doctrine\DBAL\Event\Listeners\MysqlSessionInit;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Gedmo\Sluggable\SluggableListener;
use Gedmo\Timestampable\TimestampableListener;
use Gedmo\Tree\TreeListener;

/**
 * CodeIgniter Doctrine Library
 *
 * Doctine 2 wrapper for Codeigniter
 *
 * @category		Libraries
 * @author			Rubén Sarrió <rubensarrio@gmail.com>
 * @link 				https://github.com/rubensarrio/codeigniter-hmvc-doctrine
 * @version			1.1
 */
class Doctrine
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	public $em = null;

	/**
	 * @var Doctrine\ORM\Tools\SchemaTool
	 */
	public $tool = null;

	public function __construct()
	{
		// Is the config file in the environment folder?
		if (!defined('ENVIRONMENT') OR !file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/database.php'))
		{
			$file_path = APPPATH . 'config/database.php';
		}

		// load database configuration from CodeIgniter
		require_once $file_path;

		// Set up class loading
		require_once APPPATH . 'third_party/doctrine-orm/Doctrine/Common/ClassLoader.php';

		$loader = new ClassLoader('Doctrine', APPPATH . 'third_party/doctrine-orm');
		$loader->register();

		// Set up models loading
		$loader = new ClassLoader('models', APPPATH);
		$loader->register();

		foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m)
		{
			$module = str_replace(APPPATH . 'modules/', '', $m);
			$loader = new ClassLoader($module, APPPATH . 'modules');
			$loader->register();
		}

		// Set up proxies loading
		$loader = new ClassLoader('Proxies', APPPATH . 'Proxies');
		$loader->register();

		// Set up Gedmo
		$loader = new ClassLoader('Gedmo', APPPATH . 'third_party');
		$loader->register();

		// Set up caches
		$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), true);
		$cache = new ArrayCache;
		$config->setMetadataCacheImpl($cache);
		$config->setQueryCacheImpl($cache);

		AnnotationRegistry::registerFile(APPPATH . 'third_party/doctrine-orm/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

		// Set up driver
		$reader = new AnnotationReader($cache);
		$cachedReader = new CachedReader($reader, $cache);

		$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
		Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM($driverChain, $cachedReader);

		$evm = new EventManager;
		// timestampable
		$evm->addEventSubscriber(new TimestampableListener);
		// sluggable
		$evm->addEventSubscriber(new SluggableListener);
		// tree
		$evm->addEventSubscriber(new TreeListener);

		// Set up models
		$models = array(APPPATH . 'models');

		foreach (glob(APPPATH.'modules/*/models', GLOB_ONLYDIR) as $m)
		{
			array_push($models, $m);
		}
		$driver = new AnnotationDriver($reader, $models);

		$config->setMetadataDriverImpl($driver);

		// Proxy configuration
		$config->setProxyDir(APPPATH . '/Proxies');
		$config->setProxyNamespace('Proxies');

		// Set up logger
		//$logger = new EchoSqlLogger;
		//$config->setSqlLogger($logger);

		$config->setAutoGenerateProxyClasses(TRUE);

		// Database connection information
		$connection = array(
			'driver' => 'pdo_mysql',
			'user' => $db[$active_group]['username'],
			'password' => $db[$active_group]['password'],
			'host' => $db[$active_group]['hostname'],
			'dbname' => $db[$active_group]['database']
		);

		// Create EntityManager
		$this->em = EntityManager::create($connection, $config, $evm);

		// Force UTF-8
		$this->em->getEventManager()->addEventSubscriber(new MysqlSessionInit('utf8', 'utf8_unicode_ci'));

		// Schema Tool
		$this->tool = new SchemaTool($this->em);
	}

}
