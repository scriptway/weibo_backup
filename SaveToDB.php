<?php

namespace spider;
class SaveToDB
{
    protected $pdo;//保存PDO对象

    public function __construct()
    {
        $this->initPDO();//初始化PDO连接对象
    }

    private function initPDO()
    {
        $dbInfo = CONFIGS['database'];
        $dsn = "mysql:host={$dbInfo['host']};port={$dbInfo['port']};dbname={$dbInfo['dbname']};charset={$dbInfo['charset']}";
        $this->pdo = new \PDO($dsn, "{$dbInfo['user']}", "{$dbInfo['pwd']}");
    }

    public function insert($sql)
    {
        $this->pdo->exec($sql);
    }


}


//$db = new SaveToDB();
//$db->insert("insert into myweibo(text) values ('podpdodpopod')");
