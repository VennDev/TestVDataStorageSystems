<?php

declare(strict_types=1);

namespace venndev\TestVDataStorageSystems;

use Exception;
use Throwable;
use pocketmine\plugin\PluginBase;
use venndev\vapmdatabase\database\mysql\MySQL;
use venndev\vapmdatabase\database\sqlite\SQLite;
use venndev\vdatastoragesystems\utils\TypeDataStorage;
use venndev\vdatastoragesystems\VDataStorageSystems;
use vennv\vapm\Async;

final class TestVDataStorageSystems extends PluginBase
{
    use VDataStorageSystems;

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function onEnable(): void
    {
        self::initVDataStorageSystems($this);

        // Create a storage with the name "test.yml" and type "YAML"
        self::createStorage(
            name: $this->getDataFolder() . "test.yml",
            type: TypeDataStorage::TYPE_YAML
        );
        self::getStorage($this->getDataFolder() . "test.yml")->set("test", "test");

        // Create a storage with the name "test.db" and type "SQLITE"
        self::createStorage(
            name: "testSQLITE",
            type: TypeDataStorage::TYPE_SQLITE,
            database: new SQLite($this->getDataFolder() . "test.db")
        );
        self::getStorage("testSQLITE")->set("test", ["testAC", "testB"]);
        // This is an example of how to use the Async class to get data from the database
//        new Async(function () {
//            $data = Async::await(self::getStorage("testSQLITE")->get("test"));
//            var_dump($data);
//        });

        // Create a storage with the name "test" and type "MYSQL"
        self::createStorage(
            name: "testMYSQL",
            type: TypeDataStorage::TYPE_MYSQL,
            database: new MySQL(
                host: "localhost",
                username: "root",
                password: "",
                databaseName: "testg",
                port: 3306
            )
        );
        self::getStorage("testMYSQL")->set("test", ["testAC", "testB"]);
        // This is an example of how to use the Async class to get data from the database
//        new Async(function () {
//            $data = Async::await(self::getStorage("testMYSQL")->get("test"));
//            var_dump($data);
//        });
    }

    public function onDisable(): void
    {
        self::saveAll();
    }

}