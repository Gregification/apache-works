<?php
    declare(strict_types=1);

    namespace private_request;
    
    use private_request\DB\PsqlChatEnum;

    use PDO;
    use PDOException;

    class ConHandler {
        private static array $connections;

        private function __construct() {}

        public static function getPDO(ConHandlerEnum $connectionTo) : PDO {
            if(!array_key_exists($connectionTo->name, self::$connections) || self::$connections[$connectionTo->name] == null){
                switch($connectionTo){
                    case ConHandlerEnum::PSQL : 
                        try {
                            $connectionInfo = json_decode(file_get_contents('/var/private_request/psqlConnectionInfo.json'), true);
                            
                            $host       = $connectionInfo['iPv4'];
                            $port       = $connectionInfo['port'];
                            $dbname     = PsqlChatEnum::DATABASE->value;
                            $user       = "postgres";
                            $password   = "password";
                            
                            $ref = &self::$connections[$connectionTo->name];
                            $ref = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);

                            //settings
                            $ref->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
                            
                        } catch (PDOException $e) {
                            //should be immideatly fatal
                            trigger_error("failed to connect to db ".$connectionTo->name."\t" . $e->getMessage(), E_USER_ERROR);
                        }       
                        break;
                }
            }

            return self::$connections[$connectionTo->name];
        }
    }

    enum ConHandlerEnum {
        //database  = [relative file with connection info]
        case PSQL   = '/var/private_request/psqlConnectionInfo.json';
        //what ever else
    }
?>